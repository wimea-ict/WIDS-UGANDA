
        <!-- Main content -->

         <section class="content-header">
<!----------------------------- Amoko ------------------------------------>
                    <h1>
                        Region
                        <small>Data tables</small>
                    </h1>
<!----------------------------- Amoko ------------------------------------>

                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Administrative Structures</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Regions</a></li>
                    </ol>
                </section>

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>LIST OF REGIONS <?php
                   if($_SESSION['usertype'] == "wimea" || $_SESSION['usertype'] == "forecast"){
				  echo anchor('index.php/season/create/','Create',array('class'=>'btn btn-danger btn-sm'));
				   }else{

				   }?>
		<?php //echo anchor(site_url('index.php/season/excel'), ' <i class="fa fa-file-excel-o"></i> Excel', 'class="btn btn-primary btn-sm"'); ?>
        
<!----------------------- Amoko -------------------------------------->
		<?php echo anchor(site_url('index.php/region/word'), '<i class="fa fa-file-word-o"></i> Word', 'class="btn btn-primary btn-sm"'); ?>
<!----------------------- Amoko -------------------------------------->

		<?php echo anchor(site_url('index.php/region/pdf'), '<i class="fa fa-file-pdf-o"></i> PDF', 'class="btn btn-primary btn-sm"'); ?></h3>

        <?php echo anchor(site_url('index.php/Region/displayform'), '<i class="fa fa-plus"></i> Add New', 'class="btn btn-success btn-sm"'); ?>

                </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
                <div class='box-body'   >
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
                    <th width="80px">No</th>
		   		    <th>Region Name</th>
		            <th>Action</th>
           	    </tr>
            </thead>
	    <tbody>

        <?php foreach($region_data as $re){


		?>
        <tr>
		    <td><?php echo ++$start ?></td>
			<td><?php  echo $re->region_name;?></td>

		    <td style="text-align:center" width="140px">
          <?php
                echo '  ';
               echo anchor(site_url('index.php/Region/update/'.$re->id),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'Edit','class'=>'btn btn-primary btn-sm'));
                echo '  ';
                echo anchor(site_url('index.php/Region/delete/'.$re->id),'<i class="fa fa-trash-o"></i>','title="Delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are You Sure ?\')"');

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
