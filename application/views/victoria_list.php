
        <!-- Main content -->

         <section class="content-header">
                    <h1>
                        Victoria Forecast
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/Victoria"><i class="fa fa-dashboard"></i> Victotia Forecast</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
                    </ol>
                </section>  

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>24-HOUR MARINE FORECAST  <?php
                 
				//  echo anchor('index.php/season/create/','Create',array('class'=>'btn btn-danger btn-sm'));
				  ?>
		<?php //echo anchor(site_url('index.php/season/excel'), ' <i class="fa fa-file-excel-o"></i> Excel', 'class="btn btn-primary btn-sm"'); ?>
		<?php // echo anchor(site_url('index.php/Victoria/word'), '<i class="fa fa-file-word-o"></i> Word', 'class="btn btn-primary btn-sm"'); ?>
		<?php //echo anchor(site_url('index.php/Victoria/pdf'), '<i class="fa fa-file-pdf-o"></i> PDF', 'class="btn btn-primary btn-sm"'); ?>
        <?php echo anchor(site_url('index.php/Victoria/create'), '<i class="fa fa-plus"></i> Add Marine Forecast', 'class="btn btn-success btn-sm"'); ?>
      
        </h3>
        
         </h3> 
                </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
                <div class='box-body'   >
        <div class="table-responsive"><table class="table table-bordered " id="mytable">
            <thead>
                <tr>
                    <th width="40px">No</th>	
                    <th>Forecast Date</th>
                    <th>Issue Date</th>
                    <th>Advice</th>
                    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
		//print_r($season_data); exit;
            foreach ($victoria_data as $p)
            { ?>
                <tr>
                    <td><?php   echo ++$start; ?></td>
                    <td><?php   echo $p['forecast_date']; ?></td>
                    <td><?php   echo $p['issue_date']; ?></td>
                    <td><?php   echo substr($p['advice'], 0,100).'...' ?></td>
                    <td style="text-align:center" width="">
			<?php 
			echo anchor(site_url('index.php/Victoria/read/'.$p['id']),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-primary btn-sm')); 
			echo '  ';
				
			// echo anchor(site_url('index.php/Victoria/update/'.$p['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-primary btn-sm'));			
			 
			

			?>
          
            &nbsp;&nbsp;
            <?php 
            $area_forecast = "index.php/Victoria/showareaforecast/".$p['id'];
            echo anchor(site_url($area_forecast),'<i class="fa fa-cloud"></i>',array('title'=>'Area Forecasts','class'=>'class="btn btn-primary btn-sm"'));
            ?>
            &nbsp;&nbsp;
            <?php

            echo '  '; 
            echo anchor(site_url('index.php/Victoria/delete/'.$p['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are You Sure ?\')"');

			?>


         
		    </td>
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
                    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->