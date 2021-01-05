<!-- Main content -->
<script type="text/javascript">
    function HandleOption(){

      var SelectBox = document.getElementById('lang');
      var UserOption = SelectBox.options[SelectBox.selectedIndex].value;
      if(UserOption == 'English'){
        document.getElementById('DisplayOption').style.visibility = 'visible';
      }
      else{
        document.getElementById('DisplayOption').style.visibility = 'collapse';
      }
      return false;
    }
</script>

<section class="content-header">
                    <h1>
                        Broadcast
                        <small>Message</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i>Broadcast Message</a></li>
                    </ol>
                </section>
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  <h3 class='box-title'>Message Broadcast</h3>
<!------------------ Amoko -->

                      <div class='box box-primary'>
        <form action="<?php echo site_url('index.php/Season/broadcast_msg'); ?>" method="post" enctype="multipart/form-data" ><table class='table table-bordered'>

           
            <tr><td>Date Range:</td>
              <td> 
                Start Date<br>
                <input type="date" name="date_from" required>
             </td>
             <td>
               End Date: <br>
               <input type="date" name="date_to" required>
             </td>
           </tr>        
          <tr>
              <td>Message:</td>
              <td colspan="2">
                <textarea style="width: 100%" cols="90" name="msg"></textarea>
              </td>
          </tr>
        
	    <tr>
        <td><input type="submit" value="Broadcast" name="submit" class="btn btn-primary">
	   </td>
   </tr>

    </table></form>
    <?php
    // foreach ($selected_users as $dd) {
    //   # code...
    //   echo  $dd->phone;
    //   echo  $dd->menuvalue;
   // }
   
    ?>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
