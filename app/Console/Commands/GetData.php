<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
class GetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {

        $data = Date("Y M d");

        $list = $this->getdatalist();

// Open a file in write mode ('w')
        $fp = fopen('file/File'.$data.'.csv', 'w');

// Loop through file pointer and a line
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);


        \Log::info("Cron is working fine!");
        $this->info(' Command Run successfully!');

    }
    public function getdatalist()
    {
        $salary_date ="";
        $bonus_date ="";

        $list = array(
            ['Month','Salary','Bonus'],
        );

        $getYear = date('Y');


        $i = 1;
        while ($i <= 12)
        {

            $Bonusdate    =  $last_day = \Carbon\Carbon::parse($getYear."-".$i."-10")->addMonth()->toDateString();


            $last_day = \Carbon\Carbon::parse($getYear."-".$i)->endOfMonth()->toDateString();

            $LM = date("l", strtotime($last_day));
            $bM = date("l", strtotime($Bonusdate));


            if($LM == "Saturday")
            {
                $salary_date = date('Y-M-d l', strtotime($last_day . ' -1 day'));
            }
            else if($LM == "Sunday"){

                $salary_date = date('Y-M-d l', strtotime($last_day . ' -2 day'));
            }
            else
            {
                $salary_date = $last_day;
            }


            if($bM == "Saturday")
            {
                $bonus_date = date('Y-M-d l', strtotime($Bonusdate . ' +3 day'));
            }
            else if($bM == "Sunday"){
                $bonus_date = date('Y-M-d l', strtotime($Bonusdate . ' +2 day'));
            }
            else
            {
                $bonus_date = date('Y-M-d l', strtotime($Bonusdate ));
            }


            $year = date('M Y', strtotime($salary_date));
            $date = date('D d M', strtotime($salary_date));
            $Bonus = date('D d M', strtotime($bonus_date));
            array_push($list,[$year,$date,$Bonus]);


            $i++;
        }
        return $list;
    }
}
