
<!-- Main content -->

<section class="content-header">
    <h1>
        Monthly Forecast
        <small>Data tables</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url() ?>index.php/Season/index"><i class="fa fa-dashboard"></i> Monthly Forecast</a></li>
        <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
    </ol>
</section>  

<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>
          <h3 class='box-title'> 
            <?php

            echo " ";
            ?>

            <?php echo anchor(site_url('index.php/monthly_forecast/add_forecast'), '<i class="fa fa-plus"></i> Add Monthly Forecast', 'class="btn btn-success btn-sm"'); ?>

        </h3>
        
    </h3> 
</div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
<div class='box-body table-responsive'   >
    <table class="table table-bordered " id="mytable">
        <thead>
            <tr>
                <th width="40px">No</th>	
                <th>Start Month</th>
                <th>End Month</th>
                <th>Year</th>
                <th>Summary</th>
                <th>Rainfall Outlook</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $start = 0;
		//print_r($season_data); exit;
            foreach ($season_data as $p)
                { ?>
                    <tr>
                        <td><?php   echo ++$start; ?></td>
                        <td><?php   echo $p['month_from']; ?></td>
                        <td><?php   echo $p['month_to']; ?></td>
                        <td><?php   echo $p['year']; ?></td>
                        <td><?php   echo substr($p['summary'],1,50)." More ..." ; ?></td>
                        <td><?php   echo substr($p['weather_outlook'],1,50)." More ..."; ?></td>  
                        <td style="text-align:center" width="">
                         <?php 
                         echo anchor(site_url('index.php/monthly_forecast/read/'.$p['id']),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-primary btn-sm')); 
                         echo '  ';

                         echo anchor(site_url('index.php/monthly_forecast/update/'.$p['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-success btn-sm'));			

                         echo '  '; 
                         echo anchor(site_url('index.php/monthly_forecast/delete/'.$p['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are you sure, you want to delete this monthly forecast ?\')"'); 
                         ?>
                         &nbsp;&nbsp;
                         <?php 

                         ?>

                         <?php 
                         $advisory = "index.php/monthly_forecast/advisory_list/".$p['id'];
                         echo anchor(site_url($advisory),'<i class="	ion-android-mail"></i>',array('title'=>'Advisories','class'=>'class="btn btn-primary btn-sm"'));
                         ?>


                         &nbsp;&nbsp;

                         <?php 
                         $impacts = "index.php/monthly_forecast/impacts/".$p['id'];
                         echo anchor(site_url($impacts),'<i class="fa fa-bolt"></i>',array('title'=>'Impacts','class'=>'class="btn btn-primary btn-sm"'));
                         ?>


                         <?php 
		 //  }
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
        </section><!-- /.content -->