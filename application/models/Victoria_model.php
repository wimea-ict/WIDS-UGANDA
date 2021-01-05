<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Victoria_model extends CI_Model
{

    public $table = 'victoria_data';
    public $id = 'id';
    public $order = 'DESC';
  public $issuetime = 'issuetime';

    function __construct()
    {
        parent::__construct();
    }

   function get_all()
    {  
      $this->db->select('id,forecast_date, issue_date, advice');
      $this->db->from('victoria_data');
      $this->db->order_by('id','DESC');
    return $this->db->get()->result_array();
    }

    public function get_languages(){
      $this->db->from('ussdmenulanguage');
      return $this->db->get()->result_array();
    }

    public function get_deleted_forecast($id)
    {
      $this->db->select('victoria_area.name,victoria_area_data.time');
      $this->db->from('victoria_area_data');
      $this->db->join('victoria_area', 'victoria_area.id = victoria_area_data.vic_area');
      $this->db->where('victoria_area_data.id',$id);
      $query=$this->db->get();
      return $query->result_array();
    }


    function insert($data=array())
    {    $this->db->insert($this->table,$data);    

    }

    function area_forecast_data($id){
      $today = date('Y-m-d');
      $this->db->select('victoria_area_data.id, victoria_area.name as area_name, highlights, victoria_area_data.time, wind_strength.name as wind_strength, wind_direction.name as wind_direction, wave_height.name as wave_height, weather_cond.name as cat_name, rainfall_dist.name as rainfall_dist, visibility.name as visibility, harzard');
      $this->db->from('victoria_area_data');
      $this->db->join('victoria_area','victoria_area.id = victoria_area_data.vic_area');
      $this->db->join('wind_strength','wind_strength.id = victoria_area_data.wind_strength');
      $this->db->join('wind_direction','wind_direction.id = victoria_area_data.wind_direction');
      $this->db->join('wave_height','wave_height.id = victoria_area_data.wave_height');
      $this->db->join('weather_cond','weather_cond.id = victoria_area_data.weather');
      $this->db->join('rainfall_dist','rainfall_dist.id = victoria_area_data.rainfall_dist');
      $this->db->join('visibility','visibility.id= victoria_area_data.visibility');
      $this->db->where('victoria_area_data.forecast_id',$id);
      $this->db->where('victoria_area_data.forecast_id',$id);
      $this->db->order_by('victoria_area_data.id','DESC');
      return $this->db->get()->result_array();

    }

    public function options($table){
      $this->db->select('id, name');
      $this->db->from($table);
      return $this->db->get()->result_array();
    }
    public function options1(){
      $this->db->select('id, cat_name');
      $this->db->from('weather_category');
      return $this->db->get()->result_array();
    }

    public function forecast_checker($f_id, $v_area)
    {
      $this->db->select('victoria_area_data.id,victoria_area.name');
      $this->db->from('victoria_area_data');
      $this->db->join('victoria_area', 'victoria_area.id = victoria_area_data.vic_area');
      $this->db->where('forecast_id',$f_id);
      $this->db->where('vic_area', $v_area);
      $query=$this->db->get();
      return $query->result_array();
    }

    public function insertForecastArea($data=array())
    {  
        $this->db->insert('victoria_area_data',$data);
    }

    function delete_area_forecast($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete("victoria_area_data");
    }

    function delete($id)
    {
        $this->db->from('victoria_data');
        $this->db->where($this->id, $id);
        $row = $this->db->get()->row();
        $this->session->set_userdata('deleted',$row->forecast_date);


        $this->db->where($this->id, $id);
        $this->db->delete("victoria_data");
        $this->db->where('forecast_id', $id);
        $this->db->delete("victoria_area_data");
    }

   function view_forecast_data($landing_site_id){
    $today = date('Y-m-d');
    $today_minus_1 = date('Y-m-d',strtotime('-1 day'));
      $this->db->select('victoria_area.id as identity, victoria_data.forecast_date, victoria_data. issue_date, victoria_data.map, victoria_data.advice, victoria_area_data.id, victoria_area.name as area_name, highlights, victoria_area_data.time as day_time, wind_strength.image_name as wind_strength, wind_strength.name as wind_strength_name, wind_direction.image_name as wind_direction, wind_direction.name as wind_direction_name, wave_height.image_name as wave_height, wave_height.name as wave_height_name, weather_cond.image_name as weather, weather_cond.name as weather_name, rainfall_dist.image_name as rainfall_dist, rainfall_dist.name as rainfall_dist_name, visibility.image_name as visibility, visibility.name as visibility_name, harzard,victoria_area.name as zone,  landing_site.site_name, victoria_districts.name as district,');
      $this->db->from('victoria_area_data');
      $this->db->join('victoria_area','victoria_area.id = victoria_area_data.vic_area');
      $this->db->join('wind_strength','wind_strength.id = victoria_area_data.wind_strength');
      $this->db->join('wind_direction','wind_direction.id = victoria_area_data.wind_direction');
      $this->db->join('wave_height','wave_height.id = victoria_area_data.wave_height');
      $this->db->join('weather_cond','weather_cond.id = victoria_area_data.weather');
      $this->db->join('rainfall_dist','rainfall_dist.id = victoria_area_data.rainfall_dist');
      $this->db->join('visibility','visibility.id= victoria_area_data.visibility');
      $this->db->join('victoria_data','victoria_data.id= victoria_area_data.forecast_id');
       $this->db->join(' victoria_districts', 'victoria_districts.zone_id = victoria_area.id');

      $this->db->join('landing_site', 'landing_site.district_id = victoria_districts.id');

      

      //----between today_plus_1 and today_minus_1----------------------
     // $this->db->where('victoria_data.forecast_date',$today);
       $this->db->where('landing_site.id',$landing_site_id);
       $this->db->where('victoria_data.forecast_date >=',$today_minus_1);
       //------------------------------------------------------------------
      //$this->db->order_by('victoria_area_data.id','ASC');
      $this->db->order_by('victoria_data.forecast_date','DESC');
      



      return $this->db->get()->result_array();
    }

    public function get_landing_site($landing_site_id){
      $this->db->select('*');
      $this->db->from('landing_site');
      $this->db->where('id',$landing_site_id);
     
      return $this->db->get()->result_array();
    }

    public function get_period($id){
      $this->db->from('victoria_periods');
      $this->db->where('id',$id);
      return $this->db->get()->row()->name;
    }



  }
?>
