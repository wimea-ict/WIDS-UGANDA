
        <!-- Main content -->
        
         <section class="content-header">
                    <h1>
                        Active User List
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Active User List</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
                    </ol>
                </section>  

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>ACTIVE USER LIST <?php
                  //have to replace the forecast usertype to user??
                   if($_SESSION['usertype'] == "wimea" || $_SESSION['usertype'] == "forecast"){
				  //echo anchor('index.php/Landing/create_user/','Create',array('class'=>'btn btn-danger btn-sm'));
				   }else{
					   
				   }?>
		<?php //echo anchor(site_url('index.php/season/excel'), ' <i class="fa fa-file-excel-o"></i> Excel', 'class="btn btn-primary btn-sm"'); ?>
		<?php
        $link = "/index.php/Landing/create_user";
         echo anchor(site_url($link), '<i class="fa fa-user-plus"></i>  Add New User', 'class="btn btn-success btn-sm"'); ?>
		<?php //echo anchor(site_url('index.php/season/pdf'), '<i class="fa fa-file-pdf-o"></i> PDF', 'class="btn btn-primary btn-sm"'); ?></h3>
                </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
                <div class='box-body'   >
        <div class="table-responsive"><table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="80px">No</th>
		    <th>Username</th>
			<th>First Name</th>
            <th>Last Name</th>
		    <th>Email</th>
		    <th>Role</th>
             <th>Phone No.</th>
		   <th>Action</th>
                </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($system_users as $users)
            {
                ?>
                <tr>
		    <td><?php echo ++$start ?></td>
			<td><?php echo substr(($users->username), 0, 20)?></td>
			<td><?php   echo substr(($users->first_name), 0, 20)?></td>
			<td><?php echo $users->last_name ?></td>
			<td><?php echo $users->email ?></td>
             <td><?php echo $users->usertype ?></td>
              <td><?php echo $users->phone ?></td>
			
		    <td style="text-align:center" width="140px" disabled>
			<?php 
             echo anchor(site_url('index.php/Landing/update_user/'.$users->id),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'Edit','class'=>'btn btn-primary btn-sm')); 
			echo ' '; 
			
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