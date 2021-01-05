
        <!-- Main content -->
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
            type: "bar",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();
     
    }
    </script>

        <section class="content-header">

<h1>
    REQUESTED SECTORS
    <small>REPORTS</small>
</h1>


<ol class="breadcrumb">
    <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i>Requested Sectors</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> Report</a></li>
</ol>
</section>

<section class='content'>
<div class='row'>
<div class='col-xs-12'>
<div class='box'>
<div class='box-header'>

<h3 class='box-title'>  &nbsp


<!-- change the link -->
<?php echo anchor(site_url('index.php/district_coverage/word'), '<i class="fa fa-file-word-o"></i> Download Word Doc', 'class="btn btn-primary btn-sm"'); ?>


<?php echo anchor(site_url('index.php/district_coverage/pdf'), '<i class="fa fa-file-pdf-o"></i> Download PDF', 'class="btn btn-primary btn-sm"'); ?></h3>





<div class='box-body'   >
<table class="table table-bordered table-striped" id="mytable">
<thead>
<tr>
<th width="80px">No</th>
<th> Sector</th>
<th>Request Frequency</th>
</tr>
</thead>
<tbody>
<?php
$start = 0;
// print_r($city_data); exit();
foreach ($requested_sectors as $c)
{
$sector_name = $c["menuvalue"];
$date = date("Y-m-d");
        $query = "SELECT menuvalue as sector, COUNT(menuvalue) as frequency FROM ussdtransaction_new WHERE menuvariable ='sector' AND menuvalue = '$sector_name'  ORDER BY frequency DESC";
        $result = $this->db->query($query);
        
?>
<tr>
<td><?php echo ++$start ?></td>
<td><?php
krsort($result->result_array());
    foreach ($result->result_array() as $row) {


            $sector = $row['sector'];
           
     echo $sector;
    }
      ?></td>

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
