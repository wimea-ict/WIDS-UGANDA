<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/morris/morris.css">
<!--begin page css link-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/begin.css">
<!--<div class="content-wrapper"> -->


<section class="content" id="dashboard-content">

    <div class="row">

        <!-- Main content -->
        <!-- Main content -->
        <section class="content-header">
                    <h1>
                       <small>USSD Requests Trend Since 2018</small>
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
                            <h5><b></span> <?=date("Y")-1;?> USSD  REQUESTS <span style="color: red">Vs </span><?=date("Y");?> USSD REQUESTS </b></h5>
                            <div class="chart" id="test_bar" style="height: 420px;">
                                <?php echo $bar_chart; ?>
                            </div>
                        </div>
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