<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sub_region extends CI_Controller
{
	
	  function __construct()
    {
        parent::__construct();
	$this->config->set_item('theme','Ghana');
        $this->load->model('Sub_region_model');
		$this->load->model('Region_model');
        $this->load->library('form_validation');
		$this->load->library('session');
    }


   public function index()
    { 
	  $data['sub_region_data'] = $this->Sub_region_model->get_all();
	  $data['change'] = 54;
      $this->load->view('template', $data);
	
	}
	public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=sub_region.doc");

        $data = array(
            'sub_region_data' => $this->Sub_region_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('sub_region_doc',$data);
    }
	
	
    public function pdf()
    {
        $data = array(
            'sub_region_data' => $this->Sub_region_model->get_all(),
            'start' => 0
        );
        
        ini_set('memory_limit', '10G');
        $html = $this->load->view('sub_region_doc', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output('sub_region.pdf', 'D'); 
    }
	
	//show form for adding the division
	public function displayform(){

	$data['region_data']= $this->Region_model->get_all();
	$data['change'] = 55;
	$this->load->view('template', $data);	
   }
   
   public function saveSub_region(){
   	   $id = $this->input->post('id');
      $datatoinsert = array(
       		 'sub_region_name' => $this->input->post('sub_region_name',TRUE),
			 'region_id' => $this->input->post('region_id',TRUE)
	    );
     //====== checking the presence of $id==========
		if (!is_null($id) && $this->Sub_region_model->get_by_id($id)) {
            $this->Sub_region_model->update($id,$datatoinsert);
            $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Sub-Region record updated Successfully!.</div>');
        } else {

            $datatoinsert1 = array(
       		  'sub_region_name' => $this->input->post('sub_region_name',TRUE),
			 'region_id' => $this->input->post('region_id',TRUE)		    
	       );

           $this->Sub_region_model->insert($datatoinsert1);
           $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Sub-Region record added Successfully!.</div>');
        }
		//=====================================================
	redirect('index.php/Sub_region');	   
	   
  }
  //--------- Updating  and deleting a given row---------------------
	 public function update($id=NULL)

     { 
        $data['region_data']= $this->Region_model->get_all();
	    $row = $this->Sub_region_model->get_by_id($id);
	 
	    if ($row) { //if there is some data
            $data['change'] = 55;
			$data['sub_region_data']= $row;

			$data['row_data'] =$this->Sub_region_model->get_by_id($id);
            $this->load->view('template', $data);			
			
        } else {
		  $data = array(
		      'change' => 54
	    );
            $this->session->set_flashdata('message', '<font color="red" size="5">Record Not Found</font>');
           $this->load->view('template', $data);
        }
    }

     public function delete($id=NULL){

     	    $this->Sub_region_model->delete($id);
     	 //if there is some data
     	    $minor_sector = $this->Sub_region_model->get_all();
            $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>'.$this->session->userdata('deleted').'</strong> Sub-Region deleted Successfully!.</div>');
           redirect('index.php/Sub_region')	;		
		
	}
	//----------------------the end--------------------------------
	
}//end of the class 