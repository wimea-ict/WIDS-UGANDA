        <!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                <h3 class='box-title'>Lake Victoria 24HR Forecast</h3>
                 <?php foreach($rows as $dd){ ?>  

                    <table class="table table-bordered" >
                        <tr>
                            <td>Issue Date:</td><td><p><?php echo $dd['issue_date'] ?></p></td>
                        </tr>
                        <tr>
                            <td>Forecast Date:</td><td><p><?php echo $dd['forecast_date'] ?></p></td>
                        </tr>
                        <tr>
                            <td colspan="2"><img style="width: 600px;height: 400px" src="<?php echo site_url('assets/frameworks/adminlte/img')."/".$dd['map'] ?>"></td>
                        </tr>
                        <tr>
                            <td>Advice:</td><td><p><?php echo $dd['advice'] ?></p></td>
                        </tr>

                    </table>

                 <?php break; } ?> 
                 <table class="table table-bordered">
                 <?php $ct = 0; foreach($rows as $dd){ $ct++; ?> 
                    
                        <?php if($ct == 1 ) { ?>
                             <tr>
                                <td colspan="8"><h4><b><?php echo $dd['area_name'] ?></b></h4></td>
                            </tr>
                            <tr>
                                <td style="width: 15%"><b>Highlight</b></td>
                                <td colspan="7"><p><?php echo $dd['highlights'] ?></p></td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td>Period</td>
                                <td>Wind Strength</td>
                                <td>Wind Direction</td>
                                <td>Wave Height</td>
                                <td>Weather</td>
                                <td>Rainfall Distribution</td>
                                <td>Visibility</td>
                                <td>Hazards</td>
                            </tr>
                        <?php } ?>
                            
                       <?php  if($ct == 4) $ct=0;  ?>
                        <tr>
                            <td style="width: 15%"><?php echo $dd['time']; ?></td>
                            <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wind_strength']; ?>"><?=$dd['wind_strength_name'] ?></td>
                            <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wind_direction']; ?>"><?=$dd['wind_direction_name'] ?></td>
                            <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['wave_height']; ?>"><?=$dd['wave_height_name'] ?></td>
                            <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['weather']; ?>"><?=$dd['weather_name'] ?></td>
                            <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['rainfall_dist']; ?>"><?=$dd['rainfall_dist_name'] ?></td>
                            <td style="width: 15%"><img style="width: 60px" src="<?php echo site_url('assets/icons')."/".$dd['visibility']; ?>"><?=$dd['visibility_name'] ?></td>
                            <td style="width: 15%; background: <?php echo $dd['harzard']; ?>"></td>
                        </tr>
                 <?php } ?> 
                 </table>  

             
            <tr>
                <td colspan="2">
                    <a href="<?php echo base_url().'index.php/Victoria' ?>"><button  style="background-color: #3c8dbc; width: 100px; height: 35px;border-radius: 5px; text-align: center;color: #fff">Go Back</button></a>
                </td>
            </tr>
            
            
    </table>

    
        </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->