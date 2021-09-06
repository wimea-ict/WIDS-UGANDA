<!--amoko  Replace whole file -->
        <!-- Main content -->
        <section class="content-header">
                    <h1>
                        USSD User Feedback
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <?php $this->session->set_flashdata('message', ''); ?>
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> USSD Management</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
                    </ol>
                </section>
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'>USSD USER FEEDBACK LIST 
                  <?php echo anchor(site_url('index.php/Landing/Users_word'), '<i class="fa fa-file-word-o"></i> Export Word', 'class="btn btn-primary btn-sm"').'   '; ?>
                  <?php echo anchor(site_url('index.php/Landing/Users_pdf'), '<i class="fa fa-file-pdf-o"></i> Download PDF', 'class="btn btn-primary btn-sm"'); ?> 
        
        </h3> 
        
        <div class="box-body">

    </div>
       
                </div><!-- /.box-header -->
                <div class='box-body'>
        <div class="table-responsive"><table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
            <th width="80px">No</th>
            <th>Date</th>
            <th>Phone/ Contact</th>
            <th>District</th>
            <th>Feedback</th>
            <th>Replied</th>
            <th>Action</th>
           </tr>
            </thead>
      <tbody> 
            <?php
            $start = 0;
      if(isset($ussd_feedback)){
            foreach ($ussd_feedback as $p)
            {   ?>
                <tr>
                <td><?php echo ++$start ?></td>
                <td><?php echo $p['datetime']; ?></td>
                  <td>+<?php  echo $p['phone']; ?></td>     
                  <td><?php echo ucwords($p['district']); ?></td>
                <td><?php echo $p['feedback']; ?></td>
                <td><?php echo substr($p['reply'],0,40)."....."; ?></td>
                <td style="text-align:center" width="140px">
        <?php
                        $add_id = $p['id'];
                 $sqlx = "SELECT * FROM  feedback WHERE  id = $add_id";
                            $sql2= $this->db->query($sqlx);
                            $cont = "";$fb = "";
                            foreach ($sql2->result_array() as $row1) {
                              $cont = $row1['phone'];
                              $fb = $row1['reply'];
                            } if(strlen($fb)>3){
                              echo anchor(site_url('index.php/USSD/View_feedback_reply/'.$p['id']),'<i class="fa fa-eye"></i>','title="View Reply" class="btn btn-success btn-sm"');
                                  echo ' ';
                              echo '<button class="btn btn-primary">Replied</button>';
                            }else{

                              
                              echo anchor(site_url('index.php/USSD/Reply/'.$p['id']),'<i class="fa fa-reply"></i>','title="Reply" class="btn btn-primary btn-sm"');

                            }
                            ?>
      <?php
              
              echo "  ";
              // echo anchor(site_url('index.php/Landing/delete/'.$p['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javascript: return confirm(\'Are You Sure ?\')"');

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
