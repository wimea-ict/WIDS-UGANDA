<!-- Amoko  Replace the whole file -->
        <!-- Main content -->

         <section class="content-header">
                    <h1>
                        Marine Forecasts
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/Victoria"><i class="fa fa-dashboard"></i>Marine</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Forecast Area</a></li>
                    </ol>
                </section>

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>24-HOUR MARINE FORECAST <?php
      //              if($_SESSION['usertype'] == "wimea" || $_SESSION['usertype'] == "forecast"){
				  // echo anchor('index.php/season/create/','Create',array('class'=>'btn btn-danger btn-sm'));
				  //  }
				   $idd = $this->uri->segment(3);
				   $link = site_url('index.php/Victoria/createregionforecast/'.$idd);
				   ?>
		<?php
        // echo anchor(site_url('index.php/season/wording'), '<i class="fa fa-file-word-o"></i> Word', 'class="btn btn-primary btn-sm"');  
        //echo anchor(site_url('index.php/season/pdf'), '<i class="fa fa-file-pdf-o"></i> PDF', 'class="btn btn-primary btn-sm"');
         echo anchor($link, '<i class="fa fa-plus"></i> Add Zonal Forecast', 'class="btn btn-success btn-sm"'); ?>
        </h3>
       
                </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
                <div class='box-body'   >
        <div class="table-responsive"><table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
            <th width="80px">No</th>
		    <th>Zone</th>
            <th>Highlight</th>
            <th>Period</th>
            <th>Wind strength</th>
            <th>Wind Direction</th>            
            <th>Wave Height</th>
            <th>Weather</th>
            <th>Rainfall Distribution</th>
            <th>Visibility</th>
            <th>Harzard</th>
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
				<td><?php echo $d['area_name']; ?></td>
                <td><?php echo $d['highlights']; ?></td>
                <td><?php echo $d['time'] ?></td>
                <td><?php echo $d['wind_strength'] ?></td>
                <td><?php echo $d['wind_direction'] ?></td>
                <td><?php echo $d['wave_height']; ?></td>

                <td><?php echo $d['cat_name'] ?></td>
                <td><?php echo $d['rainfall_dist'] ?></td>
                <td><?php echo $d['visibility'] ?></td>
                <td style="background: <?php echo $d['harzard']; ?>"></td>
               

		    <td style="text-align:center" width="140px">
			<?php
						echo '  ';
           
			// echo anchor(site_url('index.php/Season/update/'.$d['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-primary btn-sm'));
			echo '  ';
			echo anchor(site_url('index.php/Victoria/delete_area/'.$d['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are you sure, you want to delete this forecast ?\')"');
		   
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
