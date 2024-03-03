<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Jobs\ProcessEmployees;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use App\Models\JobBatch;

class UploadController extends Controller
{
    public function index(){
        return view('upload');
    }

    public function progress(){
        return view('progress');
    }


    public function uploadFileAndStoreInDatabase(Request $request)
    {
       try{
            if($request->has('csvFile')){
                $fileName = $request->csvFile->getClientOriginalName();
                $fileWithPath = public_path('uploads'). '/'.$fileName;

                if (!file_exists($fileWithPath))
                {
                    $request->csvFile->move(public_path('uploads'),$fileName);
                }

                $header = null;
                $dataFromcsv = array();
                $records = array_map('str_getcsv', file($fileWithPath));

                foreach($records as $record)
                {
                    if(!$header)
                    {
                        $header = $record;
                    }
                    else
                    {
                        $dataFromcsv[] = $record;
                    }
                }
                //breaking the data

                $dataFromcsv = array_chunk($dataFromcsv,30);

                $batch = Bus::batch([])->dispatch();

               foreach($dataFromcsv as $index => $dataCsv)
              {
                 //loop through each data  as 100/30
                 foreach($dataCsv as $data)
                 {
                    $employeeData[$index][] = array_combine($header,$data);
                 }
                 $batch->add(new ProcessEmployees($employeeData[$index]));
                //  ProcessEmployees::dispatch($employeeData[$index]);
              }
              //update session id every time we process new batch
              session()->put('lastBatchId',$batch->id);

              return redirect('/progress?id='.$batch->id);
            //   echo "Jobs Added Successfully";

            }
       }
       catch(Exception $e)
       {
        Log::error($e);
        dd($e);
       }
    }
// function gets thr progress while execute obs
    public function progressForCsvStoreProcess(Request $request)
    {

        try
        {
            $batchId = $request->id ?? session()->get('lastBatchId');
            if(JobBatch::where('id',$batchId)->count())
            {
                $response = JobBatch::where('id',$batchId)->first();
                return response()->json($response);
            }
        }
        catch(Exception $e)
        {
            Log::error($e);
            dd($e);
        }
    }
}
