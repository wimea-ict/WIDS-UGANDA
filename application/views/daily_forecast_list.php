<!--amoko  Replace whole file -->
        <!-- Main content -->
        <section class="content-header">
                    <h1>
                        Daily Forecast
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <?php $this->session->set_flashdata('message', ''); ?>
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/Daily_forecast/index"><i class="fa fa-dashboard"></i> Daily forecast</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
                    </ol>
                </section>
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>DAILY FORECAST LIST 
    <?php echo anchor(site_url('index.php/daily_forecast/word'), '<i class="fa fa-file-word-o"></i> Word', 'class="btn btn-primary btn-sm"'); ?>
    <?php echo anchor(site_url('index.php/daily_forecast/pdf'), '<i class="fa fa-file-pdf-o"></i> PDF', 'class="btn btn-primary btn-sm"'); ?> <?php echo anchor(site_url('index.php/daily_forecast/addnew'), '<i class="fa fa-plus"></i> Add New Forecast', 'class="btn btn-primary btn-sm"');
  echo " ".anchor(site_url('index.php/daily_forecast/pdf_uploader'), '<i class="fa fa-file-pdf-o"></i> 6Hrly PDF Uploader', 'class="btn btn-success btn-sm"'); 
    echo " ".anchor(site_url('index.php/daily_forecast/pdf_uploader24'), '<i class="fa fa-file-pdf-o"></i> 24Hrly PDF Uploader', 'class="btn btn-success btn-sm"'); ?>
        
        </h3> 
        
        <div class="box-body">
            <ol class="breadcrumb">
                 <li> <span class="fa fa-clock-o" aria-hidden="true">Early Morning(12:00am - 06:00am)</span></li>
                 <li> <span class="fa fa-clock-o" aria-hidden="true">Late Morning(06:00am - 12:00pm)</span></li>
                  <li><span class="fa fa-clock-o" aria-hidden="true">Afternoon(12:00pm -06:00pm) </span></li>
                  <li><span class="fa fa-clock-o" aria-hidden="true">Late Evening( 06:00pm-12:00am) </span>
            </ol>
           <!--  <h5 style="color: red"><b>Alert:</b> The six hourly uploader will temporarily be inactive! But the 24-hourly uploader is ACTIVE</h5> -->
        </div>
       
          </div><!-- /.box-header -->
          <div class='box-body'>
        <div class="table-responsive"><table class="table table-bordered table-striped" id="mytable">
                          <thead>
                              <tr>
                          <th width="80px">No</th>
                          <th>Forecast Date</th>
                          <th>Forecast Time</th>
                          <th>Issue Date</th>
                          <th>Validity</th>
                      <th>Duty Forecaster</th>
                      <th>Weather Summary</th>
                          <th>Language</th>
                      <th>Action</th>
                         </tr>
                          </thead>
                    <tbody>
                          <?php
                          $start = 0;
                    if(isset($daily_forecast_data)){
                          foreach ($daily_forecast_data as $p)
                          {   ?>
                              <tr>
                      <td><?php echo ++$start ?></td>
                    <td><?php  echo $p['date']; ?></td>     
                    <td><?php echo $p['time']; ?></td>
                    <td><?php echo $p['issuedate']; ?></td>
                    <td><?php echo $p['validitytime']; ?></td>
                    <td><?php echo $p['dutyforecaster']; ?></td>      
                    <td><?php echo $p['weather']; ?></td>
                          <td><?php echo $p['language']; ?></td>
                    <td style="text-align:center" width="140px">
                    <?php
                                   
                         echo anchor(site_url('index.php/daily_forecast/daily_forecast_data/'.$p['id']),'<i class="fa fa-cloud"></i>',array('title'=>'Area forecast','class'=>'btn btn-primary btn-sm')); 
                          echo '  ';
                         // echo anchor(site_url('index.php/Forecast_impact/daily_impacts_data/'.$p['id']),'<i class="fa  fa-exclamation"></i>',array('title'=>'Forecast Impacts','class'=>'btn btn-primary btn-sm')); 
                          echo '  ';
                          echo anchor(site_url('index.php/daily_forecast/updated/'.$p['id']),'<i class="fa fa-pencil-square-o"></i>',array('title'=>'edit','class'=>'btn btn-primary btn-sm'));
                          echo '  ';
                          echo anchor(site_url('index.php/daily_forecast/delete1/'.$p['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are you sure, you want to delete this record?\')"');
                          //echo anchor(site_url('index.php/Advisory/daily1/'.$p['id']) ,'<i class=" ion-android-mail" style="margin-left:10px;"></i>',array('title'=>'Advisory','class'=>'class="btn btn-primary btn-sm"')); 

                    ?>
                      </td>
                        </tr>
                              <?php
                          }
                    
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
