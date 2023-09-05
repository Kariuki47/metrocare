<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\ECG;
use App\Models\Patient;

class ECGController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ECG = ECG::where('patient_id', $id)->first();
        $patient = Patient::find($id);
        if(!$ECG){
            abort(404);
        }
        return Inertia::render('Admin/ECG/Edit', [
            'ecg' => $ECG,
            'patient' => $patient
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ECG = ECG::find($id);
        if ($ECG->update($request->all())) {
            $patient = Patient::find($ECG->patient_id);
            if($patient)activity()->performedOn($patient)->withProperties(['ip' => $request->ip(), 'model' => 'Patient'])->log('update');
            $message = 'Patient updated successfully.';
        } else {
            $message = 'Error while saving. Please try again.'.json_encode($ECG);
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
