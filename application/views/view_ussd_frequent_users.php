      <section class="content-header">
                    <h1>
                        <?php

                         echo strtoupper($submitted_district)?> 
                          USSD FREQUENT USERS
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Frequent Users</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
                    </ol>
                </section>  

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>USSD FREQUENT USERS 
    <?php //echo anchor(site_url('index.php/season/excel'), ' <i class="fa fa-file-excel-o"></i> Excel', 'class="btn btn-primary btn-sm"'); ?>
    <?php echo anchor(site_url('index.php/Landing/frequent_users_word'), '<i class="fa fa-file-word-o"></i> Export Word', 'class="btn btn-primary btn-sm"'); ?>

    <?php echo anchor(site_url('index.php/Landing/frequent_users_pdf'), '<i class="fa fa-file-pdf-o"></i> Download PDF', 'class="btn btn-primary btn-sm"'); ?>
    <?php echo anchor(site_url('index.php/Landing/overall_frequent_users_word'), '<i class="fa fa-file-word-o"></i> Export Overall Users Word', 'class="btn btn-primary btn-sm"'); ?>
        <?php echo anchor(site_url('index.php/Landing/frequent_users'), '<i class="fa fa-plus"></i> View Frequent Users For Another District', 'class="btn btn-success btn-sm"'); ?>
      
        </h3>
        
         </h3> 
                </div><!-- /.box-header --> <!--style=" overflow-y: scroll;"-->
                <div class='box-body'   >
        <div class="table-responsive"><table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
            <th width="80px">No</th>
            <th>Most Frequent Phone</th>
            <th>Frequency</th>
           </tr>
            </thead>
      <tbody>
            <?php
            $start = 0;
      if(isset($frequent_users_data)){
            foreach ($frequent_users_data as $p)
            {   ?>
                <tr>
        <td><?php echo ++$start ?></td>     
      <td><?php echo $p['phone']; ?></td>
      <td><?php echo $p['MOST_FREQUENT']; ?></td>
      
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
          <div class="box-tools pull-right">
       
       
       </div>
      
                    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->


