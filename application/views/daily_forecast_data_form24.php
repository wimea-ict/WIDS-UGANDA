<!-- Main content -->

<section class="content-header">
                    <h1>
                        24 hrs Daily
                        <small>Single Forecast form</small>
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
        <form action="<?php echo  site_url('index.php/Daily_forecast/saveforecastdata24')?>" method="post"><div class="table-responsive"><table class='table table-bordered'>
          
 <!-- get the regions for the dailyforecast_region table-->
         <tr>
            <td>Region:</td>
                <td colspan="4"> 
                
                <select name="region" class="form-control">
                	<?php if(isset($region)){ 
							foreach($region as $r){
					?>
                        <option value="<?php echo $r->id; ?>"><?php echo $r->region_name; ?></option>
                   <?php }
				   
					}?>
               </select> </td>
        <!-- </tr>
         <tr><td> <?php //echo $division_type; ?>:</td>
                <td colspan="4"> <select name="division" class="form-control">     -->            
                         <?php
					 // /if(isset($division_data)){
						//   foreach($division_data as $fd){
							  ?><!-- 
                              <option value="<?php //echo $fd['id']; ?>"><?php //echo $fd['division_name']; ?></option> -->
                              <?php 							  
						// }
						// }					
					?>    
             <!--  </select> </td>
            </tr>   --> 
            <tr>
                <td>Period</td>
                <td>Late Evening</td>
                <td>Early Morning</td>
                <td>Late Morning</td>
                <td>Afternoon</td>
            </tr>
            <tr><td>Weather Outlook <?php echo form_error('cat_id') ?></td>
                <td> <?php echo combo_function('cat_id1','weather_category','cat_name','id','cat_id')?></td>
                <td> <?php echo combo_function('cat_id2','weather_category','cat_name','id','cat_id')?></td>
                <td> <?php echo combo_function('cat_id3','weather_category','cat_name','id','cat_id')?></td>
                <td> <?php echo combo_function('cat_id4','weather_category','cat_name','id','cat_id')?></td>
         </tr> 
        <tr>
       		<td>Temperature <?php echo form_error('mean_temp') ?></td>
            <td><input type="number" required class="form-control" name="mean_temp1" id="mean_temp" placeholder="Mean Temp" value="<?php echo $mean_temp; ?>" />
            </td>
            <td><input type="number" required class="form-control" name="mean_temp2" id="mean_temp" placeholder="Mean Temp" value="<?php echo $mean_temp; ?>" />
            </td>
            <td><input type="number" required class="form-control" name="mean_temp3" id="mean_temp" placeholder="Mean Temp" value="<?php echo $mean_temp; ?>" />
            </td>
            <td><input type="number" required class="form-control" name="mean_temp4" id="mean_temp" placeholder="Mean Temp" value="<?php echo $mean_temp; ?>" />
            </td>
	    
        <tr>
            <td>Wind direction <?php echo form_error('wind_direction') ?></td>
            
            <td>
                <select name="wind_direction1" class="form-control" required>
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
            <td>
                <select name="wind_direction2" class="form-control" required>
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
            <td>
                <select name="wind_direction3" class="form-control" required>
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
            <td>
                <select name="wind_direction4" class="form-control" required>
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
        <tr>
            <td>Wind strength <?php echo form_error('wind_strength') ?></td>
           
            <td>
                <select name="wind_strength1" class="form-control" required>
                    <option value="Light">Light</option>
                     <option value="Moderate">Moderate</option>
                     <option value="Variable">Variable</option>
                     <option value="Strong">Strong</option>
                 </select>
            </td>
            <td>
                <select name="wind_strength2" class="form-control" required>
                    <option value="Light">Light</option>
                     <option value="Moderate">Moderate</option>
                     <option value="Variable">Variable</option>
                     <option value="Strong">Strong</option>
                 </select>
            </td>
            <td>
                <select name="wind_strength3" class="form-control" required>
                    <option value="Light">Light</option>
                     <option value="Moderate">Moderate</option>
                     <option value="Variable">Variable</option>
                     <option value="Strong">Strong</option>
                 </select>
            </td>
            
            <td>
                <select name="wind_strength4" class="form-control" required>
                    <option value="Light">Light</option>
                     <option value="Moderate">Moderate</option>
                     <option value="Variable">Variable</option>
                     <option value="Strong">Strong</option>
                 </select>
            </td>

         </tr>
	 <tr>
     	<td colspan='2'><input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-default" href="<?php echo base_url("index.php/daily_forecast/daily_forecast_data/".$this->uri->segment(3));?>">Cancel</a>
	    <input type="hidden" name="forecast_id" value="<?php echo $forecast_id; ?>"/>
        </td>
     </tr>

    </table></div></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
