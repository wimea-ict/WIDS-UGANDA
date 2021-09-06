<!-- Main content -->

<section class="content-header">
    <h1>
     Monthly Advisories
 </h1>
 <ol class="breadcrumb">
   <?php $this->session->set_flashdata('message', ''); ?>
   <li><a href="<?php echo base_url() ?>index.php/Landing"><i class="fa fa-dashboard"></i> Home</a></li>
   <li><a href="<?php echo base_url() ?>index.php/monthly_forecast"><i class="fa fa-dashboard"></i> Monthly Forecast</a></li>
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
            $link = "index.php/monthly_forecast/advisory_form/".$this->uri->segment(3);
        //echo anchor(site_url('index.php/Advisory/excel'), ' <i class="fa fa-file-excel-o"></i> Excel', 'class="btn 

            if($this->uri->segment(3) != NULL) echo anchor(site_url($link ), '<i class="fa fa-plus"></i> Add Advisory', 'class="btn btn-success btn-sm"'); ?>

        </h3>
    </div><!-- /.box-header -->
    <div class='box-body'>
        <div class="table-responsive">
          <table class="table table-bordered " id="mytable">
            <thead>
                <tr>
                    <th width="30px">No</th>
                    <th>Sector</th>
                    <th>Season</th>
                    <th>Advisory Message</th>
                    <th>Action(s)</th>
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
                        <td><?php  echo $ad['minor_name'] ; ?></td>
                        <td><?php  echo $ad['month_from']. " & ".$ad['month_to']."";  ?></td>

                        <td> <?php echo $ad['message_summary']; ?>     </td>                 

                        <td style="text-align:center" width="">
                         <?php 
                         
                         echo anchor(site_url('index.php/monthly_forecast/update_advisroy/'.$ad['advisory_id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'Edit Advisory','class'=>'btn btn-success btn-sm'));         
                         
                         echo '  '; 
                         echo anchor(site_url('index.php/monthly_forecast/delete_advisory/'.$ad['advisory_id']),'<i class="fa fa-trash-o"></i>','title="Delete Advisory" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are you sure, you want to delete this Advisory record ?\')"'); 
                         ?>
                         &nbsp;&nbsp;
                         <?php 
                         
                         ?>
                         
                         
                         
                         
                        

                         
                         <?php 
         //  }
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