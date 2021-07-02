<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class monthly_forecast extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->config->set_item('theme',$this->config->item('country'));
        $this->load->model('Season_model');
        $this->load->model('Monthly_model');
        $this->load->model('Minor_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }



    public function index()
    { 
        $monthly = $this->Monthly_model->get_all();
        $data = array('season_data' => $monthly,'change' => 127);
        $this->load->view('template', $data);
    }
    
    //Add general monthly forecast
    public function add_forecast() 
    {
       $data['change'] = 128;    
       $this->load->view('template', $data);
   }

 //saves forecast data in the monthly_forecast table
   function save_forecast(){
    $date = strtotime($this->input->post('date',TRUE));
    $date_time = date('Y',$date).'-'.date('m',$date).'-'.date('d',$date);
    $filename = $_FILES['img']['name'];
    $dir = 'assets/frameworks/adminlte/img/'.$filename;
    if (($this->input->post('month_from',TRUE) != null) && ($this->input->post('month_to',TRUE) != null) && ($this->input->post('year',TRUE)) != null ) {

       $exists = $this->Monthly_model->check_forecast_existence($this->input->post('month_from',TRUE), $this->input->post('month_to',TRUE), $this->input->post('year',TRUE));
       $times = 0;
       foreach ($exists as $ke) {
         $times++;
     }
     if($times>0){

         $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Forecast already exists for the input start month, end month and year. Insertion Failure!!!</div>');

     }else{
        move_uploaded_file($_FILES['img']['tmp_name'], $dir);

        $datatoinsert = array(
            'month_from' => $this->input->post('month_from',TRUE),
            'month_to' => $this->input->post('month_to',TRUE),
            'year' => $this->input->post('year',TRUE),
            'weather_outlook' => $this->input->post('weather_outlook',TRUE),
            'summary' => $this->input->post('summary',TRUE),
            'introduction' => $this->input->post('introduction',TRUE),
            'issue_date' => $date_time,
            'forecast_map' => $filename

            );
        $this->Monthly_model->save_forecast('monthly_forecast', $datatoinsert);
        $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Monthly Forecast Uploaded Successfully!</div>');
    }

}
redirect('index.php/monthly_forecast');

}

public function read($id=NULL) 
{   $id = $this->uri->segment(3);
    $row = $this->Monthly_model->view_monthly_data($id);  
    $data['change'] = 129;
    $data['monthly_data']= $row;
    $data['area'] =$this->Season_model->get_areaseason_data($id);
    $this->load->view('template', $data);           
}

public function update() 
{
    $id = $this->uri->segment(3);
    $row = $this->Monthly_model->get_by_id($id);
    if ($row) {
        $data = array('change'   => 128);
        $data['monthly_id_data'] = $this->Monthly_model->get_update_data($id);
        $this->load->view('template', $data);
    } else {
        $this->session->set_flashdata('message', '<font color="red" size="5">Record Not Found</font>');
        $this->load->view('template', $data);
    }

}

  
public function save_update(){
    $id = $this->uri->segment(3);
    $datatoupdate = array(
       'summary' => $this->input->post('summary',TRUE),
       'month_from' => $this->input->post('month_from',TRUE),
       'month_to' => $this->input->post('month_to',TRUE),
       'issue_date' => $this->input->post('issue_date',TRUE),
       'weather_outlook' => $this->input->post('weather_outlook',TRUE),
       'introduction'=>$this->input->post('introduction',TRUE)
       );
    $this->Monthly_model->update_data($id, $datatoupdate, 'monthly_forecast');
    $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Forecast Updated Successfully!</div>');
    redirect('index.php/monthly_forecast');

}

public function delete($id) 
{
   $this->Monthly_model->delete_forecast($id, 'monthly_forecast');
   $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  Monthly Forecast Deleted Successfully!</div>');
   redirect('index.php/monthly_forecast');

}


public function advisory_form()
{

   $data = array(
       'error' => '',
       'button' => 'Add Advisory',
       'action' => 'index.php/monthly_forecast/save_advisory/',
       'id' => set_value('id'),
       'type' => set_value('type'),
       'parent_id' => $this->uri->segment(3),
       'msg' => set_value('msg'),
       'summary' => set_value('summary'),
       'change' => 130
       );

   $data['sector_data']= $this->Monthly_model->get_sectors();
   $data['forecast_id']= $this->uri->segment(3);
   $this->load->view('template', $data);
}

public function impacts_form()
{

   $data = array(
       'error' => '',
       'button' => 'Add Impacts',
       'id' => set_value('id'),
       'type' => set_value('type'),
       'msg' => set_value('msg'),
       'summary' => set_value('summary'),
       'change' => 133
       );

   $data['forecast_id']= $this->uri->segment(3);
   $this->load->view('template', $data);
}



public function advisory_list()
{
    $id= $this->uri->segment(3);
    $_SESSION['parent_id'] = $id;
    $advisory = $this->Monthly_model->get_all_advisories($id);
    $data = array(
        'change' => 131,
        'forecast_id' => $id,
        'advisory_data' => $advisory
        );

    $this->load->view('template', $data);
}


public function save_advisory()
{
    // Loop to store and display values of individual checked checkbox.
    $datatoinsert = array(
     'forecast_id' => $this->input->post('forecast_id',TRUE),
     'sector_id' => $this->input->post('sector_id',TRUE),
     'message_summary' => $this->input->post('message_summary',TRUE) 
     );

    $exists = $this->Monthly_model->check_existence($this->input->post('forecast_id',TRUE), $this->input->post('sector_id',TRUE));
    $times = 0;
    foreach ($exists as $ke) {
     $times++;
 }
 if($times>0){

     $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>The advisory already exists for the selected Selector. Try another sector!</div>');

 }else{
    $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Advisory uploaded Successfully!</div>');
    $this->Monthly_model->save_forecast('monthly_advisories', $datatoinsert);


}
$advisory = $this->Monthly_model->get_all_advisories($_SESSION['parent_id']);
$data = array(
    'change' => 131,
    'forecast_id' => $id,
    'advisory_data' => $advisory
    );
redirect("index.php/monthly_forecast/advisory_list/".$_SESSION['parent_id']);

}

public function save_impacts()
{
                // Loop to store and display values of individual checked checkbox.
    $datatoinsert = array(
     'forecast_id' => $this->input->post('forecast_id',TRUE),
     'impact' => $this->input->post('impacts',TRUE) 
     );

    $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Monthly Impact(s) added Successfully!</div>');
    $this->Monthly_model->save_forecast('monthly_impacts', $datatoinsert);
    $advisory = $this->Monthly_model->get_all_advisories($_SESSION['parent_id']);
    $data = array(
        'change' => 131,
        'forecast_id' => $id,
        'advisory_data' => $advisory
        );
    redirect("index.php/monthly_forecast/impacts/".$_SESSION['impacts_parent_id']);

}

public function impacts()
{
    $id= $this->uri->segment(3);
    $_SESSION['impacts_parent_id'] = $id;
    $impacts = $this->Monthly_model->get_all_impacts($id);
    $data = array(
        'change' => 132,
        'forecast_id' => $id,
        'impacts_data' => $impacts
        );
    $this->load->view('template', $data);
}

public function update_advisroy() 
{
    $id = $this->uri->segment(3);
    $row = $this->Monthly_model->get_advisory_by_id($id);

    if ($row) {
        $data = array(
            'button' => 'Update Advisory',
            'parent_id' => $_SESSION['parent_id'],
            'action' => 'index.php/monthly_forecast/save_advisory_update/',
            'change'   => 130,
            );
        $data['monthly_advisory_data'] = $this->Monthly_model->get_advisory_update_data($id);
        $data['sector_data']= $this->Monthly_model->get_sectors();
        $this->load->view('template', $data);
    } else {
        $this->session->set_flashdata('message', '<font color="red" size="5">Record Not Found</font>');
        $this->load->view('template', $data);
    }
    // }
}


public function save_advisory_update(){
    $id = $this->uri->segment(3);
    $datatoupdate = array(
        'sector_id'=>$this->input->post('sector_id',TRUE),
        'message_summary'=>$this->input->post('message_summary',TRUE)
        );
    $this->Monthly_model->update_data($id, $datatoupdate,'monthly_advisories');
    $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Advisory Updated Successfully!</div>');
    redirect("index.php/monthly_forecast/advisory_list/".$_SESSION['parent_id']);

}

public function delete_advisory($id) 
{
   $this->Monthly_model->delete_forecast($id,'monthly_advisories');
   $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  Monthly Advisory Deleted Successfully!</div>');
   redirect("index.php/monthly_forecast/advisory_list/".$_SESSION['parent_id']);

}

public function delete_impact($id) 
{
   $this->Monthly_model->delete_forecast($id,'monthly_impacts');
   $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>  IMPACT Deleted Successfully!</div>');
   redirect("index.php/monthly_forecast/impacts/".$_SESSION['impacts_parent_id']);
}


}