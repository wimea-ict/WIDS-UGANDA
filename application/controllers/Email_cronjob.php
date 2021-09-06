<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');

}
class Email_cronjob extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');  
        $this->load->config('email');
        $this->load->model('Email_model');
        $this->load->library('email');
    
    }
public function index(){
date_default_timezone_set("Africa/Kampala");
$month =date("m");
$current_full_date = date("Y-d-m");
$tomorrow = date("Y-m-d", strtotime('tomorrow'));
$yesterday = date("Y-m-d", strtotime('-1 day'));
$day_of_month = date("d-m");
$date = date("d");
$year =date("Y");
$next_year =date("Y",strtotime("+1 year"));
$time = date("H:m:s");
$message ="";
 switch($time){
     case  $time >= date("05:00:00") &&  $time <= date("10:59:00"):
        $this->Email_model->daily_early_morning_upload_status();
        if(! $this->Email_model->daily_early_morning_upload_status()){
            $message = " The  $current_full_date 6 hourly Early_Morning forecast was not uploaded";

        }
        $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo ' Email sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }
        $this->Email_model->daily_late_morning_upload_status();
        if(! $this->Email_model->daily_late_morning_upload_status()){
        $message = " This is a reminder for the next Late_morning forecast";
        } elseif($this->Email_model->daily_late_morning_upload_status()){
            $items = $this->Email_model->daily_late_morning_upload_status();
            $time = $items[0]['time'];
            $uploadtime = $items[0]['uploadtime'];
            if($time > date("5:30:00")){
                 $message = "The  $current_full_date Late_morning forecast was uploded at $uploadtime " ;

             } else{
                $message = "The $current_full_date Late_morning forecast was uploded at $uploadtime ";
             }

        }
     break;

     case $time >= date("11:00:00") && $time <= date("16:59:00") :
        $this->Email_model->daily_late_morning_upload_status();
        if(!$this->Email_model->daily_late_morning_upload_status()){
            $message = " The $current_full_date Late_Morning forecast was not uploaded";
        } 
    $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo ' daily 24 hourly sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }

        $this->Email_model->daily_afternoon_upload_status();
        if(! $this->Email_model->daily_afternoon_upload_status()){
            $message = " This is a reminder for the $current_full_date afternoon forecast";

        } elseif($this->Email_model->daily_afternoon_upload_status()){
            $items = $this->Email_model->daily_afternoon_upload_status();
            $time = $items[0]['time'];
            $uploadtime = $items[0]['uploadtime'];
             if($time > date("11:30:00")){
                 $message = "The $current_full_date afternoon forecast was uploded at $uploadtime";

             } else{
                $message = "The $current_full_date afternoon forecast was uploded at $uploadtime ";
             }
            }
     break;
     
        case $time >= date("17:00:00") && $time <= date("22:59:00") :
       
        $this->Email_model->daily_afternoon_upload_status();
        if(!$this->Email_model->daily_afternoon_upload_status()){
            $message = " The $current_full_date afternoon forecast was not uploaded";
        } ########################################
    $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo ' daily 24 hourly sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }
            $this->Email_model->daily_24hr_upload_status();
            if(! $this->Email_model->daily_24hr_upload_status()){
            $message = " This is a reminder for the $current_full_date-$tomorrow 24 hourly  daily forecast";
        
         } elseif($this->Email_model->daily_24hr_upload_status()){
         $items = $this->Email_model->daily_24hr_upload_status();
         $time = $items[0]['time'];
         $uploadtime = $items[0]['uploadtime'];
         if($time > date("17:30:00")){
         $message = "The $current_full_date-$tomorrow  24 hourly daily forecast was uploded at $uploadtime";
         } else{
        $message = "The $current_full_date-$tomorrow  24 hourly daily forecast was uploded at $uploadtime ";
         }
           }  ############################################################
   $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo ' daily 24 hourly sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }
   $this->Email_model->daily_evening_upload_status();
        if(! $this->Email_model->daily_evening_upload_status()){
            $message = " This is a reminder for the $current_full_date 6hourly evening daily forecast";

        } elseif($this->Email_model->daily_evening_upload_status()){
            $items = $this->Email_model->daily_evening_upload_status();
            $time = $items[0]['time'];
            $uploadtime = $items[0]['uploadtime'];
             if($time > date("17:30:00")){
                 $message = "The $current_full_date evening forecast was uploded at $uploadtime";

             } else{
                $message = "The $current_full_date evening forecast was uploded at $uploadtime ";
             }
            }
        
     break;

     case $time >= date("23:00:00")  && $time <= date("00:00:00") :
        $this->Email_model->daily_evening_upload_status();
        if(! $this->Email_model->daily_evening_upload_status()){
            $message = " The $current_full_date  6 hourly evening daily forecast was not uploaded ";

        }
    $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo ' daily sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }
        //###################################################################################
        $this->Email_model->daily_early_morning_upload_status();
        if(! $this->Email_model->daily_early_morning_upload_status()){
            $message = " This is a reminder for the $tomorrow 6hourly early daily forecast";

        } elseif($this->Email_model->daily_early_morning_upload_status()){
            $items = $this->Email_model->daily_early_morning_upload_status();
            $time = $items[0]['time'];
            $uploadtime = $items[0]['uploadtime'];
             if($time > date("23:30:00")){
                 $message = "The $tomorrow early morning forecast was uploded at $uploadtime";

             } else{
                $message = "The $tomorrow Early morning forecast was uploded at $uploadtime ";
             }
            }
     break;
     case $time >= date("00:01:00")  && $time <= date("04:59:00") :
        $this->Email_model->daily_early_morning_upload_status();
        if(! $this->Email_model->daily_early_morning_upload_status()){
            $message = " This is a reminder for the $current_full_date 6hourly early daily forecast";

        } elseif($this->Email_model->daily_early_morning_upload_status()){
            $items = $this->Email_model->daily_early_morning_upload_status();
            $time = $items[0]['time'];
            $uploadtime = $items[0]['uploadtime'];
             if($time > date("23:30:00")){
                 $message = "The $current_full_date early morning forecast was uploded at $uploadtime";

             } else{
                $message = "The $current_full_date  Early morning forecast was uploded at $uploadtime ";
             }
            }
     break;
    default:
    $message = "No  time selected ";
    break;
         
         //sending emails
    $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo ' daily sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }
 }
/* For the seasonal forecast reminders 
   seasonal forecast reminders
*/

   if ($month ==  2){ //Feb
    if($date > 25 && ($date <= 28 || $date <=29)){
    $this->Email_model->get_MAM_season_upload_status();
       if(! $this->Email_model->get_MAM_season_upload_status()){
           $message = " This is a reminder for the $year MAM seasonal forecast";
       }elseif($this->Email_model->get_MAM_season_upload_status()){
        $items = $this->Email_model->get_MAM_season_upload_status();
        $uploadtime = $items[0]['uploadtime'];  
        $message =" The $year MAM seasonal forecast was uploaded at $uploadtime";
       }
    }
    }
       elseif($month == 5){ //May
        if($date > 28 && $date <= 31){
        $this->Email_model->get_JJA_season_upload_status();
        if(! $this->Email_model->get_JJA_season_upload_status()){
            $message = " This is a reminder for the $year JJA seasonal forecast";  
        }
        elseif($this->Email_model->get_JJA_season_upload_status()){
            $items = $this->Email_model->get_JJA_season_upload_status();
            $uploadtime = $items[0]['uploadtime'];  
            $message =" The $year JJA seasonal forecast was uploaded at $uploadtime";
           }
        }

       }
       elseif($month ==  8){ //Aug
        if($date > 28 && $date <= 31){
        $this->Email_model->get_SOND_season_upload_status();
        if(! $this->Email_model->get_SOND_season_upload_status()){
            $message = " This is a reminder for the $year SOND seasonal forecast";  
        }
        elseif($this->Email_model->get_SOND_season_upload_status()){
            $items = $this->Email_model->get_SOND_season_upload_status();
            $uploadtime = $items[0]['uploadtime'];  
            $message =" The $year SOND seasonal forecast was uploaded at $uploadtime";
           }
        }

       }
       elseif($month == 12){ //Dec
        if($date > 28 && $date <= 31){
        $this->Email_model->get_JF_season_upload_status();
        if(! $this->Email_model->get_JF_season_upload_status()){
            $message = " This is a reminder for the $next_year JF seasonal forecast";  
        }
        elseif($this->Email_model->get_JF_season_upload_status()){
            $items = $this->Email_model->get_JF_season_upload_status();
            //$time = $items[0]['uploadtime'];
            $uploadtime = $items[0]['uploadtime'];  
            $message =" The $next_year  JF seasonal forecast was uploaded at $uploadtime";
           }
        }

       } 

       //sending emails
       $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo 'seasonal sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }
   

   /* For the monthly forecast reminders 
   monthly forecast reminders
*/
   // $lmonth = date("t-m");
   if ($day_of_month == date("t-m")){
    $this->Email_model->get_monthly_upload_status();
       if(! $this->Email_model->get_monthly_upload_status()){
           $message = " This is a reminder for the next monthly forecast";
       
           $from = $this->config->item('smtp_user');
           $to = $this->Email_model->get_by_id();
           $subject = 'WIDS-upload Reminder';
               
             foreach ($to as $row) {
                   
                   $this->email->from($from);
                   $this->email->to($row);
                   $this->email->subject($subject);
                   $this->email->message($message);
                   $this->email->set_newline("\r\n");
                   if ($this->email->send()) {
                       echo ' monthly sucess   ';
                   } else {
                       show_error($this->email->print_debugger());
                  }
          }
       
       
        }
       //##############################
    
     //#####################
       elseif($this->Email_model->get_monthly_upload_status()){
        $items = $this->Email_model->get_monthly_upload_status();
        //$time = $items[0]['uploadtime'];
        $uploadtime = $items[0]['uploadtime'];  
        $message =" The next monthly  forecast was uploaded at $uploadtime";
    
     //$this->Sending_emails();

       $from = $this->config->item('smtp_user');
       $to = $this->Email_model->get_by_id();
       $subject = 'WIDS-upload Reminder';
           
         foreach ($to as $row) {
               
               $this->email->from($from);
               $this->email->to($row);
               $this->email->subject($subject);
               $this->email->message($message);
               $this->email->set_newline("\r\n");
               if ($this->email->send()) {
                   echo ' monthly sucess   ';
               } else {
                   show_error($this->email->print_debugger());
              }
      }

}
   }
}



/* //public function Sending_emails(){
    //sending emails
    $from = $this->config->item('smtp_user');
    $to = $this->Email_model->get_by_id();
    $subject = 'WIDS-upload Reminder';
        
      foreach ($to as $row) {
            
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            $this->email->set_newline("\r\n");
            if ($this->email->send()) {
                echo ' monthly sucess   ';
            } else {
                show_error($this->email->print_debugger());
           }
   }

}*/
}
?>