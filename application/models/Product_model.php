
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Product_model extends CI_Model{
     
    function get_category(){
        $query = $this->db->get('category');
        return $query;  
    }
 
    function get_sub_category($category_id){
        // $query = $this->db->get_where('sub_category', array('subcategory_category_id' => $category_id));
        $query = $this->db->get_where('possible_advisories', array('cat' => $category_id));
        return $query;
    }

    function logfeedback($data=array())
    {
    	 
    	$this->db->insert('user_feedback',$data);  
    }

    function get_advisory($lang_id){
        $this->db->select('minor_sector.id, minor_name');
        $this->db->from('minor_sector');
        $this->db->join('major_sector', 'minor_sector.major_id = major_sector.id');
        $this->db->where('major_sector.language_id',$lang_id);
        $query = $this->db->get();
        return $query;
    }
    function get_langs(){
        $query = $this->db->get('ussdmenulanguage');
        return $query;
    }


    function get_sub_regions($region){
        $this->db->select('sub_region_name, id');
        $this->db->from('sub_region');
        $this->db->where('main_region_id',$region);
        $query = $this->db->get();
        return $query;
    }

    function display_records($from, $to)
    {
        $query="SELECT DISTINCT phone FROM `ussdtransaction_new` WHERE date BETWEEN '$from 00:00:01' AND '$to 23:59:59'";
       $dd =  $this->db->query($query);
        return $dd;
    }
     
}