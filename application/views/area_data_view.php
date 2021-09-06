        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                <h3 class='box-title'>Area Seasonal Forecast Overview</h3>
                
             <?php    foreach($forecast_area_data as $d){ ?>
        <table class="table table-bordered" style="margin-top: 20px">
            <tr>
                <td>Region:</td><td><p><?php echo $d['region_name']; ?></p></td>
            </tr>
             <tr>
                <td>Sub Region:</td><td><?php echo $d['sub_region_name']; ?></td></tr>
            <tr>
             <tr>
                <td>Rain Onset:</td><td><?php echo $d['onsetdesc']."&nbsp;".$d['onset_period']; ?></td></tr>
            <tr>
            <tr>
                <td>Expected Rain Peak:</td><td><?php echo $d['peakdesc']."&nbsp;".$d['expected_peak']; ?></td></tr>
            <tr>
            <tr>
                <td>Rain End Period:</td><td><?php echo $d['enddesc']."&nbsp;".$d['end_period']; ?></td></tr>
            <tr>
            <tr>
                <td>Overall Comment:</td><td><?php echo $d['overall_comment']; ?></td></tr>
            <tr>
            
            <?php 
        }
            ?>
           
            
                <td colspan="2">
                    <a href="<?php echo base_url().'index.php/Season/showareaforecast/'.$_SESSION['area_seasonal_forecast'] ?>"><button class="btn btn-primary" >Go Back</button></a>
                </td>
            </tr>
            
            
    </table>

    
   
        </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->