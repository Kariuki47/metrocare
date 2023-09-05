<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\BloodPressure;
use App\Models\Patient;

class BloodPressureController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:medical list', ['only' => ['index', 'show']]);
        $this->middleware('can:medical create', ['only' => ['create', 'store']]);
        $this->middleware('can:medical edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:medical delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(BloodPressure $bloodPressure)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bloodPressure = BloodPressure::where('patient_id', $id)->first();
        $patient = Patient::find($id);
        if(!$bloodPressure){
            abort(404);
        }
        return Inertia::render('Admin/BloodPressure/Edit', [
            'blood_pressure' => $bloodPressure,
            'patient' => $patient
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BloodPressure $bloodPressure)
    {
        if ($bloodPressure->update($request->all())) {
            $patient = Patient::find($bloodPressure->patient_id);
            if($patient)activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('update');
            $message = 'Patient updated successfully.';
        } else {
            $message = 'Error while saving. Please try again.';
        }

        return redirect()->back()->with('message', __($message));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
