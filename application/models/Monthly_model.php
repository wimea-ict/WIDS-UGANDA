<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Monthly_model extends CI_Model
{

  public $table = 'monthly_forecast';
  public $table2 = 'monthly_advisories';
  public $id = 'id';
  public $order = 'DESC';

  function __construct()
  {
    parent::__construct();
  }


    function check_existence( $f_id, $sect){
            $this->db->select('id');
            $this->db->from('monthly_advisories');
            $this->db->where('sector_id', $sect);
            $this->db->where('forecast_id', $f_id);
            return $this->db->get()->result_array();
        }

          function check_forecast_existence( $month_from, $month_to, $year){
            $this->db->select('id');
            $this->db->from('monthly_forecast');
            $this->db->where('month_from', $month_from);
            $this->db->where('month_to', $month_to);
            $this->db->where('year', $year);
            return $this->db->get()->result_array();
        }

    // insert forecast data 
  function save_forecast($table_name, $data=array())
  {    $this->db->insert($table_name, $data);    

  }

     // get forecast data for admin side
  function get_all()
  {  
   $this->db->select('*');
   $this->db->from('monthly_forecast'); 
   $this->db->order_by('monthly_forecast.id', $this->order);
   $query=$this->db->get();   
   return $query->result_array();

 }

    // New method for viewing the monthly forecast data on the admin side
 function view_monthly_data($id)
 {  
  $this->db->select('*');
  $this->db->from('monthly_forecast');
  $this->db->where('monthly_forecast.id', $id);
  $query=$this->db->get();   
  return $query->result_array();

}
 // get data by id
function get_by_id($id)
{    
 $this->db->where($this->id, $id);
 return $this->db->get($this->table)->row();
}

function get_advisory_by_id($id)
{    
 $this->db->where($this->id, $id);
 return $this->db->get($this->table2)->row();
}


function get_update_data($forecast_id)
{  
 $this->db->select('*');
 $this->db->from('monthly_forecast');
 $this->db->where('id', $forecast_id);

 $query=$this->db->get();   
 return $query->result_array();

}

function get_advisory_update_data($advisory_id)
{  
 $this->db->select('*, minor_sector.id as sector_id, minor_sector.minor_name');
 $this->db->from('monthly_advisories');
  $this->db->join('minor_sector','minor_sector.id = monthly_advisories.sector_id'); 
 $this->db->where('monthly_advisories.id', $advisory_id);

 $query=$this->db->get();   
 return $query->result_array();

}


     // update data
function update_data($id, $data =array(), $tab_name)
{   
  $this->db->where('id', $id);
  $this->db->set($data);
  $this->db->update($tab_name);   
}

function delete_forecast($id, $table_name)
{
  $this->db->where($this->id, $id);
  $this->db->delete($table_name);
}


function get_sectors(){
  $this->db->select('*');
  $this->db->from('minor_sector');
  $query = $this->db->get()->result_array();
  return $query;  
}

function get_all_advisories($id=NULL)
{   
  $this->db->select('monthly_advisories.id as advisory_id, monthly_advisories.message_summary, minor_sector.minor_name, monthly_forecast.month_from, monthly_forecast.month_to');
  $this->db->from('monthly_advisories');
  $this->db->join('monthly_forecast','monthly_forecast.id = monthly_advisories.forecast_id'); 
  $this->db->join('minor_sector','minor_sector.id = monthly_advisories.sector_id'); 
        //$this->db->join('major_sector','major_sector.id=minor_sector.major_id');  
  if(isset($id)){
    $this->db->where("monthly_advisories.forecast_id",$id);
  }
  $this->db->order_by('monthly_advisories.id', $this->order);   

  $query=$this->db->get();   
  return $query->result_array();

}

function get_all_impacts($id=NULL)
{   
  $this->db->select('monthly_impacts.id as impacts_id, monthly_impacts.impact, monthly_forecast.month_from, monthly_forecast.month_to');
  $this->db->from('monthly_impacts');
  $this->db->join('monthly_forecast','monthly_forecast.id = monthly_impacts.forecast_id');   
  if(isset($id)){
    $this->db->where("monthly_impacts.forecast_id",$id);
  }
  $this->db->order_by('monthly_impacts.id', $this->order);   

  $query=$this->db->get();   
  return $query->result_array();

}


        // New Method with advisories
function get_monthly_data()
{  

  $month_to = "unknown";
  if((date('m') == 1) || (date('m') == 2)) $month_to = 'February';
  else 
    if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $month_to = 'May';
  else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $month_to = 'August';
  else $season = 'December';

  $this->db->select('*');
  $this->db->from('monthly_forecast');
  $this->db->where('monthly_forecast.month_to',$month_to);
  $this->db->where("monthly_forecast.year",date('Y') );
  $this->db->order_by('monthly_forecast.id','DESC');
  $query=$this->db->get();   
  return $query->result_array();

}

function get_home_advice(){
 $month_to = "unknown";
  if((date('m') == 1) || (date('m') == 2)) $month_to = 'February';
  else 
    if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $month_to = 'May';
  else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $month_to = 'August';
  else $season = 'December';

   $this->db->select('monthly_advisories.message_summary, minor_sector.minor_name, monthly_forecast.month_from, monthly_forecast.month_to');
  $this->db->from('monthly_advisories');
  $this->db->join('monthly_forecast','monthly_forecast.id = monthly_advisories.forecast_id'); 
  $this->db->join('minor_sector','minor_sector.id = monthly_advisories.sector_id'); 
    $this->db->where("monthly_forecast.month_to",$month_to );
    $this->db->where("monthly_forecast.year",date('Y') );
  $this->db->order_by('monthly_advisories.id', $this->order);   

  $query=$this->db->get();   
  return $query->result_array();
}





}

/* End of file Season_model.php */