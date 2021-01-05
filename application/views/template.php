<?php 
    $cur_uri=substr($this->uri->uri_string(),6);
    $cur_uri = $this->uri->segment(1);
    $cur_parent = $this->db->get_where('menu',array('link'=>$cur_uri,'is_active'=>1))->result_array();
    
    if($cur_parent)
        $cur_parent = $cur_parent[0]['is_parent'];
    else
        $cur_parent = 0;
    if($_SESSION['user_logged'] == FALSE){
            // The issue is here
      $this->session->set_flashdata("error","please log in first to view this page");
        redirect("index.php/auth/login");
  }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133419491-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-133419491-1');
    </script>

        <title>Weather Information Dissemination System</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/ionicons/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/css/adminlte.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/css/skins/_all-skins.min.css">
       <!-- css for date picker --->
     <link href="<?php echo base_url(); ?>assets/frameworks/adminlte/<?php echo $this->config->item('theme');?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
     
           <link href="<?php echo base_url(); ?>assets/frameworks/adminlte/<?php echo $this->config->item('theme');?>/css/bootstrap-datetimepicker.css" rel="stylesheet">
          
        
        
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/bootstrap/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/js/demo.js"></script>
        <!-- notifying -->
        <script src="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/notify/notify.min.js"></script>

       <!-- the ajax code for notification -->


<!-- ajax code end -->
    </head>
    <body class="hold-transition skin-blue sidebar-mini" onLoad="hideDivs()">
       <!-- -->

        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                   <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>W</b>IDS</span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg" ><h5>WEATHER INFORMATION DISSEMINATION SYSTEM (UG)</h5></span>
              
          </a>
          <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; WEATHER INFORMATION DISSEMINATION SYSTEM (UGANDA) -->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                
                    

