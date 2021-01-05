<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Region_model extends CI_Model
{

    public $table = 'region';
    public $id = 'id';
    public $order = 'DESC';
     public $order_asc = 'ASC';
	public $region_name = 'region_name';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order_asc);
		//echo $this->db->get($this->table)->result(); exit();
        return $this->db->get($this->table)->result();
    }
  // =================get data by id==========
    function get_by_id($id=NULL)
    {  
     $this->db->from('region'); 
        if(isset($id)){
       $this->db->where('id',$id);   
      }
         $query=$this->db->get();   
      return $query->result_array();
    }
    //==============================================
  // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
		$this->db->or_like('region_name', $q);
		$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('season_name', $q);
	$this->db->or_like('season_code', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
   //-----------------------------------------------------------
    // insert data int major_sector table
    function insert($data = array())
    {     
         // $this->db->set($data);
          $this->db->insert('region',$data);
    }


     // update data
     function update($id, $data =array())
     {   
        $this->db->where('id', $id);
         $this->db->set($data);
        $this->db->update('region');
        
     }
 
 

    // delete data
    function delete($id)
    {
      $this->db->from($this->table);
        $this->db->where($this->id, $id);
        $ret = $this->db->get()->row();
        $this->session->set_userdata('deleted',ucwords($ret->region_name));


        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
//----------------------------------------------------------------

   

}

/* End of file Season_model.php */