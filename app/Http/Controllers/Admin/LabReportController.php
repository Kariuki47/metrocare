<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\LabReport;
use App\Models\Patient;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Validator;

class LabReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:lab list', ['only' => ['labReport', 'downloadReport']]);
        $this->middleware('can:lab create', ['only' => ['labReportUpload']]);
        $this->middleware('can:lab edit', ['only' => ['labReportUpload']]);
        $this->middleware('can:lab delete', ['only' => ['deleteReport']]);
    }

    public function labReport(string $id)
    {
        $labReports = LabReport::where('patient_id', $id)->latest()->get();
        $patient = Patient::find($id);
        return Inertia::render('Admin/LabReport/Index', [
            'lab_reports' => $labReports,
            'patient' => $patient
        ]);
    }

    public function labReportUpload(Request $request)
    {
        Log::info($request->all());
		Validator::make($request->all(), [
            'file' => ['required'],
        ])->validate();

        $file = $request->file('file')->getClientOriginalName();

        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
        $fileSize = $request->file('file')->getSize();
  
        $path = $fileName.time().'.'.$fileExtension;  
        $request->file->move(public_path('uploads'), $path);
    
        LabReport::create([
            'patient_id' => $request->patient_id,
            'name' => $fileName,
            'path' => $path,
            'size' => $fileSize,
            'type' => $fileExtension
        ]);
    
        return redirect()->route('lab.report', $request->patient_id);
	}

    public function downloadReport( string $id ) {

		$file = LabReport::find($id);
        
		if (!$file) {
			abort(404);
		}
        
		$this->fileDownload( $file );
    }

    public function fileDownload( $file ) {
		$file_path = public_path('uploads/' . $file->path);

		$downloadFileName = $file->name.'.'.$file->type;

		$downloadFile = @fopen($file_path,"rb");
		if (!$downloadFile) {
			abort(404);
		}

    	$downloadFileSize = filesize($file_path);

		$mime_types = array(
	        "htm" => "text/html",
	        "exe" => "application/octet-stream",
	        "zip" => "application/zip",
	        "doc" => "application/msword",
	        "docx" => "application/msword",
	        "jpg" => "image/jpg",
	        "php" => "text/plain",
	        "xls" => "application/vnd.ms-excel",
	        "ppt" => "application/vnd.ms-powerpoint",
	        "gif" => "image/gif",
	        "pdf" => "application/pdf",
	        "txt" => "text/plain",
	        "html"=> "text/html",
	        "png" => "image/png",
	        "jpeg"=> "image/jpg",
			"js" => "application/x-javascript"
	    );

		if( $file->type ) {
            $mime_type = $file->type;
        } else {
            $mime_type = "application/force-download";
        }

        @ob_end_clean();
        if( ini_get('zlib.output_compression') ) {
        	ini_set('zlib.output_compression', 'Off');
        }

        header('Pragma: public');
        header("Expires: 0");
        header('Connection: Keep-Alive');
        header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
	    header('Content-Type: ' . $mime_type);
	    header('Content-Disposition: attachment; filename="'.$downloadFileName.'"');
	    header("Content-Transfer-Encoding: binary");
	    header('Accept-Ranges: bytes');

	    if( isset($_SERVER['HTTP_RANGE']) ) {
	        list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
	        list($range) = explode(",",$range,2);
	        list($range, $range_end) = explode("-", $range);
	        $range=intval($range);
	        if(!$range_end) {
	            $range_end=$downloadFileSize-1;
	        } else {
	            $range_end=intval($range_end);
	        }

	        $new_length = $range_end-$range+1;
	        header("HTTP/1.1 206 Partial Content");
	        header("Content-Length: $new_length");
	        header("Content-Range: bytes $range-$range_end/$downloadFileSize");
	    } else {
	        $new_length = $downloadFileSize;
	        header("Content-Length: " . $downloadFileSize);
	    }

	    $chunksize = 1*(1024*1024);
	    $bytes_sent = 0;

        if(isset($_SERVER['HTTP_RANGE'])) {
	        fseek($downloadFile, $range);
	    }

        while(
        	!feof($downloadFile) && 
        	(!connection_aborted()) && 
        	($bytes_sent < $new_length) 
        ) {
            $buffer = fread($downloadFile, $chunksize);
            echo($buffer);
            flush();
            $bytes_sent += strlen($buffer);
        }

	    @fclose($downloadFile);
	    return;
	}

    public function deleteReport(Request $request)
    {
        $file = LabReport::find($request->id);
        $file_path = public_path('uploads/' . $file->path);
        if(unlink($file_path)){
            $file->delete();
        }
        $message = "File has been deleted successfully.";
        return redirect()->back()->with('message', __($message));
    }
}
