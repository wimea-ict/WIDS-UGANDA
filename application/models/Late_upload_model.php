<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Late_upload_model extends CI_Model
{

    public $daily_forecast_table = 'daily_forecast';
    public $daily_forecast_data_table = 'daily_forecast_data';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('array');
    }

    public function time_to_decimal($time)
    {
        $timeArr = explode(':', $time);
        $decTime = ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);

        return $decTime;
    }

    public function get_period_data($id, $day)
    {
        $date = $day ? "AND daily_forecast.date >='$day'" : "";
        $condition = "time=$id $date";
        $this->db->select(' DATE_FORMAT(date, "%Y-%m-%d") AS `date`, CAST(daily_forecast.datetime AS TIME) as time');
        $this->db->from($this->daily_forecast_table);
        $this->db->where($condition);
        $this->db->order_by('date', " ASC");

        $query = $this->db->get();
        $records = $query->result_array();
        $items = [];
        $time = "";
        if ($id == 1) {
            $time = "23:30:00";
        } else if ($id == 2) {
            $time = "05:30:00";
        } else if ($id == 3) {
            $time = "11:30:00";
        } else if ($id == 4) {
            $time = "17:30:00";
        } else if ($id == 5) {
            $time = "17:30:00";
        }else if($id==10){
            $time ="11:30:00";
        }
        foreach ($records as $row) {

            $items[] = ['date' => date('Y-m-d', strtotime($row['date'])), 'uploads' => $this->time_to_decimal($row['time']),
                'constant_time' => $this->time_to_decimal($time)];
        }

        return $items;
    }
    public function get_monthly_data($day)
    {  
        
        $this->db->select('CONCAT(issue_date," , ",monthly_forecast.month_from," - ",monthly_forecast.month_to," , ",DATE_FORMAT(monthly_forecast.timestamp, "%Y-%m-%d" )) as date,CAST(monthly_forecast.timestamp AS TIME) as time ');
        $this->db->from("monthly_forecast");
        $day ?$this->db->where( "monthly_forecast.timestamp >='$day'") : "";
        $this->db->order_by('issue_date', " ASC");

        $query = $this->db->get();
        $records = $query->result_array();
        $items = [];

        foreach ($records as $row) {

            $items[] = ['date' => $row['date'], 'uploads' => $this->time_to_decimal($row['time'])];
        }

        return $items;
    }
    public function get_seasonal_data()
    {
        

        $this->db->select('CONCAT(seasonal_forecast.issuetime," , ",season_months.abbreviation," , ",DATE_FORMAT(seasonal_forecast.created, "%Y-%m-%d")) as date,CAST(seasonal_forecast.created AS TIME) as time');
        $this->db->from("seasonal_forecast");
        $this->db->join("season_months", "season_months.id=seasonal_forecast.season_id");
        $day ? $this->db->where("seasonal_forecast.created >='$day'") : "";
        $this->db->order_by('issuetime', " ASC");

        $query = $this->db->get();
        $records = $query->result_array();
        $items = [];

        foreach ($records as $row) {

            $items[] = ['date' => $row['date'], 'uploads' => $this->time_to_decimal($row['time'])];
        }

        return $items;
    }
    // public function get_period_data_not_uploaded($id)
    // {

    //     $this->db->select(' DATE_FORMAT(daily_forecast.date, "%Y-%m-%d") AS date, COUNT(`date`) AS count');
    //     $this->db->from($this->daily_forecast_table, "region");
    //     $this->db->join($this->daily_forecast_data_table, "daily_forecast.id = daily_forecast_data.forecast_id");

    //     $this->db->where("time=$id AND (daily_forecast_data.forecast_id=daily_forecast.id and region.id NOT in (SELECT region_id from daily_forecast_data where forecast_id=daily_forecast.id))");
    //     $this->db->group_by('daily_forecast.id');
    //     $this->db->order_by('date', " ASC");
    //     $query = $this->db->get();
    //     $records = $query->result_array();
    //     $get_ids = $this->get_forecast_count_data();
    //     $items = [];
    //     foreach ($records as $row) {
    //         //foreach()
    //         $items[] = ['date' => date('Y-m-d', strtotime($row['date'])), 'uploads' => $id == 5 ? (int) $row['count'] / 4 : $row['count']];
    //     }
    //     return $items;

    // }
    // private function get_forecast_count_data()
    // {
    //     $this->db->select("count(*) as count,forecast_id");
    //     $this->db->from("daily_forecast_data", "daily_forecast");
    //     $this->db->where("daily_forecast_data.forecast_id=daily_forecast.id");
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

}

