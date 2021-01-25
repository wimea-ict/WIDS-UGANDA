<!DOCTYPE html>
<html><head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"><!-- Global site tag (gtag.js) - Google Analytics -->
	<link href="<?php echo base_url(); ?>assets/frameworks/adminlte/css/request_page.css" rel="stylesheet"><link href='https://fonts.googleapis.com/css?family=Roboto:100,300,700,400' rel='stylesheet' type='text/css'><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css'><script async src="https://www.googletagmanager.com/gtag/js?id=UA-133419491-1"></script><script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', 'UA-133419491-1');</script>

	<title>Weather Information Dissemination System</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/ionicons/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/adminlte.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        	folder instead of downloading all of them to reduce the load. -->
        	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/skins/_all-skins.min.css">
        	<!--begin page css link-->
        	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/begin.css">
        	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/styles.css">
        	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/widgets.css">
        	<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/animate.css">

        	<!-- jQuery 2.1.4 -->
        	<script src="<?php echo base_url() ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        	<!-- Bootstrap 3.3.5 -->
        	<script src="<?php echo base_url() ?>assets/frameworks/bootstrap/js/bootstrap.min.js"></script>
        	<!-- DataTables -->
        	<script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        	<script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        	<!-- SlimScroll -->
        	<script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        	<!-- FastClick -->
        	<script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.min.js"></script>
        	<!-- AdminLTE App -->
        	<script src="<?php echo base_url() ?>assets/frameworks/adminlte/js/app.min.js"></script>
        	<!-- AdminLTE for demo purposes -->
        	<script src="<?php echo base_url() ?>assets/frameworks/adminlte/js/demo.js"></script>
        	<!-- notifying -->
        	<script src="<?php echo base_url() ?>assets/plugins/notify/notify.min.js"></script>
        	<style>

        		.wrapper{
        			background-image: url("<?php echo base_url() ?>assets/frameworks/adminlte/img/trythis.jpg");

        		}
        		.main-sidebar{
        			background-image: url("<?php echo base_url() ?>assets/frameworks/adminlte/img/trythis.png");

        		}

        	</style>
        	<script type="text/javascript">
        		$(document).ready(function(){

        			$(".tabs-list li a").click(function(e){
        				e.preventDefault();
        			});

        			$(".tabs-list li").click(function(){
        				var tabid = $(this).find("a").attr("href");
     $(".tabs-list li,.tabs div.tab").removeClass("active");   // removing active class from tab

     $(".tab").hide();   // hiding open tab
     $(tabid).show();    // show tab
     $(this).addClass("active"); //  adding active class to clicked tab

 });

        		});
        	</script>
        	<script type="text/javascript" src="<?php echo base_url() ?>assets/frameworks/gritter/js/jquery.gritter.js"></script>
        	<script type="text/javascript" src="<?php echo base_url() ?>assets/frameworks/gritter/gritter-conf.js"></script>
        	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/gritter/css/jquery.gritter.css" />


        </head>
        <body class="hold-transition skin-blue sidebar-mini" style="overflow-y: hidden;">

        	<?php $dist=""; ?>
        	<div class = "wrapper" style="background-color:lavender; " >
        		<div class="row" >
        			<header class="main-header">
        				<a href="#" class="logo" style="margin-left: 15px;"  >
        					<!-- mini logo for sidebar mini 50x50 pixels -->
        					<span class="logo-mini"><b>W</b>IDS</span>
        					<!-- logo for regular state and mobile devices -->
        					<span class="logo-lg" ><h6>WEATHER INFORMATION DISSEMINATION SYSTEM</h6></span>
        				</a>
        				<!-- Header Navbar: style can be found in header.less -->
        				<nav class="navbar navbar-static-top" role="navigation">
        					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="margin-left: 15px">
        						<span class="sr-only">Toggle navigation</span>
        						<span class="icon-bar"></span>
        						<span class="icon-bar"></span>
        						<span class="icon-bar"></span>
        					</a>
        					<div class="navbar-custom-menu" style="margin-right: 30px">
        						<ul class="nav navbar-nav">


        							<li style=" text-align:left; padding-top:4%">
        								<!-- <form method="post" action="<?php //site_url('index.php/auth/index') ?>"> -->
        									<span style="color:white;font-weight:bold"><?= ucwords( $this->lang->line('msg_language')); ?>:
        									</span>
        									<select class="abc"  class="form-control" name="language" >
        										<?php 
        										if(isset($languages)){
        											foreach($languages as $fd){
        												?>
        												<option value="<?php echo $fd->name; ?>" <?php if($this->session->userdata('site_lang') == strtolower($fd->name)){ echo 'selected="selected"'; }?>> <?php  echo $fd->name; ?></option>
        												<?php                 
        											}             
        										}         
        										?> 
        									</select> 
        								</li>

        								<li><?php echo anchor(site_url('index.php/Map/index'), "<span class='glyphicon glyphicon-globe'></span>" . strtoupper('Live Map'));?></li>

        								<li><?php echo anchor(site_url('index.php/auth/load_login'), "<span class='glyphicon glyphicon-log-in'></span> " . strtoupper($this->lang->line('msg_login')));?></li>
        							</ul>
        						</div>

        					</nav>

        				</header>

        			</div>

        			<!-- Perfect location -->
        			<div class="content-wrapper" style="overflow-y: scroll;height: 75vh">
        				<div class="col-md-12" style="background-color: #ecf0f5;" >
        					<section class="content-header" style="background-color:lavender ;padding-bottom: 10px">
        						<h1 style="text-align: center;"></h1>
        					</section>
        					<?php   
         //Get Division_Name for currently displaying information
        					if(isset($division_name)){
        						foreach($division_name as $dn){
        							$div_name = $dn->division_name;
        						}
        					}
         //-----------------------------------------
        					if(isset($daily_forecast_data)){ 
        						foreach($daily_forecast_data as $d){
        							$date = $d->date;
        							$weather = $d->weather;
        							$issuedate = $d->issuedate; 
        							$validitydate = $d->validitytime;     
        						}
        					}
        					$Currentdate = date('Y-m-d');
        					?>   


        					<!-- SELECTED DAILY FORECAST CARD STARTS HERE -->
        					<?php 
        					if($category1 == "Daily Forecast"){ ?>
        						<div id="daily_forecast" >
        							<a  href ="<?php site_url('index.php/auth/index') ?>" style="float: right;" class="glyphicon glyphicon-remove-sign"> 
        							</a>
        							<!-- Daily forecast from user request -->
        							<h4>
        								<b><?=strtoupper($this->lang->line('msg_daily_forecast')) ?> - <?php $dist=$div_name; echo strtoupper($div_name);  ?>
        								<div style="background-color: cornflowerblue;height: 2.5px;margin-top: 10px; width: 100%;"></div>
        							</b>
        						</h4> 

        						<?php $count = 0;$counter =1;
        						foreach($daily_forecast_region_data_24 as $fd){$now = $today; $count ++;}

           // Very important
        						$day1 = date("l", strtotime($fd->forecasted));
        						$next_day = date('Y-m-d', strtotime(' +1 day',strtotime($fd->forecasted))); 
        						$day2 = date("l", strtotime($next_day));

            // East African timezone
        						date_default_timezone_set('Africa/Nairobi');
        						$actual_time = date('Y-m-d g:ia');
            //This is the forecast 's next day at 6:00pm when the forecast expires
        						$next_day_with_time = date('Y-m-d g:ia', strtotime($next_day.'6:00pm'));

        						if( (strtotime(date('Y-m-d g:ia')) >= strtotime($fd->forecasted)) && (strtotime(date('Y-m-d g:ia')) <= strtotime($next_day_with_time)) && $counter <4){ $counter++; ?>

        							<h5><b><?= $this->lang->line('msg_issue'); ?>:</b>&nbsp; <?php echo date('jS F Y', strtotime( $fd->issuedate))?></h5>
        							<p><b style="color: cornflowerblue;"><?= $this->lang->line('msg_summary'); ?>:</b>&nbsp;<br>
        								<?php echo $fd->weather;?></p>
        								<table class="table table-bordered" >
        									<thead>
        										<tr>
        											<th scope="col"><?= $this->lang->line('msg_time'); ?></th>
        											<th scope="col"><?= $this->lang->line('msg_weather'); ?></th>
                                                    <!-- <th scope="col">Max Temp</th>
                                                    	<th scope="col">Min Temp</th> -->
                                                    	<th scope="col"><?= $this->lang->line('msg_temperature'); ?></th>
                                                    	<th scope="col"><?= $this->lang->line('msg_wind_strength'); ?></th>        
                                                    	<!-- <th scope="col">Wind Strength</th>                               -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php 
                                                   if(isset($daily_forecast_region_data_24)){
                                                      foreach($daily_forecast_region_data_24 as $fd){
                                                         $next_day_with_time = date('Y-m-d g:ia', strtotime(date('Y-m-d', strtotime(' +1 day',strtotime($fd->forecasted))).'6:00pm'));
                                                         if( (strtotime(date('Y-m-d g:ia')) >= strtotime($fd->forecasted)) && (strtotime(date('Y-m-d g:ia')) <= strtotime($next_day_with_time)) ){
                                                            ?>
                                                            <tr>
                                                               <td scope="row" data-label="Time">

                                                                  <?php
                                                                  $day1 = date("l", strtotime($fd->forecasted));
                                                                  $next_day = date('Y-m-d', strtotime(' +1 day',strtotime($fd->forecasted))); 
                                                                  $day2 = date("l", strtotime($next_day));
                                                                  $dd = "SELECT * FROM forecast_time WHERE id='$fd->timing'";
                                                                  $ddd = $this->db->query($dd);
                                                                  foreach ($ddd->result_array() as $rowss) {

                                                                     if(($rowss['id'] == 2) || ($rowss['id'] == 3) || ($rowss['id'] == 1)){
                                                                        echo "<b>".ucwords($day2)."</b><br>";
                                                                    }else{
                                                                        echo "<b>".ucwords($day1)."</b><br>";
                                                                    }
                                                                    echo ucwords($rowss['period_name'])."<br>( ".ucwords($rowss['from_time'])."-".ucwords($rowss['to_time'])." )";


                                                                } ?>
                                                            </td>

                                                            <td data-label="Weather" >
                                                              <figure>
                                                                 <svg class="icon" style="width: 100px;height: 70px;" viewbox="0 0 100 100">
                                                                    <?php if(ucwords($rowss['period_name']) == "Evening" || ucwords($rowss['period_name']) == "Early Morning") echo '<use xlink:href="#moon" x="-20" y="-15"/>';
                                                                    else echo '<use xlink:href="#sun" x="-12" y="-18"/>';
                                                                    echo $fd->svg_data; ?>
                                                                </svg>
                                                            </figure>

                                                            <?php echo ucwords($fd->cat_name)  ?>
                                                        </td>
                            <!-- <td data-label="Max Temp"><?php  //if($fd->max_temp==0){print('-');}else{echo $fd->max_temp; ?> &deg;C <?php //} ?></td>
                            	<td data-label="Min Temp"><?php //if($fd->min_temp==0){print('-');}else{echo $fd->min_temp;?> &deg;C <?php// }  ?></td> -->
                            	<td data-label="Temperature"><?php echo $fd->mean_temp; ?> &deg;C</td>  
                            	<td data-label="Wind Direction"><?php echo $fd->wind_direction; ?></td>          
                            	<!-- <td data-label="Wind Strength"><?php //echo $fd->wind_strength; ?></td>                -->
                            </tr>
                            <?php  


                        } }  } ?>
                    </tbody>
                </table>
                <h5><b style="color: cornflowerblue;"><?= $this->lang->line('msg_valid_till'); ?> : </b> &nbsp; <strong style="color:red">  <?php echo $next_day.' @ '. $fd->validitytime;; ?></strong></h5>
                <br>
                <!-------ADDED NEW ADVISORIES DISPLAY-------- -->
                <div class="box box-default collapsed-box">
                	<div class="box-header with-border" style="margin-left: -10px">
                		<button type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 10px;margin-right: 20px; width: 180px"><i style ="font-color: green;" class="fa fa-plus"><?= $this->lang->line('msg_advisory'); ?></i></button>
                		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal" style="margin-top: 10px; width: 180px"> <?= $this->lang->line('msg_feedback'); ?> </button>

                	</div>


                	<div class="box-body">
                		<?php  if(isset($daily_advice_home)){ foreach ($daily_advice_home as $advice) :  ?>
                			<div id="advisory">
                				<table class="advice_table">
                					<tr style="background-color: powderblue;">
                						<td><?= ucwords($this->lang->line('msg_sector')); ?></td>
                						<td><?=$advice['minor_name'] ?></td>
                					</tr>
                					<tr>
                						<td>Advice</td><td><?=$advice['advice'] ?></td>
                					</tr>
                					<tr> <td><?= ucwords($this->lang->line('msg_message')); ?></td><td><?=$advice['message_summary'] ?></td> </tr>
                				</table>
                			</div>
                			<?php $flag = true; endforeach;} if($flag == false){

	                  // echo "<p>".$this->lang->line('msg_nodata')."</p>"; 
                			}?>
                		</div>
                	</div> 

                	<!-- LOGOS -->

                	<div class="row">
                		<h4 class="sponsors"><b><i><?= $this->lang->line('msg_brought_to_you'); ?>:</i></b></h4>
                		<section class="customer-logos slider">
                			<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                			<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                			<div class="slide" ><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                			<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                			<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                			<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                			<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                		</section>
                	</div>


                <?php  }else{
                // echo "<p>".$this->lang->line('msg_nodata')."</p>";

                 // 6 Hours forecast
                	$count = 0;
                	foreach($daily_forecast_region_data as $fd){$now = $today; $count ++;}
                	if($now == date('Y-m-d') && $count>0){ ?>
                		<h5 id='daily_forecast_head'>Today's Forecast</h5>
                		<div id='daily_forecast_desc_und'></div>
                		<h5><?= $this->lang->line('msg_issue'); ?>:&nbsp; <?php echo date('jS F Y', strtotime( $fd->issuedate))?></h5>
                		<p><?= $this->lang->line('msg_summary'); ?>&nbsp;<br><ul>
                			<?php  foreach($daily_forecast_region_data as $fd){ echo '<li>'.$fd->weather.'</li>';}    ?></ul></p>
                			<table class="table table-bordered" >
                				<thead>
                					<tr>
                						<th scope="col"><?= $this->lang->line('msg_time'); ?></th>
                						<th scope="col">Weather</th>
                    <!-- <th scope="col">Max Temp</th>
                    	<th scope="col">Min Temp</th> -->
                    	<th scope="col"><?= $this->lang->line('msg_temperature'); ?></th>
                    	<!-- <th scope="col">Wind Speed</th> -->
                    	<th scope="col"><?= $this->lang->line('msg_wind_strength'); ?></th>        
                    	<!-- <th scope="col">Wind Strength</th>                               -->
                    </tr>
                </thead>
                <tbody>
                	<?php 
                	if(isset($daily_forecast_region_data)){
                		foreach($daily_forecast_region_data as $fd){ ?>
                			<tr>
                				<td scope="row" data-label="Time"><?php  echo ucwords( $fd->time).'<br>'; 
                				if($fd->time=="Early Morning") echo '( 12:00am - 06:00am )';
                				else if($fd->time=="Late Morning") echo "( 06:00am - 12:00pm )"; 
                				else if($fd->time=="Afternoon") echo "( 12:00pm -06:00pm )"; 
                				else if($fd->time=="Late Afternoon") echo "( 12:00pm -06:00pm )";
                				else if($fd->time=="Evening") echo "06:00pm-12:00am";
                				else echo " ";

                				?></td>
                				<td data-label="Weather"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/<?php echo $fd->img ?>" height="50" width="50"> <?php echo ucwords($fd->cat_name);  ?></td>
                            <!-- <td data-label="Max Temp"><?php  //if($fd->max_temp==0){print('-');}else{echo $fd->max_temp; ?> &deg;C <?php //} ?></td>
                            	<td data-label="Min Temp"><?php //if($fd->min_temp==0){print('-');}else{echo $fd->min_temp;?> &deg;C <?php// }  ?></td> -->
                            	<td data-label="Temperature"><?php echo $fd->mean_temp; ?> &deg;C</td>
                            	<!-- <td data-label="Wind Speed"><?php //echo $fd->wind; ?></td>     -->
                            	<td data-label="Wind Direction"><?php echo $fd->wind_direction; ?></td>          
                            	<!-- <td data-label="Wind Strength"><?php //echo $fd->wind_strength; ?></td>                -->
                            </tr>
                            <?php  


                        }  } ?>
                    </tbody>
                </table>
                <h5><?= $this->lang->line('msg_valid_till'); ?> : &nbsp; <strong style="color:red"><?php echo $fd->validitytime;; ?></strong></h5>
                <br>


                <!-------ADDED NEW ADVISORIES DISPLAY-------- -->
                <div class="box box-default collapsed-box">
                	<div class="box-header with-border" style="margin-left: -10px">
                		<button type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 10px;margin-right: 20px; width: 180px"><i style ="font-color: green;" class="fa fa-plus"><?= $this->lang->line('msg_advisory'); ?></i></button>
                		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal" style="margin-top: 10px; width: 180px"> <?= $this->lang->line('msg_feedback'); ?></button>
                	</div>
                	<div class="box-body">
                		<?php  if(isset($daily_advice_home)){ foreach ($daily_advice_home as $advice) :  ?>
                			<div id="advisory">
                				<table class="advice_table">
                					<tr style="background-color: powderblue;">
                						<td><?= ucwords($this->lang->line('msg_sector')); ?></td>
                						<td><?=$advice['minor_name'] ?></td>
                					</tr>
                					<tr>
                						<td>Advice</td><td><?=$advice['advice'] ?></td>
                					</tr>
                					<tr> <td><?= ucwords($this->lang->line('msg_sector')); ?></td><td><?=$advice['message_summary'] ?></td> </tr>
                                    </table><?= $this->lang->line('msg_nodata'); ?>
                                </div>
                                <?php $flag = true; endforeach;} if($flag == false){echo "<p>".$this->lang->line('msg_nodata')."</p>"; }?>
                            </div>
                        </div>      

                    <?php  }else{ echo "<p>".$this->lang->line('msg_nodata')."</p>"; } } ?> 
                </div>

            <?php  }else if($category1 == "Dekadal Forecast"){ ?>

               Dekadal Pending
               <?php
           }else if($category1 == "Victoria Forecast"){
               ?>

               <div id="daily_forecast">
                  <a  href ="<?php site_url('index.php/auth/index') ?>" style="float: right;" class="glyphicon glyphicon-remove-sign"> </a>
                  <?php 
            //print_r($requested_landing_site); print($submitted);

                  foreach($requested_landing_site as $row){ 
                     $landing_site = $row['site_name'];

                 }

                 ?> 
                 <h4><b>24-HOUR FISHERMEN FORECAST FOR <?=$landing_site?> LANDING SITE</b></h4>
                 <div style="background-color: cornflowerblue;height: 2.5px;margin-top: 10px; width: 100%;"></div>
                 <?php $dt = ""; $cd = 0;
                //print_r($victoria_forecast);
                 foreach($victoria_forecast_request as $dd){ 
                     $dt = $dd['forecast_date'];
                     if((date('Y-m-d') >= $dt) && (strtotime(date('Y-m-d')) <= strtotime(date('Y-m-d', strtotime($dt. '+1 day'))))){
                        $cd = 1;
                    }
                } 
                ?>
                <?php  if(isset($victoria_forecast_request) && sizeof($victoria_forecast)>1 && $cd == 1){ $counter = 0;?>
                 <?php foreach($victoria_forecast_request as $dd){ ?>  
                    <p style="font-weight: bold;font-size: 16px;padding-top: 10px;"> <?= $this->lang->line('msg_issue'); ?>: <?php
                    echo date('jS F Y', strtotime($dd['issue_date']));?> </p>
                    <p>Advice :&nbsp; <?php echo $dd['advice'] ?></p>
                    <p style="font-weight: bold;font-size: 16px;padding-top: 10px;"> Map Showing Position of the Zones</p>
                    <div style="display: flex; justify-content: center;">
                       <img class=figures_only" style="width: 60%;height: 60%" src="<?php echo site_url('assets/frameworks/adminlte/img')."/".$dd['map'] ?>">
                   </div>


                   <?php break; } ?> 

                   <table class="table table-bordered">
                       <?php $ct = 0; foreach($victoria_forecast_request as $dd){ $ct++; ?> 

                          <?php if($ct == 1 ) { ?>
                             <tr>
                                <td colspan="8"><h4><b>Landing Site: <?=$dd['site_name']?>, <?php echo $dd['zone'] ?> Zone, <?=$dd['district']?> District</b></h4></td>
                            </tr>
                            <tr>
                                <td style="width: 15%"><b>Highlight</b></td>
                                <td colspan="7"><p><?php echo $dd['highlights'] ?></p></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td>Period</td>
                                <td>Wind Strength</td>
                                <td>Wind Direction</td>
                                <td>Wave Height</td>
                                <td>Weather</td>
                                <td>Rainfall Distribution</td>
                                <td>Visibility</td>
                                <td>Hazards</td>
                            </tr>
                        <?php } ?>

                        <?php  if($ct == 4) $ct=0;  ?>
                        <tr>
                         <td style="width: 15%"><b><?php echo $dd['day_time']; ?></b></td>
                         <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wind_strength']; ?>"><?=$dd['wind_strength_name'] ?></td>
                         <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wind_direction']; ?>"><?=$dd['wind_direction_name'] ?></td>
                         <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wave_height']; ?>"><?=$dd['wave_height_name'] ?></td>
                         <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['weather']; ?>"><?=$dd['weather_name'] ?></td>
                         <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['rainfall_dist']; ?>"><?=$dd['rainfall_dist_name'] ?></td>
                         <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['visibility']; ?>"><?=$dd['visibility_name'] ?></td>
                         <td style="width: 15%; background: <?php echo $dd['harzard']; ?>"></td>
                     </tr>
                 <?php } ?> 
                 <tr>
                  <td style="width: 15%; background: #0F0"></td>
                  <td colspan="7">No severe weather is expected.</td>
              </tr>
              <tr>
                  <td style="width: 15%; background: #FFA500"></td>
                  <td colspan="7">Potentially dangerous weather is expected. <b>Be prepared.</b></td>
              </tr>
              <tr>
                  <td style="width: 15%; background: #F00"></td>
                  <td colspan="7">Dangerous and potentially life-threatening weather conditions are expected. <b>Take immediate action to ensure your safety</b></td>
              </tr>
          </table>
      <?php }else { echo "<p style='padding-top:10px'>Data has not yet been uploaded. Please try again later.</p>";} ?>  


      <div class="row">
        <h4 class="sponsors"><b><i><?= $this->lang->line('msg_brought_to_you'); ?>:</i></b></h4>
        <section class="customer-logos slider">
           <div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
           <div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
           <div class="slide" ><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
           <div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
           <div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
           <div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
           <div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
       </section>
   </div>
</div>

<!-- LOGOS -->

<?php }else if($category1 == "Seasonal Forecast"){?>

  <div id="seasonal_forecast">
     <a  href ="<?php site_url('index.php/auth/index') ?>" style="float: right;" class="glyphicon glyphicon-remove-sign"> </a>
     <h4><b><?=strtoupper($this->lang->line('msg_seasonal_forecast')) ?> - <?php $dist=$divisio_name; echo strtoupper($divisio_name); ?>
     <div style="background-color: cornflowerblue;height: 3px;margin-top: 2%; width: 100%;"></div></b>
 </h4>



 <?php 


 $months  = array('JANUARY','FEBRUARY','MARCH','APRIL', 'MAY','JUNE','JULY', 'AUGUST', 'SEPTEMBER','OCTOBER','NOVEMBER', 'DECEMBER');
 $flag = false;$count = 0; foreach ($seasonal_data as $Seasonal) : 
 $season = "unknown";
              //-----COMMENTED OUT 'JF' season is not available
 if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
 else if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
 else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
 else $season = 'SOND';

              // Thie check the year and season we are currently in before desiding to display anything
 if(date('Y') == $Seasonal['year'] &&( ($Seasonal['abbreviation']) == $season)){
                // Set flag to true since there is data for that season in the database
     $flag = true;
     if($count == 0){ 
        ?>

        <p style="font-weight: bold;font-size: 16px;">Issue Date: <?php
        echo date('jS F Y', strtotime($Seasonal['issuetime']));
                    // echo $date_struct[2].' '.$months[$date_struct[1]-1].' '.$date_struct[0]  ?></p> 
                    <p class="season_head"><?php $m = '';
                    if( $Seasonal['abbreviation'] == 'SOND') $m = 'SEPTEMBER-OCTOBER-NOVEMBER AND DECEMBER'; 
                    else if( $Seasonal['abbreviation'] == 'MAM') $m = 'MARCH-APRIL AND MAY'; 
                    else if( $Seasonal['abbreviation'] == 'JJA') $m = 'JUNE-JULY AND AUGUST'; 
                    else if( $Seasonal['abbreviation'] == 'JF') $m = 'JANUARY AND FEBRUARY'; 
                    echo $m.' ('.$Seasonal['abbreviation'].') '.$Seasonal['year']; ?><br>SEASONAL RAINFALL OUTLOOK OVER UGANDA</p>
                    <p class="season_sub_head">1.0  Overiew</p>
                    

                    <?php
                    if (ucwords($this->session->userdata('site_lang')) == "English") {
                    	?>
                    	<p class="season_content"><?php echo $Seasonal['overview']; ?></p>
                    	<?php	
                    }
                    ?>
                    <!-- <p class="season_sub_head">2.0  General Forecast</p>
                    	<p class="season_content"><?php //echo $Seasonal['general_forecast']  ?></p> -->
                    	<p align="center"><img class="figures_only" src="<?php echo base_url() ?>assets/frameworks/adminlte/img/<?php echo $Seasonal['map'] ?>" height="50%" width="50%"></p><br>
                    	<p class="season_sub_head">2.1.0  <?php echo $Seasonal['region_name']  ?> Region</p>
                    	<p class="season_sub_head">2.2.1   <?php echo $Seasonal['sub_region_name']  ?></p>
                    	<p> <?php echo $Seasonal['overall_comment']  ?> </p>
                    	<?php
                    	if ($clip != null) {?>
                    		<p class="season_sub_head"><?= ucwords($this->lang->line('msg_audio')); ?></p>
                    		<audio controls>
                    			<source src="<?php echo base_url('assets/audio').'/'.$clip.".mp3" ?>" type="audio/mp3">
                    				<source src="<?php echo base_url('assets/audio').'/'.$clip.".ogg" ?>" type="audio/ogg">
                    					<source src="<?php echo base_url('assets/audio').'/'.$clip.".wav" ?>" type="audio/wav">
                    					</audio> 
                    					<?php

                    				}
                    				?>



                    				<!-------ADDED NEW ADVISORIES DISPLAY-------- -->


                    				<?php
                    				$sed = $Seasonal['id'];
                    				$disct = $Seasonal['district_id'];
                    				$adds = "";
                    				$gemix = "SELECT disaster_desc from disasters JOIN division ON division.region_id = disasters.region_id WHERE forecast_id = '$sed' AND division.id = '$disct'";
                    				$sql21= $this->db->query($gemix);
                    				$cm = 0;
                    				foreach ($sql21->result_array() as $row1) {$cm++;
                    					$adds .= $row1['disaster_desc']."<br>";
                    				} 
                    				if($cm > 0){  ?>
                    					<div>
                    						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample"
                    						aria-expanded="false" aria-controls="collapseExample" style="margin-left: 10px">
                    						View  Disasters
                    					</button>
                    				</div>
                    				<!-- / Collapse buttons -->

                    				<!-- Collapsible element -->
                    				<div class="collapse" id="collapseExample">
                    					<div class="mt-3" style="padding: 15px">
                    						<?=$adds ?>
                    					</div>
                    					</div> <?php  }
                    					?>


                    					<!-- Disasters -->

                    					<div class="box box-default collapsed-box">
                    						<div class="box-header with-border">
                    							<button type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 15px;width: 180px"><i style ="font-color: green;" class="fa fa-plus" ><?= $this->lang->line('msg_advisory'); ?></i>
                    							</button>
                    							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal" style="margin-top: 15px;width: 180px"> <?= $this->lang->line('msg_feedback'); ?> </button>
                    						</div>
                    						<!-- /.box-header -->
                    						<div class="box-body">
                    							<?php  if(isset($seasonal_advice)) foreach ($seasonal_advice as $advice) : 
                    							?><div id="advisory"><table class="advice_table">
                    								<tr style="background-color: powderblue;"> <td><?= ucwords($this->lang->line('msg_sector')); ?></td><td><?=$advice['minor_name'] ?></td></tr>
                    								<tr> <td><?= ucwords($this->lang->line('msg_message')); ?></td><td><?=$advice['message_summary'] ?></td> </tr>

                    							</table> 
                    						</div>
                    						<?php $flag = true; endforeach; if($flag == false){echo "<p>".$this->lang->line('msg_nodata')."</p>"; }?>
                    					</div>
                    					<!-- /.box-body -->
                    				</div>

                    				<!-- ADDED NEW ADVISORIES DISPLAY-------- -->

                    				<!-- LOGOS -->

                    				<div class="row">
                    					<h4 class="sponsors"><b><i><?= $this->lang->line('msg_brought_to_you'); ?>:</i></b></h4>
                    					<section class="customer-logos slider">
                    						<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                    						<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                    						<div class="slide" ><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                    						<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                    						<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                    						<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                    						<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                    					</section>
                    				</div>
                    				<?php

                    			}}
                    			?>  
                    			<?php $count++; endforeach; 
                    			if($flag == false){
                    				echo "<p>".$this->lang->line('msg_nodata')."</p>";
                    			}?>
                    		</div>

                    	<?php }else{

                    		$sqlx = "SELECT region.region_name, alerts.name,alerts.description, alerts.issuetime FROM alerts LEFT JOIN region on alerts.region_id = region.id";
                    		$sql2= $this->db->query($sqlx);
                    		$reg = "";$name = "";$desc = "";
                    		foreach ($sql2->result_array() as $row1) {
                    			$reg = $row1['region_name'];
                    			$name = $row1['name'];
                    			$desc = $row1['description'];
                    		} 


                    		?>


                    		<script type="text/javascript">
             //        			$(document).ready(function () {
             //        				var unique_id = $.gritter.add({
					        //     // (string | mandatory) the heading of the notification
					        //     title: '<?=$name?>',
					        //     // (string | mandatory) the text inside the notification
					        //     text: ' <b/><b/><br/> <?php  
					        //     echo"<tr>  ";
					        //     echo "<td>".$desc."</td>";


					        //     ?>  ',
					        //     // (string | optional) the image to display on the left

					        //     image: '<?php //echo base_url() ?>assets/frameworks/adminlte/img/rain.png?>',
					        //     // (bool | optional) if you want it to fade out on its own or just sit there
					        //     sticky: false,
					        //     // (int | optional) the time you want it to be alive for before fading out
					        //     time: '20000',
					        //     // (string | optional) the class name you want to apply to that specific message
					        //     class_name: 'my-sticky-class'
					        // });

             //        				return false;
             //        			});
         </script>

         <div class="tabs" style="margin-top: 10px;">
             <ul class="tabs-list">
                <li class="active"><a href="#tab1"><?=ucwords($this->lang->line('msg_daily_forecast')) ?> </a></li>
                <!-- <li ><a href="#tab2">Dekadal Forecast</a></li> -->
                <li ><a href="#tab3"><?=ucwords($this->lang->line('msg_seasonal_forecast')) ?></a></li>
                <?php
                


                if ($_SESSION['site_lang'] == "english" || $_SESSION['site_lang'] == null) {

                   if (sizeof($season_updates) > 0) {
                      foreach ($season_updates as $key) {
                         ?>
                         <li style="background-color: green;" ><a href="#tab5"><?php echo $key['month'];?> Forecast</a></li>
                         <?php
                     } }
                     ?>
                     <li ><a href="#tab4">Victoria Forecast</a></li>


                     <?php

                     if (sizeof($monthly_data_home) > 0) {
                       ?>
                       <li ><a href="#tab6">Monthly Forecast</a></li>
                       <?php
                   }
                   ?>

                   <?php
               }

               ?>
           </ul>



           <div id="tab1" class="tab active" >
               <div id="daily_forecast">

                  <?php //print_r($season_updates);?>

                  <h4><b><?=strtoupper($this->lang->line('msg_daily_forecast')) ?> - <?php $ct = 0; foreach($daily_forcast_division as $fd){$ct++;if($ct == 1){ $dist = strtoupper($fd->division_name); echo strtoupper($fd->division_name);}}  ?>
                  <div style="background-color: cornflowerblue;height: 2.5px;margin-top: 10px; width: 100%;"></div></b>
              </h4>



              <!-- END OF 6 HOURLY -->


              <?php $count = 0;
              foreach($daily_forecast_region_data_24 as $fd){$now = $today; $count ++;}

           // Very important
              $day1 = date("l", strtotime($fd->forecasted));
              $next_day = date('Y-m-d', strtotime(' +1 day',strtotime($fd->forecasted))); 
              $day2 = date("l", strtotime($next_day));

            // East African timezone
              date_default_timezone_set('Africa/Nairobi');
              $actual_time = date('Y-m-d g:ia');

            //This is the forecast 's next day at 6:00pm when the forecast expires
              $next_day_with_time = date('Y-m-d g:ia', strtotime($next_day.'6:00pm'));

              if( (strtotime(date('Y-m-d g:ia')) >= strtotime($fd->forecasted)) && (strtotime(date('Y-m-d g:ia')) <= strtotime($next_day_with_time))  ){ ?>

                  <h5><b><?= $this->lang->line('msg_issue'); ?>:</b>&nbsp; <?php echo date('jS F Y', strtotime( $fd->issuedate))?></h5>
                  <p><h5 style="color: cornflowerblue;"><b><?= $this->lang->line('msg_summary'); ?>:</b></h5>
                     <?php echo $fd->weather;?></p>
                     <table class="table table-bordered" >
                        <thead>
                           <tr>
                              <th scope="col"><?= $this->lang->line('msg_time'); ?></th>
                              <th scope="col"><?= $this->lang->line('msg_weather'); ?></th>
                    <!-- <th scope="col">Max Temp</th>
                    	<th scope="col">Min Temp</th> -->
                    	<th scope="col"><?= $this->lang->line('msg_temperature'); ?></th>
                    	<th scope="col"><?= $this->lang->line('msg_wind_strength'); ?></th>        
                    	<!-- <th scope="col">Wind Strength</th>                               -->
                    </tr>
                </thead>
                <tbody>
                	<?php 
                	if(isset($daily_forecast_region_data_24)){
                		foreach($daily_forecast_region_data_24 as $fd){
                			$next_day_with_time = date('Y-m-d g:ia', strtotime(date('Y-m-d', strtotime(' +1 day',strtotime($fd->forecasted))).'6:00pm'));
                			if( (strtotime(date('Y-m-d g:ia')) >= strtotime($fd->forecasted)) && (strtotime(date('Y-m-d g:ia')) <= strtotime($next_day_with_time)) ){
                				?>
                				<tr>
                					<td scope="row" data-label="Time">

                						<?php
                						$dd = "SELECT * FROM forecast_time WHERE id='$fd->timing'";
                						$ddd = $this->db->query($dd);
                						$day1 = date("l", strtotime($fd->forecasted));
                						$next_day = date('Y-m-d', strtotime(' +1 day',strtotime($fd->forecasted))); 
                						$day2 = date("l", strtotime($next_day));
                						foreach ($ddd->result_array() as $rowss) {


                							if(($rowss['id'] == 2) || ($rowss['id'] ==1 ) || ($rowss['id'] == 3)){
                								echo "<b>".ucwords($day2)."</b><br>";
                							}else{
                								echo "<b>".ucwords($day1)."</b><br>";
                							}
                							echo ucwords($rowss['period_name'])."<br>( ".ucwords($rowss['from_time'])."-".ucwords($rowss['to_time'])." )";


                						} ?>
                					</td>
                					<td data-label="Weather">
                						<!-- <img src="<?php //echo base_url() ?>assets/frameworks/adminlte/<?php //echo $fd->img ?>" height="50" width="50">  -->
                						<figure>
                							<svg class="icon" style="width: 100px;height: 70px;" viewbox="0 0 100 100">
                								<?php if(ucwords($rowss['period_name']) == "Evening" || ucwords($rowss['period_name']) == "Early Morning")echo '<use xlink:href="#moon" x="-20" y="-15"/>';
                								else echo '<use xlink:href="#sun" x="-12" y="-18"/>';
                								echo $fd->svg_data; ?>
                							</svg>
                						</figure>
                						<?php echo ucwords($fd->cat_name)  ?></td>
                            <!-- <td data-label="Max Temp"><?php  //if($fd->max_temp==0){print('-');}else{echo $fd->max_temp; ?> &deg;C <?php //} ?></td>
                            	<td data-label="Min Temp"><?php //if($fd->min_temp==0){print('-');}else{echo $fd->min_temp;?> &deg;C <?php// }  ?></td> -->
                            	<td data-label="Temperature"><?php echo $fd->mean_temp; ?> &deg;C</td>  
                            	<td data-label="Wind Direction"><?php echo $fd->wind_direction; ?></td>          
                            	<!-- <td data-label="Wind Strength"><?php //echo $fd->wind_strength; ?></td>                -->
                            </tr>
                            <?php  


                        } }  } ?>
                    </tbody>
                </table>
                <h5><b style="color: cornflowerblue;"><?= $this->lang->line('msg_valid_till'); ?> : </b> &nbsp; <strong style="color:red">  <?php echo $next_day.' @ '. $fd->validitytime;; ?></strong></h5>
                <br>


                <!-------ADDED NEW ADVISORIES DISPLAY-------- -->
                <div class="box box-default collapsed-box">
                	<div class="box-header with-border" style="margin-left: -10px">
                		<button type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 10px;margin-right: 20px; width: 180px"><i style ="font-color: green;" class="fa fa-plus"><?= $this->lang->line('msg_advisory'); ?></i></button>
                		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal" style="margin-top: 10px; width: 180px"> <?= $this->lang->line('msg_feedback'); ?> </button>

             <!--  <div class="box-tools pull-right">
               
             </div> -->
         </div>

         <div class="box-body">
         	<?php  if(isset($daily_advice_home)){ foreach ($daily_advice_home as $advice) :  ?>
         		<div id="advisory">
         			<table class="advice_table">
         				<tr style="background-color: powderblue;">
         					<td><?= ucwords($this->lang->line('msg_sector')); ?></td>
         					<td><?=$advice['minor_name'] ?></td>
         				</tr>
         				<tr>
         					<td>Advice</td><td><?=$advice['advice'] ?></td>
         				</tr>
         				<tr> <td><?= ucwords($this->lang->line('msg_message')); ?></td><td><?=$advice['message_summary'] ?></td> </tr>
         			</table>
         		</div>
         		<?php $flag = true; endforeach;} if($flag == false){echo "<p>".$this->lang->line('msg_nodata')."</p>"; }?>
         	</div>
         </div> 


         <!-- LOGOS -->







     <?php  }else{
                // echo "<p>".$this->lang->line('msg_nodata')."</p>";

     	$actual_time = date('Y-m-d g:ia');


     	$count = 0; foreach($daily_forecast_region_data as $fd){$now = $today; $count ++;}

     	$forecasted_date = $fd->date;


     	if($now == date('Y-m-d') && $count>0){ ?>
                 <!--  <h4><b>6 HOURLY DAILY WEATHER FORECAST
                  <div style="background-color: cornflowerblue;height: 2.5px;margin-top: 10px; width: 100%;"></div></b>
              </h4> -->
              <h5 id='daily_forecast_head'>Today's Forecast</h5>
              <div id='daily_forecast_desc_und'></div>
              <h5><b><?= $this->lang->line('msg_issue'); ?>:</b>&nbsp; <?php echo date('jS F Y', strtotime( $fd->date))?></h5>
              <p><b><?= $this->lang->line('msg_weather_summary'); ?>:</b>&nbsp;<br><ul><?php  foreach($daily_forecast_region_data as $fd){ echo '<li>'.$fd->weather.'</li>';}    ?></ul></p><br>



              <table class="table table-bordered" >
              	<thead>
              		<tr>
              			<th scope="col"><?= $this->lang->line('msg_time'); ?></th>
              			<th scope="col"><?= $this->lang->line('msg_weather'); ?></th>
                    <!-- <th scope="col">Max Temp</th>
                    	<th scope="col">Min Temp</th> -->
                    	<th scope="col"><?= $this->lang->line('msg_temperature'); ?></th>
                    	<th scope="col">Wind Speed</th>
                    	<th scope="col"><?= $this->lang->line('msg_wind_strength'); ?></th>        
                    	<!-- <th scope="col">Wind Strength</th>                               -->
                    </tr>
                </thead>
                <tbody>
                	<?php 
                	if(isset($daily_forecast_region_data)){
                		foreach($daily_forecast_region_data as $fd){ ?>
                			<tr>
                				<td scope="row" data-label="Time"><?php  echo ucwords($fd->time).'<br>'; 
                				if($fd->time=="Early Morning") echo '( 12:00am - 06:00am )';
                				else if($fd->time=="Late Morning") echo "( 06:00am - 12:00pm )"; 
                				else if($fd->time=="Afternoon") echo "( 12:00pm -06:00pm )";
                				else if($fd->time=="Late Afternoon") echo "( 12:00pm -06:00pm )";  
                				else if($fd->time=="Evening") echo "06:00pm-12:00am";
                				else echo " ";?></td>
                				<td data-label="Weather"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/<?php echo $fd->img ?>" height="50" width="50"> <?php echo ucwords($fd->cat_name);  ?></td>
                            <!-- <td data-label="Max Temp"><?php  //if($fd->max_temp==0){print('-');}else{echo $fd->max_temp; ?> &deg;C <?php //} ?></td>
                            	<td data-label="Min Temp"><?php //if($fd->min_temp==0){print('-');}else{echo $fd->min_temp;?> &deg;C <?php// }  ?></td> -->
                            	<td data-label="Temperature"><?php echo $fd->mean_temp; ?> &deg;C</td>
                            	<td data-label="Wind Speed"><?php echo $fd->wind; ?></td>    
                            	<td data-label="Wind Direction"><?php echo $fd->wind_direction; ?></td>          
                            	<!-- <td data-label="Wind Strength"><?php //echo $fd->wind_strength; ?></td>                -->
                            </tr>
                            <?php  


                        }  } ?>
                    </tbody>
                </table>
                <h5><?= $this->lang->line('msg_valid_till'); ?> : &nbsp; <strong style="color:red"><?php echo $fd->validitytime;; ?></strong></h5>
                <!-------ADDED NEW ADVISORIES DISPLAY-------- -->
                <div class="box box-default collapsed-box">
                	<div class="box-header with-border">
                		<button type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 10px;margin-right: 20px; width: 180px"><i style ="font-color: green;" class="fa fa-plus"><?= $this->lang->line('msg_advisory'); ?></i></button>
                		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal" style="margin-top: 10px; width: 180px"> <?= $this->lang->line('msg_feedback'); ?> </button>
                	</div>


                	<div class="box-body">
                		<?php  if(isset($daily_advice_home)){ foreach ($daily_advice_home as $advice) :  ?>
                			<div id="advisory">
                				<table class="advice_table">
                					<tr style="background-color: powderblue;">
                						<td>Sector</td>
                						<td><?=$advice['minor_name'] ?></td>
                					</tr>
                					<tr>
                						<td>Advice</td><td><?=$advice['advice'] ?></td>
                					</tr>
                					<tr> <td>Message</td><td><?=$advice['message_summary'] ?></td> </tr>
                				</table>
                			</div>
                			<?php $flag = true; endforeach;} if($flag == false){echo "<p>".$this->lang->line('msg_nodata')."</p>"; }?>
                		</div>
                	</div>                
                	<!-- ADDED NEW ADVISORIES DISPLAY-------- -->


                	<?php
                }else{
                	echo "<p>".$this->lang->line('msg_nodata')."</p>";
                } 
            }

               // if(($now == date('Y-m-d') && $count>0)  || ( (strtotime(date('Y-m-d g:ia')) >= strtotime($fd->forecasted)) && (strtotime(date('Y-m-d g:ia')) <= strtotime($next_day_with_time))) ){}

            ?> 
            <div class="row">
            	<h4 class="sponsors"><b><i><?= $this->lang->line('msg_brought_to_you'); ?>:</i></b></h4>
            	<section class="customer-logos slider">
            		<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
            		<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
            		<div class="slide" ><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
            		<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
            		<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
            		<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
            		<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
            	</section>
            </div>



        </div>
    </div>



    <div id="tab3" class="tab">
    	<div id="seasonal_forecast">
    		<h4><b><?=strtoupper($this->lang->line('msg_seasonal_forecast')) ?> - <?php $ct = 0; foreach($daily_forcast_division as $fd){$ct++;if($ct == 1){ $dist = strtoupper($fd->division_name); echo strtoupper($fd->division_name);}}  ?>
    		<div style="background-color: cornflowerblue;height: 3px;margin-top: 10px; width: 100%;"></div></b></h4>
    		<?php $count = 0; $flag = false; foreach ($seasonal_data_home as $Seasonal){ ?> <?php $count++; 
    			$months  = array('JANUARY','FEBRUARY','MARCH','APRIL', 'MAY','JUNE','JULY', 'AUGUST', 'SEPTEMBER','OCTOBER','NOVEMBER', 'DECEMBER');
    			$date_struct = explode('-', $Seasonal['issuetime']);
                          // New code to check the season we are in before displaying data for the season currently available in the database
    			$season = "unknown";
    			if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
    			else 
    				if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
    			else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
    			else $season = 'SOND';

              // Thie check the year and season we are currently in before desiding to display anything
    			if(date('Y') == $Seasonal['year'] && ($Seasonal['abbreviation']) == $season){
    				if($count == 1){ 
    					?>
    					<p style="font-weight: bold;font-size: 16px;">Issue Date: <?php
    					echo date('jS F Y', strtotime($Seasonal['issuetime']));?> </p>
    					<p class="season_head"><?php $m = '';
    					if( $Seasonal['abbreviation'] == 'SOND'){ $m = 'SEPTEMBER-OCTOBER-NOVEMBER AND DECEMBER'; 
    				} else if( $Seasonal['abbreviation'] == 'MAM'){ $m = 'MARCH-APRIL AND MAY'; 
    			} else if( $Seasonal['abbreviation'] == 'JJA'){ $m = 'JUNE-JULY AND AUGUST'; 
    		} else if( $Seasonal['abbreviation'] == 'JF') { $m = 'JANUARY AND FEBRUARY';}
    		echo $m.' ('.$Seasonal['abbreviation'].') '.$Seasonal['year']; ?><br>SEASONAL RAINFALL OUTLOOK OVER UGANDA
    	</p>

    	<p class="season_sub_head">1.0  Overiew</p>
    	<?php
    	if (ucwords($this->session->userdata('site_lang')) == "English") {
    		?>
    		<p class="season_content"><?php echo $Seasonal['overview']; ?></p>
    		<?php	
    	}
    	?>

    	<p class="season_sub_head">2.0  General Forecast</p>
    	<!--  <p class="season_content"><?php //echo $Seasonal['general_forecast']; ?></p> -->
    	<p align="center"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/img/<?php echo $Seasonal['map'];?>" height="50%" width="50%"></p><br>
    	<p class="season_sub_head">2.1.0  <?php echo $Seasonal['region_name']; ?> Region</p>
    	<p class="season_sub_head">2.2.1   <?php echo $Seasonal['sub_region_name']; ?></p>
    	<p> <?php echo $Seasonal['overall_comment'];  ?> </p>
    	<?php
    	if ($clip != null) {?>
    		<p class="season_sub_head"><?= ucwords($this->lang->line('msg_audio')); ?></p>
    		<audio controls>
    			<source src="<?php echo base_url('assets/audio').'/'.$clip.".mp3" ?>" type="audio/mp3">
    				<source src="<?php echo base_url('assets/audio').'/'.$clip.".ogg" ?>" type="audio/ogg">
    					<source src="<?php echo base_url('assets/audio').'/'.$clip.".wav" ?>" type="audio/wav">
    					</audio> 
    					<?php

    				}
    				?>







    				<!-------ADDED NEW ADVISORIES DISPLAY-------- -->
    				<div class="box box-default collapsed-box">
    					<div class="box-header with-border">
    						<button type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 15px;width: 180px"><i style ="font-color: green;" class="fa fa-plus" ><?= $this->lang->line('msg_advisory'); ?></i>
    						</button>
    						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal" style="margin-top: 15px;width: 180px"> <?= $this->lang->line('msg_feedback'); ?></button>
    					</div>
    					<!-- /.box-header -->
    					<div class="box-body">
    						<?php  if(isset($seasonal_advice_home)) foreach ($seasonal_advice_home as $advice) : 
    						?>

    						<div id="advisory"><table class="advice_table">
    							<tr style="background-color: powderblue;"> <td>Sector</td><td><?=$advice['minor_name'] ?></td></tr>
    							<tr> <td>Message</td><td><?=$advice['message_summary'] ?></td> </tr>

    						</table> 
    					</div>
    					<?php $flag = true; endforeach; if($flag == false){echo "<p>".$this->lang->line('msg_nodata')."</p>"; }?>
    				</div>
    				<!-- /.box-body -->
    			</div>


    			<div class="row">
    				<h4 class="sponsors"><b><i><?= $this->lang->line('msg_brought_to_you'); ?>:</i></b></h4>
    				<section class="customer-logos slider">
    					<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
    					<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
    					<div class="slide" ><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
    					<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
    					<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
    					<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
    					<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
    				</section>


    			</div>

        <!--    <div class="row" style="">
            <div class="col-sm-12">
             <h4><?= $this->lang->line('msg_brought_to_you'); ?>:</h4> 
             <table>
               <
             </table>
              <img src="<?php //echo base_url() ?>assets/frameworks/adminlte/logo/norad.png" height="20%" width="20%">

           
              <img src="<?php //echo base_url() ?>assets/frameworks/adminlte/logo/unma.png" height="20%" width="20%">
            
              <img src="<?php //echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg" height="20%" width="20%">
            </div>
             
           </div>
       -->

       <!-- ADDED NEW ADVISORIES DISPLAY-------- -->
       <!-- END OF BUTTON TO TRIGGER FEEDBACK FORM -->
       <?php  $flag = true;  } } } if(($count < 1) || ($flag == false)) echo "<p>".$this->lang->line('msg_nodata')."</p>";
       ?>
   </div>
</div>






<div id="tab2" class="tab">
	<div id="seasonal_forecast">
		<h4>TEN DAY FORECAST FOR <?php $ct = 0; foreach($daily_forcast_division as $fd){$ct++;if($ct == 1){ $dist = strtoupper($fd->division_name); echo strtoupper($fd->division_name);}}  ?>
		<?php 
		$dekadal_forecast_data= $this->Decadal_forecast_model->get_dekadal_forecast_area(2);
        // print_r($dekadal_forecast_data);exit();

		$count = 0; $flag = false;$today_data = date('Y-m-d');
		foreach($dekadal_forecast_data as $dekadal){

			$count++;
			if(($count == 1) && (($today_data >=  $dekadal['date_from'])&& ($today_data <=  $dekadal['date_to']) ) ){
				?>
				REGION: (<?php echo date('jS ', strtotime( $dekadal['date_from']))." - ".date('jS ', strtotime( $dekadal['date_to'])).', '.date('F Y', strtotime( $dekadal['date_to'])); ?>)
				<div style="background-color: cornflowerblue;height: 3px;margin-top: 10px; width: 90%;"></div>
			<?php } }?>
		</h4>

	</div>
</div>

<!------------------- MONTHLY FORECAST INFORMATION SECTION 2021 ----------------------------->
 <div id="tab6" class="tab">
        <div id="seasonal_forecast">
            <h4><b>RAINFALL OUTLOOK FOR  <?php $ct = 0; foreach($monthly_data_home as $fd){$ct++;if($ct == 1){ $dist = strtoupper($fd->month_from); echo strtoupper($fd['month_from']).' & '.strtoupper($fd['month_to']).' '. strtoupper($fd['year']);}}  ?>
            <div style="background-color: cornflowerblue;height: 3px;margin-top: 10px; width: 100%;"></div></b>
           </h4>

            <?php $count = 0; $flag = false; foreach ($monthly_data_home as $monthly){ ?> <?php $count++; 
               

                $months  = array('JANUARY','FEBRUARY','MARCH','APRIL', 'MAY','JUNE','JULY', 'AUGUST', 'SEPTEMBER','OCTOBER','NOVEMBER', 'DECEMBER');
                $date_struct = explode('-', $Seasonal['issuetime']);
                          // New code to check the season we are in before displaying data for the season currently available in the database
                $season = "unknown";
                if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
                else 
                    if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
                else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
                else $season = 'SOND';



              // Thie check the year and season we are currently in before desiding to display anything
                if(date('Y') == $monthly['year'] ){
                    if($count == 1){ 
                        ?>
                        <p style="font-weight: bold;font-size: 16px;">Issue Date:<span><?php
                        echo date('jS F Y', strtotime($monthly['issue_date']));?></span>  </p>


        <p class="season_sub_head">1.0  Summary</p>
            <p class="season_content"><?php echo $monthly['summary']; ?></p>

        <p class="season_sub_head">2.0  Introduction</p>
          <p class="season_content"><?php echo $monthly['introduction']; ?></p> 
        

        <p class="season_sub_head">2.1.0  Rainfall Outlook for <?php echo $monthly['month_from'].' & '.$monthly['month_to'].' '. $monthly['year'];; ?> </p>
        <p class="season_content"><?php echo $monthly['weather_outlook']; ?></p> 
        <p align="center"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/img/<?php echo $monthly['forecast_map'];?>" height="50%" width="50%"></p><br>
     

                    <!-------ADDED NEW ADVISORIES DISPLAY-------- -->
                    <div class="box box-default collapsed-box">
                        <div class="box-header with-border">
                            <button style ="background-color: green;" type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 15px;width: 180px"><i  class="fa fa-plus" >VIEW ADVISORIES</i>
                            </button>
                            <button style ="background-color: red;" type="button" class="btn btn-primary" data-widget="collapse" style="margin-top: 15px;width: 180px"><i  class="fa fa-plus" >VIEW IMPACTS</i>
                            </button>
                            
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php  if(isset($monthly_advice_home)) foreach ($monthly_advice_home as $advice) : 
                            ?>

                            <div id="advisory"><table class="advice_table">
                                <tr style="background-color: powderblue;"> <td>Sector</td><td><?=$advice['minor_name'] ?></td></tr>
                                <tr> <td>Message</td><td><?=$advice['message_summary'] ?></td> </tr>

                            </table> 
                        </div>
                        <?php $flag = true; endforeach; if($flag == false){echo "<p>".$this->lang->line('msg_nodata')."</p>"; }?>
                    </div>
                    <!-- /.box-body -->
                </div>


                <div class="row">
                    <h4 class="sponsors"><b><i><?= $this->lang->line('msg_brought_to_you'); ?>:</i></b></h4>
                    <section class="customer-logos slider">
                        <div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                        <div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                        <div class="slide" ><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                        <div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                        <div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                        <div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                        <div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                    </section>


                </div>

        <!--    <div class="row" style="">
            <div class="col-sm-12">
             <h4><?= $this->lang->line('msg_brought_to_you'); ?>:</h4> 
             <table>
               <
             </table>
              <img src="<?php //echo base_url() ?>assets/frameworks/adminlte/logo/norad.png" height="20%" width="20%">

           
              <img src="<?php //echo base_url() ?>assets/frameworks/adminlte/logo/unma.png" height="20%" width="20%">
            
              <img src="<?php //echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg" height="20%" width="20%">
            </div>
             
           </div>
       -->

       <!-- ADDED NEW ADVISORIES DISPLAY-------- -->
       <!-- END OF BUTTON TO TRIGGER FEEDBACK FORM -->
       <?php  $flag = true;  } } } if(($count < 1) || ($flag == false)) echo "<p>".$this->lang->line('msg_nodata')."</p>";
       ?>
   </div>
</div>

<!-- THE END OF MONTHLY FORECAST SECTION -->



<!-------------------------------SEASONAL UPDATES DISPLAY-------------  -------------------------------------->
<div id="tab5" class="tab">
	<div id="seasonal_forecast">

		<h4> 
			<?php 

			$ct = 0; foreach($season_updates as $fd){$ct++;if($ct == 1){echo strtoupper($fd['month']).",". date(' Y', strtotime( $fd['issue_time']));}}  ?> SEASONAL RAINFALL UPDATE OVER THE COUNTRY
			<div style="background-color: cornflowerblue;height: 3px;margin-top: 10px; width: 100%;"></div>     
		</h4>


		<?php $count = 0; $flag = false; foreach ($season_updates as $Seasonal){ ?> <?php $count++; 
			$months  = array('JANUARY','FEBRUARY','MARCH','APRIL', 'MAY','JUNE','JULY', 'AUGUST', 'SEPTEMBER','OCTOBER','NOVEMBER', 'DECEMBER');
			$date_struct = explode('-', $Seasonal['issue_time']);
                          // New code to check the season we are in before displaying data for the season currently available in the database
			$season = "unknown";
			if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
			else 
				if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
			else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
			else $season = 'SOND';

              // Thie check the year and season we are currently in before desiding to display anything
			if($Seasonal['month'] == date('F') && ($Seasonal['abbreviation']) == $season){
				if($count == 1){ 
					?>

					<p style="font-weight: bold;font-size: 16px;">
						<?= $this->lang->line('msg_issue'); ?>: <?php
						echo date('jS F Y', strtotime($Seasonal['issue_time']));
                           // echo $date_struct[2].' '.$months[$date_struct[1]-1].' '.$date_struct[0]  ?>
                       </p>


                       <p class="season_sub_head">Overview</p>
                       <p class="season_content"><?php echo $Seasonal['rainfall_outlook']; ?></p>
                       <p class="season_sub_head">Rainfall outlook for <?php echo $fd['month'].",". date(' Y', strtotime( $fd['issue_time']));?></p> </p>
                       <p class="season_content"><?php echo $Seasonal['further_outlook']; ?></p>
                       <p class="season_sub_head">Potential impacts expected during <?php echo $fd['month'].",". date(' Y', strtotime( $fd['issue_time']));?> 
                       <p class="season_content"><?php echo $Seasonal['impacts']; ?></p>
                       <?php if(($Seasonal['advisories']) == NULL){?>
                       	<p class="season_sub_head"> Advisories</p>
                       	<p class="season_content"><?php echo $Seasonal['advisories']; ?></p>
                       <?php } if(($Seasonal['conclusion']) == NULL){?>
                       	<p class="season_sub_head"> Conclusion</p>
                       	<p class="season_content"><?php echo $Seasonal['conclusion']; ?></p>
                       	<?php
                       }
                       ?>
                       <!-------ADDED NEW ADVISORIES DISPLAY-------- -->
                       <p class="season_content">

                       	<b>NOTE:</b><i>The Uganda National Meteorological Authority (UNMA) will continue to monitor the evolution of relevant weather systems and issue appropriate updates and advisories to the users accordingly.</i>                             
                       </p>

                       <!-- LOGOS -->

                       <div class="row">
                       	<h4 class="sponsors"><b><i><?= $this->lang->line('msg_brought_to_you'); ?>:</i></b></h4>
                       	<section class="customer-logos slider">
                       		<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                       		<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                       		<div class="slide" ><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                       		<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/mak.jpg"></div>
                       		<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                       		<div class="slide"><img src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/unma.png"></div>
                       		<div class="slide" > <img  src="<?php echo base_url() ?>assets/frameworks/adminlte/logo/norad3.png"></div>
                       	</section>
                       </div>

                       <!-- END OF BUTTON TO TRIGGER FEEDBACK FORM -->
                       <?php    $flag = true;  
        }}//-----------------------------------------------------------------------------------------------------------------------------------
      }//endOfForeach
      if(($count < 1) || ($flag == false)) echo "<p>No updates yet!.</p>"; ?>
  </div>
  <!---------------------------------------------------- end of seasonal request data --------------------------------------->
</div><!---end of updates-->







<!----------------------- Amoko --------------------->
<div id="tab4" class="tab">
	<div id="daily_forecast">
		<?php foreach($landing_site_data as $row){ 
			$landing_site = $row['site_name'];

		}

		?> 


		<?php

              // Very important


		?>





		<h4><b>24-HOUR FISHERMEN FORECAST FOR <?=$landing_site?> LANDING SITE</b></h4>
		<div style="background-color: cornflowerblue;height: 2.5px;margin-top: 10px; width: 100%;"></div>
		<?php $dt = ""; $cd = 0;
                //print_r($victoria_forecast);
		foreach($victoria_forecast as $dd){ 
                  //------------------new checker------------------------
			$day1 = date("l", strtotime($dd['forecast_date']));
			$next_day = date('Y-m-d', strtotime(' +1 day',strtotime($dd['forecast_date']))); 
			$day2 = date("l", strtotime($next_day));

                  // East African timezone
			date_default_timezone_set('Africa/Nairobi');
			$actual_time = date('Y-m-d g:ia');

                  //This is the forecast 's next day at 6:00pm when the forecast expires
			$next_day_with_time = date('Y-m-d g:ia', strtotime($next_day.'6:00pm'));

              //if(  && $counter <4){ ;
                  //-------------------end checker--------------------



			$dt = $dd['forecast_date'];
			if(  (strtotime(date('Y-m-d g:ia')) >= strtotime($dd['forecast_date'])) && (strtotime(date('Y-m-d g:ia')) <= strtotime($next_day_with_time))   ){
				$cd = 1;
			}
		} 
		?>
		<?php  

		if(isset($victoria_forecast) && sizeof($victoria_forecast)>1 && $cd == 1){ $counter = 0;?>
			<?php foreach($victoria_forecast as $dd){ ?>  
				<p style="font-weight: bold;font-size: 16px;padding-top: 10px;"> <?= $this->lang->line('msg_issue'); ?>: <?php
				echo date('jS F Y', strtotime($dd['issue_date']));?> </p>
				<p>Advice :&nbsp; <?php echo $dd['advice'] ?></p>
				<p style="font-weight: bold;font-size: 16px;padding-top: 10px;"> Map Showing Position of the Zones</p>
				<div style="display: flex; justify-content: center;">
					<img class=figures_only" style="width: 60%;height: 60%" src="<?php echo site_url('assets/frameworks/adminlte/img')."/".$dd['map'] ?>">
				</div>


				<?php break; } ?> 

				<table class="table table-bordered">
					<?php $ct = 0; foreach($victoria_forecast as $dd){ $ct++; ?> 

						<?php if($ct == 1 ) { ?>
							<tr>
								<td colspan="8"><h4><b>Landing Site: <?=$dd['site_name']?>, <?php echo $dd['zone'] ?> Zone, <?=$dd['district']?> District</b></h4></td>
							</tr>
							<tr>
								<td style="width: 15%"><b>Highlight</b></td>
								<td colspan="7"><p><?php echo $dd['highlights'] ?></p></td>
							</tr>
							<tr style="font-weight: bold;">
								<td>Period</td>
								<td>Wind Strength</td>
								<td>Wind Direction</td>
								<td>Wave Height</td>
								<td>Weather</td>
								<td>Rainfall Distribution</td>
								<td>Visibility</td>
								<td>Hazards</td>
							</tr>
						<?php } ?>

						<?php  if($ct == 4 ) $ct=0;  ?>
						<tr>
							<td style="width: 15%"><b><?php echo $dd['day_time']; ?></b></td>
							<td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wind_strength']; ?>"><?=$dd['wind_strength_name'] ?></td>
							<td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wind_direction']; ?>"><?=$dd['wind_direction_name'] ?></td>
							<td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wave_height']; ?>"><?=$dd['wave_height_name'] ?></td>
							<td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['weather']; ?>"><?=$dd['weather_name'] ?></td>
							<td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['rainfall_dist']; ?>"><?=$dd['rainfall_dist_name'] ?></td>
							<td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['visibility']; ?>"><?=$dd['visibility_name'] ?></td>
							<td style="width: 15%; background: <?php echo $dd['harzard']; ?>"></td>
						</tr>
					<?php } ?> 
					<tr>
						<td style="width: 15%; background: #0F0"></td>
						<td colspan="7">No severe weather is expected.</td>
					</tr>
					<tr>
						<td style="width: 15%; background: #FFA500"></td>
						<td colspan="7">Potentially dangerous weather is expected. <b>Be prepared.</b></td>
					</tr>
					<tr>
						<td style="width: 15%; background: #F00"></td>
						<td colspan="7">Dangerous and potentially life-threatening weather conditions are expected. <b>Take immediate action to ensure your safety</b></td>
					</tr>
				</table>
				<hr>
				<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#VictoriaFeedbackModal" style="margin-top: 10px; width: 180px"> SEND FEEDBACK </button> -->
			<?php }else { echo "<p style='padding-top:10px'>Data has not yet been uploaded. Please try again later.</p>";} ?>  

		</div>

	</div>
	<!----------------------- Amoko --------------------->


</div>
<br>
<footer style="bottom: all;">
	<div >
		<!-- <b>Version</b> -->
		<?php
                        // echo $this->config->item('dissemination_version');
		?>
		<strong>Copyright &copy; <?php //echo date('Y');?>  <a href="http://wimea.mak.ac.ug/" target="_blank">WIMEA-ICT</a>.</strong> All rights reserved.
	</div>
</footer> 
<?php } ?>

