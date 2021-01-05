
        <!-- Main content -->

         <section class="content-header">
                    <h1>
                        Seasonal Forecast Updates
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i>Seasonal</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Forecast Updates</a></li>
                    </ol>
                </section>

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>SEASONAL FORECAST UPDATES INFORMATION <?php
                   if($_SESSION['usertype'] == "wimea" || $_SESSION['usertype'] == "forecast"){
				  echo anchor('index.php/season/create/','Create',array('class'=>'btn btn-danger btn-sm'));
				   }
				   $idd = $this->uri->segment(3);
				   $link = site_url('index.php/Updates/create/'.$idd);
				   ?>
		 &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
        <?php echo anchor($link, '<i class="fa fa-file-pdf-o"></i> Add New Seasonal Updates', 'class="btn btn-primary btn-sm"'); ?>
        </h3>
       
                </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
                <div class='box-body'   >
        <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
            <th width="80px">No</th>
		    <th>Month</th>
            <th>Season</th>
            <th>Rainfall Outlook</th>            
            <th>Further outlook</th>
            <th>Conclusion</th>
		    <th>Action</th>
           </tr>
            </thead>
	    <tbody>
            <?php
            $start = 0;
            foreach ($updates_data as $d) {
            ?>
            <tr>
		    	<td><?php echo ++$start ?></td>
				<td><?php echo $d['month']; ?></td>
                <td><?php echo $d['abbreviation'] ?></td>
                <td><?php  echo substr($d['rainfall_outlook'],1,50)." More ..." ; ?></td>
                <td><?php echo substr($d['further_outlook'],1,50)." More ..." ; ?></td>
                <td><?php echo substr($d['conclusion'],1,50)." More ..." ; ?></td>
		    <td style="text-align:center" width="140px">
			<?php
						echo '  ';
           
			echo anchor(site_url('index.php/Season/update/'.$d['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-primary btn-sm'));
			echo '  ';
			echo anchor(site_url('index.php/Season/delete/'.$d['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are You Sure ?\')"');
		   
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