//SELECT count(*) as count,forecast_id from daily_forecast_data , daily_forecast where daily_forecast_data.forecast_id=daily_forecast.id
//GROUP BY forecast_id

// function used to get information for a total upload time per forecast.
// private function query_graph_date($type, $table_name)
// {

//     $items = [];
//     if ($type == 'day') {
//         $cond = $table_name == "daily_forecast" ? 'WHERE time != 5' : '';
//         $query = $this->db->query("SELECT DATE_FORMAT(datetime, '%Y-%m-%d') AS `date`, COUNT(`datetime`) as count FROM $table_name  $cond GROUP BY DAY(`datetime`) ORDER BY `date` ASC");

//         $records = $query->result_array();

//         foreach ($records as $row) {

//             $items[] = ['date' => date('Y-m-d', strtotime($row['date'])), 'uploads' => $row['count']];
//         }

//     } else if ($type == 'month' || $type == 'month24') {
//         $cond = ($type == 'month24' ? 'WHERE time = 5' : ($table_name == "daily_forecast" ? 'WHERE time != 5' : ''));
//         $query = $this->db->query("SELECT DATE_FORMAT(datetime, '%Y-%m') AS `date`, COUNT(`datetime`) as count FROM $table_name $cond GROUP BY MONTH(`datetime`)  ORDER BY `date` ASC");

//         $records = $query->result_array();
//         foreach ($records as $row) {

//             $items[] = ['date' => date('Y-m', strtotime($row['date'])), 'uploads' => $row['count']];
//         }

//     } else if ($type == 'year' || $type == 'year24') {
//         $cond = ($type == 'year24' ? 'WHERE time = 5' : ($table_name == "daily_forecast" ? 'WHERE time != 5' : ''));
//         $query = $this->db->query("SELECT DATE_FORMAT(datetime, '%Y-%m-%d') AS `date`, COUNT(`datetime`) as count FROM $table_name $cond  GROUP BY YEAR(`datetime`)  ORDER BY `date` ASC");

//         $records = $query->result_array();
//         foreach ($records as $row) {

//             $items[] = ['date' => date('Y-m-d', strtotime($row['date'])), 'uploads' => $row['count']];
//         }

//     } else {
//         $cond = ($type == '24hourlyweek' ? 'WHERE time = 5' : ($table_name == "daily_forecast" ? 'WHERE time != 5' : ''));
//         $query = $this->db->query("SELECT DATE_FORMAT(datetime, '%Y-%m-%d') AS `date`, COUNT(`datetime`) as count FROM $table_name  $cond GROUP BY WEEK(`datetime`) ORDER BY `date` ASC");

//         $records = $query->result_array();

//         foreach ($records as $row) {

//             $items[] = ['date' => date('Y-m-d', strtotime($row['date'])), 'uploads' => $row['count']];
//         }

//     }

//     return $items;
// }

// $data['chart_data'] = json_encode($items);
// $data['chart_title'] = "Daily Forecast Upload Variations";
// $dates = [];
// // get information for late uploads per period
// $items1 = $this->Late_upload_model->get_period_data(1);
// $items2 = $this->Late_upload_model->get_period_data(2);
// $items3 = $this->Late_upload_model->get_period_data(3);
// $items4 = $this->Late_upload_model->get_period_data(4);
// $items5 = $this->Late_upload_model->get_period_data(5);
// //get all dates
// for ($i = 1; $i < 6; $i++) {
//     $list = $this->Late_upload_model->get_period_data($i);

//     foreach ($list as $row) {
//         $dates[] = date('Y-m-d', strtotime($row['date']));
//     }

// }

// $late_data = [];
// // sort the dates
// asort($dates);
// foreach ($dates as $day) {

//     $late_data[] = [
//         'date' => $day,
//         'early_mornig' => (int) array_values(array_filter($items1, function ($record) use ($day) {return $record['date'] == $day;}))[0]["uploads"] / 1,
//         'late_morning' => (int) array_values(array_filter($items2, function ($record) use ($day) {return $record['date'] == $day;}))[0]["uploads"] / 1,
//         'afternoon' => (int) array_values(array_filter($items3, function ($record) use ($day) {return $record['date'] == $day;}))[0]["uploads"] / 1,
//         'late_afternoon' => (int) array_values(array_filter($items4, function ($record) use ($day) {return $record['date'] == $day;}))[0]["uploads"] / 1,
//         '24hourly' => (int) array_values(array_filter($items5, function ($record) use ($day) {return $record['date'] == $day;}))[0]["uploads"] / 1,
//     ];
// }
