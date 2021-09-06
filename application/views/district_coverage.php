
        <!-- Main content -->

        <section class="content-header">

<h1>
    USSD ACCESSIBILITY
    <small>IN VARIOUS DISTRICTS</small>
</h1>


<ol class="breadcrumb">
    <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> USSD Accessibility</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
</ol>
</section>

<section class='content'>
<div class='row'>
<div class='col-xs-12'>
<div class='box'>
<div class='box-header'>

<h3 class='box-title'> OVERALL USSD-DISTRICT ACCESSIBILITY <?php


if($_SESSION['usertype'] == "wimea" || $_SESSION['usertype'] == "forecast"){
//echo anchor('index.php/season/create/','Create',array('class'=>'btn btn-danger btn-sm'));
}else{

}?>


<!-- change the link -->
<?php echo anchor(site_url('index.php/district_coverage/word'), '<i class="fa fa-file-word-o"></i> Download Word Doc', 'class="btn btn-primary btn-sm"'); ?>


<?php echo anchor(site_url('index.php/district_coverage/pdf'), '<i class="fa fa-file-pdf-o"></i> Download PDF', 'class="btn btn-primary btn-sm"'); ?></h3>





<div class='box-body'   >
<table class="table table-bordered table-striped" id="mytable">
<thead>
<tr>
<th width="80px">No</th>
<th> Reached District</th>
<th>Request Frequency</th>
</tr>
</thead>
<tbody>
<?php
$start = 0;
// print_r($city_data); exit();
foreach ($district_usage as $c)
{
$date = date("Y-m-d");
        $query = "SELECT COUNT(menuvalue) as frequency FROM ussdtransaction_new WHERE menuvariable ='district' AND menuvalue = '".$c['menuvalue']."' AND menuvalue != 'invaliddistrict'  AND date >= '2020-01-01 00:00:00'";
        $result = $this->db->query($query);
        
?>
<tr>
<td><?php echo ++$start ?></td>
<td><?php echo strtoupper($c['menuvalue']); ?></td>

<td>
	<?php
	foreach ($result->result_array() as $row) {
         	$frequency = $row['frequency'];
           
	 echo $frequency;
	}
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
