<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Activitylog\Models\Activity;
use App\Models\Patient;
use App\Models\User;
use App\Models\BloodPressure;
use App\Models\CardiovascularSystem;
use App\Models\CentralNervousSystem;
use App\Models\ChestXRay;
use App\Models\ECG;
use App\Models\FamilyHistory;
use App\Models\GastrointestinalSystem;
use App\Models\GeneralAppearance;
use App\Models\GenitoUrinarySystem;
use App\Models\PastMedicalHistory;
use App\Models\RespiratorySystem;
use App\Models\SensoryOrgan;
use App\Models\SkeletalSystem;
use App\Models\SkinTeguments;
use App\Models\SocialHistory;
use App\Models\County;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Features;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user(),
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        activity()->performedOn($request->user())->withProperties(['ip' => $request->ip(), 'model' => 'User'])->log('update_profile');

        //return Redirect::route('profile.edit');
        return redirect()->route('profile.edit')->with('message', __('Profile updated successfully.'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function dashboard()
    {
        
        if (Auth::user()->hasRole('Administrator')) {
            $activities = Activity::join('users', 'users.id', '=', 'activity_log.causer_id')->latest()->take(5)->get(['activity_log.*', 'users.name', 'users.id as user_id']);
        }else{
            $activities = Activity::join('users', 'users.id', '=', 'activity_log.causer_id')->where('activity_log.causer_id', Auth::user()->id)->latest()->take(5)->get(['activity_log.*', 'users.name', 'users.id as user_id']);
        }
        $patients = Patient::latest()->take(5)->get();
        $users = User::latest()->take(5)->get();

        return Inertia::render('Dashboard', [
            'activities' => $activities,
            'patients' => $patients,
            'users' => $users,
            'admin' => Auth::user()->hasRole('Administrator') ? true : false,
            'can' => [
                'patients' => Auth::user()->can('patient list'),
                'users' => Auth::user()->can('user list'),
            ]
        ]);
    }

    public function activityLog()
    {
        $activities = (new Activity)->newQuery();
        if (Auth::user()->hasRole('Administrator')) {
            $activities->join('users', 'users.id', '=', 'activity_log.causer_id')->select(['activity_log.*', 'users.name', 'users.id as user_id']);
        }else{
            $activities->join('users', 'users.id', '=', 'activity_log.causer_id')->where('activity_log.causer_id', Auth::user()->id)->select(['activity_log.*', 'users.name', 'users.id as user_id']);
        }

        if (request()->has('search')) {
            $activities->where('description', 'Like', '%' . request()->input('search') . '%');
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $activities->orderBy('id', $attribute);
        } else {
            $activities->orderBy('id', 'desc')->latest();
        }

        if (request()->query('per_page')) {
            $activities = $activities->paginate(request()->query('per_page'))->onEachSide(2)->appends(request()->query());
        } else {
            $activities = $activities->paginate(20)->onEachSide(2)->appends(request()->query());
        }

        return Inertia::render('Profile/LogActivities', [
            'activities' => $activities,
            'filters' => request()->all('search'),
            'admin' => Auth::user()->hasRole('Administrator') ? true : false,
        ]);
    }

    public function accountSettings(): Response
    {
        return Inertia::render('Profile/AccountSettings', [
            'status' => session('status'),
        ]);
    }

    public function settingsSessions(Request $request): Response
    {

        return Inertia::render('Profile/SettingsSessions', [
            'sessions' => $this->sessions($request)->all(),
        ]);
    }

    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function destroySessions(Request $request)
    {
        if (!Hash::check($request->password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        Auth::logoutOtherDevices($request->password);

        $this->deleteOtherSessionRecords($request);

        return back(303);
    }

    public function settingsTwoFactor(Request $request): Response
    {
        $this->validateTwoFactorAuthenticationState($request);
        return Inertia::render('Profile/TwoFactorChallenge', [
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm'),
        ]);
    }

    public function patientDetails(): Response
    {
        $county_options = County::get();
        return Inertia::render('PatientForm', [
            'county_options' => $county_options,
        ]);
    }

    public function thankYou(): Response
    {
        return Inertia::render('Success');
    }

    public function addPatientDetails(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sex' => ['required'],
            'dob' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:patients,email'],
            'county' => ['required'],
            'phone' => ['required']
        ]);

        $patient = Patient::create($request->all());
        if ($patient) {
            BloodPressure::create(['patient_id' => $patient->id]);
            CardiovascularSystem::create(['patient_id' => $patient->id]);
            CentralNervousSystem::create(['patient_id' => $patient->id]);
            ChestXRay::create(['patient_id' => $patient->id]);
            ECG::create(['patient_id' => $patient->id]);
            FamilyHistory::create(['patient_id' => $patient->id]);
            GastrointestinalSystem::create(['patient_id' => $patient->id]);
            GeneralAppearance::create(['patient_id' => $patient->id]);
            GenitoUrinarySystem::create(['patient_id' => $patient->id]);
            PastMedicalHistory::create(['patient_id' => $patient->id]);
            RespiratorySystem::create(['patient_id' => $patient->id]);
            SensoryOrgan::create(['patient_id' => $patient->id]);
            SkeletalSystem::create(['patient_id' => $patient->id]);
            SkinTeguments::create(['patient_id' => $patient->id]);
            SocialHistory::create(['patient_id' => $patient->id]);
            activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('create');
            $message = 'Details added successfully.';
            return redirect()->route('thank.you')->with('success', __($message));
        } else {
            $message = 'Error while adding details. Please try again.';
            return redirect()->back()->with('message', __($message));
        }

    }

    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }

    protected function validateTwoFactorAuthenticationState(Request $request)
    {
        if (! Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm')) {
            return;
        }

        $currentTime = time();

        // Notate totally disabled state in session...
        if ($this->twoFactorAuthenticationDisabled($request)) {
            $request->session()->put('two_factor_empty_at', $currentTime);
        }

        // If was previously totally disabled this session but is now confirming, notate time...
        if ($this->hasJustBegunConfirmingTwoFactorAuthentication($request)) {
            $request->session()->put('two_factor_confirming_at', $currentTime);
        }

        // If the profile is reloaded and is not confirmed but was previously in confirming state, disable...
        if ($this->neverFinishedConfirmingTwoFactorAuthentication($request, $currentTime)) {
            app(DisableTwoFactorAuthentication::class)(Auth::user());

            $request->session()->put('two_factor_empty_at', $currentTime);
            $request->session()->remove('two_factor_confirming_at');
        }
    }

    /**
     * Determine if two factor authenticatoin is totally disabled.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function twoFactorAuthenticationDisabled(Request $request)
    {
        return is_null($request->user()->two_factor_secret) &&
            is_null($request->user()->two_factor_confirmed_at);
    }

    /**
     * Determine if two factor authentication is just now being confirmed within the last request cycle.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasJustBegunConfirmingTwoFactorAuthentication(Request $request)
    {
        return ! is_null($request->user()->two_factor_secret) &&
            is_null($request->user()->two_factor_confirmed_at) &&
            $request->session()->has('two_factor_empty_at') &&
            is_null($request->session()->get('two_factor_confirming_at'));
    }

    /**
     * Determine if two factor authentication was never totally confirmed once confirmation started.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $currentTime
     * @return bool
     */
    protected function neverFinishedConfirmingTwoFactorAuthentication(Request $request, $currentTime)
    {
        return ! array_key_exists('code', $request->session()->getOldInput()) &&
            is_null($request->user()->two_factor_confirmed_at) &&
            $request->session()->get('two_factor_confirming_at', 0) != $currentTime;
    }
}
