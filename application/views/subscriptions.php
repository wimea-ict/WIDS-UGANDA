
<!-- Main content -->

<section class="content-header">
  <h1>
    USSD SUBSCRIBERS
    <small>Data tables</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> USSD Subscription</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> Subscribers</a></li>
  </ol>
</section>  

<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>
        <div class='box-body'   >
          <table class="table table-bordered table-striped" id="mytable">
            <thead>
              <tr>
               <th width="30px">No</th>
               <th>Phone</th>
               <th>Forecast</th>
               <th>District</th>
               <th>Language</th>
               <th>Date</th>
             </tr>
           </thead>
           <tbody>

            <?php foreach($subscriptions as $re){ ?>
              <tr>
                <td><?php echo ++$start ?></td>
                <td><?=$re->phone; ?></td>
                <td><?=($re->forecast == 1)? "Daily Forecast":"Seasonal Forecast"; ?></td>
                <td><?=$re->division_name; ?></td>
                <td><?=$re->language; ?></td>
                <td><?=date('d F Y', strtotime($re->timestamp)); ?></td>


                
              </tr>

            <?php  }  ?>
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