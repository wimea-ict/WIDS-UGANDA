<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Division extends CI_Controller
{
	
 function __construct()
 {
  parent::__construct();
  $this->config->set_item('theme','Ghana');
  $this->load->model('Division_model');
  $this->load->model('Region_model');
  $this->load->library('form_validation');
  $this->load->library('session');
}

public function word(){
  header("Content-type: application/vnd.ms-word");
  header("Content-Disposition: attachment;Filename=divisions.doc");
  $data = array(
    'division_data' => $this->Division_model->get_all(),
    'start' => 0
    );
  $this->load->view('division_doc',$data);
}

public function pdf()
{
  $data = array(
   'division_data' => $this->Division_model->get_all(),
   'start' => 0
   );

  ini_set('memory_limit', '10G');
  $html = $this->load->view('division_doc', $data, true);
  $this->load->library('pdf');
  $pdf = $this->pdf->load();
  $pdf->WriteHTML($html);
  $pdf->Output('division.pdf', 'D'); 
}


public function index()
{ 
 $data['division_data'] = $this->Division_model->get_all();
 $data['change'] = 47;
 $this->load->view('template', $data);

}

	//show form for adding the division
public function displayform(){
	$data['region_data']= $this->Region_model->get_all();
	$data['change'] = 50;
	$this->load->view('template', $data);	
}

public function savedivision(){
  $id = $this->input->post('id');
  $datatoinsert = array(
    'division_name' => $this->input->post('division_name',TRUE),
    'division_type' => $this->input->post('division_type',TRUE),
    'region_id' => $this->input->post('region_id',TRUE)
    );
      //====== checking the presence of $id==========
  if (!is_null($id) && $this->Division_model->get_by_id($id)) {
    $this->Division_model->update($id,$datatoinsert);
    $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>District record updated Successfully!.</div>');
  } else {

    $datatoinsert1 = array(
      'division_name' => $this->input->post('division_name',TRUE),
      'division_type' => $this->input->post('division_type',TRUE),
      'region_id' => $this->input->post('region_id',TRUE)		    
      );
    $this->Division_model->insert($datatoinsert1);
    $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>District record added Successfully!.</div>');
  }
  redirect('index.php/Division');   

}
  //--------- Updating  and deleting a given row---------------------
public function update($id=NULL) 
{   
  $data['region_data']=$this->Region_model->get_all();
  $row = $this->Division_model->get_by_id($id);

	    if ($row) { //if there is some data
            $data['change'] = 50;//referencing the form view
            $data['division_data']= $row;
            $data['row_data'] =$this->Division_model->get_by_id($id);
            $this->load->view('template', $data);			
       } else {
            $data = array(
              'change' => 0,
              );
            $this->session->set_flashdata('message', '<font color="red" size="5">Record Not Found</font>');
            $this->load->view('template', $data);
         }
         
}

public function delete($id=NULL){
          $this->Division_model->delete($id);
          $division = $this->Division_model->get_all();
          $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'.$this->session->userdata('deleted').'</strong> District deleted Successfully!.</div>');
          redirect('index.php/Division');

}        
	//----------------------the end--------------------------------
}//end of the class 