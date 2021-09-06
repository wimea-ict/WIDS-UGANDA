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
    public $table_monthly_forecast = 'monthly_forecast';
    public $usertype = 'supervisor';
    
    //public $name='username';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
    }
    // get supervisor's email
    public function get_by_id()
    {
        $this->db->select('email');
        $this->db->from($this->table_users);
        $this->db->where('usertype', $this->usertype);
        $query = $this->db->get();
        //return $query->row();  var_dump($query);
        $email_list = [];
        foreach ($query->result() as $row) {
         array_push($email_list, $row->email);
        }
        return $email_list;
         }
     //format date uploaded
    public function format_date($date)
    {
        return $date;
    }

    // check for forecast upload status
    public function daily_late_morning_upload_status()
    { 
        date_default_timezone_set("Africa/Nairobi");
        $this->db->select('CAST(datetime AS time) as time, CAST( datetime AS date) as date, datetime, daily_forecast.date as forecastdate, time as type');
        $this->db->from($this->table_daily_forecast);
        $where = array(
            'daily_forecast.date' => date('Y-m-d'),
            'time'   => 2
          );
         $this->db->where($where);
         $query = $this->db->get();
        if ($query->num_rows() >= 1){ 
        $result= $query->result_array();
        $values=[];  
        foreach($result as $row){
        $values[] = [ 'date' => $row['date'], 'time' => $row['time'], 'uploadtime' => $row['datetime'], 'type' => $row['type'], 'forecastdate'=> $row['forecastdate']];
        }
       return $values;
        } else {  // no upload for the next day
            return false;
        }
      //var_dump($values);
     }
    public function daily_afternoon_upload_status()
    { 
        date_default_timezone_set("Africa/Nairobi");
        $this->db->select('CAST(datetime AS time) as time, CAST( datetime AS date) as date, datetime, daily_forecast.date as forecastdate, time as type');
        $this->db->from($this->table_daily_forecast);
        $where = array(
            'daily_forecast.date ' => date('Y-m-d'),
            'time'   => 3 );
         $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >= 1){ 
        $result= $query->result_array();
        $values=[];  
        foreach($result as $row){
        $values[] = [ 'date' => $row['date'], 'time' => $row['time'], 'uploadtime' => $row['datetime'], 'type' => $row['type'], 'forecastdate'=> $row['forecastdate']];
        }
       return $values;
        } else {  // no upload for the next day
            return false;
        }
      //var_dump($values);
    }
    public function daily_evening_upload_status()
    { 
        date_default_timezone_set("Africa/Nairobi");
        $this->db->select('CAST(datetime AS time) as time, CAST( datetime AS date) as date, datetime, daily_forecast.date as forecastdate, time as type');
        $this->db->from($this->table_daily_forecast);
        $where = array(
            'daily_forecast.date' => date('Y-m-d'),
            'time'   => 4 );
         $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >= 1){ 
        $result= $query->result_array();
        $values=[];  
        foreach($result as $row){
        $values[] = [ 'date' => $row['date'], 'time' => $row['time'], 'uploadtime' => $row['datetime'], 'type' => $row['type'], 'forecastdate'=> $row['forecastdate']];
        }
       return $values;
        } else {  // no upload for the next day
            return false;
        }
      //var_dump($values);
    }
    public function daily_early_morning_upload_status()
    { 
        date_default_timezone_set("Africa/Nairobi");
        $this->db->select('CAST(datetime AS time) as time, CAST( datetime AS date) as date, datetime, daily_forecast.date as forecastdate, time as type');
        $this->db->from($this->table_daily_forecast);
        $where = array(
            'daily_forecast.date' => date('Y-m-d'),
            'time'   => 1);
         $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >= 1){ 
        $result= $query->result_array();
        $values=[];  
        foreach($result as $row){
        $values[] = [ 'date' => $row['date'], 'time' => $row['time'], 'uploadtime' => $row['datetime'], 'type' => $row['type'], 'forecastdate'=> $row['forecastdate']];
        }
       return $values;
        } else {  // no upload for the next day
            return false;
        }
      //var_dump($values);
    }
    public function daily_24hr_upload_status()
    { 
        date_default_timezone_set("Africa/Nairobi");
        $this->db->select('CAST(datetime AS time) as time, CAST( datetime AS date) as date, datetime, daily_forecast.date as forecastdate, time as type');
        $this->db->from($this->table_daily_forecast);
        $where = array(
            'daily_forecast.date' => date('Y-m-d'),
            'time'   => 5);
         $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >= 1){ 
        $result= $query->result_array();
        $values=[];  
        foreach($result as $row){
        $values[] = [ 'date' => $row['date'], 'time' => $row['time'], 'uploadtime' => $row['datetime'], 'type' => $row['type'], 'forecastdate'=> $row['forecastdate']];
        }
       return $values;
        } else {  // no upload for the next day
            return false;
        }
      //var_dump($values);
    }

