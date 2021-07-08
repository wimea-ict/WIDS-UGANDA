<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
   public function got()
   {
      if(isset($_POST['username'])){
         $_SESSION['site_lang']=strtolower($_POST['username']);   
      }else{
         $_SESSION['site_lang'] ="english";
      }
   }

   public function __construct() {

      parent::__construct();
      $this->config->set_item('theme',$this->config->item('country'));
      $this->load->library('session');


      if(!empty($this->config->item('country'))){
         $this->load->database();
         $this->load->model('Advisory_model');
         $this->load->model('Season_model');
         $this->load->model('Monthly_model');
         $this->load->model('Updates_model');
         $this->load->model('Decadal_forecast_model');
         $this->load->model('Daily_forecast_model');
         $this->load->model('Language_model');
         $this->load->model('Division_model');
         $this->load->model('Forecast_time_model');
         $this->load->model('City_model');
         $this->load->model('Landing_model');
         $this->load->model('Major_model');
         $this->load->model('Minor_model');
         $this->load->library(array('ion_auth', 'form_validation'));
         $this->load->helper(array('url', 'language'));
         $this->load->model('victoria_model');
         $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
      }

   }


// -----------------------------------
    // redirect if needed, otherwise display the user list
   public function index($page = 'request_service') { 

   //sets the page language
    $country = $this->config->item('country'); 
    if ($_SESSION['site_lang'] == null) {
     $_SESSION['site_lang'] ="english";
  }

    //checks the country variable set in the config.php file
  if(empty($country)){
     $step= $this->input->post('step'); 

     if(!isset($step))
            $this->load->view('installer/index',$data);// has hidden variable step 1
         else if($step==1){
            $newdata = array('systemusername'  => $this->input->post('systemusername'),
               'systempassword'     => $this->input->post('systempassword'),
               'database_name' =>$this->input->post('database_name'),
               'database_username' =>$this->input->post('database_username'),
               'database_password' =>$this->input->post('database_password'),
               'system_email' =>$this->input->post('system_email'),
               'country' =>$this->input->post('country')
            );
            $this->session->set_userdata($newdata);

           //set up connection to the db  
           //  echo $this->session->userdata('database_name')." in the session ";
            $content = file_get_contents(APPPATH .'config/database.php');
            $file_content = str_replace("'username' => ''","'username' => '".$this->session->userdata('database_username')."'",$content);
         //insert the content back
            $write_result = file_put_contents(APPPATH .'config/database.php',$file_content);
            $content = file_get_contents(APPPATH .'config/database.php');
            $file_content = str_replace("'password' => ''","'password' => '".$this->session->userdata('database_password')."'",$content);
         //insert the content back
            $write_result = file_put_contents(APPPATH .'config/database.php',$file_content);
            $content = file_get_contents(APPPATH .'config/database.php');
            $file_content = str_replace("'database' => ''","'database' => '".$this->session->userdata('database_name')."'",$content);
          //insert the content back
            $write_result = file_put_contents(APPPATH .'config/database.php',$file_content); 
          //cresate the database 
            $link = mysqli_connect('localhost', $this->session->userdata('database_username'), $this->session->userdata('database_password'));
            if (!$link) {
               die('Could not connect: ' . mysql_error());
            }
   ///     echo $this->session->userdata('database_name')." is the database";
         $db =  mysqli_query($link ,"create database IF NOT EXISTS ".$this->input->post('database_name'));//$this->session->userdata('database_name')
         if(!$db){
            echo mysqli_error($link); echo "create database IF NOT EXISTS ".$this->session->userdata('database_name');   exit(); 
         }        
         mysqli_select_db($link, $this->session->userdata('database_name'));///select the database
         $this->create_tables($link,$this->session->userdata('systemusername'), $this->session->userdata('systempassword'), $this->session->userdata('system_email'),$this->session->userdata('country'));  
         $country = $this->session->userdata('country');       
         $write_result = file_put_contents(APPPATH .'config/config.php', "$"."config['country'] = '".$country."';",FILE_APPEND);
         $this->session->unset_userdata($newdata);
         //refresh so that the person is led to the actual system
         $this->load->helper('url');
         redirect(base_url('/index.php/auth/index'));        
      }
         }else { //loading the main content from here 
            $langg = $this->input->post('language', TRUE);
            //  echo $langg." thsisis"; 
            if(!empty($langg)){
            //session
               $this->session->set_userdata($langg);
               $this->load->helper('url');
               redirect(base_url('/index.php/auth/index')); 
            }else {   

          //if user has selected to view any product there will be some post variables           
               $data['division_type']= $this->Division_model->getdivisionname($country);    
        //get all major cities 
               $cities = $this->City_model->get_major_cities();
               $foreacast_time = $this->Forecast_time_model->get_all();
               $data['major_sector'] = $this->Major_model->get_all();
               $data['minor_sector'] = $this->Minor_model->get_all();
               $data['languages'] = $this->Language_model->get_all();
               $data['division_type']= $this->Division_model->getdivisionname($country);
        //get data for all the recenty entered city data 
               if(isset($cities)){
                  foreach($cities as $c){
                     if(isset($foreacast_time)){
                        foreach($foreacast_time as $ft){
                           $data['forecast_data'][$c['region_id']][$ft->id] = $this->Daily_forecast_model->get_forecast_data_for_city($c['region_id'], $ft->id);           
                           $counter++; 
                        }
                     }
                  }

               }
                  //===============SET ALL LANDING PAGE DATA ARRAYS AND VARIABLES=======================
               $data['season_available_lang'] = $this->Season_model->get_season_available_languages();
               $session_lang = $this->Language_model->get_sessionLang(ucwords($this->session->userdata('site_lang')));

               if ($this->input->post('forecast_language') == NULL) { 
                  $forecast_language = $session_lang;
               }else{
                  $forecast_language = $this->input->post('forecast_language');
               }

               $data['category1'] = $this->input->post('product');
               $id = $this->input->post('division');
               $data['country_name'] = $country;
               $division_text = $this->Division_model->get_divisionName_data($id);
               $data['division_text']= $division_text;
               //Generate a random region id to be used on the home page
               $random = rand(1, 8);
              //--------------seasonal updates----------------
               $data['season_updates'] = $this->Updates_model->get_updates_data(); 


               //-----------------SEASONAL DATA--------------------
              //audio clip data
               $data['clip'] = $this->Season_model->get_lang_clip($forecast_language);
               $data['seasonal_advice_home'] = $this->Season_model->get_advice($random, $forecast_language);
               $season_home = $this->Season_model->get_current_season(); 
               $data['divide'] = $season_home;
               $data['seasonal_data_home'] = $this->Season_model->get_season_data($season_home, $random, $forecast_language);
               $data['dekadal_forecast_data'] = $this->Decadal_forecast_model->get_dekadal_forecast_area($random);
               $data['divisio_name'] = $this->Season_model->get_current_division($random); 

            //...............Victoria forecast integrations...................
               $data['victoria_forecast'] = $this->victoria_model->view_forecast_data($random);
               $data['landing_site_data'] = $this->victoria_model->get_landing_site($random);

            //monthly_forecast_updates form
               $data['monthly_data_home'] = $this->Monthly_model->get_monthly_data();
               $data['monthly_advice_home'] = $this->Monthly_model->get_home_advice();
               $data['monthly_impacts_home'] = $this->Monthly_model->get_home_impacts();

              //-=------------------HOME PAGE DAILY FORECASTS-------------------
               $data['daily_advice_home'] = $this->Daily_forecast_model->get_advice($random);
               $daily_forecast_data_home = $this->Daily_forecast_model->get_recent_forecast();
               $next_day_forecast_data_home = $this->Daily_forecast_model->get_next_day_forecast($random);
               $data['next_day_forecast_data_home']=$next_day_forecast_data_home;


               if(isset($next_day_forecast_data_home)){ 
                  foreach($next_day_forecast_data_home as $d){ 
                   $tomorrow = $d->date; 
                   $tmr_forecast = $d->id;
                   $weather_desc = $d->weather;
                   $valid = $d->validitytime;  
                   $issuedat = $d->issuedate;     

                }
             }

             $data['daily_forecast_data_home']= $daily_forecast_data_home;
             if(isset($daily_forecast_data_home)){ 
               foreach($daily_forecast_data_home as $d){
                $forecast_id = $d->id;
                $forecast_time = $d->time;
                $today = $d->date; 
             }
          }   
          // passing data to the view
          $data['today'] = $today;
          $data['tomorrow'] = $tomorrow;
          $data['weather_desc'] =  $weather_desc;
          $data['valid'] = $valid;
          $data['issuedat'] = $issuedat;


          $get_next_day_forecast_data_for_region_home= $this->Daily_forecast_model->get_next_day_forecast_data_for_region($tmr_forecast,$random);
          $data['get_next_day_forecast_data_for_region_home'] =$get_next_day_forecast_data_for_region_home;      
                // passing data to the view
          $data['daily_forecast_data_home']= $daily_forecast_data_home;
          if(isset($daily_forecast_data_home)){ 
            foreach($daily_forecast_data_home as $d){
             $forecast_id = $d->id;
             $forecast_time = $d->time;                          
          }
       }
       
       $data['daily_forecast_region_data'] =$this->Daily_forecast_model->get_daily_forecast_data_for_region($forecast_id,$random);
       $data['daily_forcast_division'] =$this->Daily_forecast_model->get_daily_forecast_data_for_region_division($random);
       $data['daily_forecast_region_data_24'] = $this->Daily_forecast_model->forcast_for_24hrs($random);
       //division name for currently accessed daily forecast
       $division_name = $this->Division_model->get_divisionNameByID(1);
       $data['division_name'] =$division_name;
       $data['div_id']= $random;
       //==================end============================================


       $area1 = $this->Season_model->get_all_forecast_area();
       $data['area']= $area1;
        //============================================    
       $ve = $this->input->post('product');
       $division_id = $this->input->post('division');


        //----check slelected product on the request service form----------------
       if(isset($ve)){
         //===============DAILY REQUEST DATA=================================================
         if($ve=="Daily Forecast"){
          $data['daily_advice'] = $this->Daily_forecast_model->get_advice($division_id);
          $data['seasonal_advice'] = $this->Daily_forecast_model->get_advice($division_id);
          $daily_forecast_data = $this->Daily_forecast_model->get_recent_forecast();
            // retrieves forecast for the next day
          $next_day_forecast_data = $this->Daily_forecast_model->get_next_day_forecast($division_id);
          $data['next_day_forecast_data']=$next_day_forecast_data;
          if(isset($next_day_forecast_data)){ 
           foreach($next_day_forecast_data as $d){  
            $tomorrow = $d->date;   
            $tmr_forecast = $d->id;
            $weather_desc = $d->weather;
            $valid = $d->validitytime; 
            $issuedat = $d->issuedate;    

         }
      }
      $data['daily_forecast_data']= $daily_forecast_data;
      if(isset($daily_forecast_data)){ 
        foreach($daily_forecast_data as $d){
         $forecast_id = $d->id;
         $forecast_time = $d->time; 
         $today = $d->date;   
      }
   }  
      // passing data to the view
   $data['today'] = $today;
   $data['tomorrow'] = $tomorrow;
   $data['weather_desc'] =  $weather_desc;
   $data['valid'] = $valid;
   $data['issuedat'] = $issuedat;
   $get_next_day_forecast_data_for_region= $this->Daily_forecast_model->get_next_day_forecast_data_for_region($tmr_forecast,$division_id);
   $data['get_next_day_forecast_data_for_region'] =$get_next_day_forecast_data_for_region;   
                // passing data to the view
   $data['daily_forecast_data']= $daily_forecast_data;
   if(isset($daily_forecast_data)){ 
     foreach($daily_forecast_data as $d){
      $forecast_id = $d->id;
      $forecast_time = $d->time;                         
   }
}
$daily_forecast_region_data= $this->Daily_forecast_model->get_daily_forecast_data_for_region($forecast_id,$division_id);


$data['daily_forecast_region_data_24'] = $this->Daily_forecast_model->forcast_for_24hrs($division_id);
$data['daily_forecast_region_data'] =$daily_forecast_region_data;
    //division name for currently accessed daily forecast
$division_name = $this->Division_model->get_divisionNameByID($division_id);
$data['division_name'] =$division_name;
$data['div_id']= $division_id;
   //Retrieve daily forecast for specific/ random region
$daily_forecast_region_data_dynamic = $this->Daily_forecast_model->get_daily_forecast_data_for_region($forecast_id,$random);
$data['daily_forecast_region_data_dynamic'] = $daily_forecast_region_data_dynamic;

}

//====================DEKADAL DATA================================================
if($ve=="Dekadal Forecast"){

 $dekadal_forecast_data =  $this->Decadal_forecast_model->get_dekadal_forecast_division($division_id);
 $data['dekadal_forecast_data'] = $dekadal_forecast_data;
 $data['div_id']= $division_id;
}
 //===================SEASONAL DATA================================================
if($ve=="Seasonal_Forecast"){
  //advice query
 $data['seasonal_advice'] = $this->Season_model->get_advice($division_id, $forecast_language);
 $season = $this->Season_model->get_current_season(); 
 $data['divide'] = $season;
 $data['seasonal_data'] = $this->Season_model->get_season_data($season, $division_id, $forecast_language);
 $data['clip'] = $this->Season_model->get_lang_clip($forecast_language);
 $data['divisio_name'] = $this->Season_model->get_current_division($division_id);
 $data['div_id']= $division_id;
}
//===================VICTORIA DATA================================================
if($ve=="Victoria Forecast"){
 $landing_site_id = $this->input->post('division');
 $data['submitted'] = $landing_site_id;
 $data['victoria_forecast_request'] = $this->victoria_model->view_forecast_data($landing_site_id);
 $data['requested_landing_site'] = $this->victoria_model->get_landing_site($landing_site_id);
}
}   
//--------------------------------------------------------------------------------
$data['major_cities'] = $cities;
$data['counter'] = sizeof($cities);
$this->load->view($page, $data);

        } //closing else, which loads the site 
        
     }
  }

