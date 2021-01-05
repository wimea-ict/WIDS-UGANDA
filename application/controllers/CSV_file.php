<?php
require_once __DIR__.'/SimpleXLSX.php';
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CSV_file extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->config->set_item('theme',$this->config->item('country'));
        $this->load->model('CSV_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

//index function 
    public function CSV_file24(){
        $pdf_file = $_FILES['file2']['tmp_name'];

        $actual_name =  substr($_FILES['file2']['name'], 0, -4);

        $local = "/var/www/html/wids/Conversions/".$actual_name.".xlsx";
        // move_uploaded_file(filename, destination)
        $available = 0;
        if ( file_exists($local)) {$available = 1;}

        if($available == 0){
             if (!is_readable($pdf_file)) {
                    print("Error: file does not exist or is not readable: $pdf_file\n");
                    return;
            }else{
                // print( base_url()."File was accessed");
            }

            $c = curl_init();

            $cfile = curl_file_create($pdf_file, 'application/pdf');
            //---------calling the conversion api---------------------------------------
            // $apikey = 'b3gj4msnzgrd'; // from https://pdftables.com/api

            //$apikey = 'o819w8lrxqe8'; UNUSED

            $apikey = '4grlqjama6wv';
            curl_setopt($c, CURLOPT_URL, "https://pdftables.com/api?key=$apikey&format=xlsx-single");
            curl_setopt($c, CURLOPT_POSTFIELDS, array('file' => $cfile));
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_FAILONERROR,true);
            curl_setopt($c, CURLOPT_ENCODING, "gzip,deflate");

            $result = curl_exec($c);

            if (curl_errno($c) > 0) {
                // print('Error calling PDFTables: '.curl_error($c).PHP_EOL);
                $data['change'] = 3;
                $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Conversion Failed, Out of Conversion Units!</div>');
           
                $this->load->view('template',$data);

            } else {
              // save the CSV we got from PDFTables to a file
                $local = "/var/www/html/wids/Conversions/".$actual_name.".xlsx";
                file_put_contents ($local, $result);
            }

            curl_close($c);
        }
        if ( $xlsx = SimpleXLSX::parse($local)) {


            
            // $temp1 = array();
            $dim = $xlsx->dimension();
            $cols = $dim[0];
            $num_rows = $dim[1];
            $cm = 0;
            $min = 0;
            foreach ( $xlsx->rows() as $k => $r ) { $ct = 0; $min++;
                    //      if ($k == 0) continue; // skip first row
                
                for($i=0;$i<$cols;$i++){$ct++;
                    switch ($r[ 1 ]) {
                        
                        case 'Temperatures':
                            if($i == 1){ $cm++;

                                $desc[] = ($xlsx->rows( 0 )[$k-1][$i+1]=="")? ($xlsx->rows( 0 )[$k-2][$i+1]=="")?($xlsx->rows( 0 )[$k-3][$i+1]=="")?$xlsx->rows( 0 )[$k-4][$i+1]:$xlsx->rows( 0 )[$k-3][$i+1]:$xlsx->rows( 0 )[$k-2][$i+1] :$xlsx->rows( 0 )[$k-1][$i+1];
                                // echo (($xlsx->rows( 0 )[$k-1][$i+1]=="")? ($xlsx->rows( 0 )[$k-2][$i+1]=="")?($xlsx->rows( 0 )[$k-3][$i+1]=="")?$xlsx->rows( 0 )[$k-4][$i+1]:$xlsx->rows( 0 )[$k-3][$i+1]:$xlsx->rows( 0 )[$k-2][$i+1] :$xlsx->rows( 0 )[$k-1][$i+1])."<br>";

                                $desc1[] = ($xlsx->rows( 0 )[$k-1][$i+2]=="")? ($xlsx->rows( 0 )[$k-2][$i+2]=="")?($xlsx->rows( 0 )[$k-3][$i+2]=="")?$xlsx->rows( 0 )[$k-4][$i+2]:$xlsx->rows( 0 )[$k-3][$i+2]:$xlsx->rows( 0 )[$k-2][$i+2] :$xlsx->rows( 0 )[$k-1][$i+2];
                                //echo $ct.". ".$desc1."<br>";
                                $desc2[] = ($xlsx->rows( 0 )[$k-1][$i+3]=="")? 
                                ($xlsx->rows( 0 )[$k-2][$i+3]=="")?
                                ($xlsx->rows( 0 )[$k-3][$i+3]=="")?
                                ($xlsx->rows( 0 )[$k-4][$i+3]=="")?
                                $xlsx->rows( 0 )[$k-5][$i+3]
                                :$xlsx->rows( 0 )[$k-4][$i+3]
                                :$xlsx->rows( 0 )[$k-3][$i+3]
                                :$xlsx->rows( 0 )[$k-2][$i+3] 
                                :$xlsx->rows( 0 )[$k-1][$i+3];

                                $desc3[] = ($xlsx->rows( 0 )[$k-1][$i+4]=="" || $xlsx->rows( 0 )[$k-1][$i+4]=="Light")?
                                ($xlsx->rows( 0 )[$k-2][$i+4]=="" || $xlsx->rows( 0 )[$k-2][$i+4]=="Light")?
                                ($xlsx->rows( 0 )[$k-3][$i+4]=="" || $xlsx->rows( 0 )[$k-3][$i+4]=="Light")?
                                ($xlsx->rows( 0 )[$k-4][$i+4]=="" || $xlsx->rows( 0 )[$k-4][$i+4]=="Light")?
                                ($xlsx->rows( 0 )[$k-4][$i+5]=="" || $xlsx->rows( 0 )[$k-4][$i+5]=="Light")?
                                ($xlsx->rows( 0 )[$k-3][$i+5]=="" || $xlsx->rows( 0 )[$k-3][$i+5]=="Light")?
                                ($xlsx->rows( 0 )[$k-2][$i+5]=="" || $xlsx->rows( 0 )[$k-2][$i+5]=="Light")?
                                $xlsx->rows( 0 )[$k-1][$i+5]
                                :$xlsx->rows( 0 )[$k-2][$i+5]
                                :$xlsx->rows( 0 )[$k-3][$i+5]
                                :$xlsx->rows( 0 )[$k-4][$i+5]
                                :$xlsx->rows( 0 )[$k-4][$i+4]
                                :$xlsx->rows( 0 )[$k-3][$i+4]
                                :$xlsx->rows( 0 )[$k-2][$i+4]
                                :$xlsx->rows( 0 )[$k-1][$i+4];

                                
                                $temp[] = $xlsx->rows( 0 )[$k][$i+1];
                                $temp1[] = $xlsx->rows( 0 )[$k][$i+2];
                                $temp2[] = $xlsx->rows( 0 )[$k][$i+3];
                                $temp3[] = ($xlsx->rows( 0 )[$k][$i+4] =="")? $xlsx->rows( 0 )[$k][$i+5]:$xlsx->rows( 0 )[$k][$i+4];
                                
                            }
                            break;
                        case 'Wind':
                            if($i == 1){
                                $wind[] = $xlsx->rows( 0 )[$k][$i+1];
                                $wind1[] = $xlsx->rows( 0 )[$k][$i+2];
                                $wind2[] = $xlsx->rows( 0 )[$k][$i+3];
                                $wind3[] = ($xlsx->rows( 0 )[$k][$i+4] =="")? $xlsx->rows( 0 )[$k][$i+5]:$xlsx->rows( 0 )[$k][$i+4];
                            }
                            break;
                        case 'Wind strength':
                            if($i == 1){
                                // echo $ct;
                                $winds[] = $xlsx->rows( 0 )[$k][$i+1];
                                $winds1[] = $xlsx->rows( 0 )[$k][$i+2];
                                $winds2[] = $xlsx->rows( 0 )[$k][$i+3];
                                $winds3[] = ($xlsx->rows( 0 )[$k][$i+4] =="")? $xlsx->rows( 0 )[$k][$i+5]:$xlsx->rows( 0 )[$k][$i+4];
                            }
                            break;
                        
                        default:
                            break;
                    }
                    if((strpos($r[ 0 ], "Duty Forecaster") !== false) && $ct == 1){
                        $forecaster = (substr($r[ 0 ], 16)=="")? $r[ 1 ] : substr($r[ 0 ], 16);  
                        $fore =  explode(" ", $forecaster)[1]." ".explode(" ", $forecaster)[2];
                    } 

                    if((strpos($xlsx->rows( 0 )[$k][0], "weather summary") !== false) && $ct == 1){
                           $summary =  $xlsx->rows( 0 )[$k+1][0]." "; 
                    }

                    if((strpos($xlsx->rows( 0 )[$k][0], "Further outlook") !== false) && $ct == 1){
                        // Further outlook
                        $further = substr($xlsx->rows( 0 )[$k][0], 17);
                        if(strpos($xlsx->rows( 0 )[$k-1][0], "weather summary") !== true)
                           $summary .=  $xlsx->rows( 0 )[$k-1][0]; 
                       // weather summary
                    }

                }
                 
            }
            // Forecast date
            $f_date = explode(' ',( $xlsx->rows( 0 )[7][0]=='')? substr($xlsx->rows( 0 )[7][1], 15): $xlsx->rows( 0 )[7][0]);
            $new_date = $f_date[3].' '.substr($f_date[(sizeof($f_date)-2)], 0, strlen($f_date[(sizeof($f_date)-2)])-1).' '.$f_date[(sizeof($f_date)-1)];
            $forecast_date = date('Y-m-d', strtotime($new_date));
            
/////////////////////////////////////////////////////////////////////////
            // echo substr($f_date[7], 0,strlen($f_date[7])-1);
            // echo substr($f_date[(sizeof($f_date)-2)], 0, strlen($f_date[(sizeof($f_date)-2)])-1);
            // echo $forecast_date;

            // Tuesday
            // echo $f_date[3].' '.substr($f_date[(sizeof($f_date)-2)], 0, strlen($f_date[(sizeof($f_date)-2)])-1).' '.$f_date[(sizeof($f_date)-1)];

            // Month  substr($f_date[(sizeof($f_date)-2)], 0, strlen($f_date[(sizeof($f_date)-2)])-1)
            // Year  $f_date[(sizeof($f_date)-1)];
/////////////////////////////////////////////////////////////////////////


            // Issue date
            $iss_date = explode(' ',( $xlsx->rows( 0 )[6][0]=='')? substr($xlsx->rows( 0 )[6][1], 15): $xlsx->rows( 0 )[6][0]);
            // echo $iss_date[0];

            $newiss_date = $iss_date[4].' '.substr($iss_date[(sizeof($iss_date)-2)], 0, strlen($iss_date[(sizeof($iss_date)-2)])-1).' '.$iss_date[(sizeof($iss_date)-1)];

            $issue_date = date('Y-m-d', strtotime($newiss_date));
            
            //----------outlier date-----------------------
            if ($forecast_date == '1970-01-01') {
               $forecast_date = date('Y-m-d');
            }

            
            
             // Insert daily forcest
            $data_to_insert = array(
                'language_id'   => 1,
                'weather'       => $summary,
                'date'          => $forecast_date,
                'time'          => 5,
                'issuedate'     => $issue_date,
                'validitytime'  => "6:00pm",
                'dutyforecaster'=> $fore
            );
            $this->CSV_model->insert_daily($data_to_insert);
            $moments = array(4,1,2,3);
            for ($i=0; $i < 4; $i++) { 
                for($m=0;$m<sizeof($temp);$m++){
                    
                    if($i == 0){
                        if(strcmp($desc[$m], "thundershowers") == 0){
                            $dest = "Scattered thundershowers";
                        }else if(strcmp($desc[$m], "Light") == 0){
                            $dest = "Light Showers";
                        }else if(strcmp($desc[$m], "Isolated") == 0){
                            $dest = "Isolated Showers";
                        }else{
                            $dest = $desc[$m];
                        }
                        $wet_cat =( $this->CSV_model->get_weather_cat(trim($dest))->id=="")? 19: $this->CSV_model->get_weather_cat(trim($dest))->id;

                        $new_description[] =  $dest;
                        $data_to_insert2 = array(
                            'mean_temp'     => substr($temp[$m], 0, strlen($temp[$m]-1)),
                            'wind_direction'=> $wind[$m],
                            'wind_strength' => $winds[$m],
                            'region_id'     => ($m+1),
                            'weather_cat_id'=> $wet_cat,
                            'forecast_id'   => $this->CSV_model->get_recent_forecast()->id,
                            'period'        => $moments[$i]
                        );
                    }else if($i == 1) {
                        if(strcmp($desc1[$m], "thundershowers") == 0){
                            $dest = "Scattered thundershowers";
                        }else if(strcmp($desc1[$m], "Light") == 0){
                            $dest = "Light Showers";
                        }else if(strcmp($desc1[$m], "Isolated") == 0){
                            $dest = "Isolated Showers";
                        }else{
                            $dest = $desc1[$m];
                        }
                        $new_descriptions[] = $dest;
                        $wet_cat =( $this->CSV_model->get_weather_cat(trim($dest))->id=="")? 10: $this->CSV_model->get_weather_cat(trim($dest))->id;
                        $data_to_insert2 = array(
                            'mean_temp'     => substr($temp1[$m], 0, strlen($temp1[$m]-1)),
                            'wind_direction'=> $wind1[$m],
                            'wind_strength' => $winds1[$m],
                            'region_id'     => ($m+1),
                            'weather_cat_id'=> $wet_cat,
                            'forecast_id'   => $this->CSV_model->get_recent_forecast()->id,
                            'period'        => $moments[$i]
                        );
                    }else if($i == 2) {
                        if(strcmp($desc2[$m], "showers") == 0){
                            $desc = "Isolated Showers";
                        }else if(strcmp($desc2[$m], "thundershowers") == 0){
                            $dest = "Scattered thundershowers";
                        }else if(strcmp($desc2[$m], "Light") == 0){
                            $dest = "Light Showers";
                        }else if(strcmp($desc2[$m], "Isolated") == 0){
                            $dest = "Isolated Showers";
                        }else{
                            $dest = $desc2[$m];
                        }
                        $new_descriptionss[]  = $dest;
                        $wet_cat =( $this->CSV_model->get_weather_cat(trim($dest))->id=="")? 10: $this->CSV_model->get_weather_cat(trim($dest))->id;
                        $data_to_insert2 = array(
                            'mean_temp'     => substr($temp2[$m], 0, strlen($temp2[$m]-1)),
                            'wind_direction'=> $wind2[$m],
                            'wind_strength' => $winds2[$m],
                            'region_id'     => ($m+1),
                            'weather_cat_id'=> $wet_cat,
                            'forecast_id'   => $this->CSV_model->get_recent_forecast()->id,
                            'period'        => $moments[$i]
                        );
                    }else if($i == 3) {
                        if(strcmp($desc3[$m], "showers") == 0){
                            $desc = "Isolated Showers";
                        }else if(strcmp($desc3[$m], "thundershowers") == 0){
                            $dest = "Scattered thundershowers";
                        }else if(strcmp($desc3[$m], "Light") == 0){
                            $dest = "Light Showers";
                        }else if(strcmp($desc3[$m], "Isolated") == 0){
                            $dest = "Isolated Showers";
                        }else{
                            $dest = $desc3[$m];
                        }
                        $new_descriptionsss[] = $dest;
                        $wet_cat =( $this->CSV_model->get_weather_cat(trim($dest))->id=="")? 10: $this->CSV_model->get_weather_cat(trim($dest))->id;
                        $data_to_insert2 = array(
                            'mean_temp'     => substr($temp3[$m], 0, strlen($temp3[$m]-1)),
                            'wind_direction'=> $wind3[$m],
                            'wind_strength' => $winds3[$m],
                            'region_id'     => ($m+1),
                            'weather_cat_id'=> $wet_cat,
                            'forecast_id'   => $this->CSV_model->get_recent_forecast()->id,
                            'period'        => $moments[$i]
                        );
                    }
                    $this->CSV_model->insert_daily_data($data_to_insert2);
                }
            }

        $min=array();
            for($m=0;$m<sizeof($temp);$m++){
                $min[]=$this->CSV_model->get_region(($m+1))->region_name;
            }
        $data = array(
                'issue_date' => $issue_date,
                'forecast_date' => $forecast_date,
                'valid' => "6:00pm",
                'sum'   => $summary,
                'weather_desc' => $new_description,
                'weather_desc1' => $new_descriptions,
                'weather_desc2' => $new_descriptionss,
                'weather_desc3' => $new_descriptionsss,
                'temp' => $temp,
                'temp1' => $temp1,
                'temp2' => $temp2,
                'temp3' => $temp3,
                'wind_dir' => $wind,
                'wind_dir1' => $wind1,
                'wind_dir2' => $wind2,
                'wind_dir3' => $wind3,
                'wind_str' => $winds,
                'wind_str1' => $winds1,
                'wind_str2' => $winds2,
                'wind_str3' => $winds3,
                'wind_str4' => $winds4,
                'forecaster' => $fore,
                'regs' => $min,
                'change' => 108
            );

            $this->load->view('template',$data);

        } else {
            echo SimpleXLSX::parseError();
        }



           
    }


    public function index()
    {
        
        $pdf_file = $_FILES['file2']['tmp_name'];
        $actual_name =  substr($_FILES['file2']['name'], 0, -4);

        $local = "/var/www/html/wids/Conversions/".$actual_name.".xlsx";

        $available = 0;
        if ( $xlsx = SimpleXLSX::parse($local)) {$available = 1;}
        if($available == 0){
            if (!is_readable($pdf_file)) {
                print("Error: file does not exist or is not readable: $pdf_file\n");
                    return;
            }else{
                // print( base_url()."File was accessed");
            }

            $c = curl_init();

            $cfile = curl_file_create($pdf_file, 'application/pdf');
            //---------calling the conversion api---------------------------------------
            $apikey = '4grlqjama6wv'; // from https://pdftables.com/api
            curl_setopt($c, CURLOPT_URL, "https://pdftables.com/api?key=$apikey&format=xlsx-single");
            curl_setopt($c, CURLOPT_POSTFIELDS, array('file' => $cfile));
            curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c, CURLOPT_FAILONERROR,true);
            curl_setopt($c, CURLOPT_ENCODING, "gzip,deflate");

            $result = curl_exec($c);

            if (curl_errno($c) > 0) {
                // print('Error calling PDFTables: '.curl_error($c).PHP_EOL);
                $data['change'] = 3;

                $this->session->set_flashdata('message','<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Conversion Failed, Out of Conversion Units!</div>');
           
                $this->load->view('template',$data);

            } else {
              // save the CSV we got from PDFTables to a file
                $local = "/var/www/html/wids/Conversions/".$actual_name.".xlsx";
                  file_put_contents ($local, $result);
            }

            curl_close($c);

        }
       if ( $xlsx = SimpleXLSX::parse( $local )) {

            // output worsheet 1

            $dim = $xlsx->dimension();
            $num_cols = $dim[0];
            $num_rows = $dim[1];

            $val = "";
            $sum = "";
            $temp=array(); $wind_dir=array(); $wind_str=array();
            $weather_desc=array(); $region=array();

            for($p=0;$p<sizeof($xlsx->rows( 0 ));$p++){

                for($i=0;$i<$num_cols;$i++){
                    switch ($xlsx->rows( 0 )[$p][$i]) {
                        case 'Temperatures':
                            $weather_desc[] = ($xlsx->rows( 0 )[$p-1][$i+1] == "")? $xlsx->rows( 0 )[$p-2][$i+1] = ($xlsx->rows( 0 )[$p-2][$i+1] == "")? ($xlsx->rows( 0 )[$p-3][$i+1]=="")? $xlsx->rows( 0 )[$p-2][$i+2] : $xlsx->rows( 0 )[$p-3][$i+1] : $xlsx->rows( 0 )[$p-2][$i+1] : $xlsx->rows( 0 )[$p-1][$i+1];
                            $temp[]=substr($xlsx->rows( 0 )[$p][$i]=($xlsx->rows( 0 )[$p][$i+1]=="")? $xlsx->rows( 0 )[$p][$i+2]:$xlsx->rows( 0 )[$p][$i+1], 0,2);
                            break;
                        case 'Wind direction':
                            $wind_dir[]=$xlsx->rows( 0 )[$p][ $i+1 ]=($xlsx->rows( 0 )[$p][ $i+1 ]=='')?$xlsx->rows( 0 )[$p][ $i+2 ]:$xlsx->rows( 0 )[$p][ $i+1 ];
                            break;
                        case 'Wind strength':
                            $wind_str[]=$xlsx->rows( 0 )[$p][ $i+1 ]=($xlsx->rows( 0 )[$p][ $i+1 ]=='')?$xlsx->rows( 0 )[$p][ $i+2 ]:$xlsx->rows( 0 )[$p][ $i+1 ];
                            break;
                        case 'Weather description':
                            $region[]=explode('(', $xlsx->rows( 0 )[$p][ 0 ])[0];
                            break;
                        default:
                            # code...
                            break;
                    }
                }

                if(strpos($xlsx->rows( 0 )[$p][0], "Today") !== false){
                    $val = $p;
                    $sum = $xlsx->rows( 0 )[$p][0];

                    
                }else if(strpos($xlsx->rows( 0 )[$p][0], "Below") !== false){
                    if(($p-$val)>1){
                        $sum .= " ".$xlsx->rows( 0 )[$p-1][0];
                    }
                }

                if(strpos($xlsx->rows( 0 )[$p][0], "Duty Forecaster") !== false){
                    $forecaster = (substr($xlsx->rows( 0 )[$p][0], 17)=="")? $xlsx->rows( 0 )[$p][1] : substr($xlsx->rows( 0 )[$p][0], 17);  
                }  

                
                
            }

            // Changing the format of the issue date of the forecast
            $i_date="";
            $iss_date = explode(' ',( $xlsx->rows( 0 )[6][1]=='')? substr($xlsx->rows( 0 )[6][0], 15): $xlsx->rows( 0 )[6][1]);
            for($i=1;$i<sizeof($iss_date);$i++){
                $i_date .= $iss_date[$i];
            }
            $issue_date = date('Y-m-d', strtotime($i_date));



            // Changing the format of the forecast date
            $fo_date="";
            $f_date = explode(' ', ($xlsx->rows( 0 )[7][1]=='')? substr($xlsx->rows( 0 )[7][0], 14):$xlsx->rows( 0 )[7][1]);
            for($i=1;$i<5;$i++){
                $fo_date .= $f_date[$i];
            }
            $forecast_date = date('Y-m-d', strtotime($fo_date));


            // The time forecasted morning or afternoon etc
            $time =(substr(explode(',', $xlsx->rows( 0 )[7][1])[1], 5)=='')? substr(explode(',', substr($xlsx->rows( 0 )[7][0], 14))[1], 5): substr(explode(',', $xlsx->rows( 0 )[7][1])[1], 5);
            $valid = (explode(' ', $xlsx->rows( 0 )[8][1])[2]=='')? explode(' ', substr($xlsx->rows( 0 )[8][0], 15))[2]: explode(' ', $xlsx->rows( 0 )[8][1])[2];

            if($time==""){
                $time="Evening"; //for midnight
            }
            if ($forecast_date == '1970-01-01') {
               $forecast_date = date('Y-m-d');
            }

            // Insert daily forcest
            $data_to_insert = array(
                'language_id'   => 1,
                'weather'       => $sum,
                'date'          => $forecast_date,
                'time'          => $this->CSV_model->get_time(trim($time))->id,
                'issuedate'     => $issue_date,
                'validitytime'  => $valid,
                'dutyforecaster'=> $forecaster
            );


            $this->CSV_model->insert_daily($data_to_insert);
            
            for($m=0;$m<sizeof($temp);$m++){
                $wet_cat =( $this->CSV_model->get_weather_cat(trim($weather_desc[$m]))->id=="")? 10: $this->CSV_model->get_weather_cat(trim($weather_desc[$m]))->id;
                $data_to_insert2 = array(
                    'mean_temp'     => substr($temp[$m], 0, strlen($temp[$m]-1)),
                    'max_temp'      => substr($temp[$m], 0, strlen($temp[$m]-1)),
                    'min_temp'      =>  substr($temp[$m], 0, strlen($temp[$m]-1)),
                    'wind'          => substr($temp[$m], 0, strlen($temp[$m]-1)),
                    'wind_direction'=> $wind_dir[$m],
                    'wind_strength' => $wind_str[$m],
                    'region_id'     => ($m+1),
                    'weather_cat_id'=> ($wet_cat=="")? 10: $wet_cat,
                    'forecast_id'   => $this->CSV_model->get_recent_forecast()->id
                );
                $this->CSV_model->insert_daily_data($data_to_insert2);
            }
            

            $min=array();
            for($m=0;$m<sizeof($temp);$m++){
                $min[]=$this->CSV_model->get_region(($m+1))->region_name;
            }
            
            $data = array(
                'issue_date' => $issue_date,
                'forecast_date' => $forecast_date,
                'time' => $time,
                'valid' => $valid,
                'sum' => $sum,
                'weather_desc' => $weather_desc,
                'temp' => $temp,
                'wind_dir' => $wind_dir,
                'wind_str' => $wind_str,
                'forecaster' => $forecaster,
                'regs' => $min,
                'change' => 91
            );
            
            $this->load->view('template',$data);



        } else {
            echo SimpleXLSX::parseError();
        }
    }

}

/* End of file Daily_forecast.php */
