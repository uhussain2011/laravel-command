<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CsvFile extends Controller
{
    public function index()
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

              $Bonusdate    =  $last_day = \Carbon\Carbon::parse($getYear."-".$i."-10")->subMonth()->toDateString();


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
                 $bonus_date = date('Y-M-d l', strtotime($Bonusdate . ' -1 day'));
            }
            else if($bM == "Sunday"){
                 $bonus_date = date('Y-M-d l', strtotime($Bonusdate . ' -2 day'));
            }
            else
            {
                 $bonus_date = date('Y-M-d l', strtotime($Bonusdate ));
            }


             $year = date('M-Y', strtotime($salary_date));
             $date = date('d-M', strtotime($salary_date));
             $Bonus = date('d-M', strtotime($bonus_date));
           array_push($list,[$year,$date,$Bonus]);


            $i++;
        }
        return $list;
    }
}
