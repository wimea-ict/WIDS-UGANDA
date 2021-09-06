<!-- Main content -->

        <section class="content-header">
                    <h1>
                       Seasonal Advisories
                    </h1>
                    <ol class="breadcrumb">
                    	<?php $this->session->set_flashdata('message', ''); ?>
                         <li><a href="<?php echo base_url() ?>index.php/Landing"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/Season"><i class="fa fa-dashboard"></i> Seasonal Forecast</a></li>
                        <li><a href="#"><i class="fa fa-dashboard">Advisories</i>

                    </ol>
                </section> 
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>ADVISORIES 
        <?php 
        $link = "index.php/Advisory/create/".$this->uri->segment(3);
        //echo anchor(site_url('index.php/Advisory/excel'), ' <i class="fa fa-file-excel-o"></i> Excel', 'class="btn btn-primary btn-sm"'); ?>
		<?php $this->session->set_flashdata('message', ''); 
		echo anchor(site_url('index.php/Advisory/word'), '<i class="fa fa-file-word-o"></i> Word', 'class="btn btn-primary btn-sm"'); ?>
		<?php echo anchor(site_url('index.php/Advisory/pdf'), '<i class="fa fa-file-pdf-o"></i> PDF', 'class="btn btn-primary btn-sm"'); ?>
    
        <?php if($this->uri->segment(3) != NULL) echo anchor(site_url($link ), '<i class="fa fa-plus"></i> Add Advisory', 'class="btn btn-success btn-sm"'); ?>

        </h3>
                </div><!-- /.box-header -->
                <div class='box-body'>
        <div class="table-responsive">
              <table class="table table-bordered " id="mytable">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Language</th>
                    <th>Sub-region</th>
                    <th>Sector</th>
                    <th>Season</th>
                    
                     
                     <th>Advisory Message</th>
                    <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php	
			
            $start = 0;
		if(isset($advisory_data)){
            foreach ($advisory_data as $ad)
            {
             ?>
                <tr>
                    <td><?php echo ++$start ?></td>
                    <td><?php echo $ad['language']; ?></td>  
                    <td><?php  echo $ad['sub_region_name'] ; ?></td>
                    <td><?php  echo $ad['sector_name'] ; ?></td>
                    <td><?php  echo $ad['abbreviation']."(".$ad['year'].")";  ?></td>
                                     
                    <td> <?php echo $ad['message_summary']; ?>     </td>                 
                    
                    <td style="text-align:center" width="140px">
			<?php 

//////////////////////////// AMoko///////////////////////
			echo anchor(site_url('index.php/Advisory/read/'.$ad['id']),'<i class="fa fa-eye"></i>',array('title'=>'detail','class'=>'btn btn-primary btn-sm'));
//////////////////////////// AMoko///////////////////////
	 
			    // echo anchor(site_url('index.php/Advisory/update/'.$ad['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-primary btn-sm')); 
			    echo '  '; 
			    echo anchor(site_url('index.php/Advisory/delete/'.$ad['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure, you want to delete this record ?\')"'); 
			
			?>
		    </td>
	        </tr>
                <?php
            }
			
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