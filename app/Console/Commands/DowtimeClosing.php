<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\Downtime;
use App\Models\Workorder;
use Illuminate\Console\Command;

class DowtimeClosing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'downtime:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close downtime running based on end of shift time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $machines = Machine::all();
        foreach ($machines as $machine) {
            $lastWorkorderOnProcess = Workorder::where('status_wo','on process')->where('machine_id',$machine->id)->first();
            if(!$lastWorkorderOnProcess)
            {
                $this->info('no on process');
                continue;
            }
            $lastdowntimeStatus = Downtime::where('workorder_id',$lastWorkorderOnProcess->id)->orderBy('id','DESC')->first();
            $this->info($lastdowntimeStatus);
            if(!$lastdowntimeStatus)
            {
                $this->info('no last downtime');
                continue;
            }

            if($lastdowntimeStatus->status == 'run')
            {
                Downtime::create([
                    'workorder_id'          => $lastWorkorderOnProcess->id,
                    'downtime_number'       => Date($machine->id.'YmdHis'),
                    'time'                  => 0,
                    'status'                => 'stop',
                    'downtime'              => 0,
                    'is_downtime_stopped'   => false,
                    'is_remark_filled'      => false,
                ]);
                $downtime = Downtime::create([
                    'workorder_id'          => $lastWorkorderOnProcess->id,
                    'downtime_number'       => $lastdowntimeStatus->downtime_number,
                    'time'                  => 0,
                    'status'                => 'run',
                    'downtime'              => 0,
                    'is_downtime_stopped'   => true,
                    'is_remark_filled'      => false,
                ]);
                $lastdowntimeStatus->update(['is_downtime_stopped' => true]);
            }else{
                $downtime = Downtime::create([
                    'workorder_id'          => $lastWorkorderOnProcess->id,
                    'downtime_number'       => $lastdowntimeStatus->downtime_number,
                    'time'                  => 0,
                    'status'                => 'run',
                    'downtime'              => 0,
                    'is_downtime_stopped'   => true,
                    'is_remark_filled'      => false,
                ]);
                $lastdowntimeStatus->update(['is_downtime_stopped' => true]);
                Downtime::create([
                    'workorder_id'          => $lastWorkorderOnProcess->id,
                    'downtime_number'       => Date($machine->id.'YmdHis'),
                    'time'                  => 0,
                    'status'                => 'stop',
                    'downtime'              => 0,
                    'is_downtime_stopped'   => false,
                    'is_remark_filled'      => false,
                ]);
            }
        }
    }
}
