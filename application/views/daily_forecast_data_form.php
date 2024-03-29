<!-- Main content -->

<section class="content-header">
                    <h1>
                        
                        <small>Single Daily Forecast form</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Daily Forecast</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Forecast form</a></li>
                    </ol>
                </section>

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>


                  <h3 class='box-title'>DAILY FORECAST SINGLE FORM</h3>
                      <div class='box box-primary'>
        <form action="<?php echo  site_url('index.php/Daily_forecast/saveforecastdata')?>" method="post"><div class="table-responsive"><table class='table table-bordered'>
          
 <!-- get the regions for the dailyforecast_region table-->
         <tr><td>Region:</td>
                <td> 
                
                <select name="region" class="form-control">
                	<?php if(isset($region)){ 
							foreach($region as $r){
					?>
                        <option value="<?php echo $r->id; ?>"><?php echo $r->region_name; ?></option>
                   <?php }
				   
					}?>
               </select> </td>
      
        <tr>
       		<td>Temperature <?php echo form_error('mean_temp') ?></td>
            <td><input type="number" class="form-control" name="mean_temp" id="mean_temp" placeholder="Mean Temp" value="<?php echo $mean_temp; ?>" />
        </td>
	
        <tr><td>Wind direction <?php echo form_error('wind_direction') ?></td>
            <td><select name="wind_direction" class="form-control">
                 <option value="Easterly">Easterly</option>
                 <option value="Northerly">Northerly</option>
                 <option value="Northeasterly">Northeasterly</option>
                 <option value="Northwesterly">Northwesterly</option>
                 <option value="Southerly">Southerly</option>
                 <option value="Southeasterly">Southeasterly</option>
                 <option value="Southwesterly">Southwesterly</option>
                 <option value="Westerly">Westerly</option>
                 <option value="Variable">Variable</option>

                 </select>
        </td>
        <tr><td>Wind strength <?php echo form_error('wind_strength') ?></td>
           
            <td><select name="wind_strength" class="form-control">
            <option value="Light">Light</option>
                 <option value="Moderate">Moderate</option>
                 <option value="Variable">Variable</option>
                 <option value="Strong">Strong</option>
                 </select>
        </td>
        </tr>

      <tr><td>Weather Outlook <?php echo form_error('cat_id') ?></td>
            <td> <?php echo combo_function('cat_id','weather_category','cat_name','id','cat_id')?>
            
        </td>
     </tr>    
	 <tr>
     	<td colspan='2'><input type="submit" class="btn btn-primary" value="Submit">
	    <input type="hidden" name="forecast_id" value="<?php echo $forecast_id; ?>"/>
        </td>
     </tr>

    </table></div></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
