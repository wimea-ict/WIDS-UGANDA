<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Season extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
		$this->config->set_item('theme',$this->config->item('country'));
        $this->load->model('Season_model');
        $this->load->library('form_validation');
		$this->load->library('session');
		 $this->load->model('Region_model');  
		 $this->load->model('Season_names_model');
         $this->load->model('Daily_forecast_model');  
		  $this->load->model('Sub_region_model');
    }


    //----------send broadcast message to all users------------------------------
    public function broadcast(){
        $data['selected_users'] = $this->Season_model->today_users()->result();

        $data['change'] = 116;
        $this->load->view('template',$data);
    }
    public function broadcast_msg(){
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $msg = $this->input->post('msg');

        $contacts = $this->Season_model->get_contacts($date_from, $date_to);
        foreach ($contacts as $k) {
            $this->Messages($msg,$k['phone']);
        }
         $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Message Sent Successfully!</div>');

        redirect('index.php/Season/broadcast');

    }

    function Messages($message,$phoneNumber){ 

        $resp = "";
        try{
            $textmessage = urlencode($message);
            $ch = curl_init();
            curl_setopt_array($ch,array(
            CURLOPT_RETURNTRANSFER =>1,   
             CURLOPT_URL =>'http://simplysms.com/getapi.php?email=mnsabagwa@cit.ac.ug&password=XyZp3q7&sender=8777&message='.$textmessage.'&recipients='.$phoneNumber,
            CURLOPT_USERAGENT =>'Codular Sample cURL Request'));

            $resp = curl_exec($ch);

            curl_close($ch);
            
        }catch(Exception $e){}
        return $resp;

    }

     public function selected_users(){
         $selected_users = $this->Season_model->today_users()->result();
         //print_r($selected_users);
         foreach ($selected_users as $row) {
          // echo $row->menuvalue;
            $district = $row->menuvalue;
             $phoneNumber = $row->phone;
           $daily_message = $this->Season_model->broadcast_forecast($district);
           $ct = 0;
           $menuVal =  ucwords($district.', '.$phoneNumber);

           foreach ($daily_message as $row1) {$ct++;
            // echo $ct;
           $from_time = $row1['from_time'];
                        $to_time = $row1['to_time'];
                        $days = date("l", strtotime($row1['forecasted']));
                        $tomorrow = date( 'Y-m-d', strtotime($row1['forecasted'].' +1 day' ) );
                        $day_tmr = date("l", strtotime($tomorrow));

                        if($ct>1){
                            $days = $day_tmr;
                        }else{
                            $summary = ucwords('Weather Summary'.$row1['weather'].'\n');
                        }

            $menuVal .="$days, ".ucwords($row1['period'])."\n($from_time - $to_time)"."\nWeather Outlook: ".$row1['weather_desc']."\nTemperature: ".$row1['mean_temp'].".C\nWind Strength: ".ucwords($row1['strength'])."\n\n";
            
           
         }
         echo $menuVal.'<br>';
         echo '<br><br>';
         //---------calling the Messages function------------------------
        // $this->Messages($menuVal,'256772671359');
        // break;
         
     }

    }
    ////////////////////////////////////

    public function index()
    { 
	$season = $this->Season_model->get_all();
	//print_r($season); exit;
	$data = array(
            'season_data' => $season,
			'change' => 15
        );

        $this->load->view('template', $data);
    }

    public function audio_list()
    { 

         $id= $this->uri->segment(3);
        $_SESSION['parent_season_id'] = $id;
        $data = array(
            'change' => 92,
            'clips' => $this->Season_model->get_clips()
        );
        $this->load->view('template',$data);
    }

    public function audio()
    { 


         $id= $this->uri->segment(3);
        $_SESSION['parent_season_id'] = $id;
        
        $data = array(
            'change' => 93,
            'language' => $this->Season_model->get_available_language()
        );
        $this->load->view('template',$data);
    }

    public function audio_delete()
    { 
        $this->Season_model->delete_clip($this->uri->segment(3));

         $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$this->session->userdata('deleted').' Voice Clip Deleted Successfully!</div>');
        redirect('index.php/Season/audio_list/'.$_SESSION['parent_season_id']);
    }

    public function audio_upload()
    { 
        $path = $_SERVER['DOCUMENT_ROOT'].'/wids/assets/audio/';
        // $path = base_url('assets/audio/').'/';
        
        
        
        $file1 = $_FILES['audio_clip']['name'];
        $lan = $this->input->post('lang');


        $seasoned = "";
        if($this->Season_model->get_abb($this->input->post('identity')) !== null){
            foreach ($this->Season_model->get_abb($this->input->post('identity')) as $k) {
                $seasoned = $lan."_".$k['abbreviation']."_".date('Y');
            }

            if($this->Season_model->check_audio($lan, $seasoned) == null){
                $path = $path.basename($seasoned).".mp3";
                list($txt, $ext) = explode(".", $file1);
                $valid_formats = array('mp3','ogg','wav');
                if(in_array($ext, $valid_formats)){
                    $actual_image_name = $txt.".".$ext;
                    $tmp = $_FILES['audio_clip']['tmp_name'];

                    if(move_uploaded_file($_FILES['audio_clip']['tmp_name'], $path)){
                        $datatoinsert = array(
                            'language_id'   => $lan,
                            'voice_name'    => $seasoned
                        );
                        $this->Season_model->upload_audio($datatoinsert);
                        

                         $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Voice Clip Uploaded Successfully!</div>');
                        
                    }else{
                       
                         $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Upload Failed!</div>');
                    }
                }else{
                   
                     $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Unsupported file format!</div>');
                }
            }else{
                
                $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Audio clip already exists!</div>');
            }
            
            
        }else{
        	$this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> No File!</div>');
        }

        redirect('index.php/Season/audio_list/'. $_SESSION['parent_season_id']);
        //$this->audio_list();
        

    }



	public function wording()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=season's data.doc");
        $data = array(
            'forecast_area_data2'=> $this->Season_model->get_forecast_area($_SESSION['area_seasonal_forecast']),
            'start' => 0
        );
        
        $this->load->view('season_doc2',$data);
    }
    public function pdfing()
    {
        $data = array(
            'forecast_area_data2'=> $this->Season_model->get_forecast_area($_SESSION['area_seasonal_forecast']),
            'start' => 0
        );

        ini_set('memory_limit', '10G');
        $html = $this->load->view('season_doc2', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output('Area Seasonal Forecast data.pdf', 'D');
    }

 
  public function read($id=NULL) 
    {       $id = $this->uri->segment(3);
            $row = $this->Season_model->view_season_data($id);	
	        $data['change'] = 16;
			$data['seasonal_data']= $row;
			$data['area'] =$this->Season_model->get_areaseason_data($id);
            $this->load->view('template', $data);			
    }
	
	
    //create a new season
    public function create() 
    {
	    $data['change'] = 14;	
	  //  $data['region_data'] = $this->Season_model->get_all();

       $data['available_language_data'] = $this->Daily_forecast_model->get_available_language();
		$data['season_data'] = $this->Season_names_model->get_all();
		 
        $this->load->view('template', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if (!empty($_FILES['userfile']['name'])) {
                $this->do_upload();
                if (!$this->upload->do_upload('userfile')) {

                    $data = array(
                        'error' => $this->upload->display_errors(),
                        'error1' => '',
                        'ed' => '1',
                        'button' => 'Create',
                        'action' => site_url('index.php/season/create_action'),
                        'id' => set_value('id'),
                        'descrip' => set_value('descrip'),
                        'impact' => set_value('impact'),
                        'audio' => set_value('audio'),
                        'graph' => set_value('graph'),
                        'change' => 14,

                    );

                    $det = "3";
                    $upload = "not_ok";
                    $this->load->view('template', $data);

                } else {
                     $this->upload->set_max_filesize(10240);
                    $temp = $this->upload->data();
                    $image = $temp['file_name'];
                    $upload = "ok";
                    $det = "2";
                }
            }else{
                $image = "no image upload";
                $upload = "ok";
                $det = "1";
            }
            if (!empty($_FILES['userfile1']['name'])) {
                $this->do_upload();
                if (!$this->upload->do_upload('userfile1')) {
                    $data = array(
                        'error1' => $this->upload->display_errors(),
                        'error' => '',
                        'ed' => '1',
                        'button' => 'Create',
                        'action' => site_url('index.php/season/create_action'),
                        'id' => set_value('id'),
                        'descrip' => set_value('descrip'),
                        'impact' => set_value('impact'),
                        'audio' => set_value('audio'),
                        'graph' => set_value('graph'),
                        'change' => 14,

                    );
                    $upload1 = "not_ok";
                    $det1 = "2";

                    $this->load->view('template', $data);

                } else {
                    $dat = $this->upload->data();
                    $image1 = $dat['file_name'];
                    $upload1 = "ok";
                    $det1 = "1";

                }
            }else{
                $upload1 = "ok";
                $det1 = "1";
                $image1 = "no audio uploaded";


            }
            if ($det == "2" && $det1 == "2") {
               // echo "am here";
                //echo $det1;
                //exit;

                $path1 = $_SERVER['DOCUMENT_ROOT'] . 'Dissemination/uploads/' . $image;
                //$path = $_SERVER['DOCUMENT_ROOT'].'Dissemination_tz/'.$row->audio;

                $this->remove_file($path1);
                //$this->remove_file($path);
            }
            if ($det == "3" && $det1 == "1") {

                $path1 = $_SERVER['DOCUMENT_ROOT'] . 'Dissemination/uploads_decadal/' . $image1;
                //$path = $_SERVER['DOCUMENT_ROOT'].'Dissemination_tz/'.$row->audio;

                $this->remove_file($path1);
                //$this->remove_file($path);
            }
            if ($upload == "ok" && $upload1 == "ok") {

                $all = $this->input->post('impact', TRUE);
                $all .= "<br/>";
                if (!empty($_POST['check_list'])) {

                    // Loop to store and display values of individual checked checkbox.
                    foreach ($_POST['check_list'] as $selected) {
                        $all .= $selected;
                    }

                }

                $data = array(
                    'region' => $this->input->post('region', TRUE),
                    'sub' => $this->input->post('sub_region', TRUE),
                    'seas' => $this->input->post('seas', TRUE),
                    'lang' => $this->input->post('lang',TRUE),
                    'descrip' => $this->input->post('descrip', TRUE),
                    'impact' => $all,
                    'file1' => 'uploads/' . $image,
                    'file2' => 'uploads/' . $image1,
                    'region2' => $this->input->post('region_id', TRUE),

                );

                $hh = $this->Season_model->insert($data);
                if ($hh) {

                    $region = $this->input->post('region', TRUE);
                    $sub_region = $this->input->post('sub_region', TRUE);
                    $season = $this->input->post('seas', TRUE);

                    $farm = $this->Season_model->getfarmers($region,$sub_region,$season);
                    // var_dump($farm);exit;

                    $this->session->set_flashdata('message', '<font color="green" size="5">Create Record Success</font>'); 
                } else {
                    $this->session->set_flashdata('message', '<font color="red" size="5">Create not Record Successful</font>');
                }
                $season = $this->Season_model->get_all();
                $data = array(
                    'season_data' => $season,
                    'change' => 15,
                );

                $this->load->view('template', $data);

               }

            }

    }
    
       public function update() 
    {
        $id = $this->uri->segment(3);
        $row = $this->Season_model->get_by_id($id);
        $luganda = $row->descriptionLuganda;
        $lugandaImpact=$row->impactLuganda;
        $english = $row->description;
        $impact=$row->impact;
        echo $english;
       // echo $english;exit;
        if($luganda!=NULL)
        {
            // echo $luganda;exit;
        if ($row) {
            $impact =str_replace("<br/>", ".", "$row->impactLuganda");
            $data = array(
                'error1' => '',
                'error' => '',
                'ed' => '2',
                'button' => 'Update',
                'action' => site_url('index.php/season/update_action'),
        'id' => set_value('id', $row->sea_id),
        'descrip' => set_value('descrip',$row->descriptionLuganda),
        'impact' => set_value('impact',$impactLuganda),
         'audio' => set_value('audio',$row->audio),
         'graph' => set_value('graph',$row->graph),
        'change'   => 14,
        );
            $this->load->view('template', $data);
        } else {
            $this->session->set_flashdata('message', '<font color="red" size="5">Record Not Found</font>');
            $this->load->view('template', $data);
        }
    }
    // elseif ($english!=NULL) {
        // echo $english;exit;

        if ($row) {
            $impact =str_replace("<br/>", ".", "$row->impact");
            $data = array(
                'error1' => '',
                'error' => '',
                'ed' => '2',
                'button' => 'Update',
                'action' => site_url('index.php/season/update_action'),
        'id' => set_value('id', $row->sea_id),
        'descrip' => set_value('descrip',$row->description),
        'impact' => set_value('impact',$impact),
         'audio' => set_value('audio',$row->audio),
         'graph' => set_value('graph',$row->graph),
        'change'   => 14,
        );
            $sn = $this->uri->segment(3);
            $data['season_data'] = $this->Season_names_model->get_all();
            $data['data_before'] = $this->Season_model->get_update_data($sn);
            $this->load->view('template', $data);
        } else {
            $this->session->set_flashdata('message', '<font color="red" size="5">Record Not Found</font>');
            $this->load->view('template', $data);
        }
    // }
    }
    // New method
    public function save_update(){
        $id = $this->uri->segment(3);
        $datatoupdate = array(
             'overview' => $this->input->post('overview',TRUE),
             'general_forecast'=>$this->input->post('general_forecast',TRUE)
             );
        $this->Season_model->update_data($datatoupdate,$id);
        $data['season_data'] = $this->Season_model->get_all();
       
        $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Forecast Updated Successfully!</div>');
        redirect('index.php/Season');
        
    }

    //////////////////////////////  /////////////////////////////
    
    
	
	//------------- for the area seasonal forecat-------------------------------
	function createregionforecast(){
       $forecastid= $this->uri->segment(3);
       $region = $this->Region_model->get_all();
       $available_language_data = $this->Season_model->get_available_language();
       $season = $this->Season_model->get_all();
	   $subregion = $this->Sub_region_model->get_all();
        $data = array(
                'region_data'=>$region,
                'season_data' => $season,
                'available_language_data' => $available_language_data,
                'change' => 72,
				'subregion'=>$subregion,
                'add_id'=>$forecastid
             );
      $this->load->view('template', $data);
            
	}
    //-------------------------adding data to the database------------------------------
    public function  SaveForecastArea(){
        $id = $this->uri->segment(3);
         $datatoinsert = array(
            'language_id' => $this->input->post('language',TRUE),
             'region_id' => $this->input->post('region_id',TRUE),
			 'subregion_id'=>$this->input->post('subregion_id',TRUE),			
             'expected_peak' => $this->input->post('expected_peak',TRUE),
			 'peakdesc' => $this->input->post('peakdesc',TRUE),
             'onset_period' => $this->input->post('onset_start',TRUE),
             'onsetdesc' => $this->input->post('onsetdesc',TRUE),
			 'enddesc' => $this->input->post('enddesc',TRUE),
			 'end_period' => $this->input->post('end_period',TRUE),
             'overall_comment' => $this->input->post('overall_comment',TRUE),
			 'forecast_id' => $this->input->post('forecast_id',TRUE)
             );

         //-------------2020 changes--------------------------------------------------------------------
          $recs = $this->Season_model->forecast_checker($this->input->post('region_id',TRUE), $this->input->post('subregion_id',TRUE),$this->input->post('language',TRUE),$this->input->post('forecast_id',TRUE));
         $exists = FALSE;
         foreach ($recs as $key) {
             $exists = TRUE;
         }

         if($exists == TRUE){
         	$this->session->set_flashdata('message','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Forecast already exists!</div>');
            
        }else{
            $this->Season_model->insertForecastArea($datatoinsert);
            $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Forecast Entered Successfully!</div>'); 
        }
        //--------------------------------------------------------------------------------------------------------
         
        redirect('index.php/Season/showareaforecast/'.$id);
    }
	//display specific area forecasts
	public function showareaforecast(){
		$id = $this->uri->segment(3);
        $_SESSION['area_seasonal_forecast'] = $this->uri->segment(3);
		$data = array(
           'forecast_area_data'=> $this->Season_model->get_forecast_area($id),
           'change' => 73
            );
   		 $this->load->view('template',$data);
	
	}

    public function ViewArea(){
        $id = $this->uri->segment(3);
        $data = array(
           'forecast_area_data'=> $this->Season_model->get_area_forecast_data($id),
           'change' => 115
            );
         $this->load->view('template',$data);
    
    }
	
    //------------------------------------------------------------------------------------------
    
    
	function saveforecast(){
        $date = strtotime($this->input->post('date',TRUE));
        $date_time = date('Y',$date).'-'.date('m',$date).'-'.date('d',$date);
        $filename = $_FILES['img']['name'];
        $dir = 'assets/frameworks/adminlte/img/'.$filename;

        // $this->Season_model->insert($datatoinsert);
        if($this->Season_model->check_seasonal($this->input->post('year',TRUE), $this->input->post('season_id',TRUE))>0){
             move_uploaded_file($_FILES['img']['tmp_name'], $dir);

            $datatoinsert = array(
                 'year' => $this->input->post('year',TRUE),
                 'general_forecast' => $this->input->post('general_forecast',TRUE),
                 'season_id' => $this->input->post('season_id',TRUE),
                 'overview' => $this->input->post('overview',TRUE),
                 'issuetime' => $date_time,
                 'map' => $filename
                            
            );
            $this->Season_model->insert($datatoinsert);

            $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Seasonal Forecast Uploaded Successfully!</div>');
        }else{
            $this->session->set_flashdata('message','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Seasonal Forecast Already Exists!</div>');   
        }
       

        redirect('index.php/Season');
	
}
    
 
    public function delete($id) 
    {
         $this->Season_model->delete2($id);
	   	$this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$this->session->userdata('deleted').' Area Seasonal Forecast Deleted Successfully!</div>');
           
            redirect('index.php/Season/showareaforecast/'.$_SESSION['area_seasonal_forecast']);
        
    }

    public function remove_file($pp)
    {
        if (file_exists($pp)) {
            unlink($pp);
                   }
                   //else{
           // echo "path not found";
        //}
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('descrip', 'Description', 'trim|required');
    $this->form_validation->set_rules('impact', 'Impact', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "season.xls";
        $judul = "season";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Season Name");
	xlsWriteLabel($tablehead, $kolomhead++, "Season Code");

	foreach ($this->Season_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->season_name);
	    xlsWriteLabel($tablebody, $kolombody++, $data->season_code);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }
	
	public function list()
    { 
	$season = $this->Season_model->get_all();
	$data = array(
            'season_data' => $season,
			'change' => 15
        );

        $this->load->view('template', $data);
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=season.doc");

        $data = array(
            'season_data' => $this->Season_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('season_doc',$data);
    }

    public function pdf()
    {
        $seasons = $this->Season_model->get_all();

        $data = array(
            'season_data' => $seasons,
            'start' => 0
        );
        
        ini_set('memory_limit', '10G');
        $html = $this->load->view('season_doc', $data, true);
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->WriteHTML($html);
        $pdf->Output('season.pdf', 'D'); 
    }

    public function do_upload()
    {
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png|mp3|mp4|mpeg';
        $config['max_size']             = 5000000;
        $config['max_width']            = 5000000;
        $config['max_height']           = 5000000;

        $this->load->library('upload', $config);
      
    }


    
    //TODO: change the table primary key to autoincrement
}

/* End of file Season.php */