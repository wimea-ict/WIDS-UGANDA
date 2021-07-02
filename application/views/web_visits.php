<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$past_30 = date('Y-m-d', strtotime('-30 days'));

?>

<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    title:{
        text: "Unique Web Requests"
    },
    axisY: {
        title: "Number of requests",
        includeZero: true
    },
    data: [{
        type: "bar",
        yValueFormatString: "#,###",
        indexLabel: "{y}",
        indexLabelPlacement: "inside",
        indexLabelFontWeight: "bolder",
        indexLabelFontColor: "black",
        dataPoints: <?php echo json_encode($graph_data, JSON_NUMERIC_CHECK); ?>
    }]
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
                       <small>Web Requests Report</small>
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
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <h5>Daily Requests: <?=$daily_count?></h5>
                                </div>
                                <div class="col-md-6">
                                     <h5>Seasonal Requests: <?=$seasonal_count?></h5>
                                </div>
                            </div>
                           
                        </div>
                        <div id="chartContainer" style="height: 200px; width: 100%;"></div><br>
                        <hr>
                        <h4><center><b>Web Visits Table</b></center></h4>




                        <div class="table-responsive"><table class="table table-bordered " id="mytable">
            <thead>
                <tr>
                    <th width="40px">No</th>    
                    <th>Region </th>
                    <th>City</th>
                    <th>Public Ip</th>
                    <th>Page Visited</th>
                    <th>Date</th>
                </tr>
            </thead>
        <tbody>
            <?php
            $start = 0;
        //print_r($season_data); exit;
            foreach ($visits_data as $row)
            { ?>
                <tr>
                    <td><?php   echo ++$start; ?></td>
                    <td><?php   echo $row['region']; ?></td>
                    <td><?php   echo $row['city']; ?></td>
                    <td><?php   echo $row['userip']; ?></td>
                    <td><?php   echo $row['page']; ?></td>
                     <td><?php   echo $row['date_visited']; ?></td>
                 
            </tr>
                <?php
            }
            ?>
            </tbody>
        </table></div>
        <script src="<?php echo base_url('assets/frameworks/jquery/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        </script>
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