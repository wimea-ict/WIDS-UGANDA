<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
// print_r($users);
$dataPoints = array();
$rects = array();
for ($i=30; $i >=0 ; $i--) { 
    
    $rects["y"] = $users[$i][0]['count_users'];
    $rects["label" ] = date('Y-m-d', strtotime( date('Y-m-d').'-'.$i.' day'));
    
    $dataPoints[] = $rects;
    unset($rects);
}
     
    ?>
    <!DOCTYPE HTML>
    <html>
    <head>
    <script>
    window.onload = function () {
     
    var chart = new CanvasJS.Chart("chartContainer", {
        title: {
            text: "USSD-WIDS Daily Usage Trend (30 days)"
        },
        axisY: {
            title: "Number of Users"
        },
         axisX: {
            title: "Date"
        },
        data: [{
            type: "line",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
     
    }
    </script>
    <?php 
    // print_r($users);
    // echo $users[24][0]['count_users'];
        

        // function get_user($date){
        // $dd = "SELECT COUNT(DISTINCT phone) AS count_users FROM ussdtransaction_new WHERE ussdtransaction_new.date BETWEEN '".$date." 00:00:01' AND '".$date." 23:59:59'";

        // $ddd = $this->db->query($dd);
        // $rec = 0;
        // foreach ($ddd->result_array() as $rowss) {
        //   $rec = $rowss['count_users'];
        // }
        // return $rec;
     
    ?>


<link rel="stylesheet" href="<?php echo base_url() ?>assets/<?php echo $this->config->item('theme');?>/plugins/morris/morris.css">

<!--<div class="content-wrapper"> -->

     <section class="content-header" style="margin-top: -50px">
        <div>
        <h2>Home
            <small>System Statistics</small>                        
        <small class="pull-right">
       <?php if($_SESSION['usertype'] != 'wimea' && $_SESSION['first_time_login']==1){?> 
       <a href="<?php echo base_url(); ?>index.php/Auth/change_pass"><button type="button" class="btn"><strong>Change Password</strong></button></a> 
       <?php }?>                         
        </small>
        </h2>
        </div>

      </section>  

<section class="content" id="dashboard-content">


    <!-- Info boxes -->
    <div class="row">
    <?php if($_SESSION['usertype']=='wimea' && $_SESSION['first_time_login']==0){?>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-person-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SYSTEM USERS</span>
                    <span class="info-box-number"><?php echo $count_users; ?></span>
                    
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion-android-people"></i></span>

                <div class="info-box-content">
                <a href="<?php echo base_url(); ?>index.php/Landing/ussdcount"><span class="info-box-text">USSD USERS</span></a>
                    <span class="info-box-number"><?php echo $ussd_count; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">SOCIETY FORECAST HELP</span>
                    <span class="info-box-number"><?php echo $count_feedback; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
                <?php }?>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-phone"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">USSD REQUESTS</span>
                    <span class="info-box-number"><?php echo $count_daily_forecast; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
       
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                 <?php

                              $dd = "SELECT COUNT(DISTINCT phone) AS count_users FROM ussdtransaction_new";
                              $ddd = $this->db->query($dd);
                              foreach ($ddd->result_array() as $rowss) {
                                $count_users = $rowss['count_users'];
                              }
                                ?>
                <div class="info-box-content">
                    <span class="info-box-text">USSD UNIQUE USERS</span>
                    <span class="info-box-number"><?php echo $count_users; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
         <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="ion-android-cloud-circle"></i></span>

                <div class="info-box-content">
                       <?php

                              $dd = "SELECT * FROM totalview";
                              $ddd = $this->db->query($dd);
                              foreach ($ddd->result_array() as $web_users) {
                                $count_web_users = $web_users['totalvisit'];
                              }
                                ?>
                    <span class="info-box-text">Web Visits</span>
                    <span class="info-box-number"><?php echo $count_web_users; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>


    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion-android-contacts"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Number of users</span>
                <span class="info-box-number"><?php echo $count_season; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-android-globe"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Regions</span>
                <span class="info-box-number"><?php echo $count_region; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="ion-ios-partlysunny-outline"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">DISTRICTS</span>
                <span class="info-box-number"><?php echo $count_division; ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.row -->
</div>
    <div class="row">
        
        <!-- Main content -->
        <!-- Main content -->

        <section class="content col-md-12" >
            <div class="row">


                    <!-- BAR CHART -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <!-- <h3 class="box-title" style="text-align: center">Previous Average Temperature and Windspeed Daily Forecast For all Regions</h3> -->

                            <div class="box-tools pull-right">
                                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                            <div id="chartContainer" style="height: 300px;width: 100%"></div>
                            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                        </div>
                        <!-- /.box-body -->
                    </div>

                    <!-- /.box -->
                    <!-- end of area chart -->


                    <!-- /.box -->


                </div>
                <!-- /.box -->
        </section>
    </div>
        <!-- /.content -->

</section>

<!-- /.content -->

<!-- Morris.js charts -->
<script src="<?php echo base_url() ?>assets/plugins/morris/raphael.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>assets/plugins/knob/jquery.knob.js"></script>

<script src="<?php echo base_url() ?>assets/plugins/chartjs/Chart.min.js"></script>