<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/morris/morris.css">
<!--begin page css link-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/begin.css">
<!--<div class="content-wrapper"> -->
    <section class="content" id="dashboard-content">

        <div class="row">
            <section class="content-header">
                <h1>
                 <small>Statistics of USSD Requests</small>
             </h1>
             <ol class="breadcrumb">
              <?php $this->session->set_flashdata('message', ''); ?>
              <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
              <li><a href="#"><i class="fa fa-dashboard"></i>Visualizaions</a></li>
          </ol>
      </section>  


      <div class="box box-success">
        <div class="box-header with-border">

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body chart-responsive">
            <?php
            $today = date('F j, Y, g:i a');
            ?>
            <h5><b><span style="color: cornflowerblue;"><?=$today ?></span>: USSD DAILY REQUESTS <span style="color: red">Vs</span> SEASONAL FORECASTS <span style="color: red">Vs</span> MARINE FORECASTS</b></h5>
            <div class="chart" id="test_bar" style="height: 400px;">

                <?php echo $bar_chart; ?>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.content -->
</div>
</section>

<script src="<?php echo base_url() ?>assets/plugins/morris/raphael.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url() ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>assets/plugins/knob/jquery.knob.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/chartjs/Chart.min.js"></script>