//========================= INSTALLER CODE FOR CREATING===========================================
 //=====for creating tables===================
  public function create_tables($link,$u,$p,$email,$country){
    $q = array();

      //---------------Table 1--------------
    array_push($q,"CREATE TABLE `advice` (
     `id_advice` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
     `advice_name` varchar(100) NOT NULL,
     `advice_des` varchar(100) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
     //---------Table 2------------------------
    array_push($q,"
     CREATE TABLE `advisory` (
     `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
     `sector` int(5) NOT NULL,
     `forecast_id` int(11) NOT NULL,
     `advice` text NOT NULL,
     `message_summary` text,
     `TS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     `region_id` int(11) NOT NULL
     ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
     ");
     //------------Table 3------------------
    $enc_password = md5($p);
    array_push($q,"CREATE TABLE `alerts` (
     `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
     `name` varchar(45) DEFAULT NULL,
     `description` text,
     `issuetime` timestamp NULL DEFAULT NULL,
     `region_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
     //------------------Table 4 -------------
    array_push($q,"CREATE TABLE `area_decadal_forecast` (
     `id` int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `region_id` int(10) NOT NULL,
     `subregion_id` int(10) NOT NULL,
     `dekadal_id` bigint(16) NOT NULL,
     `mapurl` varchar(100) NOT NULL,
     `general_info` text NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

     //------------------Table 5 ----------------
    array_push($q,"CREATE TABLE `seasonal_forecast` (
     `id` bigint(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `overview` text,
     `year` int(4) NOT NULL,
     `general_forecast` text NOT NULL,
     `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `issuetime` date NOT NULL,
     `season_id` int(11) NOT NULL,
     `map` varchar(100) NOT NULL
     ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
     ");
     //------------------Table 6 ----------------
    array_push($q,"

     CREATE TABLE `area_seasonal_forecast` (
     `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `forecast_id` int(10) NOT NULL,
     `region_id` int(4) NOT NULL,
     `subregion_id` int(4) NOT NULL,
     `expected_peak` varchar(25) NOT NULL,
     `peakdesc` varchar(32) NOT NULL,
     `onset_period` varchar(35) NOT NULL,
     `onsetdesc` varchar(23) NOT NULL,
     `end_period` varchar(23) NOT NULL,
     `enddesc` varchar(23) NOT NULL,
     `overall_comment` text NOT NULL,
     `general_info` text,
     `language_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
     //------------------Table 7 -----------
    array_push($q,"CREATE TABLE IF NOT EXISTS `city` (
      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `city_name` varchar(45) NOT NULL,
      `major_city` int(1) NOT NULL default 0,
      `division_id` varchar(45) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//------------------Table 8 -----------
    array_push($q,"
      INSERT INTO `city` (`id`, `city_name`,`division_id`,`major_city`) VALUES
      ('1','Kiboga','1','1'),
      ('2','Mubende','2','1'),
      ('3','Rakai','3','1'),
      ('4','Buvuma','10','1');"); 

 //-------------Table 9 ---------------------
    array_push($q,"
      CREATE TABLE `ci_news` (
      `ne_id` NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `ne_title` varchar(300) NOT NULL,
      `ne_slug` varchar(50) NOT NULL,
      `ne_desc` text NOT NULL COMMENT 'نص الخبر',
      `ne_img` varchar(255) NOT NULL,
      `ne_views` int(11) NOT NULL,
      `ne_created` varchar(50) NOT NULL
   ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

//-----------Table 10 -----------------
    array_push($q,"CREATE TABLE `daily_advisory` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `sector` int(5) NOT NULL,
      `forecast_id` int(11) NOT NULL,
      `advice` text NOT NULL,
      `message_summary` text,
      `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//-----------Table 11 -----------------
    array_push($q,"CREATE TABLE `daily_forecast` (
      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `language_id` int(11) NOT NULL,
      `weather` text,
      `date` date DEFAULT NULL,
      `time` varchar(11) DEFAULT NULL,
      `issuedate` date NOT NULL,
      `validitytime` varchar(30) DEFAULT NULL,
      `dutyforecaster` varchar(300) NOT NULL,
      `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;   ");
//-----------Table 12 -----------------
    array_push($q,"
      CREATE TABLE `daily_forecast_data` (
      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `mean_temp` text,
      `max_temp` double DEFAULT NULL,
      `min_temp` double DEFAULT NULL,
      `wind` int(11) DEFAULT NULL,
      `wind_direction` text,
      `wind_strength` text,
      `region_id` int(10) NOT NULL,
      `division_id` int(10) DEFAULT NULL,
      `weather_cat_id` varchar(11) DEFAULT NULL,
      `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `forecast_id` int(11) NOT NULL,
      `period` int(11) DEFAULT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
   ");

//-----------Table 13 -----------------
    array_push($q," CREATE TABLE `decadal_forecast` (
      `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `date_from` date NOT NULL,
      `date_to` date NOT NULL,
      `issuedate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      `volume` int(9) NOT NULL,
      `general_info` text NOT NULL,
      `max_temp` int(11) NOT NULL,
      `min_temp` int(11) NOT NULL,
      `mean_temp` int(11) NOT NULL,
      `issue` varchar(30) NOT NULL,
      `rainfall` text NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//-----------Table 14 -----------------
    array_push($q,"CREATE TABLE IF NOT EXISTS `feedback` (
      `record_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `forecast_type` int(11) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//-----------Table 15 -----------------
    array_push($q,"CREATE TABLE `forecast_time` (
      `id` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `period_name` varchar(20) NOT NULL,
      `to_time` varchar(10) NOT NULL,
      `from_time` varchar(10) NOT NULL,
      `timeadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//-----------Table 16 -----------------
    array_push($q,"INSERT INTO `forecast_time` (`id`, `period_name`, `to_time`, `from_time`, `timeadded`) VALUES
      (1, 'Early morning', '6:00 am ', '12:00 am', '2019-09-08 06:22:57'),
      (2, 'Late morning', '12:00 pm', '6:00 am', '2019-09-07 16:22:57'),
      (3, 'Late Afternoon', '6:00 pm', '12:00 pm', '2019-09-08 07:07:57'),
      (4, 'Evening', '12:00 am', '6:00 pm', '2020-01-30 17:21:13'),
      (5, '24 Hrs', '6:00 pm', '6:00 pm', '2020-01-30 17:21:13'),
      (10, 'Afternoon', '6:00 pm', '12:00 pm', '2020-08-27 10:03:50');");

//-----------Table 17 -----------------
    array_push($q,"CREATE TABLE `impacts` (
      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `description` varchar(234) NOT NULL,
      `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//-----------Table 18 -----------------
    array_push($q,"CREATE TABLE `impact_forecast` (
       `id` int(24) NOT NULL,
       `impact_id` int(24) NOT NULL,
       `forecast_id` int(24) NOT NULL,
       `type` varchar(100) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
//-------------Table 19 -------------
    array_push($q,"CREATE TABLE `landing_site` (
      `id` int(11) NOT NULL,
      `site_name` varchar(100) NOT NULL,
      `district_id` int(11) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//-------------Table 20 -------------
    array_push($q,"INSERT INTO `landing_site` (`id`, `site_name`, `district_id`) VALUES
      (1, 'KIGUNGU', 1),
      (2, 'GREEN FIELDS', 1),
      (3, 'BUGONGA', 1),
      (4, 'KASENYI', 1),
      (5, 'GERENGE', 1),
      (6, 'NAKIWOGO', 1),
      (7, 'BUSABALA', 1),
      (8, 'KIWULWE', 1),
      (9, 'KAGULUBE', 1),
      (10, 'GULWE', 1),
      (11, 'KINYWANTE', 1),
      (12, 'KYANJAZI', 1),
      (13, 'KAVA ENNYANJA', 1),
      (14, 'KITUUFU', 1),
      (15, 'BUGIRI', 1),
      (16, 'BUGANGA', 1),
      (17, 'KKOJA', 1),
      (18, 'SEMALUULU', 1),
      (19, 'KIBAMBA', 1),
      (20, 'GGABA', 2),
      (21, 'PORT BELL', 2),
      (22, 'SSENYONDO', 3),
      (23, 'KATEMBO', 3),
      (24, 'LWALAARO', 3),
      (25, 'KAMALIBA', 4),
      (26, 'KAMUWUNGA', 4),
      (27, 'LUTOBOKA', 5),
      (28, 'MWENA', 5),
      (29, 'KAGOONYA', 5),
      (30, 'KISUJJU', 5),
      (31, 'KASEKULO', 5),
      (32, 'LUKU', 5),
      (33, 'BUGOMA', 5),
      (34, 'KAAZI', 5),
      (35, 'KAMMESE', 5),
      (36, 'KACHANGA', 5),
      (37, 'KAAYA', 5),
      (38, 'MISONZI', 5),
      (39, 'BBOSA', 5),
      (40, 'BANDA', 5),
      (41, 'KITOBO', 5),
      (42, 'JAANA', 5),
      (43, 'NTOWA', 5),
      (44, 'LWANABATYA', 5),
      (45, 'BUBEKE', 5),
      (46, 'BUYANGE', 5),
      (47, 'NKESE', 5),
      (48, 'MAKONZI', 6),
      (49, 'BUKAKKATA', 6),
      (50, 'LAMBU', 6),
      (51, 'KAZIRU', 6),
      (52, 'DDIMU', 6),
      (53, 'NAMIREMBE', 6),
      (54, 'MALEMBO', 7),
      (55, 'ZZINGA', 7),
      (56, 'MUSAMBWA', 7),
      (57, 'KYABASIMBA', 7),
      (58, 'KASENSERO', 7),
      (59, 'LUKUNYU', 7),
      (60, 'NKOSE', 8),
      (61, 'LUJAAMBWA', 8),
      (62, 'KYAGALANYI', 8),
      (63, 'NAKATIBA', 8),
      (64, 'KASAMBA', 8),
      (65, 'MIYANA', 8),
      (66, 'KACHUNGWA', 8),
      (67, 'BUSINDI', 8),
      (68, 'KISABA', 8),
      (69, 'NAKIRANGA', 8),
      (70, 'DAJJE', 8),
      (71, 'MAWAALA', 8),
      (72, 'KANANAASI', 8),
      (73, 'KIYINDI', 9),
      (74, 'SENYI', 9),
      (75, 'MAYUGE', 9),
      (76, 'MASESE', 10),
      (77, 'LUKALE', 11),
      (78, 'LUFU', 11),
      (79, 'NAMAKEBA', 11),
      (80, 'KIKONGO', 11),
      (81, 'LUKOMA', 11),
      (82, 'MUBAALE', 11),
      (83, 'KILONGO', 11),
      (84, 'YUBWE', 11),
      (85, 'KACHANGA', 11),
      (86, 'NAMUGOMBE', 11),
      (87, 'KILEWE', 11),
      (88, 'LUBYA', 11),
      (89, 'NAMITI', 11),
      (90, 'NAMUTALE', 11),
      (91, 'WAKIRERE', 11),
      (92, 'LINGIRA', 11),
      (93, 'LIIBU', 11),
      (94, 'NKATA', 11),
      (95, 'KIWOLOLO', 11),
      (96, 'KITAMIIRO', 11),
      (97, 'NAMAKEBA', 11),
      (98, 'MUWAMA', 11),
      (99, 'ZZINGA', 11),
      (100, 'SSIRIBA', 11),
      (101, 'LYABAANA', 11),
      (102, 'MAKALAGA', 11),
      (103, 'MAJANJI', 12),
      (104, 'MADUWA', 12),
      (105, 'BUGOTO', 13),
      (106, 'WAKAWAKA', 13),
      (107, 'BWONOHA', 14),
      (108, 'NAMONI', 14),
      (109, 'LWANIKA', 14),
      (110, 'MALINDI', 14),
      (111, 'LUKAGABO', 14),
      (112, 'KABUUKA', 14),
      (113, 'JAGUSI', 14),
      (114, 'SAGITI', 14),
      (115, 'BUMBA', 14),
      (116, 'NAMUGONGO', 14),
      (117, 'NANGO', 14),
      (118, 'WAMALA', 14),
      (119, 'SSERINYABBI', 14),
      (120, 'LUGALA', 15),
      (121, 'BUMERU A', 15),
      (122, 'BUMERU B', 15),
      (123, 'SINGIRA', 15),
      (124, 'GOLOOFA', 15),
      (125, 'KANDEEGE', 15),
      (126, 'MANINGA', 15),
      (127, 'HAAMA', 15),
      (128, 'MIGINGO', 16);");
//----------Table 21-------------
    array_push($q,"CREATE TABLE `language` (
      `id` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `name` varchar(30) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//----------Table 22-------------
    array_push($q,"
      INSERT INTO `language` (`id`, `name`) VALUES
      (1, 'English'),
      (2, 'Luganda');");
//----------Table 23-------------
    array_push($q,"CREATE TABLE `main_regions` (
     `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
     `region_name` varchar(50) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
//----------Table 24-------------
    array_push($q,"INSERT INTO `main_regions` (`id`, `region_name`) VALUES
     (1, 'Western '),
     (2, 'Central Region and Lake Victoria Basin'),
     (3, 'Eastern '),
     (5, 'Northern ');");
//---------Table 25 --------------
    array_push($q,"
      CREATE TABLE `major_sector` (
      `id` int(11) NOT NULL,
      `language_id` int(11) NOT NULL,
      `sector_name` varchar(45) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
      ");

//---------Table 26 --------------
    array_push($q,"INSERT INTO `major_sector` (`id`, `language_id`, `sector_name`) VALUES
      (1, 1, 'Agriculture and food security'),
      (2, 1, 'Health'),
      (3, 1, 'Construction '),
      (4, 1, 'Waters'),
      (5, 1, 'weather'),
      (6, 1, 'Disaster Management '),
      (8, 4, 'Ekitongole ky’ebyobulimi n’obungi bw’emmere'),
      (9, 4, 'Ekitongole ky’ebigwa bitalaze n’ebibamba'),
      (10, 4, 'Ekitongole ky’amazzi '),
      (11, 4, 'Ekitundu ky’ebyobulamu'),
      (12, 6, 'Ey\'ebyobulimi n\'ebyokulya'),
      (13, 6, 'Ey\'ekujunanizibwa okufushya ebigwererezi'),
      (14, 6, 'Ey\'eby\'amaizi'),
      (15, 6, 'Ey\'eby\'obwomeezi'),
      (16, 10, 'Esitongole sye bikwawo nibitalakire'),
      (17, 10, 'Obulamu'),
      (18, 10, 'Amachi'),
      (19, 4, 'Ekitongole ky\'emirimu n\'enguudo'),
      (20, 9, 'Ebyobuhingi'),
      (21, 9, 'Eby\'amagara'),
      (22, 5, 'Ebigema kubyokulima n\'okwelinda endhala'),
      (23, 5, 'Ate kubyobulamu'),
      (24, 5, 'Ebigema kuntambula n\'enguudu'),
      (25, 14, 'Dogtic ma mako peko ma ngole atura'),
      (26, 14, 'Dogtic ma mako gedo '),
      (27, 14, 'Pi Yotkom'),
      (28, 14, 'Idog tic me Pur ki Gwoko dero cam'),
      (29, 12, 'Ocoko ma Azakozu'),
      (30, 12, 'Yii Dria'),
      (31, 12, 'Alata Dria'),
      (32, 12, 'Ega Nyaka Ezozu Azini Nyaka Tambazu Ri'),
      (33, 13, 'Busiku butundubikhe'),
      (34, 13, 'Bye kameetsi'),
      (35, 13, 'Bye bubwombekhi, tsingudo ni ingenda'),
      (36, 13, 'Bye bulamu'),
      (37, 13, 'Bye bulimi ni khuuba ni biilyo bibiiyikinikha'),
      (38, 9, 'Eby\'amatungo');");
//------------Table 27 ----------
    array_push($q,"CREATE TABLE `menu` (
      `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `link` varchar(255) NOT NULL,
      `icon` varchar(255) NOT NULL,
      `is_active` int(11) NOT NULL,
      `is_parent` int(11) NOT NULL,
      `descrpition` varchar(100) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//------------Table 28 ----------
    array_push($q,"INSERT INTO `menu` (`id`, `name`, `link`, `icon`, `is_active`, `is_parent`, `descrpition`) VALUES
      (1, 'Forecasts', '', 'fa fa-line-chart', 1, 0, 'forecast'),
      (2, 'Dekadal forecast', '/index.php/Dekadal_forecast/index', 'fa fa-cloud', 1, 1, 'one'),
      (3, 'Daily Forecast', '/index.php/Daily_forecast/index', 'fa fa-cloud', 1, 1, 'one'),
      (4, 'Seasonal Forecast', '/index.php/Season', 'fa fa-cloud', 1, 1, 'one'),
      (8, 'Advisories', '/index.php/Advisory/index', 'fa fa-check-square-o', 1, 0, 'one'),
      (12, 'Forecast Advice', '/index.php/user_feedback/index', 'ion-android-mail', 1, 5, 'one'),
      (14, 'forecast graphs', '/index.php/graph/index', 'ion-arrow-graph-up-right', 0, 0, 'one'),
      (15, 'user feedback', '/index.php/User_feedback', 'fa fa-comments', 1, 0, 'one'),
      (16, 'STATISTICS', '/index.php/graph/index', 'fa fa-bar-chart', 1, 0, 'one'),
      (17, 'feedback', '/index.php/graph/feedback', '', 1, 16, 'one'),
      (18, 'ussd requests', 'index.php/graph/ussdRequest', '', 1, 16, 'one'),
      (19, 'ussd request trend', 'index.php/graph/trend', '', 1, 16, 'one'),
      (20, 'Admin Structures', '/index.php/Division/index', 'fa fa-sitemap', 1, 0, ''),
      (21, 'Region', '/index.php/Region', '', 1, 20, 'one'),
      (22, 'District', '/index.php/Division', '', 1, 20, 'one'),
      (23, 'City', '/index.php/City/index', '', 0, 20, 'one'),
      (24, 'Sectors', '/index.php/Sector', 'glyphicon glyphicon-grain', 1, 0, ''),
      (25, 'Major Sector', '/index.php/Major_Sector', '', 1, 24, 'one'),
      (26, 'Minor Sector', '/index.php/Minor_sector', '', 1, 24, 'one'),
      (27, 'Daily Forecast Time', '/index.php/Daily_forecast_time/index', 'fa fa-cloud', 1, 1, 'one'),
      (31, 'Possible Impacts', '/index.php/Impacts', 'fa fa-compress', 1, 0, ''),
      (32, 'Seasons', '/index.php/Season_names', 'fa fa-cloud', 1, 0, ''),
      (33, 'Possible Advisories', '/index.php/Possible_advisories', 'fa fa-check-square', 1, 0, ''),
      (34, 'Seasonal Terminologies', '/index.php/Terminologies/index', '', 0, 0, ''),
      (35, 'SUB-REGIONS', '/index.php/Sub_region', '', 1, 20, 'one'),
      (36, 'Daily Advisory', '/index.php/Advisory/daily', '', 1, 8, 'one'),
      (37, 'Dekadal Advisory', '/index.php/Advisory/dekadal', '', 1, 8, 'one'),
      (38, 'Seasonal Advisory', '/index.php/Advisory/index', '', 1, 8, 'one'),
      (39, 'USSD Menu Settings', '/index.php/USSD', 'fa fa-tablet', 1, 43, 'one'),
      (40, 'User Management', '/index.php/Landing/Users', 'fa fa-users', 1, 0, 'User management'),
      (41, 'Victoria Forecast', '/index.php/Victoria', 'fa fa-cloud', 1, 1, 'one'),
      (42, 'Broadcast Message', '/index.php/Season/broadcast', 'glyphicon glyphicon-signal', 1, 43, 'one'),
      (43, 'USSD MANAGEMENT', '/index.php/Landing/Users', 'fa fa-tablet', 1, 0, 'one'),
      (44, 'USSD DAILY USERS', '/index.php/USSD/DailyUsers', 'fa fa-bar-chart', 1, 43, 'one'),
      (45, 'USSD USER FEEDBACK', '/index.php/USSD/UserFeedback', 'fa fa-comments-o', 1, 43, 'one'),
      (46, 'DISTRICT COVERAGE', '/index.php/district_coverage', 'ion ion-android-globe', 1, 43, 'one'),
      (47, 'USSD HOURLY USERS', '/index.php/USSD/ussd_hourly_users', 'fa fa-bar-chart', 1, 43, 'one'),
      (48, 'FREQUENT USSD USERS', '/index.php/Landing/frequent_users', 'fa fa-bar-chart', 1, 43, 'one'),
      (49, 'USSD REQUESTED SECTORS', 'index.php/graph/requested_sectors', '', 1, 16, 'one'),
      (50, 'USSD SUBSCRIBERS', 'index.php/USSD/Subscriptions', 'fa fa-user', 1, 53, 'one'),
      (51, 'Web Visits', 'index.php/graph/web_visits', '', 1, 16, 'one'),
      (52, 'USSD Session tracking', 'index.php/graph/ussd_sessions', '', 1, 16, 'one'),
      (53, 'USSD SUBSCRIPTIONS', '/index.php/Landing/Users', 'fa fa-tablet', 1, 0, 'one'),
      (54, 'Monthly Forecast', '/index.php/monthly_forecast', 'fa fa-cloud', 1, 1, 'one'),
      (55, 'SUBSCRIPTION MESSAGES', 'index.php/USSD/Subscription_messages', 'icon-envelope', 1, 53, 'one'),
      (56, 'Voice Message Requests', '/index.php/USSD/Voice', 'fa fa-bar-chart', 1, 43, 'one');

      ");
     //---------------Table 29 -----------
array_push($q,"CREATE TABLE `victoria_area_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `vic_area` int(11) NOT NULL,
  `highlights` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `time_frame` int(20) NOT NULL,
  `time_date` date DEFAULT NULL,
  `wind_strength` int(11) NOT NULL,
  `wind_direction` int(12) NOT NULL,
  `wave_height` int(11) NOT NULL,
  `weather` int(11) NOT NULL,
  `rainfall_dist` int(11) NOT NULL,
  `visibility` int(11) NOT NULL,
  `harzard` varchar(255) NOT NULL,
  `forecast_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


     //---------------Table 30 -----------
array_push($q,"CREATE TABLE `season_months` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `season_name` varchar(80) NOT NULL,
  `month_from` varchar(80) NOT NULL,
  `month_to` varchar(80) NOT NULL,
  `abbreviation` varchar(80) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

     //---------------Table 31 -----------
array_push($q,"INSERT INTO `season_months` (`id`, `season_name`, `month_from`, `month_to`, `abbreviation`, `time_added`) VALUES
  (1, 'September to December', 'SEPT', 'DEC', 'SOND', '2019-09-09 14:44:58'),
  (2, 'March to May', 'March', 'May', 'MAM', '2019-09-09 14:47:27'),
  (3, 'June to July', 'June', 'July', 'JJA', '2019-09-12 02:16:08'),
  (4, 'January to Feb', 'January', 'Feb', 'JF', '2019-09-14 07:37:46');
  "); 
 //---------------Table 32 -----------
array_push($q,"CREATE TABLE `region` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `region_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

array_push($q,"INSERT INTO `region` (`id`, `region_name`) VALUES
   (1, 'Eastern Lake Victoria basin'),
   (2, 'Central Lake Victoria basin'),
   (3, 'Western Lake Victoria basin'),
   (4, 'Western parts of Central'),
   (5, 'Eastern parts of Central'),
   (6, 'Mid-western'),
   (7, 'Northern Rwenzori'),
   (8, 'Southern Rwenzori'),
   (9, 'Kigezi Highlands'),
   (10, 'Southwestern'),
   (11, 'West Nile'),
   (12, 'Central Northern'),
   (13, 'Northern Kyoga'),
   (14, 'Eastern Kyoga'),
   (15, 'Northeastern'),
   (16, 'Mt. Elgon highlands'),
   (17, 'Eastern Lowlands'),
   (18, 'South and Central Western');");
 //---------------Table 33 -----------

array_push($q,"CREATE TABLE `sub_region` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `sub_region_name` varchar(80) NOT NULL,
 `region_id` int(11) NOT NULL,
 `main_region_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


  //---------------Table 34 ----------- 
array_push($q,"
   INSERT INTO `sub_region` (`id`, `sub_region_name`, `region_id`, `main_region_id`) VALUES
   (1, 'All Regions', 20, NULL),
   (2, 'South Western', 1, 1),
   (3, 'Western Central', 1, 1),
   (4, 'Northern and Southern parts of central', 2, NULL),
   (5, 'Central and Western Lake Victoria Basin', 2, 2),
   (6, 'Eastern parts of Central', 2, 2),
   (7, 'Eastern Lake Victoria and South Eastern', 2, 2),
   (8, 'Eastern Central', 3, 3),
   (9, 'North Eastern', 3, 3),
   (10, 'Central Northern Parts', 5, 5),
   (11, 'North Western', 5, 5),
   (12, 'Eastern Northern Parts', 5, 5),
   (13, 'South Eastern', 18, 3),
   (14, 'Western parts of Central', 1, 2);");           

  //---------------Table 35 ----------- 
array_push($q,"CREATE TABLE `division` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `division_name` varchar(45) NOT NULL,
  `division_type` varchar(45) NOT NULL,
  `region_id` int(8) NOT NULL,
  `sub_region_id` int(11) DEFAULT NULL,
  `main_region` int(11) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  ");

//---------------Table 36 ----------- 
array_push($q,"CREATE TABLE `ussdmenulanguage` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `language` varchar(100) NOT NULL,
  `language_text_table` varchar(255) NOT NULL,
  `forecast_table` varchar(100) NOT NULL,
  `daily` varchar(100) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  ");

//---------------Table 37 ----------- 
array_push($q,"CREATE TABLE `seasonal_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `season_id` int(11) NOT NULL,
  `month` varchar(40) NOT NULL,
  `issue_time` date NOT NULL,
  `rainfall_outlook` text NOT NULL,
  `further_outlook` text NOT NULL,
  `advisories` text,
  `impacts` text NOT NULL,
  `conclusion` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 38 ----------- 
array_push($q,"CREATE TABLE `voice` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `language_id` int(11) NOT NULL,
  `voice_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


//---------------Table 39 ----------- 
array_push($q,"CREATE TABLE `ussd_transactions_2021` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `phone` varchar(15) NOT NULL,
  `sessionId` varchar(200) NOT NULL,
  `language` varchar(200) DEFAULT NULL,
  `district` varchar(200) DEFAULT NULL,
  `product` varchar(200) DEFAULT NULL,
  `period_selected` varchar(200) DEFAULT NULL,
  `advisory` varchar(200) DEFAULT NULL,
  `msg_type` varchar(200) DEFAULT NULL,
  `confirmation` varchar(200) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


//---------------Table 40 ----------- 
  array_push($q,"    INSERT INTO `division` (`id`, `division_name`, `division_type`, `region_id`, `sub_region_id`, `main_region`, `lat`, `lng`) VALUES
   (1, 'KAMPALA', 'District', 2, 5, 2, 0.315556, 32.565556),
   (2, 'KISORO', 'District', 9, 2, 1, -1.283639, 29.688249),
   (3, 'KABALE', 'District', 9, 2, 1, -1.326111, 30.003889),
   (4, 'RUKUNGIRI', 'District', 9, 2, 1, -0.841111, 29.941944),
   (5, 'KANUNGU', 'District', 9, 2, 1, -0.9575, 29.789722),
   (6, 'NTUNGAMO', 'District', 10, 2, 1, -0.879444, 30.264167),
   (7, 'MBARARA', 'District', 10, 2, 1, -0.630583, 30.658179),
   (8, 'KIRUHURA', 'District', 10, 2, 1, -0.235556, 30.8725),
   (9, 'ISINGIRO', 'District', 10, 2, 1, -0.868637, 30.830189),
   (10, 'IBANDA', 'District', 10, 2, 1, -0.153889, 30.531944),
   (11, 'BUSHENYI', 'District', 10, 2, 1, -0.585278, 30.211389),
   (12, 'BUHWEJU', 'District', 10, 2, 1, -0.350269, 30.300291),
   (13, 'SHEEMA', 'District', 10, 2, 1, -0.626019, 30.435935),
   (14, 'RUBIRIZI', 'District', 10, 2, 1, -0.298889, 30.133611),
   (15, 'KASESE', 'District', 8, 2, 1, 0.23, 29.988333),
   (16, 'BUNDIBUGYO', 'District', 7, 3, 1, 0.708474, 30.063418),
   (17, 'NTOROKO', 'District', 7, 3, 1, 1.041111, 30.481111),
   (18, 'KABAROLE', 'District', 7, 3, 1, 0.661959, 30.282684),
   (19, 'KYENJOJO', 'District', 7, 3, 1, 0.632778, 30.621389),
   (20, 'KYEGEGWA', 'District', 7, 3, 1, 0.502222, 31.041389),
   (21, 'KAMWENGE', 'District', 7, 3, 1, 0.211111, 30.420833),
   (22, 'KIBAALE', 'District', 6, 3, 1, 0.8, 31.066667),
   (23, 'HOIMA', 'District', 6, 3, 1, 1.435556, 31.343611),
   (24, 'BULIISA', 'District', 6, 3, 1, 2.117807, 31.411633),
   (25, 'MASINDI', 'District', 6, 3, 1, 1.674444, 31.715),
   (26, 'MOYO', 'District', 11, 11, 5, 3.660883, 31.724736),
   (27, 'ARUA', 'District', 11, 11, 5, 3.020129, 30.911052),
   (28, 'MARACHA', 'District', 11, 11, 5, 3.270421, 30.955322),
   (29, 'NEBBI', 'District', 11, 11, 5, 2.478259, 31.088935),
   (30, 'ADJUMANI', 'District', 12, 11, 5, 3.377862, 31.790897),
   (31, 'YUMBE', 'District', 11, 11, 5, 3.465057, 31.246893),
   (32, 'KOBOKO', 'District', 11, 11, 5, 3.413637, 30.959935),
   (33, 'ZOMBO', 'District', 11, 11, 5, 2.51355, 30.909094),
   (34, 'RAKAI', 'District', 3, 4, 2, -0.72, 31.483889),
   (35, 'LYANTONDE', 'District', 3, 4, 2, -0.403056, 31.157222),
   (36, 'BUKOMANSIMBI', 'District', 3, 5, 2, -0.157778, 31.604167),
   (37, 'SEMBABULE', 'District', 3, 4, 2, -0.077222, 31.456667),
   (38, 'MUBENDE', 'District', 4, 4, 2, 0.589167, 31.36),
   (39, 'KIBOGA', 'District', 4, 4, 2, 0.916111, 31.774167),
   (40, 'KYANKWANZI', 'District', 4, 4, 2, 1.200615, 31.800625),
   (41, 'NAKASEKE', 'District', 5, 4, 2, 0.751667, 32.385),
   (42, 'NAKASONGOLA', 'District', 5, 4, 2, 1.308889, 32.456389),
   (43, 'MUKONO', 'District', 2, 6, 2, 0.353333, 32.755278),
   (44, 'LUWEERO', 'District', 5, 4, 2, 0.849167, 32.473056),
   (45, 'BUIKWE', 'District', 2, 6, 2, 0.3375, 33.010556),
   (46, 'KAYUNGA', 'District', 2, 6, 2, 0.7025, 32.888611),
   (47, 'KALANGALA', 'District', 2, 5, 2, -0.308889, 32.225),
   (48, 'BUVUMA', 'District', 2, 6, 2, 0.222155, 33.206081),
   (49, 'WAKISO', 'District', 2, 5, 2, 0.404444, 32.459444),
   (50, 'MASAKA', 'District', 3, 4, 2, -0.312724, 31.715937),
   (51, 'MPIGI', 'District', 2, 5, 2, 0.225, 32.313611),
   (52, 'KALUNGU', 'District', 3, 5, 2, -0.166667, 31.756944),
   (53, 'GOMBA', 'District', 4, 5, 2, 0.203333, 32.088056),
   (54, 'MITYANA', 'District', 4, 5, 2, 0.4175, 32.022778),
   (55, 'JINJA', 'District', 1, 7, 2, 0.424444, 33.204167),
   (56, 'MAYUGE', 'District', 1, 7, 2, 0.457812, 33.480622),
   (57, 'BUGIRI', 'District', 1, 7, 2, 0.571389, 33.741667),
   (58, 'BUSIA', 'District', 1, 7, 2, 0.454444, 34.075833),
   (59, 'KAMULI', 'District', 4, 13, 3, 0.947222, 33.119722),
   (60, 'IGANGA', 'District', 1, 13, 3, 0.609167, 33.468611),
   (61, 'LUUKA', 'District', 4, 13, 3, 0.700756, 33.300202),
   (62, 'NAMUTUMBA', 'District', 17, 13, 3, 0.836305, 33.685763),
   (63, 'BUYENDE', 'District', 4, 13, 3, 1.151667, 33.155),
   (64, 'KALIRO', 'District', 17, 13, 3, 0.894873, 33.504792),
   (65, 'TORORO', 'District', 1, 7, 2, 0.692991, 34.180853),
   (66, 'PALLISA', 'District', 17, 8, 3, 1.145, 33.709444),
   (67, 'MBALE', 'District', 16, 8, 3, 1.074804, 34.177352),
   (68, 'SIRONKO', 'District', 16, 8, 3, 1.234913, 34.256757),
   (69, 'MANAFWA', 'District', 16, 8, 3, 0.978421, 34.374301),
   (70, 'BUDUDA', 'District', 16, 8, 3, 1.011178, 34.331123),
   (71, 'KAPCHORWA', 'District', 16, 8, 3, 1.396509, 34.450929),
   (72, 'KUMI', 'District', 14, 8, 3, 1.460833, 33.936111),
   (73, 'KABERAMAIDO', 'District', 14, 8, 3, 1.738889, 33.159444),
   (74, 'SOROTI', 'District', 14, 8, 3, 1.685556, 33.616389),
   (75, 'SERERE', 'District', 14, 8, 3, 1.494167, 33.455278),
   (76, 'AMOLATAR', 'District', 13, 12, 5, 1.615556, 32.839722),
   (77, 'BUTALEJA', 'District', 17, 13, 3, 0.916554, 33.956315),
   (78, 'BULAMBULI', 'District', 16, 8, 3, 1.166667, 34.383333),
   (79, 'KWEEN', 'District', 16, 8, 3, 1.416667, 34.533333),
   (80, 'BUKWO', 'District', 17, 8, 3, 1.259167, 34.753889),
   (81, 'BUKEDEA', 'District', 4, 8, 3, 1.316944, 34.050556),
   (82, 'NGORA', 'District', 14, 8, 3, 1.431389, 33.777222),
   (83, 'KATAKWI', 'District', 14, 9, 3, 1.891111, 33.966111),
   (84, 'KAPELEBYONG', 'District', 14, 9, 3, 2.52922, 34.659753),
   (85, 'MOROTO', 'District', 15, 9, 3, 2.52922, 34.659753),
   (86, 'KOTIDO', 'District', 15, 9, 3, 2.980556, 34.133056),
   (87, 'NAKAPIRIPIRIT', 'District', 15, 9, 3, 1.916667, 34.783333),
   (88, 'ABIM', 'District', 18, 9, 3, 2.701667, 33.676111),
   (89, 'NAPAK', 'District', 15, 9, 3, 2.251391, 34.250124),
   (90, 'AMUDAT', 'District', 15, 9, 3, 1.95, 34.95),
   (91, 'AMURIA', 'District', 14, 9, 3, 2.003611, 33.651111),
   (92, 'KABONG', 'District', 15, 9, 3, 3.483611, 34.149167),
   (93, 'APAC', 'District', 13, 12, 5, 1.975556, 32.538611),
   (94, 'LIRA', 'District', 13, 12, 5, 2.235, 32.909722),
   (95, 'ALEBTONG', 'District', 13, 12, 5, 2.244722, 33.254722),
   (96, 'KITGUM', 'District', 12, 12, 5, 3.292284, 32.877828),
   (97, 'OTUKE', 'District', 13, 12, 5, 2.500375, 33.50065),
   (98, 'PADER', 'District', 12, 12, 5, 3.05, 33.216667),
   (99, 'AMURU', 'District', 12, 10, 5, 2.813879, 31.938684),
   (100, 'AGAGO', 'District', 12, 12, 5, 2.833825, 33.33361),
   (101, 'LAMWO', 'District', 12, 10, 5, 3.529719, 32.801604),
   (102, 'NWOYA', 'District', 12, 10, 5, 2.634225, 32.001065),
   (103, 'OYAM', 'District', 13, 10, 5, 2.235002, 32.38495),
   (104, 'KOLE', 'District', 5, 12, 5, 2.400151, 32.800343),
   (105, 'DOKOLO', 'District', 13, 12, 5, 1.898333, 33.1775),
   (106, 'KIRYANDONGO', 'District', 6, 3, 1, 1.876334, 32.062246),
   (107, 'NAMAYINGO', 'District', 1, 7, 2, 0.239833, 33.884908),
   (108, 'LWENGO', 'District', 3, 5, 2, -0.416111, 31.408056),
   (109, 'GULU', 'District', 12, 10, 5, 2.774569, 32.29899),
   (110, 'KIBUKU', 'District', 17, 8, 3, 1.043333, 33.7975),
   (111, 'PAKWACH', 'District', 11, 11, 5, 2.460932, 31.494934),
   (112, 'BUTEBO', 'District', 17, 8, 3, NULL, NULL),
   (113, 'KYOTERA', 'District', 3, 4, 2, NULL, NULL),
   (114, 'BUNYANGABU', 'District', 7, 3, 1, NULL, NULL),
   (115, 'NABILATUK', 'District', 15, 9, 3, NULL, NULL),
   (116, 'BUGWERI', 'District', 1, 7, 2, NULL, NULL),
   (117, 'RWAMPARA', 'District', 10, 2, 1, NULL, NULL),
   (118, 'BUDAKA', 'District', 17, 8, 3, NULL, NULL),
   (121, 'OMORO', 'District', 12, 10, 5, NULL, NULL),
   (122, 'NAMISINDWA', 'District', 16, 8, 3, NULL, NULL),
   (123, 'KASANDA', 'District', 4, 4, 2, NULL, NULL),
   (126, 'OBONGI', 'District', 11, 11, 5, NULL, NULL),
   (127, 'MADI-OKOLLO', 'District', 11, 11, 5, NULL, NULL),
   (128, 'KARENGA', 'District', 15, 9, 3, NULL, NULL),
   (129, 'LUSOT', 'District', 15, 9, 3, NULL, NULL),
   (130, 'KAKUMIRO', 'District', 6, 4, 2, NULL, NULL),
   (131, 'KAGADI', 'District', 6, 3, 1, NULL, NULL),
   (132, 'RUBANDA', 'District', 9, 2, 1, NULL, NULL),
   (133, 'RUKIGA', 'District', 9, 2, 1, NULL, NULL),
   (134, 'KITAGWENDA', 'District', 7, 2, 1, NULL, NULL),
   (135, 'MITOOMA', 'District', 10, 2, 1, NULL, NULL),
   (137, 'KIKUUBE', 'District', 6, 3, 1, NULL, NULL),
   (138, 'KALAKI', 'District', 13, 8, 3, NULL, NULL),
   (139, 'BUTAMBALA', 'District', 4, 5, 2, NULL, NULL),
   (140, 'KAZO', 'District', 10, 7, 2, NULL, NULL); "); 
//---------------Table 41 ----------- 
array_push($q,"INSERT INTO `ussdmenulanguage` (`id`, `language`, `language_text_table`, `forecast_table`, `daily`) VALUES
  (1, 'English', 'ussdmenu', 'seasonal_forecast', 'daily_forecast_data'),
  (4, 'Luganda', 'ussdmenuluganda', 'seasonal_forecast_luganda', 'daily_forecast_data_luganda'),
  (5, 'Lusoga', 'ussdmenulusoga', 'seasonal_forecast_lusoga', 'daily_forecast_data_lusoga'),
  (6, 'Rutoro', 'ussdmenurutoro', 'seasonal_forecast_rutoro', 'daily_forecast_data_rutoro'),
  (7, 'Japadhola', 'ussdmenujapadhola', 'seasonal_forecast_japadhola', 'daily_forecast_data_japadhola'),
  (9, 'Runyankole(Rukiga)', 'ussdmenurunyankolerukiga', 'seasonal_forecast_runyankolerukiga', 'daily_forecast_data_runyankolerukiga'),
  (10, 'Lusamia', 'ussdmenusamia', 'seasonal_forecast_samia', 'daily_forecast_data_samia'),
  (11, 'Kiswahili', 'ussdmenukiswahili', 'seasonal_forecast_kiswahili', 'daily_forecast_data_kiswahili'),
  (12, 'Lugbara', 'ussdmenulugbara', 'seasonal_forecast_lugbara', 'daily_forecast_data_lugbara'),
  (13, 'Lumasaba (Lugisu)', 'ussdmenulugisu', 'seasonal_forecast_lugisu', 'daily_forecast_data_lugisu'),
  (14, 'Acholi', 'ussdmenuacholi', 'seasonal_forecast_acholi', 'daily_forecast_data_acholi');");



//---------------Table 42 ----------- 
array_push($q,"CREATE TABLE `seasonal_terminology` (
  `id` int(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `terminology` varchar(34) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


//---------------Table 43 ----------- 
array_push($q,"CREATE TABLE `contacts` (
  `contact_id` int(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `contact_group_id` int(5) NOT NULL DEFAULT '0',
  `contact_name` varchar(250) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `contact_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contact_status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 44 ----------- 
array_push($q,"CREATE TABLE `weather_impacts` (
  `ps` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `weather_type` varchar(23) NOT NULL,
  `impact` text NOT NULL,
  `state` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 45 ----------- 
array_push($q,"CREATE TABLE `weather_category` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL,
  `img` varchar(50) NOT NULL,
  `widget` varchar(100) NOT NULL,
  `svg_data` varchar(1000) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
//---------------Table 46 SVG NOT ADDED-----------
array_push($q,"INSERT INTO `weather_category` (`id`, `cat_name`, `img`, `widget`) VALUES
  (1, 'heavy rain', 'img/rain.PNG', 'heavyrain'),
  (2, 'light thunder showers', 'img/thunderstorm.PNG', 'thundershowers'),
  (3, 'sunny intervals', 'img/sunny.PNG', 'partlysunny'),
  (4, 'showers', 'img/showers.ico', 'rainy'),
  (5, 'sunny', 'img/image1s0.jpg', 'sunny'),
  (6, 'cloudy', 'img/img-thing.jpg', 'cloudy'),
  (7, 'flood', 'img/floudimages.jpg', 'flood'),
  (8, 'light rain', 'img/H.PNG', 'lightrain'),
  (9, 'heavy thunder', 'img/lightthunder.ico', 'thunder'),
  (10, 'isolated showers', 'img/isolated_showers.ico', 'lightrain'),
  (11, 'isolated rain', 'img/showers.ico', 'lightrain'),
  (12, 'light isolated showers', 'img/showers.ico', 'lightrain'),
  (13, 'partly cloudy', 'img/partlyCloudy.png', 'partlysunny');");

//---------------Table 47 -----------

array_push($q,"CREATE TABLE IF NOT EXISTS `contacts` (
  `contact_id` int(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `contact_group_id` int(5) NOT NULL DEFAULT '0',
  `contact_name` varchar(250) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `contact_email` varchar(50) DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `contact_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contact_status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 48 -----------
array_push($q,"CREATE TABLE IF NOT EXISTS `seasonal_forecast` (
  `id` bigint(10) NOT NULL,
  `overview` text,
  `year` int(4) NOT NULL,
  `general_forecast` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `issuetime` date NOT NULL,
  `season_id` int(11) NOT NULL,
  `map` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 49 -----------
array_push($q,"CREATE TABLE IF NOT EXISTS `weather_impacts` (
  `ps` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `weather_type` varchar(23) NOT NULL,
  `impact` text NOT NULL,
  `state` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
//---------------Table 50 -----------
array_push($q,"CREATE TABLE `season` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `season_name` varchar(45) NOT NULL,
  `month_from` varchar(45) NOT NULL,
  `month_to` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
//---------------Table 51 -----------
array_push($q,"INSERT INTO `season` (`id`, `season_name`, `month_from`, `month_to`) VALUES
  (1, 'MAM', 'March', 'May');");

//---------------Table 52 -----------
array_push($q,"CREATE TABLE `user_feedback` (
  `id` int(20) NOT NULL,
  `city_id` int(10) NOT NULL,
  `sector` text NOT NULL,
  `accuracy` int(2) NOT NULL,
  `applicability` int(2) NOT NULL,
  `timeliness` int(2) NOT NULL,
  `generalComment` text NOT NULL,
  `contact` text NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 53 -----------
array_push($q,"CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `ip_address` varchar(15) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `usertype` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `first_time_login` bit(1) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

//---------------Table 54 -----------
array_push($q, "INSERT INTO `users` (`username`, `usertype`,`password`,  `email`,`active`) VALUES ( 'admin','".$u."', '".$enc_password."', '".$email."','1')");
//---------------Table 55 -----------
array_push($q,"CREATE TABLE `minor_sector` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `minor_name` varchar(45) NOT NULL,
  `major_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1");

//---------------Table 56 -----------
array_push($q,"
  INSERT INTO `minor_sector` (`id`, `minor_name`, `major_id`) VALUES
(1, 'Animal husbandry ', 1),
(2, 'Harvesting', 1),
(3, 'Planting', 1),
(4, 'Water', 4),
(6, 'Health', 2),
(7, 'Crop', 1),
(8, 'Livestock ', 1),
(9, 'Fisheries', 1),
(10, 'Bee farming', 1),
(11, 'Disaster Management', 6),
(12, 'Weather', 5),
(13, 'Infrastructure, works & transport', 5),
(14, 'Eby\'obulimi bw\'emmere', 8),
(15, 'Eby\'amazzi', 10),
(16, 'Eby\'obulamu', 11),
(17, 'Ebigwa bitalaze ', 9),
(18, 'Eby\'obulimi n\'ebyokulya', 12),
(19, 'Eyekujunanizibwa okufushya ebigwererezi', 13),
(20, 'Ey\'ebyamaizi', 14),
(21, 'Ey\'eby\'obwomeezi', 15),
(22, 'Esitongole sye bikwawo nibitalakire', 16),
(23, 'Obulamu', 17),
(24, 'Amachi', 18),
(25, 'Ekitongole ky\'emirimu ne\'nguudo', 19),
(26, 'Ebyobuhingi', 20),
(27, 'Eby\'amagara', 21),
(28, 'Ebigema kubyokulima n\'okwelinda endhala', 22),
(29, 'Kubyobulamu', 23),
(30, 'Ebigema kuntambula n\'enguudu', 24),
(31, 'Mako peko ma ngole atura', 25),
(32, 'Mako gedo ', 26),
(33, 'Pi Yotkom', 27),
(34, 'Idog tic me Pur ki Gwoko dero cam', 2),
(35, 'Yii Dria', 30),
(36, 'Ocoko ma Azakozu', 29),
(37, 'Alata Dria', 31),
(38, 'Ega Nyaka Ezozu Azini Nyaka Tambazu Ri', 32),
(39, 'Busiku butundubikhe', 33),
(40, 'Bye kameetsi', 34),
(41, 'Bye bubwombekhi, tsingudo ni ingenda', 35),
(42, 'Bye bulamu', 36),
(43, 'Bye bulimi ni khuuba ni biilyo bibiiyikinikha', 37),
(44, 'Eby\'amatungo', 38);
  ");

//---------------Table 57 -----------
array_push($q,"CREATE TABLE `possible_advisories` (
  `pos` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `cat` text NOT NULL,
  `advise` text NOT NULL,
  `state` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
//---------------Table 58 -----------
array_push($q,"INSERT INTO `possible_advisories` (`pos`, `cat`, `advise`, `state`) VALUES
  (1, '1', 'Use irregular light rains for early land preparation and securing inputs like seed, fertilizer, chemicals.', 'normal'),
  (2, '1', 'Timely planting of improved varieties such as Beans (NABE 15-23 series), maize (Longe 5, 7H, 10H-11H).', 'normal'),
  (3, '4', 'Establishment of water harvesting structures at household and communal level.', 'above'),
  (4, '3', 'Soil and water conservation practices e.g. trenches, grass bunds, mulching to enhance soil moisture retention and control erosion.', 'above'),
  (5, '1', 'Enhance good agronomic practices (proper spacing, fertilizer use, weeding).', 'above');");

//---------------Table 59 -----------
array_push($q,"CREATE TABLE `possible_impacts` (
  `id` int(7) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `impact` text NOT NULL,
  `state` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 60 -----------
array_push($q,"CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `days_of_the_week` varchar(10) NOT NULL,
  `d01` double NOT NULL,
  `d02` double NOT NULL,
  `d03` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 61 -----------
array_push($q,"
  INSERT INTO `data` (`id`, `days_of_the_week`, `d01`, `d02`, `d03`) VALUES
  (1, 'Monday', 9.91858, 1.60976, 3.32214),
  (2, 'Tuesday', 5.22581, 0, 5.75889),
  (3, 'Wednesday', 10.36767, 3.99439, 13.58074),
  (4, 'Thursday', 18.40449, 0.29202, 12.50758),
  (5, 'Friday', 21.72388, 0.19852, 14.06225),
  (6, 'Monday', 26.56933, 4.53594, 18.40455),
  (7, 'Tuesday', 12.69532, 0.611, 8.64607),
  (8, 'Wednesday', 3.24182, 0.79654, 3.90178),
  (9, 'Thursday', 12.36614, 0, 0.66021),
  (10, 'Friday', 11.67441, 0, 9.31397);
  ");
//---------------Table 62 -----------
array_push($q,"CREATE TABLE `dekadal_advisory` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sector` int(5) NOT NULL,
  `forecast_id` int(11) NOT NULL,
  `advice` text NOT NULL,
  `message_summary` text,
  `TS` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


//---------------Table 63 -----------
array_push($q,"CREATE TABLE `victoria_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 64 -----------
array_push($q,"INSERT INTO `victoria_area` (`id`, `name`) VALUES
  (1, 'Entebbe and Northwest'),
  (2, 'Kyotera and Southwest'),
  (3, 'Buvuma and Northeast'),
  (4, 'Migingo and Southeast');");

//---------------Table 65 -----------
array_push($q,"CREATE TABLE `wind_strength` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 66 -----------
array_push($q,"INSERT INTO `wind_strength` (`id`, `name`, `image_name`) VALUES
  (1, 'Light', 'wind_strength_light.png'),
  (2, 'Moderate', 'wind_strength_moderate.png');");

//---------------Table 67 -----------
array_push($q,"CREATE TABLE `wind_direction` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 68 -----------
array_push($q,"INSERT INTO `wind_direction` (`id`, `name`, `image_name`) VALUES
  (1, 'South', 'wind_direction_south.png'),
  (2, 'South East', 'wind_direction_southeast.png'),
  (3, 'South West', 'wind_direction_southwest.png'),
  (4, 'Variable', 'wind_direction_variable.png'),
  (5, 'West', 'wind_direction_west.PNG'),
  (6, 'North West', 'wind_direction_northwest.PNG'),
  (7, 'North', 'wind_direction_north.PNG'),
  (8, 'North East', 'wind_direction_northeast.PNG'),
  (9, 'East', 'wind_direction_east.PNG');");

//---------------Table 69 -----------
array_push($q,"CREATE TABLE `weather_cond` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 70 -----------
array_push($q,"INSERT INTO `weather_cond` (`id`, `name`, `image_name`) VALUES
  (1, 'Light Rain', 'weather_light_rain.png'),
  (2, 'Clear Skies', 'weather_clear_skies.png'),
  (3, 'Showers', 'weather_showers.PNG'),
  (4, 'Moderate Rain', 'weather_moderate_rain.png'),
  (5, 'Partly Cloudy', 'weather_partly_cloudy.png'),
  (6, 'Sunny Intervals', 'weather_sunny_intervals.png'),
  (7, 'Isolated Thunderstorms', 'weather_isolated_thunder_showers.png'),
  (8, 'Thunderstorms', 'weather_thunderstorms.PNG'),
  (9, 'Cloudy', 'weather_cloudy.PNG'),
  (10, 'Thunder Rain', 'weather_thunderrain.PNG'),
  (11, 'Isolated Light Rain', 'weather_isolatedlightrain.PNG'),
  (12, 'Widespread thunder rain', 'weather_widespreadthunderrain.PNG'),
  (13, 'Isolated thunder rain', 'weather_isolatedthunderrain.PNG'),
  (14, 'Isolated rain', 'weather_isolatedrain.PNG');");

//---------------Table 71 -----------
array_push($q,"CREATE TABLE `wave_height` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(30) NOT NULL,
  `image_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 72 -----------
array_push($q,"INSERT INTO `wave_height` (`id`, `name`, `image_name`) VALUES
  (1, 'Small', 'wave_height_small.png'),
  (2, 'Moderate', 'wave_height_moderate.png');");

//---------------Table 73 -----------
array_push($q,"CREATE TABLE `rainfall_dist` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(50) NOT NULL,
  `image_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 74 -----------
array_push($q,"INSERT INTO `rainfall_dist` (`id`, `name`, `image_name`) VALUES
  (1, 'Few', 'rainfall_dist_few.png'),
  (2, 'Many', 'rainfall_dist_many.png');");


//---------------Table 75 -----------
array_push($q,"CREATE TABLE `visibility` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


//---------------Table 76 -----------
array_push($q,"INSERT INTO `visibility` (`id`, `name`, `image_name`) VALUES
  (1, 'Good', 'visibility_good.png'),
  (2, 'Moderate', 'visibility_moderate.png');");

//---------------Table 77 -----------
array_push($q,"CREATE TABLE `victoria_periods` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 78 -----------
array_push($q,"INSERT INTO `victoria_periods` (`id`, `name`) VALUES
  (1, 'Morning'),
  (2, 'Afternoon'),
  (3, 'Night before midnight'),
  (4, 'Night after midnight');");
//---------------Table 79 -----------
array_push($q,"CREATE TABLE `victoria_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `language_id` int(11) DEFAULT NULL,
  `forecast_date` varchar(30) NOT NULL,
  `issue_date` varchar(30) NOT NULL,
  `map` varchar(255) NOT NULL,
  `advice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 81 -----------
array_push($q,"CREATE TABLE `victoria_districts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` text NOT NULL,
  `zone_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 82 -----------
array_push($q,"INSERT INTO `victoria_districts` (`id`, `name`, `zone_id`) VALUES
  (1, 'WAKISO', 1),
  (2, 'KAMPALA', 1),
  (3, 'MPIGI', 1),
  (4, 'KALUNGU', 1),
  (5, 'KALANGALA-NORTH', 1),
  (6, 'MASAKA', 1),
  (7, 'KYOTERA', 2),
  (8, 'KALANGALA-SOUTH', 2),
  (9, 'BUIKWE', 3),
  (10, 'JINJA', 3),
  (11, 'BUVUMA', 3),
  (12, 'BUSIA', 3),
  (13, 'BUGIRI', 3),
  (14, 'MAYUGE', 3),
  (15, 'NAMAYINGO', 3),
  (16, 'MIGINGO', 4);");


//---------------Table 83 -----------
array_push($q,"CREATE TABLE `ussdtransaction_new` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `phone` varchar(100) NOT NULL,
  `sessionId` varchar(100) NOT NULL,
  `menuvariable` varchar(255) DEFAULT NULL,
  `menuvalue` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `districtId` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


//---------------Table 84 -----------
array_push($q,"CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 85 -----------
array_push($q,"CREATE TABLE `sub_category` (
  `subcategory_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `subcategory_name` varchar(100) DEFAULT NULL,
  `subcategory_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 86 -----------
array_push($q,"
CREATE TABLE `monthly_advisories` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `sector_id` int(11) NOT NULL,
  `forecast_id` int(11) NOT NULL,
  `message_summary` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 87 -----------
array_push($q,"
CREATE TABLE `monthly_forecast` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `month_from` varchar(40) NOT NULL,
  `month_to` varchar(40) NOT NULL,
  `issue_date` date NOT NULL,
  `year` int(4) NOT NULL,
  `summary` text NOT NULL,
  `introduction` text NOT NULL,
  `weather_outlook` text NOT NULL,
  `forecast_map` varchar(400) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 88 -----------
array_push($q,"
CREATE TABLE `monthly_impacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `forecast_id` int(11) NOT NULL,
  `impact` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
");

//---------------Table 89 -----------
array_push($q,"
CREATE TABLE `pageview` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `page` text NOT NULL,
  `userip` text NOT NULL,
  `date_visited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `country` varchar(300) DEFAULT NULL,
  `region` varchar(300) DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
");
//---------------Table 90 -----------
array_push($q,"CREATE TABLE `totalview` (
   `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `totalvisit` bigint(20) NOT NULL DEFAULT '0',
  `page` varchar(300) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

//---------------Table 91 -----------
array_push($q,"CREATE TABLE `ussdmenu` (
  `menuname` varchar(200) DEFAULT NULL,
  `menuid` int(11) NOT NULL,
  `menudescription` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//---------------Table 91 -----------
array_push($q,"INSERT INTO `ussdmenu` (`menuname`, `menuid`, `menudescription`) VALUES
('Submission-opt', 7, 'Confirm Submission'),
('End', 8, 'You will receive a message shortly-Thank you for Contacting Us.'),
('Cancel', 9, 'Request Canceled'),
('district', 13, 'Please Enter Your District-Or Landing Site'),
('invaliddistrict', 14, 'District Unknown\r\n'),
('invalidinput', 15, 'Unknown Input Option-0. back'),
('back', 16, 'back'),
('response_format', 17, 'Please Choose a Response format-1. Text Message-2. Audio-0. Back'),
('no_data', 18, 'Sorry, the selected forecast data is currently unavailable.-Please try again later-0. Enter district'),
('sector', 19, 'Without advisory'),
('voicecall', 20, 'You will receive a call shortly-Thank you for Contacting Us.'),
('daily', 21, 'Daily Forecast'),
('seasonal', 22, 'Seasonal Forecast'),
('dekadal', 23, 'Ten Days Forecast'),
('prod', 24, 'Select a product'),
('wind', 25, 'Wind Strength'),
('temp', 26, 'Temperature'),
('sum', 27, 'Summary'),
('wet', 28, 'Weather'),
('advise', 29, 'Advisory for'),
('early', 30, 'Early'),
('mid', 31, 'Mid'),
('start', 32, 'The rains shall start in'),
('late', 33, 'Late'),
('peak', 34, 'peak will be in'),
('ends', 35, 'and end in'),
('sects', 36, 'Select a Sector'),
('feedbackdisp', 37, 'How can we best improve on our forecasts or services?-0. Back'),
('feedbackrep', 38, 'Feedback recieved. Thank you for supporting us'),
('feedback', 39, 'Give feedback'),
('landing_site', 40, 'Please Enter Landing Site'),
('site', 41, 'Enter Landing Site'),
('landing_site', 42, 'Marine Forecast-Select a period'),
('subscription', 43, 'Select a Forecast to Subscribe to-1. Daily Forecast-2. Seasonal Forecast'),
('subscribe', 44, 'Subscribe'),
('period', 45, 'Choose period to recieve-1. Daily-2. Weekly-3. Monthly-0. back'),
('complete_subscription', 46, 'You have successfully Subscribed for weather updates, Thank you'),
('complete_unsubscription', 47, 'You have Unsubscribed from all weather updates, Thank you'),
('unsubscribe', 48, 'Unsubscribe'),
('repeat', 49, 'You want '),
('in', 50, 'in'),
('for', 51, 'for'),
('yes', 52, 'Yes'),
('no', 53, 'No');");

array_push($q,"CREATE TABLE `ussd_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `session_id` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `forecast` int(11) NOT NULL,
  `district` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

array_push($q,"CREATE TABLE `ussd_subscriptions_messages` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `district` varchar(50) NOT NULL,
  `forecast` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

//PERFORM ALL MIGRATIONS HERE
for($i=0;$i<94;$i++){   
  $db =  mysqli_query($link ,$q[$i]);
  if(!$db){
    echo mysqli_error($link);
    echo "Query is ".$q[$i];

  }
  }//for
}


   //for logging in
public function load_login() {
   $data['remember_me'] = $this->lang->line('msg_remember_me');
   $data['login'] = $this->lang->line('msg_login');
   $data['forgot_passwords'] = $this->lang->line('msg_forgot_passwords');

   $this->load->view('auth/login', $data);
}

    // log the user in
public function login() {
   $this->form_validation->set_rules('identity', 'Email', 'required');
   $this->form_validation->set_rules('password', 'Password', 'required');
   $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
     //  echo $_POST['submit_login']; exit();
   if ($this->form_validation->run()== FALSE) {
      
      $this->load_login();
   } else {
      $dat[1] = $_POST['identity'];
      $dat[2] = md5($_POST['password']);

      $sql = $this->ion_auth->login1($dat);

      foreach ($sql->result_array() as $row)
      {           
         $username = $row['phone'];
         $email = $row['email'];
         $first_name = $row['first_name'];
         $last_name = $row['last_name'];
         $usertype = $row['usertype'];
         $first_time_login = $row['first_time_login'];
         $username = $row['username']; 
         $pic = $row['pic'];
         $active = $row['active'];        
      }
      if ($username && $active == 1) {

         $_SESSION['user_logged']=TRUE;
         $_SESSION['username']= $username;
         $_SESSION['usertype']= $usertype;
         $_SESSION['phone'] = $row['phone'];
         $_SESSION['email'] = $row['email'];
         $_SESSION['first_name'] = $row['first_name'];
         $_SESSION['last_name']  = $row['last_name'];
         $_SESSION['first_time_login']=  $first_time_login;       
         $_SESSION['pic']= $pic;
         $data['change'] = 0;
         redirect('index.php/landing/index');

      }elseif(!$username){
         $this->session->set_flashdata("error","<div class = 'alert alert-danger'> Incorrect login Credentials ... Consider checking your Email or Password</div>");
         $this->load_login();

      } elseif($username && !$active == 1){
         $this->session->set_flashdata("error","<div class = 'alert alert-danger'> You can not login in ... this account is not active</div>");
         $this->load_login();



      }
   }


}

    // log the user out
public function logout() {
   $this->data['title'] = "Logout";
        // log the user out
   $logout = $this->ion_auth->logout();
   // redirect them to the login page
   $this->session->set_flashdata('message', $this->ion_auth->messages());
   redirect('index.php/auth/login', 'refresh');
}

public function _rules()
{
   $this->form_validation->set_rules('old_password', 'Old Password', 'required');
   $this->form_validation->set_rules('new_password', 'New Password', 'required');
   $this->form_validation->set_rules('new_password_conf', 'Password Confirmation', 'required|matches[new_password]');
   $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
}

public function minano(){

   $this->_rules();
   $username = '';
   if ($this->form_validation->run() == FALSE) {
      $this->load->view('auth/new_password');
   }else{

      $data = array(
         'username' => $_SESSION['username'],
         'usertype' =>  $_SESSION['usertype'],
         'pic'      => $_SESSION['pic'],
         'change'   => 0,
      );

      $username =  $_SESSION['username'];
      $password=$this->Landing_model->get_old_password($username);
      $entered_old_password=md5($this->input->post('old_password'));
      $new_password=md5($this->input->post('new_password'));
      if($password->password==$entered_old_password){
         $this->Landing_model->update_old_password($username,$new_password);
         redirect('index.php/auth/login', 'refresh');
      }
   }
}



public function change_pass(){
   $data = array(
      'change' => 34,
   );
   $this->load->view('template',$data);
}

    // change password
public function change_password() {
   $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
   $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
   $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

   if (!$this->ion_auth->logged_in()) {
      redirect('index.php/auth/login', 'refresh');
   }

   $user = $this->ion_auth->user()->row();
   if ($this->form_validation->run() == false) {
            // display the form
            // set the flash data error message if there is one
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
      $this->data['old_password'] = array(
         'name' => 'old',
         'id' => 'old',
         'type' => 'password',
      );
      $this->data['new_password'] = array(
         'name' => 'new',
         'id' => 'new',
         'type' => 'password',
         'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
      );
      $this->data['new_password_confirm'] = array(
         'name' => 'new_confirm',
         'id' => 'new_confirm',
         'type' => 'password',
         'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
      );
      $this->data['user_id'] = array(
         'name' => 'user_id',
         'id' => 'user_id',
         'type' => 'hidden',
         'value' => $user->id,
      );


            // render
      $this->template->load_auth('auth/change_password', $this->data);
   } else {
      $identity = $this->session->userdata('identity');

      $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

      if ($change) {
                //if the password was successfully changed
         $this->session->set_flashdata('message', $this->ion_auth->messages());
         $this->logout();
      } else {
         $this->session->set_flashdata('message', $this->ion_auth->errors());
         redirect('auth/change_password', 'refresh');
      }
   }
}

    // forgot password
public function forgot_password() {
        // setting validation rules by checking whether identity is username or email
   if ($this->config->item('identity', 'ion_auth') != 'email') {
      $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
   } else {
      $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
   }

   if ($this->form_validation->run() == false) {
      $this->data['type'] = $this->config->item('identity', 'ion_auth');
            // setup the input
      $this->data['identity'] = array('name' => 'identity',
         'id' => 'identity',
      );

      if ($this->config->item('identity', 'ion_auth') != 'email') {
         $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
      } else {
         $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
      }

            // set any errors and display the form
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->template->load_auth('auth/forgot_password', $this->data);
   } else {
      $identity_column = $this->config->item('identity', 'ion_auth');
      $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

      if (empty($identity)) {

         if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->ion_auth->set_error('forgot_password_identity_not_found');
         } else {
            $this->ion_auth->set_error('forgot_password_email_not_found');
         }

         $this->session->set_flashdata('message', $this->ion_auth->errors());
         redirect("auth/forgot_password", 'refresh');
      }

            // run the forgotten password method to email an activation code to the user
      $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

      if ($forgotten) {
                // if there were no errors
         $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
             } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
             }
          }
       }

    // reset password - final step for forgotten password
       public function reset_password($code = NULL) {
        if (!$code) {
         show_404();
      }

      $user = $this->ion_auth->forgotten_password_check($code);

      if ($user) {
            // if the code is valid then display the password reset form

         $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
         $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

         if ($this->form_validation->run() == false) {
                // display the form
                // set the flash data error message if there is one
          $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

          $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
          $this->data['new_password'] = array(
           'name' => 'new',
           'id' => 'new',
           'type' => 'password',
           'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
        );
          $this->data['new_password_confirm'] = array(
           'name' => 'new_confirm',
           'id' => 'new_confirm',
           'type' => 'password',
           'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
        );
          $this->data['user_id'] = array(
           'name' => 'user_id',
           'id' => 'user_id',
           'type' => 'hidden',
           'value' => $user->id,
        );
          $this->data['csrf'] = $this->_get_csrf_nonce();
          $this->data['code'] = $code;

                // render
          $this->template->load_auth('auth/reset_password', $this->data);
       } else {
                // do we have a valid request?
          if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
           $this->ion_auth->clear_forgotten_password_code($code);

           show_error($this->lang->line('error_csrf'));
        } else {
                    // finally change the password
           $identity = $user->{$this->config->item('identity', 'ion_auth')};

           $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

           if ($change) {
                        // if the password was successfully changed
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth/login", 'refresh');
         } else {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect('auth/reset_password/' . $code, 'refresh');
         }
      }
   }
} else {
            // if the code is invalid then send them back to the forgot password page
   $this->session->set_flashdata('message', $this->ion_auth->errors());
   redirect("auth/forgot_password", 'refresh');
}
}

    // activate the user
public function activate($id, $code = false) {
  if ($code !== false) {
   $activation = $this->ion_auth->activate($id, $code);
} else if ($this->ion_auth->is_admin()) {
   $activation = $this->ion_auth->activate($id);
}

if ($activation) {
            // redirect them to the auth page
   $this->session->set_flashdata('message', $this->ion_auth->messages());
   redirect("auth", 'refresh');
} else {
            // redirect them to the forgot password page
   $this->session->set_flashdata('message', $this->ion_auth->errors());
   redirect("auth/forgot_password", 'refresh');
}
}

    // deactivate the user
public function deactivate($id = NULL) {
  if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            // redirect them to the home page because they must be an administrator to view this
   return show_error('You must be an administrator to view this page.');
}

$id = (int) $id;

$this->load->library('form_validation');
$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

if ($this->form_validation->run() == FALSE) {
            // insert csrf check
   $this->data['csrf'] = $this->_get_csrf_nonce();
   $this->data['user'] = $this->ion_auth->user($id)->row();

   $this->template->load_auth('auth/deactivate_user', $this->data);
} else {
            // do we really want to deactivate?
   if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
    if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
     show_error($this->lang->line('error_csrf'));
  }

                // do we have the right userlevel?
  if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
     $this->ion_auth->deactivate($id);
  }
}

            // redirect them back to the auth page
redirect('auth', 'refresh');
}
}

    // create a new user
public function create_user() {
  $this->data['title'] = $this->lang->line('create_user_heading');

  if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
   redirect('auth', 'refresh');
}

$tables = $this->config->item('tables', 'ion_auth');
$identity_column = $this->config->item('identity', 'ion_auth');
$this->data['identity_column'] = $identity_column;

        // validate form input
$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
if ($identity_column !== 'email') {
   $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
   $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
} else {
   $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
}
$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

if ($this->form_validation->run() == true) {
   $email = strtolower($this->input->post('email'));
   $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
   $password = $this->input->post('password');

   $additional_data = array(
    'first_name' => $this->input->post('first_name'),
    'last_name' => $this->input->post('last_name'),
    'company' => $this->input->post('company'),
    'phone' => $this->input->post('phone'),
 );
}
if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)) {
            // check to see if we are creating the user
            // redirect them back to the admin page
   $this->session->set_flashdata('message', $this->ion_auth->messages());
   redirect("auth", 'refresh');
} else {
            // display the create user form
            // set the flash data error message if there is one
   $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

   $this->data['first_name'] = array(
    'name' => 'first_name',
    'id' => 'first_name',
    'type' => 'text',
    'value' => $this->form_validation->set_value('first_name'),
 );
   $this->data['last_name'] = array(
    'name' => 'last_name',
    'id' => 'last_name',
    'type' => 'text',
    'value' => $this->form_validation->set_value('last_name'),
 );
   $this->data['identity'] = array(
    'name' => 'identity',
    'id' => 'identity',
    'type' => 'text',
    'value' => $this->form_validation->set_value('identity'),
 );
   $this->data['email'] = array(
    'name' => 'email',
    'id' => 'email',
    'type' => 'text',
    'value' => $this->form_validation->set_value('email'),
 );
   $this->data['company'] = array(
    'name' => 'company',
    'id' => 'company',
    'type' => 'text',
    'value' => $this->form_validation->set_value('company'),
 );
   $this->data['phone'] = array(
    'name' => 'phone',
    'id' => 'phone',
    'type' => 'text',
    'value' => $this->form_validation->set_value('phone'),
 );
   $this->data['password'] = array(
    'name' => 'password',
    'id' => 'password',
    'type' => 'password',
    'value' => $this->form_validation->set_value('password'),
 );
   $this->data['password_confirm'] = array(
    'name' => 'password_confirm',
    'id' => 'password_confirm',
    'type' => 'password',
    'value' => $this->form_validation->set_value('password_confirm'),
 );

   $this->template->load_auth('auth/create_user', $this->data);
}
}

    // edit a user
public function edit_user($id) {
  $this->data['title'] = $this->lang->line('edit_user_heading');

  if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
   redirect('auth', 'refresh');
}

$user = $this->ion_auth->user($id)->row();
$groups = $this->ion_auth->groups()->result_array();
$currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
   if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
    show_error($this->lang->line('error_csrf'));
 }

            // update the password if it was posted
 if ($this->input->post('password')) {
    $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
    $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
 }

 if ($this->form_validation->run() === TRUE) {
    $data = array(
     'first_name' => $this->input->post('first_name'),
     'last_name' => $this->input->post('last_name'),
     'company' => $this->input->post('company'),
     'phone' => $this->input->post('phone'),
  );

                // update the password if it was posted
    if ($this->input->post('password')) {
     $data['password'] = $this->input->post('password');
  }



                // Only allow updating groups if user is admin
  if ($this->ion_auth->is_admin()) {
                    //Update the groups user belongs to
     $groupData = $this->input->post('groups');

     if (isset($groupData) && !empty($groupData)) {

      $this->ion_auth->remove_from_group('', $id);

      foreach ($groupData as $grp) {
       $this->ion_auth->add_to_group($grp, $id);
    }
 }
}

                // check to see if we are updating the user
if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
  $this->session->set_flashdata('message', $this->ion_auth->messages());
  if ($this->ion_auth->is_admin()) {
   redirect('auth', 'refresh');
} else {
                        ////redirect('/', 'refresh');
}
} else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
  $this->session->set_flashdata('message', $this->ion_auth->errors());
  if ($this->ion_auth->is_admin()) {
   redirect('auth', 'refresh');
} else {
                        ////redirect('/', 'refresh');
}
}
}
}

        // display the edit user form
$this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
$this->data['user'] = $user;
$this->data['groups'] = $groups;
$this->data['currentGroups'] = $currentGroups;

$this->data['first_name'] = array(
   'name' => 'first_name',
   'id' => 'first_name',
   'type' => 'text',
   'value' => $this->form_validation->set_value('first_name', $user->first_name),
);
$this->data['last_name'] = array(
   'name' => 'last_name',
   'id' => 'last_name',
   'type' => 'text',
   'value' => $this->form_validation->set_value('last_name', $user->last_name),
);
$this->data['company'] = array(
   'name' => 'company',
   'id' => 'company',
   'type' => 'text',
   'value' => $this->form_validation->set_value('company', $user->company),
);
$this->data['phone'] = array(
   'name' => 'phone',
   'id' => 'phone',
   'type' => 'text',
   'value' => $this->form_validation->set_value('phone', $user->phone),
);
$this->data['password'] = array(
   'name' => 'password',
   'id' => 'password',
   'type' => 'password'
);
$this->data['password_confirm'] = array(
   'name' => 'password_confirm',
   'id' => 'password_confirm',
   'type' => 'password'
);

$this->template->load_auth('auth/edit_user', $this->data);
}

    // create a new group
public function create_group() {
  $this->data['title'] = $this->lang->line('create_group_title');

  if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
   redirect('auth', 'refresh');
}

        // validate form input
$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

if ($this->form_validation->run() == TRUE) {
   $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
   if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
    $this->session->set_flashdata('message', $this->ion_auth->messages());
    redirect("auth", 'refresh');
 }
} else {
            // display the create group form
            // set the flash data error message if there is one
   $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

   $this->data['group_name'] = array(
    'name' => 'group_name',
    'id' => 'group_name',
    'type' => 'text',
    'value' => $this->form_validation->set_value('group_name'),
 );
   $this->data['description'] = array(
    'name' => 'description',
    'id' => 'description',
    'type' => 'text',
    'value' => $this->form_validation->set_value('description'),
 );

   $this->template->load_auth('auth/create_group', $this->data);
}
}

    // edit a group
public function edit_group($id) {
        // bail if no group id given
  if (!$id || empty($id)) {
   redirect('auth', 'refresh');
}

$this->data['title'] = $this->lang->line('edit_group_title');

if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
   redirect('auth', 'refresh');
}

$group = $this->ion_auth->group($id)->row();

        // validate form input
$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

if (isset($_POST) && !empty($_POST)) {
   if ($this->form_validation->run() === TRUE) {
    $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

    if ($group_update) {
     $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
  } else {
     $this->session->set_flashdata('message', $this->ion_auth->errors());
  }
  redirect("auth", 'refresh');
}
}

        // set the flash data error message if there is one
$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
$this->data['group'] = $group;

$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

$this->data['group_name'] = array(
   'name' => 'group_name',
   'id' => 'group_name',
   'type' => 'text',
   'value' => $this->form_validation->set_value('group_name', $group->name),
   $readonly => $readonly,
);
$this->data['group_description'] = array(
   'name' => 'group_description',
   'id' => 'group_description',
   'type' => 'text',
   'value' => $this->form_validation->set_value('group_description', $group->description),
);

$this->template->load_auth('auth/edit_group', $this->data);
}


   //function 
public function _get_csrf_nonce() {
  $this->load->helper('string');
  $key = random_string('alnum', 8);
  $value = random_string('alnum', 20);
  $this->session->set_flashdata('csrfkey', $key);
  $this->session->set_flashdata('csrfvalue', $value);

  return array($key => $value);
}

public function _valid_csrf_nonce() {
  if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
   $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
   return TRUE;
} else {
  return FALSE;
}
}


}
