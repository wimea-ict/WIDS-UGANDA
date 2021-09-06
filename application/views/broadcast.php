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
    WIDS Broadcast
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

          <h3 class='box-title'>WIDS Message Broadcast</h3>
          <div class='box box-primary'>
            <form action="<?php echo site_url('index.php/Season/broadcast_msg'); ?>" method="post" enctype="multipart/form-data" ><table class='table table-bordered'>
              <tr><td>Date Range:</td>
                <td> 
                  Start Date<br>
                  <input type="date" name="date_from" class="form-control" required>
                </td>
                <td>
                 End Date: <br>
                 <input type="date" name="date_to" class="form-control" required>
               </td>
             </tr>        
             <tr>
              <td>Message:</td>
              <td colspan="2">
                <textarea id="message" style="width: 100%" cols="90" name="msg" maxlength="150"></textarea>
                <div id="the-count_message" style="">
                  <span id="current_message">0</span>
                  <span id="maximum_message"> / 150</span>
                </div>
              </td>
            </tr>

            <tr>
              <td><input type="submit" value="Make a Broadcast" name="submit" class="btn btn-primary">
              </td>
            </tr>

          </table></form>
          <?php

          ?>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->

<script>
  $('#message').keyup(function () {
    var characterCount = $(this).val().length,
    current = $('#current_message'),
    maximum = $('#maximum_message'),
    theCount = $('#the-count_message');
    var maxlength = $(this).attr('maxlength');
    var changeColor = 0.75 * maxlength;
    current.text(characterCount);

    if (characterCount > changeColor && characterCount < maxlength) {
      current.css('color', '#FF4500');
      current.css('fontWeight', 'bold');
    }
    else if (characterCount >= maxlength) {
      current.css('color', '#B22222');
      current.css('fontWeight', 'bold');
    }
    else {
      var col = maximum.css('color');
      var fontW = maximum.css('fontWeight');
      current.css('color', col);
      current.css('fontWeight', fontW);
    }
  });
</script>