/* Pulling details from the database for the seasonal forecast
     seasonal forecast reminders
*/

   public function get_MAM_season_upload_status()
     {
    date_default_timezone_set("Africa/Nairobi");
     $this->db->select('month_from,month_to,year,abbreviation,created');
     $this->db->from($this->table_seasonal_forecast);
     $this->db->join($this->table_season_months, $this->table_season_months . ".id=" . $this->table_seasonal_forecast . ".season_id");
     $where = array(
         'season_id' =>2,
        //'month_from >' => date('m'),
        'year ='   => date('Y')
    );
     $this->db->where($where);
     $query = $this->db->get();
     if ($query->num_rows() >= 1) {
           $records = $query->result_array();
           $items= [];
           foreach ($records as $row) {
           $items[] = ['start' => $row['month_from'], 'end' => $row['month_to'], 'season' => $row['abbreviation'], 'uploadtime' => $row['created']];
             }
        return $items;
         } else {
             // no upload for the next day
              return false;
         }
  //var_dump($items);
         }
         public function get_JJA_season_upload_status()
     {
    date_default_timezone_set("Africa/Nairobi");
     $this->db->select('month_from,month_to,year,abbreviation,created');
     $this->db->from($this->table_seasonal_forecast);
     $this->db->join($this->table_season_months, $this->table_season_months . ".id=" . $this->table_seasonal_forecast . ".season_id");
     $where = array(
         'season_id' =>3,
        //'month_from >' => date('m'),
        'year ='   => date('Y')
    );
     $this->db->where($where);
     $query = $this->db->get();
     if ($query->num_rows() >= 1) {
           $records = $query->result_array();
           $items= [];
           foreach ($records as $row) {
           $items[] = ['start' => $row['month_from'], 'end' => $row['month_to'], 'season' => $row['abbreviation'], 'uploadtime' => $row['created']];
             }
        return $items;
         } else {
             // no upload for the next day
              return false;
         }
  //var_dump($items);
         }
        public function get_SOND_season_upload_status()
     {
    date_default_timezone_set("Africa/Nairobi");
     $this->db->select('month_from,month_to,year,abbreviation,created');
     $this->db->from($this->table_seasonal_forecast);
     $this->db->join($this->table_season_months, $this->table_season_months . ".id=" . $this->table_seasonal_forecast . ".season_id");
     $where = array(
         'season_id' =>1,
        //'month_from >' => date('m'),
        'year >=' => date('Y')
    );
     $this->db->where($where);
     $query = $this->db->get();
     if ($query->num_rows() >= 1) {
           $records = $query->result_array();
           $items= [];
           foreach ($records as $row) {
           $items[] = ['start' => $row['month_from'], 'end' => $row['month_to'], 'season' => $row['abbreviation'], 'uploadtime' => $row['created']];
             }
        return $items;
         } else {
             // no upload for the next day
              return false;
         }
  //var_dump($items);
         }
      public function get_JF_season_upload_status()
     {
    date_default_timezone_set("Africa/Nairobi");
     $this->db->select('month_from,month_to,year,abbreviation,created');
     $this->db->from($this->table_seasonal_forecast);
     $this->db->join($this->table_season_months, $this->table_season_months . ".id=" . $this->table_seasonal_forecast . ".season_id");
     $where = array(
         'season_id' =>4,
        //'month_from >' => date('m'),
        'year ='   => date('Y')
    );
     $this->db->where($where);
     $query = $this->db->get();
     if ($query->num_rows() >= 1) {
           $records = $query->result_array();
           $items= [];
           foreach ($records as $row) {
           $items[] = ['start' => $row['month_from'], 'end' => $row['month_to'], 'season' => $row['abbreviation'], 'uploadtime' => $row['created']];
             }
        return $items;
         } else {
             // no upload for the next day
              return false;
         }
  //var_dump($items);
         }





    /* Pulling details from the database for the monthly forecast
     monthly forecast reminder
*/
         public function get_monthly_upload_status(){
            date_default_timezone_set("Africa/Nairobi");
            //$query = $this->db->query('SELECT CAST(timestamp AS time) as time, CAST(timestamp AS date) as date, month_from,from_to, issue_date');
            $this->db->select('CAST(timestamp AS time) as  time, CAST(timestamp AS date) as date, month_from, month_to, timestamp');
            $this->db->from($this->table_monthly_forecast);
            $where = array(
                'month_from >' => date('m'),
                'year >='   => date('Y')
            );
             $this->db->where($where);
            $query = $this->db->get();

            if ($query->num_rows() >= 1){
                $results = $query->result_array();
                $values = [];
                foreach ($results as $row){
                $values[] = ['start' => $row['month_from'], 'finish' => $row['month_to'], 'uploadtime' => $row['timestamp'], 'time' => $row['time'], 'date' => $row['date']];
                
            }
             return $values;

            } else {
                return false;
            }
            //var_dump($values);
         }

}
?>