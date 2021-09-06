        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  <?php
                    $dayofweek = date('w', strtotime($date));
                    $result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));

                  ?>
                  <h3 class='box-title'> AREA <strong></strong>FORECAST</h3>
                      <div class='box box-primary'>
        <form action="<?php echo site_url('index.php/Victoria/SaveForecastArea').'/'.$this->uri->segment(3); ?>" method="post" enctype="multipart/form-data" ><div class="table-responsive"><table class='table table-bordered'>
        <tr>
          <td>Zone</td>
          <td colspan="4">
            <select name="area" id="area" class="form-control">
             <?php foreach($area as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
        </tr>


        <tr>
          <td>Highlight</td>
          <td colspan="4"><textarea class="form-control" rows = "3" name="highlight" id="highlight" placeholder="Overall Comment" required /></textarea></td>
       </tr>


        <tr>
          <td>Period</td>
          <td>
            <p><b>Morning</b></p>
            <select name="period" id="period" class="form-control">
                    <option value="<?php echo date('Y-m-d')?> 1"><?php echo date('l')?> Morning</option>
                     <option value="<?php echo date('Y-m-d',strtotime(' +1 day'))?> 1"><?php echo date('l',strtotime(' +1 day'))?> Morning</option>
                
            </select>
            
          </td>
           <td>
            <p><b>Afternoon</b></p>

            <select name="period1" id="period1" class="form-control">
                    <option value="<?php echo date('Y-m-d')?> 2"><?php echo date('l')?> Afternoon</option>
                     <option value="<?php echo date('Y-m-d',strtotime(' +1 day'))?> 2"><?php echo date('l',strtotime(' +1 day'))?> Afternoon</option>
                
            </select>
           
          </td>
          <td>
            <p><b>Night before midnight</b></p>

            <select name="period2" id="period2" class="form-control">
                    <option value="<?php echo date('Y-m-d')?> 3"><?php echo date('l')?> Night before midnight</option>
                     <option value="<?php echo date('Y-m-d',strtotime(' +1 day'))?> 3"><?php echo date('l',strtotime(' +1 day'))?> Night before midnight</option>
                
            </select>
            
          </td>
           <td>
            <p><b>Night after midnight</b></p>
              <select name="period3" id="period3" class="form-control">
                    <option value="<?php echo date('Y-m-d')?> 4"><?php echo date('l')?> Night after midnight</option>
                     <option value="<?php echo date('Y-m-d',strtotime(' +1 day'))?> 4"><?php echo date('l',strtotime(' +1 day'))?> Night after midnight</option>
                
            </select>
            
          </td>
        </tr>



        <tr>
          <td>Wind Strength</td>
          <td>
            <select name="wind_strength" id="wind_strength" class="form-control">
             <?php foreach($wind_strength as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_strength1" id="wind_strength1" class="form-control">
             <?php foreach($wind_strength as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_strength2" id="wind_strength2" class="form-control">
             <?php foreach($wind_strength as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_strength3" id="wind_strength3" class="form-control">
             <?php foreach($wind_strength as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
        </tr>



         <tr>
          <td>Wind Direction</td>
          <td>
            <select name="wind_direction" id="wind_direction" class="form-control">
             <?php foreach($wind_direction as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_direction1" id="wind_direction1" class="form-control">
             <?php foreach($wind_direction as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_direction2" id="wind_direction2" class="form-control">
             <?php foreach($wind_direction as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_direction3" id="wind_direction3" class="form-control">
             <?php foreach($wind_direction as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
        </tr>



         <tr>
          <td>Wave Height</td>
          <td>
            <select name="wind_height" id="wind_height" class="form-control">
             <?php foreach($wave_height as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_height1" id="wind_height1" class="form-control">
             <?php foreach($wave_height as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_height2" id="wind_height2" class="form-control">
             <?php foreach($wave_height as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="wind_height3" id="wind_height3" class="form-control">
             <?php foreach($wave_height as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
        </tr>



         <tr>
          <td>Weather</td>
          <td>
            <select name="weather" id="weather" class="form-control">
             <?php foreach($weather as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
           <td>
            <select name="weather1" id="weather1" class="form-control">
             <?php foreach($weather as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="weather2" id="weather2" class="form-control">
             <?php foreach($weather as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
           <td>
            <select name="weather3" id="weather3" class="form-control">
             <?php foreach($weather as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
        </tr>



         <tr>
          <td>Rainfall Distribution</td>
          <td>
            <select name="rainfall_dist" id="rainfall_dist" class="form-control">
             <?php foreach($rainfall_dist as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
           <td>
            <select name="rainfall_dist1" id="rainfall_dist1" class="form-control">
             <?php foreach($rainfall_dist as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
           <td>
            <select name="rainfall_dist2" id="rainfall_dist2" class="form-control">
             <?php foreach($rainfall_dist as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
           <td>
            <select name="rainfall_dist3" id="rainfall_dist3" class="form-control">
             <?php foreach($rainfall_dist as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
        </tr>
        



        <tr>
          <td>Visibility</td>
          <td>
            <select name="visibility" id="visibility" class="form-control">
             <?php foreach($visibility as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="visibility1" id="visibility1" class="form-control">
             <?php foreach($visibility as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="visibility2" id="visibility2" class="form-control">
             <?php foreach($visibility as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
          <td>
            <select name="visibility3" id="visibility3" class="form-control">
             <?php foreach($visibility as $dd){ ?> 
                    <option value="<?php  echo $dd['id'];?>"><?php echo $dd['name'];?></option>
                  <?php }?> 
            </select>
          </td>
        </tr>
     


    	    <tr>
            <td>Harzards</td>
            <td>
              <select class="form-control" name="harzard">
                <option value="#0F0">Green</option>
                <option value="#FFA500">Orange</option>
                <option value="#F00">Red</option>
              </select>
            </td>
            <td>
              <select class="form-control" name="harzard1">
                <option value="#0F0">Green</option>
                <option value="#FFA500">Orange</option>
                <option value="#F00">Red</option>
              </select>
            </td>
            <td>
              <select class="form-control" name="harzard2">
                <option value="#0F0">Green</option>
                <option value="#FFA500">Orange</option>
                <option value="#F00">Red</option>
              </select>
            </td>
            <td>
              <select class="form-control" name="harzard3">
                <option value="#0F0">Green</option>
                <option value="#FFA500">Orange</option>
                <option value="#F00">Red</option>
              </select>
            </td>
           
         </tr>
      <!-- <tr > -->
       <!-- <td>General information <?php //echo form_error('general_info') ?></td> -->
        <!-- <td><textarea class="form-control" rows = "10" name="general_info" id="general_info" placeholder="General information" /> <?php //echo $general_info; ?></textarea>
        </td> -->
                        
	    <input type="hidden" name="forecast_id" value="<?php echo $add_id; ?>" />

	    <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo "Submit" ?></button>
	    <a href="<?php echo site_url('index.php/Victoria/showareaforecast').'/'.$this->uri->segment(3) ?>" class="btn btn-default">Cancel</a></td></tr>

    </table></div></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
