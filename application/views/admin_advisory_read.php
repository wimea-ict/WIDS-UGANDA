
        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                <h3 class='box-title'>Advisory Read</h3>
				<div class="table-responsive">
        <table class="table table-bordered" style="margin-top: 20px;">

          <?php foreach ($advisory_read as $k) {?>

              <tr>
                <td>Sector</td>
                <td><?php echo $k->minor_name  ?></td>
              </tr>
              <tr>
                <td>Forecast</td>
                <td><?php echo $k->abbreviation; ?></td>
              </tr>
              <tr>
                <td>Advice</td>
                <td><?php echo $k->advice  ?></td>
              </tr>
              <tr>
                <td>Summary</td>
                <td><?=$k->message_summary  ?></td>
              </tr>
          <?php }  ?>
	   <tr>
      <td colspan="2">
        <a href="<?php echo base_url().'index.php/Advisory/index/'.$_SESSION['parent_id'] ?>">
          <button style="width: 60px; height: 30px; color: black">Close</button>
        </a>
      </td> 
     </tr>
	     </table></div>
        </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->