<!-- Amoko  Replace the whole file -->
<!-- Main content -->

<section class="content-header">
    <h1>
        Seasonal Forecasts
        <small>Data tables</small>
    </h1>
    <ol class="breadcrumb">
        <?php $this->session->set_flashdata('message', ''); ?>
        <li><a href="<?php echo base_url() ?>index.php/Landing"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url() ?>index.php/Season"><i class="fa fa-dashboard"></i>Seasonal</a></li>
        <li><a href="#"><i class="fa fa-dashboard"></i> Forecast Area</a></li>
    </ol>
</section>

<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>
          <h3 class='box-title'>SEASONAL FORECAST AREA INFORMATION <?php
          if($_SESSION['usertype'] == "wimea" || $_SESSION['usertype'] == "forecast"){
             // echo anchor('index.php/season/create/','Create',array('class'=>'btn btn-danger btn-sm'));
          }
          $idd = $this->uri->segment(3);
          $link = site_url('index.php/Season/createregionforecast/'.$idd);
          ?>
          <?php echo anchor(site_url('index.php/season/wording'), '<i class="fa fa-file-word-o"></i> Word', 'class="btn btn-primary btn-sm"'); ?>
          <?php echo anchor(site_url('index.php/season/pdfing'), '<i class="fa fa-file-pdf-o"></i> PDF', 'class="btn btn-primary btn-sm"'); ?>
          <?php echo anchor($link, '<i class="fa fa-plus"></i> Add New', 'class="btn btn-success btn-sm"'); ?>
      </h3>

  </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
  <div class='box-body table-responsive'   >
    <table class="table table-bordered table-striped" id="mytable">
        <thead>
            <tr>
                <th width="30px">No</th>
                <th>Language</th>
                <th>Region</th>
                <th>Sub Region</th>
                <th>Rain Onset</th>
                <th>Expected Rain Peak</th>            
                <th>Rain End Period</th>
                <th>Overall Comment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $start = 0;
            foreach ($forecast_area_data as $d) {
                ?>
                <tr>
                    <td><?php echo ++$start ?></td>
                    <td><?php echo $d['language']; ?></td>

                    <td><?php echo $d['region_name']; ?></td>
                    <td><?php echo $d['sub_region_name']; ?></td>
                    <td><?php echo $d['onsetdesc']."&nbsp;".$d['onset_period']; ?></td>
                    <td><?php echo $d['peakdesc']."&nbsp;".$d['expected_peak']; ?></td>
                    <td><?php echo $d['enddesc']."&nbsp;".$d['end_period']; ?></td>
                    <td><?php echo substr($d['overall_comment'], 0,100).' ...' ?></td>


                    <td style="text-align:center" width="140px">
                        <?php
                        echo '  ';

                        echo anchor(site_url('index.php/Season/ViewArea/'.$d['id']),'<i class="fa fa-eye"></i>',array('title'=>'view','class'=>'btn btn-primary btn-sm'));

            // echo anchor(site_url('index.php/Season/update/'.$d['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-primary btn-sm'));
                        echo '  ';
                        echo anchor(site_url('index.php/Season/delete/'.$d['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are You Sure ?\')"');

                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <script src="<?php echo base_url('assets/frameworks/jquery/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
    <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
    <script type="text/javascript">
     $(document).ready(function () {
        $("#mytable").dataTable();
    });
</script>

</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content --><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
</head>

<body>
</body>
</html>
