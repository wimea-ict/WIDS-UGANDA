<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Minor_sector extends CI_Controller
{
	
 function __construct()
 {
  parent::__construct();
  $this->config->set_item('theme','Ghana');
  $this->load->model('Minor_sector_model');
  $this->load->model('Major_model');
  $this->load->library('form_validation');
  $this->load->library('session');
}


public function index()
{ 
 $data['minor_sector_data'] = $this->Minor_sector_model->get_all();
 $data['change'] = 63;
 $this->load->view('template', $data);

}

	//show form for adding the division
public function displayform(){
	$data['major_data']= $this->Major_model->get_all();
	$data['change'] = 64;
	$this->load->view('template', $data);	
}

public function savedMinor(){
  $id = $this->input->post('id');
  $datatoinsert = array(
    'minor_name' => $this->input->post('sector_name',TRUE),
    'major_id' => $this->input->post('major_id',TRUE)
    );

    //====== checking the presence of $id==========
  if (!is_null($id) && $this->Minor_sector_model->get_by_id($id)) {
    $this->Minor_sector_model->update($id,$datatoinsert);
    $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Minor Sector record updated Successfully!.</div>');
  } else {
   $datatoinsert1 = array(
    'minor_name' => $this->input->post('sector_name',TRUE),
    'major_id' => $this->input->post('major_id',TRUE)
    );
   $this->Minor_sector_model->insert($datatoinsert1);
   $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Minor Sector record added Successfully!.</div>');
 }

 redirect('index.php/Minor_sector'); 	   

}

  //--------- Updating  and deleting a given row---------------------
public function update($id=NULL)
{ 
  $data['major_data']= $this->Major_model->get_all();
  $row = $this->Minor_sector_model->get_by_id($id);

	    if ($row) { //if there is some data
        $data['change'] = 64;
        $data['minor_data']= $row;
        $data['row_data'] =$this->Minor_sector_model->get_by_id($id);
        $this->load->view('template', $data);			
      } else {
        $data = array('change' => 0);
        $this->session->set_flashdata('message','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Minor Sector record not found.</div>');
        $this->load->view('template', $data);
      }
    }

  public function delete($id=NULL){
      $this->Minor_sector_model->delete($id);
     	 //if there is some data
      $minor_sector = $this->Minor_sector_model->get_all();
      $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Minor Sector record deleted Successfully!.</div>');
      redirect('index.php/Minor_sector'); 			

  }
	//----------------------the end--------------------------------

    public function word()
    {
      header("Content-type: application/vnd.ms-word");
      header("Content-Disposition: attachment;Filename=minor_sector.doc");
      $data = array(
        'minor_sector_data' => $this->Minor_sector_model->get_all(),
        'start' => 0
        );
      $this->load->view('minor_doc',$data);
    }

    public function pdf()
    {
      $data = array(
       'minor_sector_data' => $this->Minor_sector_model->get_all(),
       'start' => 0
       );
      ini_set('memory_limit', '10G');
      $html = $this->load->view('minor_doc', $data, true);
      $this->load->library('pdf');
      $pdf = $this->pdf->load();
      $pdf->WriteHTML($html);
      $pdf->Output('minor_sector.pdf', 'D'); 
    }

}//end of the class 