</div>

</div>


</div>

<!-- Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center"><?= $this->lang->line('msg_user_feedbacks')?></h3>
			</div>
			<div class="modal-body">

				<form method="POST" action = "<?php echo site_url('index.php/User_feedback/log_userfeedback'); ?>" >
					<div class="form-group row">
						<label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm"><?= $this->lang->line('msg_division')?> </label>
						<div class="col-sm-8">

							<select name="districtName" id="districtName" class = "form-control" >

								<?php

								$dd = "SELECT * FROM division order by division_name ASC";
								$ddd = $this->db->query($dd);
								foreach ($ddd->result_array() as $rowss) { ?>
									<option value="<?php echo $rowss['id']; ?>"><?php $dist = strtoupper($rowss['division_name']); echo $rowss['division_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>


					<div class="form-group row">
						<label for="colFormLabel" class="col-sm-4 col-form-label"><?= $this->lang->line('msg_weather_forecast')?></label>
						<div class="col-sm-8">
							<select name="CategoryName" id="CategoryName" class = "form-control" >

								<option><?= $this->lang->line('msg_daily_forecast')?></option>
								<option><?= $this->lang->line('msg_seasonal_forecast')?></option>



								<!-- <option>DEKADAL FORECAST</option> -->
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Accuracy Level</label>
						<div class="col-sm-8">
							<select name="accuracy" id="accuracy" class="form-control">
								<option>10</option>
								<option>9</option>
								<option>8</option>
								<option>7</option>
								<option>6</option>
								<option>5</option>
								<option>4</option>
								<option>3</option>
								<option>2</option>
								<option>1</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Applicability</label>
						<div class="col-sm-8">
							<select name="applicability" id="applicability" class="form-control">
								<option>10</option>
								<option>9</option>
								<option>8</option>
								<option>7</option>
								<option>6</option>
								<option>5</option>
								<option>4</option>
								<option>3</option>
								<option>2</option>
								<option>1</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Timeliness</label>
						<div class="col-sm-8">
							<select name="timeliness" id="timeliness" class="form-control">
								<option>10</option>
								<option>9</option>
								<option>8</option>
								<option>7</option>
								<option>6</option>
								<option>5</option>
								<option>4</option>
								<option>3</option>
								<option>2</option>
								<option>1</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg"><?= $this->lang->line('msg_contact')?></label>
						<div class="col-sm-8">
							<textarea name="contact" id="contact" class="form-control" ></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg"><?= $this->lang->line('msg_comment')?></label>
						<div class="col-sm-8">
							<textarea name="generalComment" id="generalComment" class="form-control" required></textarea>
						</div>
					</div>

				</form>
				<h6><center><i>**We really appreciate your feedback. Thank You!**</i></center></h6>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $this->lang->line('msg_close')?></button>
				<button type="submit" name="feedback_button" id="feedback_button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal"><?= $this->lang->line('msg_submit')?> </button>
			</div>
		</div>
	</div>
</div>

<!-- VICTORIA FORECAS FEEDBACK MODAL -->
<!-- Modal -->
<div class="modal fade" id="VictoriaFeedbackModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title" style="text-align: center"><?= $this->lang->line('msg_user_feedbacks')?></h3>
			</div>
			<div class="modal-body">

				<form method="POST" action = "<?php echo site_url('index.php/User_feedback/log_userfeedback'); ?>" >
					<div class="form-group row">
						<label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Landing Site </label>
						<div class="col-sm-8">

							<select name="districtName" id="districtName" class = "form-control" >

								<?php

								$dd = "SELECT * FROM landing_site order by site_name ASC";
								$ddd = $this->db->query($dd);
								foreach ($ddd->result_array() as $rowss) { ?>
									<option value="<?php echo $rowss['id']; ?>"><?php $dist = strtoupper($rowss['site_name']); echo $rowss['site_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>


					<div class="form-group row">
						<label for="colFormLabel" class="col-sm-4 col-form-label">Forecast</label>
						<div class="col-sm-8">
							<input type="text" readonly="" name="CategoryName" id="CategoryName" class = "form-control" value="VICTORIA FORECAST">

						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Accuracy Level</label>
						<div class="col-sm-8">
							<select name="accuracy" id="accuracy" class="form-control">
								<option>10</option>
								<option>9</option>
								<option>8</option>
								<option>7</option>
								<option>6</option>
								<option>5</option>
								<option>4</option>
								<option>3</option>
								<option>2</option>
								<option>1</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Applicability</label>
						<div class="col-sm-8">
							<select name="applicability" id="applicability" class="form-control">
								<option>10</option>
								<option>9</option>
								<option>8</option>
								<option>7</option>
								<option>6</option>
								<option>5</option>
								<option>4</option>
								<option>3</option>
								<option>2</option>
								<option>1</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Timeliness</label>
						<div class="col-sm-8">
							<select name="timeliness" id="timeliness" class="form-control">
								<option>10</option>
								<option>9</option>
								<option>8</option>
								<option>7</option>
								<option>6</option>
								<option>5</option>
								<option>4</option>
								<option>3</option>
								<option>2</option>
								<option>1</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Contact Details(Email/Phone)</label>
						<div class="col-sm-8">
							<textarea name="contact" id="contact" class="form-control" ></textarea>
						</div>
					</div>

					<div class="form-group row">
						<label for="colFormLabelLg" class="col-sm-4 col-form-label col-form-label-lg">Your Feedback</label>
						<div class="col-sm-8">
							<textarea name="generalComment" id="generalComment" class="form-control" required></textarea>
						</div>
					</div>

				</form>
				<h6><center><i>**We really appreciate your feedback. Thank You!**</i></center></h6>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" name="vic_feedback_button" id="vic_feedback_button" class="btn btn-primary" data-toggle="modal" data-target="#VictoriaFeedbackModal">Submit </button>
			</div>
		</div>
	</div>
</div>

<!-- END OF VIC MODAL -->

<aside class="main-sidebar">
	<section class="sidebar">
		<div class="col-md-12" ><br>
			<header> <h4><b><span class="test1"> <?php echo $this->lang->line('msg_request_service_form'); ?> </span></b></h4> </header>
			<?php if($this->session->flashdata('success')){?>
				<div class = "alert alert-success"><?php echo $this->session->flashdata('success');?></div>
			<?php }

			?><br/>
			<form method="post" action="<?php site_url('index.php/auth/index') ?>">

				<input type="hidden" name="session_language" value="<?php echo $this->session->userdata('site_lang')?>">
				<div class="control-group">
					<label class="control-label" for = "Slung" ><?=ucwords($this->lang->line('msg_select_Category')); ?>
					<?=$_SESSION['selected_g'] ?>
				</label>
				<div class="controls">
					<select name = 'product' id="product" class="form-control" required>
						<option value= "Select Product"  ><?=ucwords($this->lang->line('msg_select_Category')) ?></option>
						<option value= "Daily Forecast"  ><?=ucwords($this->lang->line('msg_daily_forecast')) ?> </option>
						<option value= "Seasonal Forecast" ><?=ucwords($this->lang->line('msg_seasonal_forecast')) ?></option>

						<?php
						if ($_SESSION['site_lang'] == "english") {?>
							<option value= "Victoria Forecast" >MARINE FORECAST</option>
						<?php }
						?>

					</select>

				</div>
			</div><br/>



			<div class="test1 control-group">
				<label class="control-label" for="option" id="opt_type"> <?= ucwords($this->lang->line('msg_select_ditrict')); ?></label>
				<div class="controls">                             
					<select name = "division" id="division" class = "form-control" required>
						<option value=""><?php echo $this->lang->line('msg_select_ditrict'); ?></option>                            

					</select>
				</div>
			</div>

			<br/>
			<div class="control-group">
				<div class="controls">
					<center><button type="submit" name="request_s" class="btn btn-info"><i class="fa fa-hand-rock-o" aria-hidden="true"></i>&nbsp; <?php echo ucwords($this->lang->line('msg_request')); ?></button></center><br><br>


				</div>
			</form>

		</div>
	</section>
	<section style="position: absolute; 
	bottom: 50px;">
	<div >
		<center>-OR-</center>
		<h4 class="sponsors"><i><?php echo $this->lang->line('msg_advert'); ?></i></h4>

		<img class="advert_img" src="<?php echo base_url() ?>assets/icons/ussd_advert.jpeg?> width" width="100%" height="100%">
	</div>
</section>
</aside>



<!-- START OF  DIV FOR FEEDBACK FORM -->


<?php include('svg.php'); ?>                        

</body>

<script>
	$(document).ready(function(){
		$('#feedback_button').click(function(){

			var division = $('#districtName').val();
			var category = $('#CategoryName').val();
			var accuracy = $('#accuracy').val();
			var applicability = $('#applicability').val();
			var timeliness = $('#timeliness').val();
			var generalComment = $('#generalComment').val();
			var contact = $('#contact').val();

			var div = "qwertyu";

			if(generalComment != ""){

            // alert(division); 
            $.ajax({
            	url : "<?php echo base_url().'index.php/Product/log_userfeedback'?>",
            	method : "POST",
            	data: {'division': division, 'category':category, 'accuracy': accuracy, 'applicability' : applicability, 'timeliness': timeliness, 'generalComment' : generalComment, 'contact' : contact},
                    // async : true,
                    // dataType : 'json',
                    success: function(data){

                    	alert("Well received. Thank you  for your feedback");


                    },
                    error: function(jqXHR, textStatus, errorThrown){
                    	alert(errorThrown);
                    }
                });

        }
        else{
        	alert("We really appreciate your comment. Please provide a comment !!!");
        	return false;

        }

    });

	})
</script>

<!-- victoria modal -->
<script>
	$(document).ready(function(){
		$('#vic_feedback_button').click(function(){

			var division = $('#districtName').val();
			var category = $('#CategoryName').val();
			var accuracy = $('#accuracy').val();
			var applicability = $('#applicability').val();
			var timeliness = $('#timeliness').val();
			var generalComment = $('#generalComment').val();
			var contact = $('#contact').val();

			var div = "qwertyu";

			if(generalComment != ""){

            // alert(division); 
            $.ajax({
            	url : "<?php echo base_url().'index.php/Product/log_userfeedback'?>",
            	method : "POST",
            	data: {'division': division, 'category':category, 'accuracy': accuracy, 'applicability' : applicability, 'timeliness': timeliness, 'generalComment' : generalComment, 'contact' : contact},
                    // async : true,
                    // dataType : 'json',
                    success: function(data){

                    	alert("Well received. Thank you  for your feedback");


                    },
                    error: function(jqXHR, textStatus, errorThrown){
                    	alert(errorThrown);
                    }
                });

        }
        else{
        	alert(generalComment);
        	return false;

        }

    });
	})
</script>
<!--  -->

<script>

	$(document).ready(function(){
		$('#feedback_button').click(function(){

		});

	})
</script>  

<script>

	$(document).ready(function(){
		$('#vic_feedback_button').click(function(){

		});

	})
</script> 

<script>
	$(document).ready(function(){
		$('.customer-logos').slick({
			slidesToShow: 6,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 1500,
			arrows: false,
			dots: false,
			pauseOnHover: false,
			responsive: [{
				breakpoint: 768,
				settings: {
					slidesToShow: 4
				}
			}, {
				breakpoint: 520,
				settings: {
					slidesToShow: 3
				}
			}]
		});
	});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>



<script>

	$("#product").change(function(){
		var selection=$("#product").val();
		if(selection=="Daily Forecast"){

			var opt = "<?= ucwords($this->lang->line('msg_select_ditrict')); ?>";
			var options="<option value = ><?= ucwords($this->lang->line('msg_select_your_ditrict')); ?></option>";
			<?php

			$dd = "SELECT * FROM division order by division_name ASC";
			$ddd = $this->db->query($dd);
			foreach ($ddd->result_array() as $row) { ?>

				options+="<option value = <?php echo $row['id']; ?>><?php echo $row['division_name']; ?></option>";
				<?php
			}
			?>

			$("#opt_type").html(opt);
			$("#division").html(options);
		}else if(selection=="Seasonal Forecast"){

			var opt = "<?= ucwords($this->lang->line('msg_select_ditrict')); ?>";
			var options="<option value = > <?= ucwords($this->lang->line('msg_select_your_ditrict')); ?></option>";
			<?php

			$dd = "SELECT * FROM division order by division_name ASC";
			$ddd = $this->db->query($dd);
			foreach ($ddd->result_array() as $row) { ?>

				options+="<option value = <?php echo $row['id']; ?> ><?php echo $row['division_name']; ?></option>";
				<?php
			}
			?>

			$("#opt_type").html(opt);
			$("#division").html(options);
		}else if(selection== "Victoria Forecast"){
			var opt = "Select Landing Site";
			var options="<option value = > Select Landing Site</option>";
			<?php

			$dd = "SELECT * FROM landing_site order by site_name ASC";
			$ddd = $this->db->query($dd);
			foreach ($ddd->result_array() as $row) { ?>

				options+="<option value = <?php echo $row['id']; ?> ><?php echo $row['site_name']; ?></option>";
				<?php
			}
			?>

			$("#opt_type").html(opt);
			$("#division").html(options);


		}else if(selection== "Select Product"){
			var opt = "No Selected";
			var options="<option value = > No Selected</option>";


			$("#opt_type").html(opt);
			$("#division").html(options);


		}


	});



</script>



<script>
	$(document).ready(function()
	{
		$('.abc').on('change', function() 
		{
			var user = $( ".abc option:selected" ).val();
			$.ajax({
				type: 'POST',
				url: "<?=base_url('index.php/Auth/got') ?>",
				data: {username: user},
				success: function (data) {

				}
			});
			demo();
			location.reload();
		});
	});

	function sleep(ms) {
		return new Promise(resolve => setTimeout(resolve, ms));
	}

	async function demo() {
		await sleep(1000);

  // Sleep in loop
  for (let i = 0; i < 5; i++) {
  	
  	await sleep(1000);
  	console.log(i);
  }
}
</script>

<?php
    //Visitor counter
$user_ip=$_SERVER['REMOTE_ADDR'];
$dd = "SELECT userip from pageview where page='home' and userip='".$user_ip."'";
$check_ip = $this->db->query($dd);
       // echo  $user_ip;exit();

if($check_ip->num_rows() >=1)
{
	$UPDATE = "UPDATE totalview set totalvisit = totalvisit+1 where page='home'";
	$this->db->query($UPDATE);
}
else
{
	$INSERT = "INSERT into pageview (page, userip) values('home','$user_ip')";
	$this->db->query($INSERT);

	$UPDATE = "UPDATE totalview set totalvisit = totalvisit+1 where page='home'";
	$this->db->query($UPDATE);


}

?>
</html>
