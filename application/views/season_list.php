
        <!-- Main content -->

         <section class="content-header">
                    <h1>
                        Seasonal Forecast
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/Season/index"><i class="fa fa-dashboard"></i> Seasonal Forecast</a></li>
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
        		<?php //echo anchor(site_url('index.php/season/excel'), ' <i class="fa fa-file-excel-o"></i> Excel', 'class="btn btn-primary btn-sm"'); ?>
        		<?php echo anchor(site_url('index.php/Season/word'), '<i class="fa fa-file-word-o"></i> Export Word', 'class="btn btn-primary btn-sm"'); ?>
        		<?php echo anchor(site_url('index.php/Season/pdf'), '<i class="fa fa-file-pdf-o"></i> Download PDF', 'class="btn btn-primary btn-sm"'); ?>
                <?php echo anchor(site_url('index.php/Season/create'), '<i class="fa fa-plus"></i> Add Seasonal Forecast', 'class="btn btn-success btn-sm"'); ?>
      
        </h3>
        
         </h3> 
                </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
                <div class='box-body table-responsive'   >
        <table class="table table-bordered " id="mytable">
            <thead>
                <tr>
                    <th width="40px">No</th>	
                    <th>Season</th>
                    <th>Year</th>
                    <th>Overview</th>
                    <th>General Forecast</th>
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
                    <td><?php   echo $p['abbreviation']; ?></td>
                    <td><?php   echo $p['year']; ?></td>
                    <td><?php   echo substr($p['overview'],1,50)." More ..." ; ?></td>
                    <td><?php   echo substr($p['general_forecast'],1,50)." More ..."; ?></td>  
                    <td style="text-align:center" width="">
			<?php 
			echo anchor(site_url('index.php/season/read/'.$p['id']),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-primary btn-sm')); 
			echo '  ';
				
			echo anchor(site_url('index.php/season/update/'.$p['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-success btn-sm'));			
			 
			echo '  '; 
			echo anchor(site_url('index.php/season/delete/'.$p['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are you sure, you want to delete this seasonal forecast ?\')"'); 
			?>
            &nbsp;&nbsp;
            <?php 
			
			?>
            
            <?php 
			$advisory = "index.php/Advisory/index/".$p['id'];
			echo anchor(site_url($advisory),'<i class="	ion-android-mail"></i>',array('title'=>'Advisory','class'=>'class="btn btn-primary btn-sm"'));
			$area_forecast = "index.php/Season/showareaforecast/".$p['id'];
			?>
            &nbsp;&nbsp;
            <?php 
            echo anchor(site_url($area_forecast),'<i class="fa fa-cloud"></i>',array('title'=>'Area Forecasts','class'=>'class="btn btn-primary btn-sm"'));
			?>
			
            &nbsp;&nbsp;
            <?php 
            $audio = "index.php/Season/audio_list/".$p['id'];
            echo anchor(site_url($audio),'<i class="fa fa-file-audio-o"></i>',array('title'=>'Audio','class'=>'class="btn btn-primary btn-sm"'));
            ?>
               &nbsp;&nbsp;
            <?php 
            $disaster = "index.php/Disaster/index/".$p['id'];
            echo anchor(site_url($disaster),'<i class="fa fa-bolt"></i>',array('title'=>'Disasters','class'=>'class="btn btn-primary btn-sm"'));
            ?>

             &nbsp;&nbsp;
            <?php 
            $updates = "index.php/Updates/index/".$p['id'];
            echo anchor(site_url($updates),'<i class="fa fa-globe"></i>',array('title'=>'Seasonal Updates','class'=>'class="btn btn-primary btn-sm"'));
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