<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Email_model extends CI_Model
{

    public $table_users = 'users';
    public $table_daily_forecast = 'daily_forecast';
    public $table_seasonal_forecast = 'seasonal_forecast';
    public $table_season_months = 'season_months';
    public $table_daily_forecast_data = 'daily_forecast_data';
    public $usertype = 'supervisor';
    //public $name='username';

    public function __construct()
    {
        parent::__construct();
    }
    // get supervisor's email
    public function get_by_id()
    {
        $this->db->select('email');
        $this->db->from($this->table_users);
        $this->db->where('usertype', $this->usertype);
        $query = $this->db->get();
        //return $query->row();
        // var_dump($query);
        $email_list = [];
        foreach ($query->result() as $row) {

            array_push($email_list, $row->email);
        }
        return $email_list;
        //if ($query->num_rows() == 1)
        //   {

        //    $val = $query->row();
        // $dat = $query->result_array();
        //var_dump($dat);
        // $dat = return  var_dump($val);
        //return $val['email'];
        // $result = (array) json_decode($val);
        //return $query;
        //return $val->result;
        // return $val->email;
        //echo $this->id;
        // }
        // else{
        //  echo   'sorry many';
        // print_r('no row');
        //  }

    }
    // update data
    /* public function getEmail($id)
    {
    $this->db->select('email');
    $this->db->from('users');
    $this->db->where('id', $id);

    //$this->db->order_by('seasonal_updates.issue_time', $this->order);
    $query=$this->db->get();
    //return $query->row();
    if ($query->num_rows() == 1)
    {
    $val = $query->row();
    return $val->result;
    }
    else{
    print_r();
    }
    }*/

    // public function get_forecast_data()
    // {
    //     $this->db->select('issue_date');
    //     $this->db->from($this->table_daily_forecast);
    //     $this->db->where('usertype', $this->usertype);
    //     $query = $this->db->get();

    // }

    //format date uploaded
    public function format_date($date)
    {

        return $date;
    }
    // check for forecast upload status
    public function get_daily_upload_status()
    {
        date_default_timezone_set("Africa/Nairobi");

        $this->db->select('date,issuedate,region_id');
        $this->db->from($this->table_daily_forecast_data);
        $this->db->join($this->table_daily_forecast, $this->table_daily_forecast . ".id=" . $this->table_daily_forecast_data . ".forecast_id");
        $this->db->where('date >=', date("Y-m-d"));
        $query = $this->db->get();
        // foreach ($query->result() as $row) {

        //     echo $row->date . "\t";
        //     echo $row->issuedate . "\t";
        //     echo $row->region_id . "\n";
        // }

        if ($query->num_rows() >= 1) {
            echo "no emails have been sent";
            // upload for the next available
            return false;
        } else {
            // no upload for the next day
            echo "sending emails";
            return true;
        }
    }
    // TODO : seasonal reminder
  
    // public function get_seasonal_upload_status()
    // {
    //     date_default_timezone_set("Africa/Nairobi");

    //     $this->db->select('month_from,month_to,year');
    //     $this->db->from($this->table_seasonal_forecast);
    //     $this->db->join($this->table_season_months, $this->table_season_months . ".id=" . $this->table_seasonal_forecast . ".season_id");
    //     $this->db->where('year >=', date("Y"));
    //     $query = $this->db->get();

    //     if ($query->num_rows() >= 1) {

    //         foreach ($query->result() as $row) {

    //             echo $row->date . "\t";
    //             echo $row->issuedate . "\t";
    //             echo $row->region_id . "\n";
    //         }

    //         echo "no emails have been sent";
    //         // upload for the next available
    //         return false;
    //     } else {
    //         // no upload for the next day
    //         echo "sending emails";
    //         return true;
    //     }
    // }

}
