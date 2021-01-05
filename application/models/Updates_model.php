<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Updates_model extends CI_Model
{

    public $table = 'seasonal_updates';
    public $id = 'id';
    public $order = 'DESC';
	public $issuetime = 'issuetime';

    function __construct()
    {
        parent::__construct();
    }
       
   function get_updates_data()
    {  
        $current_month = date('F');
       $this->db->select('season_months.season_name,seasonal_forecast.year,seasonal_updates.conclusion,seasonal_updates.impacts, seasonal_updates.advisories,seasonal_updates.rainfall_outlook,seasonal_updates.further_outlook,seasonal_updates.month,seasonal_updates.issue_time, season_months.abbreviation,seasonal_forecast.id');
       $this->db->from('seasonal_updates');
       $this->db->join('seasonal_forecast','seasonal_forecast.id=seasonal_updates.season_id');  
       $this->db->join('season_months','season_months.id=seasonal_forecast.season_id');  
       $this->db->where('seasonal_updates.month', $current_month);
        $this->db->order_by('seasonal_updates.issue_time', $this->order);   
       $query=$this->db->get();   
       return $query->result_array();
    
    }





    function get_all($id)
    {  
	   $this->db->select('season_months.season_name,seasonal_forecast.year,seasonal_updates.conclusion, seasonal_updates.rainfall_outlook,seasonal_updates.further_outlook,seasonal_updates.month,seasonal_updates.issue_time, season_months.abbreviation,seasonal_forecast.id');
	   $this->db->from('seasonal_updates');
       $this->db->join('seasonal_forecast','seasonal_forecast.id=seasonal_updates.season_id');  
       $this->db->join('season_months','season_months.id=seasonal_forecast.season_id');  
      $this->db->where('seasonal_forecast.id', $id);
	   
	   $query=$this->db->get();   
       return $query->result_array();
    
    }


    // New method for viewing the seasonal forecast data on the admin side
    function view_season_data($id)
    {  
        $this->db->select('seasonal_forecast.issuetime, seasonal_forecast.year,season_months.season_name, season_months.abbreviation, seasonal_forecast.overview, seasonal_forecast.general_forecast, ');
        $this->db->from('seasonal_forecast');
        $this->db->join('season_months','seasonal_forecast.season_id = season_months.id');
        $this->db->where('seasonal_forecast.id', $id);
       $query=$this->db->get();   
       return $query->result_array();
    
    }

    function get_update_data($forecast_id)
    {  
       $this->db->select('issuetime, overview,general_forecast');
       $this->db->from('seasonal_forecast');
       // $this->db->where('id', $forecast_id);
       
       $query=$this->db->get();   
       return $query->result_array();
    
    }

    function update_data($data, $id)
    {  
       $sql = "UPDATE seasonal_forecast SET overview = ?, general_forecast = ? WHERE id = $id";
       return $this->db->query($sql, $data);
    
    }
	
	function get_current_season(){
	   	
	  $this->db->select('season.season_name,seasonal_forecast.id as id'); 
	   $this->db->from('season');
	   $this->db->join('seasonal_forecast','seasonal_forecast.season_id=season.id');
	    $this->db->order_by('seasonal_forecast.issuetime', $this->order);	   
	   $this->db->limit(1);
	   $query = $this->db->get();
	   
	   if($query->num_rows()>0) {	 
		 $data = $query->row_array();		 
		 $value = $data['id'];		 
		 return $value;
		 
	 }
	}
	
	function get_recent_forecast($region,$forecast_id){
	   $this->db->select('area_seasonal_forecast.region_id,area_seasonal_forecast.subregion_id,area_seasonal_forecast.expected_peak, area_seasonal_forecast.peakdesc, area_seasonal_forecast.onset_period,area_seasonal_forecast.onsetdesc,area_seasonal_forecast.end_period,area_seasonal_forecast.enddesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info');
	   $this->db->from('area_seasonal_forecast');  
	   $this->db->join('region','region.id=area_seasonal_forecast.region_id'); //area_seasonal_forecast
	   $this->db->join('sub_region','area_seasonal_forecast.subregion_id=sub_region.id');
	   $multipleWhere = ['area_seasonal_forecast.region_id =' => $region, 'area_seasonal_forecast.forecast_id =' => $forecast_id];	 
	   $this->db->where($multipleWhere);
      // $this->db->order_by('area_seasonal_forecast.issuetime', $this->order);
	   
	   $query=$this->db->get();   
       return $query->result_array();
    	
		
	}
    
    //------------------------------
    
    //------------------------------

    function get_season_data1($id)
    {  
	   $this->db->select('season_months.season_name,seasonal_forecast.year,seasonal_forecast.overview,seasonal_forecast.general_forecast,seasonal_forecast.issuetime,season_months.abbreviation,seasonal_forecast.id');
	   $this->db->from('seasonal_forecast');
       $this->db->join('season_months','season_months.id=seasonal_forecast.season_id'); 
	   $this->db->where('seasonal_forecast.id',$id);
       $this->db->order_by('seasonal_forecast.issuetime', $this->order);   
	   
	   $query=$this->db->get();   
       return $query->result_array();
    
    }
	
	//area forcast
function get_areaseason_data($id)
    {  
	   $this->db->select('area_seasonal_forecast.expected_peak, area_seasonal_forecast.peakdesc, area_seasonal_forecast.onset_period,area_seasonal_forecast.end_period,area_seasonal_forecast.enddesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info,region.region_name,sub_region.sub_region_name');
	   $this->db->from('area_seasonal_forecast');
	   $this->db->join('seasonal_forecast','area_seasonal_forecast.forecast_id=seasonal_forecast.id'); 
	   $this->db->join('region','area_seasonal_forecast.region_id=region.id');
	   $this->db->join('sub_region','area_seasonal_forecast.subregion_id=sub_region.id');
	   $this->db->where('area_seasonal_forecast.forecast_id',$id);	   
	   
	   $query=$this->db->get();   
       return $query->result_array();
    
    }


     
public  function get_forecast_area($id=NULL){
      
      $this->db->select('area_seasonal_forecast.expected_peak, area_seasonal_forecast.onset_period,area_seasonal_forecast.onsetdesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info, region.region_name,area_seasonal_forecast.enddesc,area_seasonal_forecast.end_period,area_seasonal_forecast.peakdesc,area_seasonal_forecast.id');
      $this->db->from('area_seasonal_forecast');

      $this->db->join('region','region.id=area_seasonal_forecast.region_id','inner'); 
     if(isset($id)){
        $this->db->where('area_seasonal_forecast.forecast_id',$id);	 
	}
     $query=$this->db->get();   
      return $query->result_array();

     }
  // get data by id
    function get_by_id($id)
    {    
	   $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
	

 

    // insert data
    function insert($data=array())
    {    $this->db->insert('seasonal_updates',$data);    

    }
  //==================seasonal forecast with advisory------------------------------------------


 //---------------------insert seasonal data area-----------------
     // insert data int minor_sector table
    function insertForecastArea($data=array())
    {  
        $this->db->insert('area_seasonal_forecast',$data);
    }
 //---------------------------------------------

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    //get farmers to send message
    
    //smsapi



}

/* End of file Season_model.php */