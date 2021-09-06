<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Email_cronjob extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->config('email');
        //$this->load->library('input');
    }

    public function Early_reminder()
    {

        date_default_timezone_set("Africa/Nairobi");

        $this->load->model('Email_model');
        // This is about remindering users to upload the data five minutes.
        // $i = strtotime(date("H:i:s"));
        // $time = "";
        // switch ($i) {
        //     case $i >= strtotime("23:55:00") && $i < strtotime("00:00:00"):
        //         $time = "Early Morning 6 hourly forecast";
        //         break;
        //     case $i >= strtotime("05:55:00") && $i < strtotime("06:00:00"):
        //         $time = "Late Morning 6 hourly forecast";
        //         break;
        //     case $i >= strtotime("11:55:00") && $i < strtotime("12:00:00"):
        //         $time = "Afternoon 6 hourly forecast";
        //         break;
        //     case $i >= strtotime("14:17:00") && $i < strtotime("14:30:00"):
        //         $time = "aftermath 6 hourly  forecast";
        //         break;
        // }
        // $message = "This is a reminder that the  $time has not yet been uploaded.";

        // check if no data has been recieved
        // TODO : check for particular regions
        // TODO : create supervisor field for each region
        // TODO : Ensure validity for date of upload and restrict the user from making errors.
        // TODO : Set specific upload time. for the users.
        $this->Email_model->get_daily_upload_status();
        if ($this->Email_model->get_daily_upload_status()) {
            $message = "This is a reminder that the 6 hourly or 24 hourly forecast has not yet been uploaded.
            If you have already uploaded ,kindly ingore the message.";

            $from = $this->config->item('smtp_user');
            $to = $this->Email_model->get_by_id();
            $subject = 'WIDS-upload Reminder';
            //send emails.

            foreach ($to as $row) {
                $this->email->set_newline("\r\n");
                $this->email->from($from);
                $this->email->to($row);
                $this->email->subject($subject);
                $this->email->message($message);
                if ($this->email->send()) {
                    echo 'Your Email has successfully been sent.';
                } else {
                    show_error($this->email->print_debugger());
                }
            }

        }

    }

    public function Late_notification()
    {

        date_default_timezone_set("Africa/Nairobi");

        $this->load->model('Email_model');
        $i = strtotime(date("H:i:s"));
        $time = "";
        switch ($i) {
            case $i >= strtotime("00:00:00") && $i < strtotime("00:05:00"):
                $time = "Early Morning 6 hourly forecast ";
                break;
            case $i >= strtotime("06:00:00") && $i < strtotime("06:05:00"):
                $time = "Late Morning 6 hourly forecast ";
                break;
            case $i >= strtotime("12:00:00") && $i < strtotime("12:05:00"):
                $time = "Afternoon 6 hourly forecast";
                break;
            case $i >= strtotime("14:17:00") && $i < strtotime("14:30:00"):
                $time = "aftermath 6 hourly forecast";
                break;
        }
        $message = "Hey, it seems the $time was  uploaded late.";
        if (strtotime(date("H:i:s")) >= strtotime("17:50:00") && strtotime(date("H:i:s")) < strtotime("18:00:00")) {
            $message = "Evening 6 hourly and 24 hourly forecast has not yet been uploaded.";
        }

        $from = $this->config->item('smtp_user');
        $to = $this->Email_model->get_by_id();
        $subject = 'Weather';

        foreach ($to as $row) {
            $this->email->set_newline("\r\n");
            $this->email->from($from);
            $this->email->to($row);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($this->email->send()) {
                echo 'Your Email has successfully been sent.';
            } else {
                show_error($this->email->print_debugger());
            }
        }

    }
    // public function Daily_24hrs()
    // {
    //     $this->load->model('Email_model');
    //     //$this->load->model('Email_model');

    //     $from = $this->config->item('smtp_user');
    //     $to = $this->Email_model->get_by_id();
    //     $subject = 'Weather';
    //     $message = "Hey, it seems the next 24 hours forecast has not yet been uploaded. This is to serve as a reminder to you.";
    //     foreach ($to as $row) {
    //         $this->email->set_newline("\r\n");
    //         $this->email->from($from);
    //         $this->email->to($row);
    //         $this->email->subject($subject);
    //         $this->email->message($message);
    //         if ($this->email->send()) {
    //             echo 'Your Email has successfully been sent.';
    //         } else {
    //             show_error($this->email->print_debugger());
    //         }
    //     }

    // }

}
