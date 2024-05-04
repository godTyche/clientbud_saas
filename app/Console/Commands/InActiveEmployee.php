<?php

namespace App\Console\Commands;

use App\Models\EmployeeDetails;
use Illuminate\Console\Command;

class InActiveEmployee extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactive-employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The employee is set to inactive if he exit the company';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = EmployeeDetails::with('user')->whereNotNull('last_date')->get();

        foreach ($employees as $employee) {
            if ($employee->last_date->isToday()) {
                $employee->user->status = 'deactive';
                $employee->user->inactive_date = now();
                $employee->user->save();
            }
        }
    }

}
