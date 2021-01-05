<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Disaster_model extends CI_Model
{

    public $table = 'disasters';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_all($id=NULL)
    {   


            $season = "unknown";
            if((date('m') == 1) || (date('m') == 2) ) $season = 'MAM';
            else  if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
            else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
            else $season = 'SOND';



        $this->db->select('disasters.disaster_desc,region.region_name,season_months.abbreviation');
        $this->db->from('disasters');
        $this->db->join('seasonal_forecast','disasters.forecast_id=seasonal_forecast.id');
        $this->db->join('season_months','seasonal_forecast.season_id=season_months.id'); 
        $this->db->join('region','region.id=disasters.region_id');  
        $this->db->where("season_months.abbreviation",$season);
        if(isset($id)){
            $this->db->where("disasters.forecast_id",$id);
        }
        $this->db->order_by('disasters.id', $this->order);   
           
        
      $query=$this->db->get();   
       return $query->result_array();
    }
     

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();

    }
	  


    // insert data
    function insert($data=array())
    {
	      $this->db->insert('disasters',$data); 
    }

    
    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

  

   

   
}

/* End of file Ward_model.php */