        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                <h3 class='box-title'>User Feedback Overview</h3>
                
             <?php foreach($reply_data as $dd){ ?>
        <table class="table table-bordered" style="margin-top: 20px">
            <tr>
                <td>Phone:</td><td><p><?php echo $dd['phone']; ?></p></td>
            </tr>
             <tr>
                <td>District:</td><td><?php echo $dd['district']; ?></td></tr>
            <tr>
             <tr>
                <td>Reply Message:</td><td><?php echo $dd['reply']; ?></td></tr>
            <tr>
            <tr>
                <td>Date</td><td><?php echo $dd['datetime']; ?></td>
            </tr>
            
           
            <?php 
        }
            ?>
           
            
                <td colspan="2">
                    <a href="<?php echo base_url().'index.php/USSD/UserFeedback' ?>"><button  style="background-color: #3c8dbc; width: 100px; height: 35px;border-radius: 5px; text-align: center;color: #fff">Go Back</button></a>
                </td>
            </tr>
            
            
    </table>

    
   
        </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->