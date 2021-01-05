<?php

/* @property news_model $news_model */
class News extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }


    function index()
    {
        $data['news'] = $this->news_model->get_all();
        $this->load->view('content/news_list', $data);
    }

    function show_one($slug)
    {
        $data['news'] = $this->news_model->get_one($slug);
        $this->load->view('content/show_one', $data);
        // here you put your query to select the article
        // //by slug or whatever by id //
        //then call the counter function and pass the slug or the
        // //id for the counte function
        $this->add_count($slug);
    }

    // This is the counter function..
    function add_count($slug)
    {
        // load cookie helper
        $this->load->helper('cookie');
        // this line will return the cookie which has slug name
        $check_visitor = $this->input->cookie(urldecode($slug), FALSE);
        // this line will return the visitor ip address
        $ip = $this->input->ip_address();
        // if the visitor visit this article for first time then //
        // //set new cookie and update article_views column ..
        // //you might be notice we used slug for cookie name and ip
        // //address for value to distinguish between articles views
        
// $cookie = array("name" => urldecode($slug), "value" => "$ip", "expire" => 36000, "secure" => false);
//          $this->input->set_cookie($cookie);
//             $this->news_model->update_counter(urldecode($slug));    
        if ($check_visitor == false) {
            $cookie = array("name" => urldecode($slug), "value" => "$ip", "expire" => 7200, "secure" => false);
            // gettype($cookie);
            $this->input->set_cookie($cookie);
            $this->news_model->update_counter(urldecode($slug));
        }
    }
}
/* End of file dashboard.php */
/* Location: ./system/application/modules/matchbox/controllers/dashboard.php */