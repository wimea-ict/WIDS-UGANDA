<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Season_model extends CI_Model
{

    public $table = 'seasonal_forecast';
    public $id = 'id';
    public $order = 'DESC';
	public $issuetime = 'issuetime';

    function __construct()
    {
        parent::__construct();
    }
        function no_data()
    {  
       $year = date('Y');
               $this->db->select('region.region_name, area_seasonal_forecast.region_id,seasonal_forecast.year');
        $this->db->distinct('region.region_name');
       $this->db->from('area_seasonal_forecast');
       $this->db->join('seasonal_forecast','seasonal_forecast.id = area_seasonal_forecast.forecast_id');
       $this->db->join('region','area_seasonal_forecast.region_id = region.id'); 
       $this->db->order_by('seasonal_forecast.year', $this->order);
       $this->db->where('seasonal_forecast.year', $year);  
       $query=$this->db->get();   
       return $query->result_array();
    
    } 

    public function check_seasonal($year, $season){
      $this->db->from('seasonal_forecast');
      $this->db->where('year',$year);
      $this->db->where('season_id',$season);
      if(($this->db->get()->row()) == null){
        return 1;
      }
      return 0;
    }

    function get_users($date_cut){
      $qry = "SELECT COUNT(DISTINCT phone) AS count_users FROM ussdtransaction_new WHERE ussdtransaction_new.date BETWEEN '$date_cut 00:00:01' and '$date_cut 23:59:59'";
      $query=$this->db->query($qry);
      return $query->result_array();
    }
    public  function get_abb($id)
    {   
      $this->db->select('abbreviation');
      $this->db->from('seasonal_forecast');
      $this->db->join('season_months','season_months.id = seasonal_forecast.season_id');
      $this->db->where('seasonal_forecast.id',$id);   
      return $this->db->get()->result_array();
  }

  public function get_clips()
    {   
      $this->db->select('voice.id, language, voice_name');
      $this->db->from('voice');
      $this->db->join('ussdmenulanguage','ussdmenulanguage.id = voice.language_id');
      $this->db->order_by('voice.id','DESC');
      // $this->db->join('season_months','season_months.id = seasonal_forecast.season_id');
      // $this->db->where('seasonal_forecast.id',$id);   
      return $this->db->get()->result_array();
  }
 
//get clip for the language session
  public function get_lang_clip($session_lang)
    {   
      $this->db->select('voice.id, language, voice_name');
      $this->db->from('voice');
      $this->db->join('ussdmenulanguage','ussdmenulanguage.id = voice.language_id');
      $this->db->where('ussdmenulanguage.id',$session_lang);
      // $this->db->join('season_months','season_months.id = seasonal_forecast.season_id');
      // $this->db->where('seasonal_forecast.id',$id);   
      return $this->db->get()->row('voice_name');
  }


   public function delete_clip($id)
    {   

       $this->db->from('voice');
       $this->db->join('ussdmenulanguage', 'ussdmenulanguage.id = voice.language_id');
        $this->db->where('voice.id', $id);
        $ret = $this->db->get()->row();
        $this->session->set_userdata('deleted',$ret->language);

      $this->db->where('id', $id);
      $this->db->delete('voice');
  }

  public function upload_audio($data=array()){
    $this->db->insert('voice',$data);  
  }

  public function check_audio($lang_id, $name){
    $this->db->from('voice');
    $this->db->where('language_id',$lang_id);
    $this->db->where('voice_name',$name);   
    return $this->db->get()->result_array();
  }


      //---------------------get language available--------------------------------
      function get_available_language()
    {   
       $this->db->select('language,id as language_id');
     $this->db->from('ussdmenulanguage');
     $query=$this->db->get();
   
       return $query->result_array();
  }
    //-----------------------------------------------------


    // get allgetdivisionname
    function get_all()
    {  
	   $this->db->select('season_months.season_name,seasonal_forecast.year,seasonal_forecast.overview,seasonal_forecast.general_forecast,seasonal_forecast.issuetime,season_months.abbreviation,seasonal_forecast.id');
	   $this->db->from('seasonal_forecast');
       $this->db->join('season_months','season_months.id=seasonal_forecast.season_id');  
       $this->db->order_by('seasonal_forecast.issuetime', $this->order);
	   
	   $query=$this->db->get();   
       return $query->result_array();
    
    }
    // New method for viewing the seasonal forecast data on the admin side
    function view_season_data($id)
    {  
        $this->db->select('seasonal_forecast.issuetime, seasonal_forecast.year,season_months.season_name, season_months.abbreviation, seasonal_forecast.overview, seasonal_forecast.general_forecast, ');
        $this->db->from('seasonal_forecast');
        $this->db->join('season_months','seasonal_forecast.season_id = season_months.id');
        $this->db->where('seasonal_forecast.id', $id);
       $query=$this->db->get();   
       return $query->result_array();
    
    }

    function get_update_data($forecast_id)
    {  
       $this->db->select('issuetime, overview,general_forecast');
       $this->db->from('seasonal_forecast');
       // $this->db->where('id', $forecast_id);
       
       $query=$this->db->get();   
       return $query->result_array();
    
    }

    function update_data($data, $id)
    {  
       $sql = "UPDATE seasonal_forecast SET overview = ?, general_forecast = ? WHERE id = $id";
       return $this->db->query($sql, $data);
    
    }
	
	function get_current_season(){
	   	
	  $this->db->select('season.season_name,seasonal_forecast.id as id'); 
	   $this->db->from('season');
	   $this->db->join('seasonal_forecast','seasonal_forecast.season_id=season.id');
	    $this->db->order_by('seasonal_forecast.issuetime', $this->order);	   
	   $this->db->limit(1);
	   $query = $this->db->get();
	   
	   if($query->num_rows()>0) {	 
		 $data = $query->row_array();		 
		 $value = $data['id'];		 
		 return $value;
		 
	 }
	}
	
	function get_recent_forecast($region,$forecast_id){
	   $this->db->select('area_seasonal_forecast.region_id,area_seasonal_forecast.subregion_id,area_seasonal_forecast.expected_peak, area_seasonal_forecast.peakdesc, area_seasonal_forecast.onset_period,area_seasonal_forecast.onsetdesc,area_seasonal_forecast.end_period,area_seasonal_forecast.enddesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info');
	   $this->db->from('area_seasonal_forecast');  
	   $this->db->join('region','region.id=area_seasonal_forecast.region_id'); //area_seasonal_forecast
	   $this->db->join('sub_region','area_seasonal_forecast.subregion_id=sub_region.id');
	   $multipleWhere = ['area_seasonal_forecast.region_id =' => $region, 'area_seasonal_forecast.forecast_id =' => $forecast_id];	 
	   $this->db->where($multipleWhere);
      // $this->db->order_by('area_seasonal_forecast.issuetime', $this->order);
	   
	   $query=$this->db->get();   
       return $query->result_array();
    	
		
	}
    
    //------------------------------
    
    //------------------------------

    function get_season_data1($id)
    {  
	   $this->db->select('season_months.season_name,seasonal_forecast.year,seasonal_forecast.overview,seasonal_forecast.general_forecast,seasonal_forecast.issuetime,season_months.abbreviation,seasonal_forecast.id');
	   $this->db->from('seasonal_forecast');
       $this->db->join('season_months','season_months.id=seasonal_forecast.season_id'); 
	   $this->db->where('seasonal_forecast.id',$id);
       $this->db->order_by('seasonal_forecast.issuetime', $this->order);   
	   
	   $query=$this->db->get();   
       return $query->result_array();
    
    }
	
	//area forcast
function get_areaseason_data($id)
    {  
	   $this->db->select('area_seasonal_forecast.expected_peak, area_seasonal_forecast.peakdesc, area_seasonal_forecast.onset_period,area_seasonal_forecast.end_period,area_seasonal_forecast.enddesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info,region.region_name,sub_region.sub_region_name');
	   $this->db->from('area_seasonal_forecast');
	   $this->db->join('seasonal_forecast','area_seasonal_forecast.forecast_id=seasonal_forecast.id'); 
	   $this->db->join('region','area_seasonal_forecast.region_id=region.id');
	   $this->db->join('sub_region','area_seasonal_forecast.subregion_id=sub_region.id');
	   $this->db->where('area_seasonal_forecast.forecast_id',$id);	   
	   
	   $query=$this->db->get();   
       return $query->result_array();
    
    }

//----------------------------------
public  function get_all_forecast_area($id=NULL){
    $id = 2; 
    $this->db->select('area_seasonal_forecast.region_id, area_seasonal_forecast.subregion_id, area_seasonal_forecast.expected_peak, area_seasonal_forecast.onset_period,area_seasonal_forecast.onsetdesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info, region.region_name,area_seasonal_forecast.enddesc,region.id,seasonal_forecast.season_id, area_seasonal_forecast.end_period,area_seasonal_forecast.peakdesc,area_seasonal_forecast.id');
    $this->db->from('area_seasonal_forecast');
    $this->db->join('seasonal_forecast','seasonal_forecast.id=area_seasonal_forecast.forecast_id','inner'); 
    $this->db->join('region','region.id=area_seasonal_forecast.region_id','inner'); 

     $this->db->where('area_seasonal_forecast.forecast_id',$id);	 
   $query=$this->db->get();   
    return $query->result_array();

   }
//------------------------------------
     
public  function get_forecast_area($id=NULL){
      
      $this->db->select('area_seasonal_forecast.expected_peak, language, area_seasonal_forecast.onset_period,area_seasonal_forecast.onsetdesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info, sub_region.sub_region_name, main_regions.region_name,area_seasonal_forecast.enddesc,area_seasonal_forecast.end_period,area_seasonal_forecast.peakdesc,area_seasonal_forecast.id');
      $this->db->from('area_seasonal_forecast');

      $this->db->join('sub_region','area_seasonal_forecast.subregion_id=sub_region.id'); 


      $this->db->join('main_regions','main_regions.id=area_seasonal_forecast.region_id','inner');
      $this->db->join('ussdmenulanguage','area_seasonal_forecast.language_id=ussdmenulanguage.id'); 

     if(isset($id)){
        $this->db->where('area_seasonal_forecast.forecast_id',$id);  
  }
  $this->db->order_by('area_seasonal_forecast.id','DESC');
     $query=$this->db->get();   
      return $query->result_array();

     }


     public  function get_area_forecast_data($id){
      
      $this->db->select('area_seasonal_forecast.expected_peak, area_seasonal_forecast.onset_period,area_seasonal_forecast.onsetdesc,area_seasonal_forecast.overall_comment,area_seasonal_forecast.general_info, sub_region.sub_region_name, main_regions.region_name,area_seasonal_forecast.enddesc,area_seasonal_forecast.end_period,area_seasonal_forecast.peakdesc,area_seasonal_forecast.id');
      $this->db->from('area_seasonal_forecast');

      $this->db->join('sub_region','area_seasonal_forecast.subregion_id=sub_region.id'); 


      $this->db->join('main_regions','main_regions.id=area_seasonal_forecast.region_id','inner'); 
      $this->db->where('area_seasonal_forecast.id',$id);   
     $query=$this->db->get();   
      return $query->result_array();

     }


  // get data by id
    function get_by_id($id)
    {    
	   $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
	
  // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('season_name', $q);
	$this->db->or_like('season_code', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('season_name', $q);
	$this->db->or_like('season_code', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data=array())
    {    $this->db->insert('seasonal_forecast',$data);    

    }
  //==================seasonal forecast with advisory------------------------------------------
        // New Method with advisories
     function get_season_data($id, $division, $language_id)
    {  

      //$language_id = 1;default for english
        $this->db->select('division.id as district_id,seasonal_forecast.id,seasonal_forecast.issuetime, seasonal_forecast.year, season_months.abbreviation, seasonal_forecast.overview, seasonal_forecast.general_forecast, seasonal_forecast.map, main_regions.region_name, sub_region.sub_region_name, area_seasonal_forecast.overall_comment');
        $this->db->from('division');
        $this->db->join('main_regions','division.main_region = main_regions.id');
        $this->db->join('area_seasonal_forecast','area_seasonal_forecast.region_id =  division.main_region');
        $this->db->join('sub_region','area_seasonal_forecast.subregion_id = sub_region.id');
        $this->db->join('seasonal_forecast','area_seasonal_forecast.forecast_id = seasonal_forecast.id');
        $this->db->join('season_months','seasonal_forecast.season_id = season_months.id');
        //$this->db->where('seasonal_forecast.id', $id);
        $this->db->where('division.id', $division);
         $this->db->where('area_seasonal_forecast.language_id', $language_id);
        $this->db->order_by('area_seasonal_forecast.id','DESC');
       $query=$this->db->get();   
       return $query->result_array();
    
    }


    //get this season's available languages

    function get_season_available_languages()
    {  

      $season = "unknown";
       if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
                           else 
                            if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
                          else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
                          else $season = 'SOND';

     
        $this->db->select('ussdmenulanguage.language, ussdmenulanguage.id');
        $this->db->DISTINCT('ussdmenulanguage.language, ussdmenulanguage.id');
        $this->db->from('ussdmenulanguage');
        $this->db->join('area_seasonal_forecast','area_seasonal_forecast.language_id = ussdmenulanguage.id');
        $this->db->join('seasonal_forecast','area_seasonal_forecast.forecast_id = seasonal_forecast.id');
        $this->db->join('season_months','seasonal_forecast.season_id = season_months.id');
        $this->db->where('season_months.abbreviation',$season);
       $this->db->where('seasonal_forecast.year',date('Y'));
        $this->db->order_by('ussdmenulanguage.language','ASC');
       $query=$this->db->get();   
       return $query->result_array();
    
    }


    function get_advice($division, $session_lang){

    	$year = date('Y');
       $season = "unknown";
                          if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
                           else 
                            if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
                          else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
                          else $season = 'SOND';

        $this->db->select(' minor_sector.minor_name, season_months.abbreviation, division.division_name, advisory.advice,advisory.message_summary,seasonal_forecast.year');
        $this->db->from('advisory');
        $this->db->join('minor_sector','advisory.sector = minor_sector.id');
        $this->db->join('major_sector','major_sector.id = minor_sector.major_id');
        $this->db->join('seasonal_forecast ',' advisory.forecast_id = seasonal_forecast.id');
        $this->db->join('season_months','seasonal_forecast.season_id = season_months.id');
        $this->db->join('area_seasonal_forecast ',' advisory.forecast_id = area_seasonal_forecast.forecast_id');
    
        $this->db->join('sub_region',' sub_region.id = advisory.region_id');
         $this->db->join('division ',' division.sub_region_id = sub_region.id');
        $this->db->where('division.id',$division);
        $this->db->where('major_sector.language_id',$session_lang);
           $this->db->where('season_months.abbreviation',$season);
           $this->db->where('seasonal_forecast.year',$year);
        $this->db->group_by('advisory.id');
        $qy =  $this->db->get_compiled_select();
    

       $this->db->select('minor_sector.minor_name, season_months.abbreviation, division.division_name, advisory.advice,advisory.message_summary,seasonal_forecast.year');
       $this->db->from('advisory');
       $this->db->join('minor_sector', 'advisory.sector = minor_sector.id');
        $this->db->join('major_sector','major_sector.id = minor_sector.major_id');
      $this->db->join('ussdmenulanguage',' ussdmenulanguage.id = major_sector.language_id');
          $this->db->join('seasonal_forecast','advisory.forecast_id = seasonal_forecast.id ');
            $this->db->join('area_seasonal_forecast', 'advisory.forecast_id = area_seasonal_forecast.forecast_id ');
               $this->db->join('division','area_seasonal_forecast.region_id = division.main_region');
                $this->db->join('season_months',' seasonal_forecast.season_id = season_months.id ');
                  $this->db->where('division.id', $division);
                    $this->db->where('abbreviation', $season);
                    $this->db->where('ussdmenulanguage.id', $session_lang);
                    $this->db->where('seasonal_forecast.year',$year);
                     $this->db->where('advisory.region_id', 1);
                     $this->db->group_by('advisory.id');
                      $qy1 =  $this->db->get_compiled_select();
                        $query = $this->db->query($qy . ' UNION ALL ' . $qy1);

        return $query->result_array();
    }


    //==================seasonal forecast with advisory------------------------------------------
    //---------------get-map advice--------------------------------
     function get_map_advice($division){

        $this->db->select('division.division_name, advisory.id,advice,message_summary,seasonal_forecast.year, minor_name');
        $this->db->from('advisory');
        $this->db->join('minor_sector','advisory.sector = minor_sector.id');
        $this->db->join('major_sector','major_sector.id = minor_sector.major_id');
        $this->db->join('seasonal_forecast ',' advisory.forecast_id = seasonal_forecast.id');
        $this->db->join('area_seasonal_forecast ',' advisory.forecast_id = area_seasonal_forecast.forecast_id');
        $this->db->join('division ',' area_seasonal_forecast.region_id = division.main_region');
        $this->db->where('division.division_name',$division);
        $this->db->where('major_sector.language_id',1);
        $this->db->group_by('advisory.id');
        $qy = $this->db->get();
        return $qy->result_array();

    }
    
    function get_current_division($id){
        $this->db->select('division_name');
        $this->db->from('division');
        $this->db->where('id', $id);
        $query=$this->db->get(); 
        if($query->num_rows()>0) {   
         $data = $query->row_array();        
         $value = $data['division_name'];       
         return $value;
     }
        
    }
     // update data
// Edited the method to be able to update the specific season data for the admin
     function update($id, $data)
     {
         $data1 = array(
             'region' => $data['region'],
             'subregion' => $data['subregion'],
             'seas' => $data['seas'],
             'descrip' => $data['descrip'],
             'impact' =>$data['impact'],
             'file1' =>  $data['file1'],
             'file2' => $data['file2'],
         );
          if($data['lang']=='English')
           $sql = "UPDATE $this->table SET region = ?, subregionid = ?, season = ?, description = ?, impact = ?, graph = ?, audio =?  WHERE id = $id";
           if($data['lang']=='Luganda')
           $sql = "UPDATE $this->table SET region = ?, subregionid = ?, season = ?, descriptionLuganda = ?, impactLuganda = ?, graph = ?, audio =?  WHERE id = $id";
          
         return $this->db->query($sql, $data1);
     }
/////////////////////////////////////////////////////////////////
 //---------------------insert seasonal data area-----------------
     // insert data int minor_sector table
    function insertForecastArea($data=array())
    {  
        $this->db->insert('area_seasonal_forecast',$data);
    }
 //---------------------------------------------

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function delete2($id)
    {
      $this->db->from('area_seasonal_forecast');
        $this->db->where($this->id, $id);
        $this->db->join('main_regions','main_regions.id = area_seasonal_forecast.region_id');
        $this->db->join('sub_region','sub_region.id = area_seasonal_forecast.subregion_id');

        $ret = $this->db->get()->row();
        $this->session->set_userdata('deleted',ucwords($ret->sub_region_name));


        $this->db->where($this->id, $id);
        $this->db->delete('area_seasonal_forecast');
    }

  // 2020 changes////////////

    function forecast_checker($reg, $subreg, $lang,$forecast_id)
    {
      $this->db->select('region_id, subregion_id');
      $this->db->from('area_seasonal_forecast');
      $this->db->where('region_id', $reg);
      $this->db->where('subregion_id',$subreg);
      $this->db->where('language_id', $lang);
      $this->db->where('forecast_id', $forecast_id);
      $query=$this->db->get();
      return $query->result_array();
    }


    function delete1($id)
    {   

       $this->db->from('seasonal_forecast');
        $this->db->join('season_months', 'season_months.id = seasonal_forecast.season_id');
        $this->db->where('seasonal_forecast.id', $id);
        $ret = $this->db->get()->row();
        $this->session->set_userdata('deleted',$ret->season_name);


        $this->db->where("id", $id);
        $this->db->delete("seasonal_forecast");
        $this->db->where("forecast_id", $id);
        $this->db->delete("area_seasonal_forecast");
    }

 // 2020 changes////////////

    //get farmers to send message
    function getfarmers($region,$sub_region,$season){

        $numbers = "";
        $unique = array();
        $count = "";
        

       
            $this->db->select('ussdtransaction.Msisdn,ussdtransaction.districtid');

            $this->db->from('ussdtransaction');

            $array = array('regionid'=>$region,'subregionid'=>$sub_region,'Level1'=>'Seasonal','districtid IS NOT NULL'=>NULL,
            'Level6 IS NOT NULL'=>NULL,'Level0 IS NOT NULL'=>NULL,'Level7 IS NOT NULL'=>NULL);

             $this->db->where($array);

             $numbers = $this->db->get()->result();
            
        
        

        foreach($numbers as $number){

            //get one instance of each number returned

            $unique[$number->Msisdn] = $number;
            
        }
        
        
        foreach($unique as $uni){
            
                $this->db->select('COUNT(*) as total');

                $this->db->from('ussdtransaction');

                $array = array('regionid'=>$region,'subregionid'=>$sub_region,'Level1'=>'Seasonal   ','Msisdn'=>$uni->Msisdn);

                $this->db->where($array);

                $num =$this->db->count_all_results();
               

                    if($num >= 2){
                        
                        $message = "There is new seasonal forecast, for more information please dial *255*85#";

                       $count = $this->smsapi($uni->Msisdn,$message);
                    }
                    
            
           
        }
       
        return $count;
       
    
       
    }

    //smsapi

    function smsapi($phoneNumber,$message){

        echo $phoneNumber." ".$message;

        $msg=str_replace("<br>","\n",$message);
        $messg=str_replace("?","\'",$msg);
        

		$resp = "";
		try{
                
        
        $textmessage = urlencode($messg);	
        
		$url = 'http://simplysms.com/getapi.php';
        $urlfinal = $url.'?'.'email'.'='.'rc4wids@yahoo.com'.'&'.'password'.'='.'VBsd9A2'.'&'.'sender'.'='.'8777'.'&'.'message'.'='.$textmessage.'&'.'recipients'.'='.$phoneNumber;
        //var_dump($urlfinal);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $urlfinal);
		curl_setopt_array($ch,array(
		CURLOPT_RETURNTRANSFER =>1,   
		//CURLOPT_URL =>$urlfinal,
		CURLOPT_USERAGENT =>'Codular Sample cURL Request'));

		$resp = curl_exec($ch);

		curl_close($ch);
			
		}catch(Exception $e){}
		return $resp;
    }



    public function get_districts(){
    	$season = "unknown";
                          if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
                           else 
                            if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
                          else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
                          else $season = 'SOND';

      $this->db->select('division.id, division.division_name,division.lat,division.lng');
      $this->db->from('advisory');
      $this->db->join('division', "division.sub_region_id = advisory.region_id");
      $this->db->join('seasonal_forecast', 'seasonal_forecast.id = advisory.forecast_id');
      $this->db->join('season_months','season_months.id=seasonal_forecast.season_id');
      $this->db->join('minor_sector','advisory.sector=minor_sector.id');
      $this->db->join('major_sector','major_sector.id=minor_sector.major_id');
      $this->db->where('major_sector.language_id', 1);
      $this->db->where('season_months.abbreviation', $season);
      $this->db->where('advisory.sector',11);
      $query=$this->db->get();
      return $query->result_array();
    }
    public function get_district($id){
      $this->db->select('*');
      $this->db->from('division');
      $this->db->where('id',$id);
      $query=$this->db->get();
      return $query->result_array();
    }
     public function get_contacts($from, $to){
      $this->db->select('phone');
      $this->db->from('ussdtransaction_new');
      $this->db->where('date BETWEEN "'. $from. ' 00:00:01" and "'.$to.' 23:59:59"');
      $this->db->group_by('phone');
      $query=$this->db->get();
      return $query->result_array();
    }
  
public function today_users(){
     $query ="SELECT DISTINCT phone, menuvalue FROM `ussdtransaction_new` WHERE date >= '2020-07-18 00:00:00' AND date <= '2020-07-18 18:00:00'AND menuvariable = 'district' AND menuvalue != 'invaliddistrict'";
     $dd = $this->db->query($query);
      
     return $dd;
    }

    public function broadcast_forecast($divisions){
        $query =" SELECT daily_forecast.date as forecasted, forecast_time.period_name as period, forecast_time.from_time, forecast_time.to_time, daily_forecast_data.mean_temp as mean_temp,daily_forecast_data.period as periodic, daily_forecast_data.wind_strength as strength, weather_category.cat_name as weather_desc, daily_forecast.weather as weather FROM daily_forecast LEFT OUTER JOIN daily_forecast_data ON daily_forecast.id = daily_forecast_data.forecast_id LEFT OUTER JOIN region ON region.id = daily_forecast_data.region_id LEFT OUTER JOIN division on division.region_id = region.id LEFT OUTER JOIN weather_category on weather_category.id = daily_forecast_data.weather_cat_id LEFT OUTER JOIN forecast_time on daily_forecast_data.period = forecast_time.id WHERE division.division_name = '$divisions' AND daily_forecast.date = '2020-07-18' AND daily_forecast.language_id = '1' AND daily_forecast.time = 5 ORDER BY daily_forecast_data.id ASC";
        $dd = $this->db->query($query);
      
     return $dd->result_array();
    }

}

/* End of file Season_model.php */