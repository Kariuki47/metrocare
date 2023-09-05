<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Role;
use App\Models\County;
use App\Models\Patient;
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
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:patient list', ['only' => ['index', 'show']]);
        $this->middleware('can:patient create', ['only' => ['create', 'store']]);
        $this->middleware('can:patient edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:patient delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = (new Patient)->newQuery();

        $patients->join('past_medical_histories', 'past_medical_histories.patient_id', '=', 'patients.id')->join('family_histories', 'family_histories.patient_id', '=', 'patients.id')->select('patients.*', 'past_medical_histories.medical_treatment', 'family_histories.history');

        if (request()->has('search')) {
            $patients->where(function ($query) {
                $query->where('name', 'Like', '%' . request()->input('search') . '%')
                    ->orWhere('email', 'Like', '%' . request()->input('search') . '%')
                    ->orWhere('phone', 'Like', '%' . request()->input('search') . '%');
            });
        }

        if (request()->query('treatment')) {
            $patients->where('past_medical_histories.medical_treatment', request()->query('treatment'));
        } else {
            $patients->latest();
        }

        if (request()->query('health')) {
            $patients->where('health', request()->query('health'));
        } else {
            $patients->latest();
        }

        if (request()->query('history')) {
            $patients->whereJsonContains('family_histories.history', (int)request()->query('history'));
        } else {
            $patients->latest();
        }

        if (request()->query('sort')) {
            $attribute = request()->query('sort');
            $patients->orderBy('id', $attribute);
        } else {
            $patients->orderBy('id', 'desc')->latest();
        }

        if (request()->query('per_page')) {
            $patients = $patients->paginate(request()->query('per_page'))->onEachSide(2)->appends(request()->query());
        } else {
            $patients = $patients->paginate(20)->onEachSide(2)->appends(request()->query());
        }

        return Inertia::render('Admin/Patient/Index', [
            'patients' => $patients,
            'filters' => request()->all('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all()->pluck("name", "id");
        $county_options = County::get();

        return Inertia::render('Admin/Patient/Create', [
            'roles' => $roles,
            'county_options' => $county_options,
            'can' => [
                'create' => Auth::user()->can('medical create'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            $message = 'Patient added successfully.';
        } else {
            $message = 'Error while adding patient. Please try again.';
        }

        return redirect()->route('patient.edit', $patient->id)->with('message', __($message));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        $county_options = County::get();
        return Inertia::render('Admin/Patient/Edit', [
            'patient' => $patient,
            'county_options' => $county_options,
            'can' => [
                'create' => Auth::user()->can('medical create'),
            ],
            'id' => $patient->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sex' => ['required'],
            'dob' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'county' => ['required'],
            'phone' => ['required']
        ]);

        if ($patient->update($request->all())) {
            activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('update');
            $message = 'Patient updated successfully.';
        } else {
            $message = 'Error while saving. Please try again.';
        }

        //if(Auth::user()->can('medical create')){
        //return redirect()->route('respiratory-system.edit', $patient->id)->with('message', __($message));
        //}

        return redirect()->route('patient.edit', $patient->id)->with('message', __($message));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Patient $patient)
    {
        activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('delete');
        $patient->delete();

        return redirect()->route('patient.index')
            ->with('message', __('Patient has been deleted successfully'));
    }

    public function destroyMany(Request $request)
    {
        //Log::info(json_encode($request->id));
        if (is_array($request->id)) {
            foreach ($request->id as $id) {
                $patient = Patient::find($id);
                activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('delete');
            }
        } else if ($request->id) {
            $patient = Patient::find($request->id);
            activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('delete');
        }
        Patient::destroy($request->id);
        if ($request->bulk) {
            $message = 'Bulk update was successful';
        } else {
            $message = 'Patient has been deleted successfully';
        }

        return redirect()->route('patient.index')
            ->with('message', __($message));
    }

    public function examinationConclusion($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            abort(404);
        }
        return Inertia::render('Admin/Patient/Conclusion', [
            'patient' => $patient,
        ]);
    }

    public function examinationConclusionStore(Request $request, $id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            $message = 'Error while saving. Please try again.';
            return redirect()->back()->with('message', __($message));
        }
        $patient->longevity = $request->longevity;
        $patient->disability = $request->disability;
        $patient->comments = $request->comments;
        $patient->health = $request->health;
        $patient->recommendation = $request->recommendation;
        $patient->conclusion = $request->conclusion;
        if ($patient->save()) {
            activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('update');
            $message = 'Patient updated successfully.';
        } else {
            $message = 'Error while saving. Please try again.';
        }

        return redirect()->back()->with('message', __($message));
    }

    public function patientData()
    {
        $patients = Patient::get();
        return response()->json($patients);
    }
}