<div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

            <!-- notification toggle------------------------------ -->

                     <?php
                        //------------------------------------------
                          $year = date('Y');

                          //Begins Handles checking for the seasonal forecast
                            $sub_regions = "SELECT * FROM sub_region WHERE sub_region_name <> 'All Regions'";
                            $qry = $this->db->query($sub_regions);  
                            $ids = array();
                            $regions = array();
                            $missing = array();
                            foreach ($qry->result_array()  as $dd) {
                                 $ids[] = $dd['id'];
                                 $regions[] = $dd['sub_region_name'];
                              }  
                              $season = "unknown";
                              if((date('m') == 1) || (date('m') == 2) ) $season = 'MAM';
                              else  if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
                              else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
                              else $season = 'SOND';
                              $ct = 0; $i=0;

                              $check = "SELECT seasonal_forecast.id as id FROM seasonal_forecast LEFT OUTER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE seasonal_forecast.year = '$year' AND season_months.abbreviation = '$season' LIMIT 1";
                               $query = $this->db->query($check);
                               $forecast_id = 0;$exist = false;
                               foreach ($query->result_array() as $idd) {
                                $exist = true;
                                 $forecast_id = $idd['id'];
                               }

                               if($exist == true){
                                  foreach ($ids as $edid) {
                                   $check = "SELECT * FROM area_seasonal_forecast LEFT OUTER JOIN seasonal_forecast on seasonal_forecast.id = area_seasonal_forecast.forecast_id LEFT OUTER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE seasonal_forecast.year = '$year' AND season_months.abbreviation = '$season' AND area_seasonal_forecast.language_id = 1 AND area_seasonal_forecast.subregion_id='$edid' ";
                                   $query = $this->db->query($check);
                                   if($query->result_array() == null){ $ct++;
                                    // echo "string";
                                    $missing[] = $regions[$i];
                                   }
                                   $i++;
                                }
                               }else{
                                  $ct++;
                               }
                              //End Handles checking for the seasonal forecast



                               //begins Handles checking for the Daily forecast
                              $regions = "SELECT * FROM region";
                              $qry = $this->db->query($regions);  
                              $daily_ids = array();
                              $daily_regions = array();
                              $daily_missing = array();
                              foreach ($qry->result_array()  as $dd) {
                                  $daily_ids[] = $dd['id'];
                                  $daily_regions[] = $dd['region_name'];
                              } 
                              $i=0;
                              $today = date('Y-m-d');

                              $there_is=true;
                              $daily_forecast_id=0;
                              $checker = "SELECT * FROM daily_forecast WHERE language_id = 1 AND date = '$today' LIMIT 1";
                              $query = $this->db->query($checker);
                              if($query->result_array() == null){
                                    $there_is=false;
                              }else{
                                $there_is=true;
                                foreach ($query->result_array() as $k) {
                                  $daily_forecast_id = $k['id'];
                                }
                              }

                              if($there_is == true){
                                foreach ($daily_ids as $edid) {
                                  $check = "SELECT * FROM daily_forecast_data LEFT OUTER JOIN daily_forecast on daily_forecast.id = daily_forecast_data.forecast_id WHERE daily_forecast.language_id = 1 AND daily_forecast.date = '$today' AND daily_forecast_data.region_id = '$edid' ";
                                  $query = $this->db->query($check);
                                   if($query->result_array() == null){ $ct++;
                                      $daily_missing[] = $daily_regions[$i];
                                   }else{

                                   }
                                   $i++;
                                }
                              }else{
                                $ct++;
                              }
                              
                               //Ends Handles checking for the seasonal forecast
                                              
                             ?>
            <!-- end--------------------------------------------------- -->
                             
                             <li class="dropdown">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
                                
                                <span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span>
             <!-- --------------------------new code -->
                                <?php
                                // $ct=0;
                                    if($ct > 0){
                                        ?>
                                         <span class="badge" style="position: absolute; top: 5px; right: 4px; padding: 4px 6px; border-radius: 60%; background: red; color: white;">
                                            <?php echo $ct; ?></span>
                                      <?php 
                                    }
                                ?>
                <!-- ------------------------------------- -->
                             </a>
                             <ul class="dropdown-menu">

                              <?php 
                              if($ct < 1){ ?>
                                    <li><a href="#">All forecasts updated</b></a></li> 
                                 <?php 

                              }else{
                                if($there_is == false){?>
                                    <li><a href="<?php echo base_url('index.php/Daily_forecast') ?>" style="color: red">6 Hourly Daily Forecast Data Unavailable</a></li> 
                                 <?php 
                                }else{
                                   if(isset($daily_missing) && sizeof($daily_missing) > 0){ ?>
                                      <li><a href="<?php echo base_url('index.php/daily_forecast/daily_forecast_data')."/".$daily_forecast_id ?>" style="color: red">Daily Forecast Missing Region Data</a></li> 
                                   <?php 
                                      foreach ($daily_missing as $k) { ?>
                                        <li><a href="<?php echo base_url('index.php/daily_forecast/addnewforecastdata').'/'.$daily_forecast_id  ?>"><?php echo $k; ?></a></li> 
                                     <?php }
                                  }
                                }

                                if($exist == false){ ?>
                                      <li><a href="#" style="color: red">Seasonal Forecast Data Unavailable</a></li> 
                                   <?php 

                                }else{
                                  if(isset($missing) && sizeof($missing) > 0){ ?>
                                      <li><a href="<?php echo base_url('index.php/Season/showareaforecast').'/'.$forecast_id  ?>" style="color: red">Seasonal Forecast Missing Region Data</a></li> 
                                       <?php 
                                          foreach ($missing as $k) { ?>
                                            <li><a href="<?php echo base_url('index.php/Season/createregionforecast').'/'.$forecast_id  ?>"><?php echo $k; ?></a></li> 
                                         <?php }
                                  }
                                }
                              }
                              
                               ?>
                              
                              </ul>
                                   

                 <!--==================================================================  -->
                                    
                                 
        <!-- ================================================================================== -->

                                                                      
                             
                             </li>
                             <!-- User Account: style can be found in dropdown.less -->       <li class="dropdown user user-menu"> 
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url()?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/img/avatar5.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
                               </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo base_url()?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/img/avatar5.png" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo $_SESSION['username']; ?>
                                            
                                           <!-- <small>Member since Nov. 2016</small>-->
                                        </p>
                                    </li>
                                    
                                    <li class="user-footer">
                                  
                                        <center><div>
                                            <?php
                                            echo anchor('index.php/auth/logout','Log out',array('class'=>'btn btn-default btn-flat'));
                                            ?>
                                            
                                            
                                        </div></center>
                                    </li>
                                </ul>
                               
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                           
                        </ul>
                    </div>
                </nav>
            </header>
            
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar" style="background-color:;">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar" >
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url()?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/img/avatar5.png" class="img-circle" alt="User Image">                           
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $_SESSION['username']; ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <div>
                    
                  <!-- <p><?php 
                               if($_SESSION['first_time_login']==1){?>
                               <a href="<?php// echo base_url(); ?>index.php/Auth/change_pass"><button type="button" class="btn">Change password</button></a><?php
                            
                               }?></p> -->
                    </div>
                  <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                      
                          <?php   echo "<li>" . anchor('index.php/Landing', "<i class='fa fa-laptop'></i> <span>" . strtoupper('Dashboard')) . "</span></li>"; ?>
                        
                        <?php
                        //$define = ""
                        $menu = $this->db->get_where('menu', array('is_parent' => 0,'is_active'=>1));
                        $cp = 0;
                        foreach ($menu->result() as $m) { $cp++;
                            // check for submenu
                            $submenu = $this->db->get_where('menu',array('is_parent'=>$m->id,'is_active'=>1));
                            if($submenu->num_rows()>0){ ?>

                              <li class="">
                                  <a href="#<?=$cp ?>" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class='<?=$m->icon ?>'></i><span><?php echo strtoupper($m->name) ?></span><i class="fa fa-angle-down pull-right"></i></a>
                                  <ul class="collapse <?php echo (($cur_parent==$m->id)?'active':"") ?>" id="<?=$cp ?>">
                                    <?php foreach ($submenu->result() as $s) : ?>
                                        <li style="padding: 5px 0 5px 0">
                                            <a href="<?php echo base_url($s->link) ?>"><i class='<?=$s->icon ?>'></i>&nbsp;&nbsp;<span><?php echo strtoupper($s->name) ?></span></a>
                                        </li>
                                  <?php endforeach; ?>
                                  </ul>
                                </li>

                              <?php
                            }else{
                                echo "<li>" . anchor($m->link, "<i class='$m->icon'></i> <span>" . strtoupper($m->name)) . "</span></li>";
                            }
                            
                        }
                        ?>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
              <div class = "alert alert-danager" style="margin-bottom: -30px"><?php echo $this->session->flashdata('message');?></div>
                <?php     
              
           if($change == 1){
        $this->load->view("daily_forecast_form");


          }else if($change == 0){

                    $this->load->view("landing_index");

        }else if($change == 3){
        $this->load->view("daily_forecast_list.php");


        }else if($change == 4){
         $this->load->view("decadal_forecast_list.php");


        }else if($change == 2 || $change == 12){
        
         $this->load->view("decadal_forecast_list");

        }
        else if($change == 5){

         $this->load->view("advisory_list.php");

        }
        else if($change == 6 || $change==7 || $change == 22 || $change== 23){
         $this->load->view("advisory_form");
        
        }
        else if($change == 8){
         $this->load->view("admin_advisory_read");
        
        }
        else if($change == 9){
         $this->load->view("advisory_change");
        }
        else if($change == 10){
         $this->load->view("daily_forecast_read");
        }
        else if($change == 11){
         $this->load->view( 'decadal_forecast_read');
        }else if($change == 13){
         $this->load->view( 'daily_forecast_read');
        }
        else if($change == 14){
         $this->load->view( 'season_form');
        }
        else if($change == 15){
         $this->load->view( 'season_list');
        }
        else if($change == 16){
         $this->load->view( 'season_read');
        }else if($change == 17){
                    $this->load->view( 'feedback');
                }else if($change == 18 || $change == 19){
                    $this->load->view( 'user_feedback_list');
                }else if($change == 20){
                    $this->load->view( 'user_feedback_read');
                }else if($change == 21){
                    $this->load->view( 'graph_show');
                }else if($change ==24){
                    $this->load->view('user_create');
                }else if($change ==26){
                    $this->load->view('user_edit');
                }else if($change ==27){
                    $this->load->view('user_list');
                }else if($change ==24){
                    $this->load->view('user_create');
                }else if($change ==34){
                    
                    $this->load->view('auth/new_password');
                }else if($change==28){
                    $this->load->view('inactive_user_list.php');
                }
                else if($change == 33){
                    $this->load->view('daily_forecast_archive_list');
                }
                else if($change == 36){
                    $this->load->view('daily_forecast_single_form');
                }
                else if($change == 37){
                    $this->load->view('daily_pdfprint');
                }
                else if($change ==38){
                    $this->load->view('ussdcount');
                }
                else if($change ==39){
                    $this->load->view('ussdcount_display');
                }
                else if($change == 40 || $change == 41){
                    $this->load->view('read_user_feedback_list');
                }
                else if($change == 42){
                    $this->load->view('read_user_feedback_read');
                }
                else if($change == 43){
                    $this->load->view('feedback_graph');
                }
                else if($change == 44){
                    $this->load->view('ussdRequest_graph');
                }
                else if($change == 45){
                    $this->load->view('trend_graph');
                }
        else if($change == 46){
                    $this->load->view('region_view');
                }
               else if($change == 47){
                    $this->load->view('division_view');
                }
        else if($change == 48){
                    $this->load->view('city_view');
                }
        
        else if($change == 49){
                    $this->load->view('region_form');
                }
        else if($change == 50){
                    $this->load->view('division_form');
                }
                else if($change == 51){
                    $this->load->view('city_form');
                }//Major and Minor Sector Views
                else if($change == 52){
                    $this->load->view('terminologies_view');
                }
                else if($change == 53){
                    $this->load->view('terminology_form');
                }
        else if($change == 54){
                    $this->load->view('sub_region_view');
                }
        else if($change == 55){
                    $this->load->view('sub_region_form');
                }
                else if($change == 61){
                    $this->load->view('major_view');
                }
                else if($change == 62){
                    $this->load->view('major_form');
                }
                else if($change == 63){
                    $this->load->view('minor_view');
                }
                else if($change == 64){
                    $this->load->view('minor_form');
                }//end of major and minor sector views
        else if($change == 65){
                    $this->load->view('daily_forecast_time_view');
                }
                else if($change == 66){
                    $this->load->view('daily_forecast_time_form');
                }
                else if($change == 67){
                    $this->load->view('season_view');
                }
                else if($change == 68){
                    $this->load->view('seasons_form');
                }
                else if($change == 69){
                    $this->load->view('impacts_view');
                }
                else if($change == 70){
                    $this->load->view('impacts_form');
                }
                else if($change == 71){
                    $this->load->view('dekadal_forecast_form');
                }
                else if($change == 72){
                    $this->load->view('area_form');
                }
                else if($change == 73){
                    $this->load->view('area_view');
                } 
                else if($change == 74){
                    $this->load->view('posible_advisoriesForm');
                }
                else if($change == 75){
                    $this->load->view('advisories_list');
                }   
         else if($change == 76){
                    $this->load->view('area_decadal_list');
                }
         else if($change == 77){
                    $this->load->view('decadal_area_form');
                }
        else if($change == 78){
          $this->load->view('daily_forecast_data_list');
        }else if($change == 79){
          $this->load->view('daily_forecast_data_form');
                }
                else if($change == 80){
                    $this->load->view('forecast_impact_data_list');
                  }else if($change == 81){
                    $this->load->view('forecast_impact_form');
                  }else if($change == 82){
                    $this->load->view('dekadal_advisory_list');
                  }else if($change == 83){
                    $this->load->view('dekadal_advisory_form');
                  }

                  else if($change == 84){
                    $this->load->view('daily_advisory_list');
                  }else if($change == 85){
                    $this->load->view('daily_advisory_form');
                  }
                  else if($change == 86){
                    $this->load->view('daily_advisory_read');
                  }
                  else if($change == 87){
                    $this->load->view('dekadal_advisory_read');
                  } else if($change == 88){
                    $this->load->view('USSD_list');
                  }else if($change == 89){
                    $this->load->view('USSD_lang_form');
                  }else if($change == 90){
                    $this->load->view('USSD_read');
                  }else if($change == 91){
                    $this->load->view('CSV_view');
                  }
                  else if($change == 92){
                    $this->load->view('audio_clip_list');
                  }
                  else if($change == 93){
                    $this->load->view('audio_clip');
                  }



                  else if($change == 100){
                    $this->load->view('victoria_list');
                  }
                  else if($change == 101){
                    $this->load->view('victoria_form');
                  }
                  else if($change == 102){
                    $this->load->view('victoria_area_data');
                  }
                  else if($change == 103){
                    $this->load->view('victoria_area_form');
                  }else if($change == 104){
                    $this->load->view('victoria_read');
                  }else if($change == 105){
                    $this->load->view('pdf_uploader');
                  }else if($change == 106){
          $this->load->view('daily_forecast_data_form24');
                }else if($change == 107){
                    $this->load->view('pdf_uploader24');
                }else if($change == 108){
                    $this->load->view('CSV_view24');
                  }

                  //-----------------------------------
                   else if($change == 109){
                    $this->load->view('disaster_list');
                  } else if($change == 110){
                    $this->load->view('disaster_form');
                  } else if($change == 113){
                    $this->load->view('updates_list');
                  } else if($change == 114){
                    $this->load->view('updates_form');
                  }
                  else if($change == 115){
                    $this->load->view('area_data_view');
                  }




                  else if($change == 116){
                    $this->load->view('broadcast');
                  }else if($change == 117){
                    $this->load->view('ussd_daily_users_req');
                  }else if($change == 118){
                    $this->load->view('ussd_user_feedback');
                  }else if($change == 119){
                    $this->load->view('reply_user');
                  }else if($change == 120){
                    $this->load->view('district_coverage');
                  }else if($change == 121){
                    $this->load->view('ussd_daily_users_req_hourly');
                  }else if($change == 122){
                    $this->load->view('ussd_frequent_users');
                  }else if($change == 123){
                    $this->load->view('view_ussd_frequent_users');
                  }else if($change == 124){
                    $this->load->view('view_feedback_reply');
                  }else if($change == 125){
                    $this->load->view('requested_sectors');
                  }else if($change == 126){
                    $this->load->view('subscriptions');
                  }

                ?>
                
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 
                    <?php 
                        echo $this->config->item('dissemination_version');
                    ?>
                </div>
                <strong>Copyright &copy; <?php echo date('Y');?>  <a href="http://wimea.mak.ac.ug/" target="_blank">WIMEA-ICT</a>.</strong> All rights reserved.
            </footer>

            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        
    <!-- link for date picker -->
    <!--<script src="<?php echo base_url(); ?>assets/frameworks/adminlte/js/bootstrap-datetimepicker.min.js"></script> -->
       <script src="<?php echo base_url(); ?>assets/<?php echo $this->config->item('theme');?>/frameworks/adminlte/js/bootstrap-datetimepicker.js"></script>
     <!-- page script -->
     <script>
       $(function(){
       $(".form_datetime").datetimepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        startDate: new Date(),
        minuteStep: 60
    });

     });
      $("#date_from").change(function() {
        var selection=$("#date_from").val();
        //$("#date_to").val(selection);
        var date1 = new Date(selection);
        var diffDays = Math.ceil(10 * (1000 * 3600 * 24)); 
        var newd = Math.abs(date1.getTime() + diffDays);
        var det = new Date(newd);
        var month = (det.getMonth() + 1);
        var dt =  det.getDate();
            if (dt < 10) {
                  dt = '0' + dt;
                    }
                 if (month < 10) {
                     month = '0' + month;
                   }

        var fin =   det.getFullYear() + '-' + month + '-' + dt ;
        $("#date_to").val(fin);
         $("#date_s").val(fin);
       
      });
     </script>
        <script>
            $("#pic").change(function() {

                var val = $(this).val();

                switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                   // case 'jpeg': case 'jpg': case 'png': case 'PNG':
                    case 'mp3':
                    //alert("an image");
                    break;
                    default:
                        $(this).val('');
                        // error message here
                        alert("Only MP3 files are allowed ");
                        break;
                }
            });
            $("#pic1").change(function() {

                var val = $(this).val();

                switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                      case 'jpeg': case 'jpg': case 'png': case 'PNG':
                        //alert("an image");
                        break;
                    default:
                        $(this).val('');
                        // error message here
                        alert("Only jpeg, jpg and PNG files allowed");
                        break;
                }
            });
        </script>

        <script>
            $(function () {
                $("#example1").DataTable();
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            });
            
            $(".treeview").on("click")({
     $(".treeview").addClass("active");
            });


        </script> 
    </body>
    <script type="text/javascript">
  
  $("#region").change(function(){
      var selection=$("#region").val();
      if(selection== 1 ){
          var opt = "Select option";
          var options="<option value = 1 >SOUTH WESTERN</option>";
              options+="<option value = 2 >WESTERN CENTRAL</option>";
          


          $("#opt_type").html(opt);
          $("#subregion").html(options);


      }else if(selection== 2){
          var opt = "Select option";
          var options="<option value = 3 >CENTRAL AND WESTERN LAKE VICTORIA BASIN</option>";
    options+="<option value = 4 >WESTERN PARTS OF CENTRAL</option>";
    options+="<option value = 5 >EASTERN PARTS OF CENTRAL</option>";

          $("#opt_type").html(opt);
          $("#subregion").html(options);
      }else if(selection== 4){
          var opt = "Select option";
          var options="<option value = 6 >EASTERN LAKE VICTORIA AND SOUTH EASTERN</option>";
              options+="<option value = 7 >EASTERN CENTRAL</option>";
              options+="<option value = 8 >NORTH EASTERNL</option>";
          $("#opt_type").html(opt);
          $("#subregion").html(options);
      }else if(selection== 5){
          var opt = "Select option";
          var options="<option value = 9 >EASTERN PARTS OF THE NORTHERN REGION</option>";
          options+="<option value = 10 >CENTRAL NORTHERN PARTS</option>";
          options+="<option value = 11 >NORTH WESTERN</option>";
          $("#opt_type").html(opt);
          $("#subregion").html(options);
      }
  });
</script>


<script src="<?php echo base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>assets/plugins/knob/jquery.knob.js"></script>

<script src="<?php echo base_url() ?>assets/plugins/chartjs/Chart.min.js"></script>






</html>

