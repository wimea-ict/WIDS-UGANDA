<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @author Pisyek Kumar
 * @email pisyek@gmail.com
 * @link http://www.pisyek.com
 */
class News_model extends CI_Model
{


    function get_all()
    {
        $query = $this->db->get('ci_news');
        return $query->result_array();
    }

    function get_one($slug)
    {
        $this->db->get_where('ci_news', array('ne_slug' => $slug));
        $query = $this->db->get('ci_news');
        return $query->row();
    }

    function update_counter($slug)
    {
        //return current article views
        $this->db->where('ne_slug', urldecode($slug));
        $this->db->select('ne_views'); $count = $this->db->get('ci_news')->row();
        // then increase by one
        $this->db->where('ne_slug', urldecode($slug));
        $this->db->set('ne_views', ($count->ne_views + 1));
        $this->db->update('ci_news');
    }



}

/* End of file blog_model.php */
    /* Location: ./application/models/blog_model.php */    