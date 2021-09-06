        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                  <h3 class='box-title'> USER FEEDBACK <strong> REPLY</strong></h3>
                      <div class='box box-primary'>
                        <?php
                        $add_id = $this->uri->segment(3);
                 $sqlx = "SELECT * FROM  feedback WHERE  id = $add_id";
                            $sql2= $this->db->query($sqlx);
                            $cont = "";$fb = "";
                            foreach ($sql2->result_array() as $row1) {
                              $cont = $row1['phone'];
                              $fb = $row1['feedback'];
                            } ?>


        <form action="<?php echo site_url('index.php/Landing/ussd_users_feedback').'/'.$this->uri->segment(3); ?>" method="post" enctype="multipart/form-data" ><table class='table table-bordered'>
        <tr>
        <td>Contact</td>
        <td><input type="hidden" name="contact" value="<?=$cont ?>"><?=$cont ?> </td>
      </tr>
      <tr>
        <td>Feedback Message</td>
        <td><?=$fb ?></td>
      </tr>
      <tr><td>Reply</td>
           <td> <textarea rows="3" style="width: 100%" name="reply" required></textarea>          </td></tr>
 
                        
      <input type="hidden" name="forecast_id" value="<?php echo $add_id; ?>" />

      <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo "Reply" ?></button>
      <a href="<?php echo site_url('index.php/USSD/UserFeedback') ?>" class="btn btn-default">Cancel</a></td></tr>

    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
