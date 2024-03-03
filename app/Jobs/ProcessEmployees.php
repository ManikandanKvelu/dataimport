<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Employee;

class ProcessEmployees implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $employeeData;
    /**
     * Create a new job instance.
     */
    public function __construct($employeeData)
    {
        $this->employeeData = $employeeData;
        // dd($this->employeeData);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this->employeeData as $employeeData)
        {
            $employee = new Employee();
            $employee->name = $employeeData['Region'].' '.$employeeData['Country'];
            $employee->save();
        }
    }
}
