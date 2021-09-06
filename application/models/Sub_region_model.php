<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sub_region_model extends CI_Model
{
     //connecting to table major_sector 
    public $table = 'sub_region';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
      
      $this->db->select('sub_region.sub_region_name, sub_region.id,region.region_name');
      $this->db->from('sub_region');
      $this->db->join('region','region.id=sub_region.region_id'); 
      $this->db->order_by('sub_region.id','DESC'); 


      //$this->db->where('minor_sector.major_id','major_sector.id');   
     $query=$this->db->get();   
      return $query->result_array();
    }

    function sub_regions_used(){
        $this->db->select('id, sub_region_name');
      $this->db->from('sub_region');  
     $query=$this->db->get();   
      return $query->result_array();
    }
// =================get data by id==========
    function get_by_id($id=NULL)
    {  
     $this->db->from('sub_region'); 
        if(isset($id)){
       $this->db->where('id',$id);   
      }
         $query=$this->db->get();   
      return $query->result_array();
    }
    //==============================================


     //-----------------------------------------------------------
    // insert data int major_sector table
    function insert($data = array())
    {     
         // $this->db->set($data);
          $this->db->insert('sub_region',$data);
    }


     // update data
     function update($id, $data =array())
     {   
        $this->db->where('id', $id);
         $this->db->set($data);
        $this->db->update('sub_region');
        
     }
    // delete data
    function delete($id)
    {
        
        $this->db->from($this->table);
        $this->db->where($this->id, $id);
        $ret = $this->db->get()->row();
        $this->session->set_userdata('deleted',$ret->sub_region_name);


        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
//----------------------------------------------------------------

}

/* End of file Minor_model.php */