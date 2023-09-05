<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ReportGeneratorController extends Controller
{
    public function index($id)
    {
        $patient = Patient::find($id);
        $respiratory = RespiratorySystem::where('patient_id', $patient->id)->first();
        $cardiovascular = CardiovascularSystem::where('patient_id', $patient->id)->first();
        $gastrointestinal = GastrointestinalSystem::where('patient_id', $patient->id)->first();
        $genito = GenitoUrinarySystem::where('patient_id', $patient->id)->first();
        $central = CentralNervousSystem::where('patient_id', $patient->id)->first();
        $skin = SkinTeguments::where('patient_id', $patient->id)->first();
        $skeletal = SkeletalSystem::where('patient_id', $patient->id)->first();
        $sensory = SensoryOrgan::where('patient_id', $patient->id)->first();
        $medical = PastMedicalHistory::where('patient_id', $patient->id)->first();
        $social = SocialHistory::where('patient_id', $patient->id)->first();
        $family = FamilyHistory::where('patient_id', $patient->id)->first();
        $appearance = GeneralAppearance::where('patient_id', $patient->id)->first();
        $blood = BloodPressure::where('patient_id', $patient->id)->first();
        $ecg = ECG::where('patient_id', $patient->id)->first();
        $chest_xray = ChestXRay::where('patient_id', $patient->id)->first();

        /*$data = [
            'patient'    => $patient,
            'respiratory'         => $respiratory,
            'cardiovascular'         => $cardiovascular,
            'gastrointestinal'      => $gastrointestinal,
            'genito' => $genito,
            'central'        => $central,
            'skin'        => $skin,
            'skeletal'        => $skeletal,
            'sensory'        => $sensory,
            'medical'        => $medical,
            'social'        => $social,
            'family' => $family,
            'appearance' => $appearance,
            'blood' => $blood
        ];
        $pdf = PDF::loadView('report', $data);
        return $pdf->stream('report.pdf');*/
        return view('report', [
            'patient'    => $patient,
            'respiratory'         => $respiratory,
            'cardiovascular'         => $cardiovascular,
            'gastrointestinal'      => $gastrointestinal,
            'genito' => $genito,
            'central'        => $central,
            'skin'        => $skin,
            'skeletal'        => $skeletal,
            'sensory'        => $sensory,
            'medical'        => $medical,
            'social'        => $social,
            'family' => $family,
            'appearance' => $appearance,
            'blood' => $blood,
            'ecg' => $ecg,
            'chest_xray' => $chest_xray
        ]);
    }

    public function pdf($id)
    {
        $patient = Patient::find($id);
        $respiratory = RespiratorySystem::where('patient_id', $patient->id)->first();
        $cardiovascular = CardiovascularSystem::where('patient_id', $patient->id)->first();
        $gastrointestinal = GastrointestinalSystem::where('patient_id', $patient->id)->first();
        $genito = GenitoUrinarySystem::where('patient_id', $patient->id)->first();
        $central = CentralNervousSystem::where('patient_id', $patient->id)->first();
        $skin = SkinTeguments::where('patient_id', $patient->id)->first();
        $skeletal = SkeletalSystem::where('patient_id', $patient->id)->first();
        $sensory = SensoryOrgan::where('patient_id', $patient->id)->first();
        $medical = PastMedicalHistory::where('patient_id', $patient->id)->first();
        $social = SocialHistory::where('patient_id', $patient->id)->first();
        $family = FamilyHistory::where('patient_id', $patient->id)->first();
        $appearance = GeneralAppearance::where('patient_id', $patient->id)->first();
        $blood = BloodPressure::where('patient_id', $patient->id)->first();
        $ecg = ECG::where('patient_id', $patient->id)->first();
        $chest_xray = ChestXRay::where('patient_id', $patient->id)->first();

        $data = [
            'patient'    => $patient,
            'respiratory'         => $respiratory,
            'cardiovascular'         => $cardiovascular,
            'gastrointestinal'      => $gastrointestinal,
            'genito' => $genito,
            'central'        => $central,
            'skin'        => $skin,
            'skeletal'        => $skeletal,
            'sensory'        => $sensory,
            'medical'        => $medical,
            'social'        => $social,
            'family' => $family,
            'appearance' => $appearance,
            'blood' => $blood,
            'ecg' => $ecg,
            'chest_xray' => $chest_xray
        ];
        $pdf = PDF::loadView('report', $data);
        return $pdf->download('medical_report_' . $id . '.pdf');
        //return $pdf->output();
    }

    public function bulkPdf(Request $request)
    {
        Log::info($request);
        if (is_array($request->id)) {
            $fileFolder = time();
            Storage::disk('local')->makeDirectory(time());
            foreach ($request->id as $id) {
                $patient = Patient::find($id);
                $respiratory = RespiratorySystem::where('patient_id', $patient->id)->first();
                $cardiovascular = CardiovascularSystem::where('patient_id', $patient->id)->first();
                $gastrointestinal = GastrointestinalSystem::where('patient_id', $patient->id)->first();
                $genito = GenitoUrinarySystem::where('patient_id', $patient->id)->first();
                $central = CentralNervousSystem::where('patient_id', $patient->id)->first();
                $skin = SkinTeguments::where('patient_id', $patient->id)->first();
                $skeletal = SkeletalSystem::where('patient_id', $patient->id)->first();
                $sensory = SensoryOrgan::where('patient_id', $patient->id)->first();
                $medical = PastMedicalHistory::where('patient_id', $patient->id)->first();
                $social = SocialHistory::where('patient_id', $patient->id)->first();
                $family = FamilyHistory::where('patient_id', $patient->id)->first();
                $appearance = GeneralAppearance::where('patient_id', $patient->id)->first();
                $blood = BloodPressure::where('patient_id', $patient->id)->first();
                $ecg = ECG::where('patient_id', $patient->id)->first();
                $chest_xray = ChestXRay::where('patient_id', $patient->id)->first();

                $data = [
                    'patient'    => $patient,
                    'respiratory'         => $respiratory,
                    'cardiovascular'         => $cardiovascular,
                    'gastrointestinal'      => $gastrointestinal,
                    'genito' => $genito,
                    'central'        => $central,
                    'skin'        => $skin,
                    'skeletal'        => $skeletal,
                    'sensory'        => $sensory,
                    'medical'        => $medical,
                    'social'        => $social,
                    'family' => $family,
                    'appearance' => $appearance,
                    'blood' => $blood,
                    'ecg' => $ecg,
                    'chest_xray' => $chest_xray
                ];
                $pdf = PDF::loadView('report', $data);
                $fileName = 'medical_report_'.$id.'.pdf';
                $path = storage_path('app/'.$fileFolder . '/' . $fileName);
                $pdf->save($path);
            }
        }
        //return $pdf->download('medical_report_'.$id.'.pdf');
        //return $pdf->output();
        Storage::disk('local')->makeDirectory('tmp',$mode=0775); 
        $zip_file=storage_path('app/tmp/'.$fileFolder.'.zip');
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $path = storage_path('app/'.$fileFolder); // path to your pdf files
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                // extracting filename with substr/strlen
                $relativePath = substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        $headers = array('Content-Type'=>'application/octet-stream',);
        $zip_new_name = "Medical_report-".date("y-m-d-h-i-s").".zip";
        //Storage::deleteDirectory(storage_path('app/'.$fileFolder ));
        File::deleteDirectory(storage_path('app/'.$fileFolder ));
        return response()->download($zip_file,$zip_new_name,$headers)->deleteFileAfterSend(true);
        //return response()->json(['zip_file', $zip_file]);
    }

    public function demo()
    {
        return view('demo');
    }
}
