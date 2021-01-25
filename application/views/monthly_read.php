        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                <h3 class='box-title'>Monthly Forecast Read</h3>
                
             <?php foreach($monthly_data as $dd){ ?>
        <table class="table table-bordered" style="margin-top: 20px">
            <tr>
                <td>Issue Date:</td><td><p><?php echo $dd['issue_date']; ?></p></td>
            </tr>
            <tr>
                <td>Year:</td><td><p><?php echo $dd['year']; ?></p></td>
            </tr>
            <tr>
                <td>Month From:</td><td><p><?php echo $dd['month_from']; ?></p></td>
            </tr>
            <tr>
                <td>Month To:</td><td><p><?php echo $dd['month_to']; ?></p></td>
            </tr>
             <tr>
                <td>Summary:</td><td><?php echo $dd['summary']; ?></td></tr>
            <tr>
             <tr>
                <td>Introduction:</td><td><?php echo $dd['introduction']; ?></td></tr>
            <tr>
            <tr>
                <td>Weather Outlook</td><td><?php echo $dd['weather_outlook']; ?></td>
            </tr>
            
           
            
            <tr>
                <td colspan="2">
                    <a href="<?php echo base_url().'index.php/monthly_forecast/index' ?>"><button  style="background-color: #3c8dbc; width: 100px; height: 35px;border-radius: 5px; text-align: center;color: #fff">Go Back</button></a>
                </td>
            </tr>
            
            
    </table>

    
    
    <?php } ?>
        </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->s