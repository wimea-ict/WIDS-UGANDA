<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Victoria extends CI_Controller
{
    
        
    function __construct()
    {
        parent::__construct();
        $this->config->set_item('theme',$this->config->item('country'));
        $this->load->model('victoria_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('Sub_region_model');
        
    }


    public function index()
    { 
        $data = array(
            'change' => 100,
            'victoria_data' => $this->victoria_model->get_all()
        );
        $this->load->view('template',$data);
    }

    public function create() 
    {  
        $data= array(
            'change' => 101,
            'languages'     => $this->victoria_model->get_languages()

        );
        $this->load->view('template', $data);
    }

    public function saveforecast(){
        $f_date = strtotime($this->input->post('date1',TRUE));
        $iss_date = strtotime($this->input->post('date',TRUE));
        // $filename = $_FILES['img']['name'];
        // $dir = 'assets/frameworks/adminlte/img/'.$filename;
        // move_uploaded_file($_FILES['img']['tmp_name'], $dir);

        $filename = 'mng_28_08_2020.PNG';

        $datatoinsert = array(
             'language_id'  => $this->input->post('language',TRUE),
             'forecast_date' => date('Y',$f_date).'-'.date('m',$f_date).'-'.date('d',$f_date),
             'issue_date' => date('Y',$iss_date).'-'.date('m',$iss_date).'-'.date('d',$iss_date),
             'map' => $filename,
             'advice' => $this->input->post('advice',TRUE)
        );
        $this->victoria_model->insert($datatoinsert);
         $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Marine Forecast Uploaded Successfully!.</div>');
        redirect("index.php/Victoria");
      
    }



    public function showareaforecast(){
        $id = $this->uri->segment(3);
        $_SESSION['parent_id'] = $id;
        $data = array(
           'forecast_area_data'=> $this->victoria_model->area_forecast_data($id),
           'change' => 102
            );
         $this->load->view('template',$data);
    
    }

    public function createregionforecast(){
       $forecastid= $this->uri->segment(3);
      
        $data = array(
            'area' => $this->victoria_model->options('victoria_area'),
            'weather' => $this->victoria_model->options('weather_cond'),
            'wind_strength' => $this->victoria_model->options('wind_strength'),
            'wind_direction' => $this->victoria_model->options('wind_direction'),
            'wave_height' => $this->victoria_model->options('wave_height'),
            'rainfall_dist' => $this->victoria_model->options('rainfall_dist'),
            'visibility' => $this->victoria_model->options('visibility'),
                'change' => 103
             );
      $this->load->view('template', $data);
            
    }
    public function  SaveForecastArea(){

        $forecast_id = $this->uri->segment(3);
        $area = $this->input->post('area',TRUE);
        $highlight = $this->input->post('highlight',TRUE);
        $recs = $this->victoria_model->forecast_checker($forecast_id,$area);
         $exists = FALSE;
         foreach ($recs as $key) {
             $exists = TRUE;
         }

         if($exists == TRUE){
            $this->session->set_flashdata('message','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$key['name'].'Zonal Forecast already exists!.</div>');
        }else{
            
            for($i=0;$i<4;$i++){
                if($i == 0){
                    $period = $this->input->post('period',TRUE);

                    $time_frame = explode(" ", $period)[1];
                    $time_date = explode(" ", $period)[0];

                    $period = date('l', strtotime($time_date))." ".$this->victoria_model->get_period($time_frame);

                    $wind_strength = $this->input->post('wind_strength',TRUE);
                    $wind_direction = $this->input->post('wind_direction',TRUE);
                    $wave_height = $this->input->post('wind_height',TRUE);
                    $weather = $this->input->post('weather',TRUE);
                    $rainfall_dist = $this->input->post('rainfall_dist',TRUE);
                    $visibility = $this->input->post('visibility',TRUE);
                    $harzard = $this->input->post('harzard',TRUE);

                    $datatoinsert = array(
                        'vic_area'       => $area,
                        'highlights'    => $highlight,
                        'time'          => $period,

                        'time_frame'    => $time_frame,
                        'time_date'     => $time_date,

                        'wind_strength' => $wind_strength,
                        'wind_direction'=> $wind_direction,
                        'wave_height'   => $wave_height,
                        'weather'       => $weather,
                        'rainfall_dist' => $rainfall_dist,
                        'visibility'    => $visibility,
                        'harzard'       => $harzard,
                        'forecast_id'   => $forecast_id
                    );

                    $this->victoria_model->insertForecastArea($datatoinsert); 
                }else {
                    $period = $this->input->post('period'.$i,TRUE);

                    $time_frame = explode(" ", $period)[1];
                    $time_date = explode(" ", $period)[0];

                    $period = date('l', strtotime($time_date))." ".$this->victoria_model->get_period($time_frame);

                    $wind_strength = $this->input->post('wind_strength'.$i,TRUE);
                    $wind_direction = $this->input->post('wind_direction'.$i,TRUE);
                    $wave_height = $this->input->post('wind_height'.$i,TRUE);
                    $weather = $this->input->post('weather'.$i,TRUE);
                    $rainfall_dist = $this->input->post('rainfall_dist'.$i,TRUE);
                    $visibility = $this->input->post('visibility'.$i,TRUE);
                    $harzard = $this->input->post('harzard'.$i,TRUE);
                    $datatoinsert = array(
                        'vic_area'       => $area,
                        'highlights'    => $highlight,
                        'time'          => $period,

                        'time_frame'    => $time_frame,
                        'time_date'     => $time_date,

                        'wind_strength' => $wind_strength,
                        'wind_direction'=> $wind_direction,
                        'wave_height'   => $wave_height,
                        'weather'       => $weather,
                        'rainfall_dist' => $rainfall_dist,
                        'visibility'    => $visibility,
                        'harzard'       => $harzard,
                        'forecast_id'   => $forecast_id
                    );
                    $this->victoria_model->insertForecastArea($datatoinsert); 
                }
            }

             $this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Forecast Uploaded Successfully!.</div>');
        }
        redirect('index.php/Victoria/showareaforecast/'.$forecast_id);
       
    }

    public function delete_area($id) 
    {
        $id = $this->uri->segment(3);
        $deleted_data = $this->victoria_model->get_deleted_forecast($id);
        foreach ($deleted_data as $key) {
            $_SESSION['deleted_zone'] = $key['name'];
             $_SESSION['deleted_period'] = $key['time'];
            # code...
        }
        $this->victoria_model->delete_area_forecast($id);


        $this->session->set_flashdata('message','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$_SESSION['deleted_zone'].', '.$_SESSION['deleted_period'].' Forecast Deleted Successfully!.</div>');
         $data = array(
           'forecast_area_data'=> $this->victoria_model->area_forecast_data($id),
           'change' => 102
         );
        redirect("index.php/Victoria/showareaforecast/".$_SESSION['parent_id']);
        
    }

    public function delete($id) 
    {
       
        $this->victoria_model->delete($id);
     
        $data = array(
           'victoria_data' => $this->victoria_model->get_all(),
           'change' => 100
        );
          $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$this->session->userdata('deleted').' Forecast Deleted Successfully!.</div>');
         redirect("index.php/Victoria");
        
    }

    public function read($id=NULL) 
    {       
        $id = $this->uri->segment(3);
        $data['rows'] = $this->victoria_model->view_forecast_data($id);  
        $data['change'] = 104;
        $this->load->view('template', $data);           
    }
}
?>