<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$past_120 = date('Y-m-d', strtotime('-120 days'));

?>

<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title:{
        text: "USSD Completed Sessions"
    },
    axisY: {
        title: "Days",
        includeZero: true
    },
    data: [
        {
        type: "line",
        yValueFormatString: "#,###",
        indexLabel: "{y}",
        indexLabelPlacement: "inside",
        indexLabelFontWeight: "bolder",
        indexLabelFontColor: "red",
        dataPoints: <?php echo json_encode($overall_session_data, JSON_NUMERIC_CHECK); ?>,

        },

         {
        type: "line",
        yValueFormatString: "#,###",
        indexLabel: "{y}",
        indexLabelPlacement: "inside",
        indexLabelFontWeight: "bolder",
        indexLabelFontColor: "black",
        dataPoints: <?php echo json_encode($session_data, JSON_NUMERIC_CHECK); ?>,

        }
        ],

});
chart.render();
 
}
</script>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/morris/morris.css">
<!--begin page css link-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/begin.css">
<!--<div class="content-wrapper"> -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<section class="content" id="dashboard-content">

    <div class="row">

        <!-- Main content -->
        <!-- Main content -->
        <section class="content-header">
                    <h1>
                       <small>USSD Session Analysis Report</small>
                    </h1>
                    <ol class="breadcrumb">
                      <?php $this->session->set_flashdata('message', ''); ?>
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i>Visualizaions</a></li>
                    </ol>
                </section>  

       
                <div class="box box-success">
                        <div class="box-header with-border">
                            <!-- <h3 class="box-title" style="text-align: center;">Trend of requests since 2018</h3> -->

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                           
                        </div>
                       
                        <span style="color:red;margin-left: 5%"><i class="fa fa-minus"></i></span> Confirmed Requests <span style="color:blue;margin-left: 2%"><i class="fa fa-minus"></i></span> UnConfirmed/other Requests 
                        <div id="chartContainer" style="height: 400%; width: 100%;"></div>
                        
                        <!-- /.box-body -->
                    </div>
        <!-- /.content -->
    </div>
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