        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  
                  <h3 class='box-title'> ADD  SEASONAL FORECAST UPDATES</h3>
                      <div class='box box-primary'>
        <form action="<?php echo site_url('index.php/Updates/SaveUpdates').'/'.$id; ?>" method="post" enctype="multipart/form-data" ><table class='table table-bordered'>

      
      <tr>

        <td>Month<?php echo form_error('month') ?></td>
           <td> 
           <select name="month"  class="form-control" id="month">
           <option value="Jan">January</option>
                            <option value="Feb">February</option>
                            <option value="Mar">March</option>
                            <option value="Apr">April</option>
                            <option value="May">May</option>
                            <option value="Jun">June</option>
                            <option value="Jul">July</option>
                            <option value="Aug">August</option>
                            <option value="Sept">September</option>
                            <option value="Oct">October</option>
                            <option value="Nov">November</option>
                            <option value="Dec">December</option>

            </select>
             </td>

           </tr>
           <tr>
            <td>Date Issued</td>
            <td><input type="date" name="issue_time" id="issue_time" class="form-control" value=""></td>
             
           </tr>
             
     
	    <tr>
        <td>Rainfall outlook <?php echo form_error('rainfall_outlook') ?></td>
        <td><textarea class="form-control" rows = "3" name="rainfall_outlook" id="rainfall_outlook" placeholder="Rainfall  Outlook" /> <?php echo $rainfall_outlook; ?></textarea></td>
     </tr>

      <tr >
       <td>Further outlook <?php echo form_error('further_outlook') ?></td>
        <td><textarea class="form-control" rows = "3" name="further_outlook" id="further_outlook" placeholder="Further Outlook" /> <?php echo $further_outlook; ?></textarea>
        </td>
      </tr>
       <tr >
       <td>Impacts <?php echo form_error('impacts') ?></td>
        <td><textarea class="form-control" rows = "5" name="impacts" id="impacts" placeholder="Impacts " /> <?php echo $impacts; ?></textarea>
        </td>
      </tr>
          <tr >
       <td>Advisories <?php echo form_error('advisories') ?></td>
        <td><textarea class="form-control" rows = "5" name="advisories" id="advisories" placeholder="Further Outlook" /> <?php echo $advisories; ?></textarea>
        </td>
      </tr> 
       <tr >
       <td>Conclusion <?php echo form_error('conclusion') ?></td>
        <td><textarea class="form-control" rows = "3" name="conclusion" id="conclusion" placeholder="Conclusion" /> <?php echo $conclusion; ?></textarea>
        </td>
      </tr>                
	    <input type="hidden" name="forecast_id" value="<?php echo $id; ?>" />

	    <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo "Submit" ?></button>
	    <a href="<?php echo site_url('index.php/Updates/index') ?>" class="btn btn-default">Cancel</a></td></tr>

    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
