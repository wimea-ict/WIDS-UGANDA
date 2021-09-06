<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Language_model extends CI_Model
{

    public $table = 'language';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {       
	  $this->db->order_by($this->sector_name, $this->order);
	  return $this->db->get($this->table)->result();
    }

    public function get_sessionLang($lang)
    {
       $this->db->from('ussdmenulanguage');
       $this->db->where('language', $lang);
       return $this->db->get()->row()->id;
    }
}

/* End of file Season_model.php */