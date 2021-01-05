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
                        Season
                        <small>Seasonal Forecast form</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url() ?>index.php/Season"><i class="fa fa-dashboard"></i> Season Forecast</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Forecast form</a></li>
                    </ol>
                </section>
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

<!-- Determining whether its an update of new data entry using the same form for both actions -->
                <?php 
                $head = '';
                $over = '';
                $gen = '';
                  if($this->uri->segment(2) == 'update'){
                    $forecast_id = $this->uri->segment(3);
                    $url = 'index.php/Season/save_update/'.$forecast_id;
                    

                    foreach($data_before as $d){
                      $over =  $d['overview'];
                      $gen = $d['general_forecast'];
                    }

                    $head = strtoupper($this->uri->segment(2));
                  }else{
                    $url = 'index.php/Season/saveforecast';
                  }
                 ?>
                  <h3 class='box-title'>SEASONAL FORECAST <?=$head?></h3>


                      <div class='box box-primary'>
        <form action="<?php echo site_url($url); ?>" method="post" enctype="multipart/form-data" ><table class='table table-bordered'>
          <?php  if($this->uri->segment(2) != 'update'){?>
           
            <tr><td>Season:</td>
           <td> 
           <select name="season_id" class="form-control" id="season">
              <?php 
          if(isset($season_data)){
             foreach ($season_data as $d){
               ?>
                           <option value="<?php echo $d->id; ?>"><?php echo $d->season_name; ?></option>
                           <?php
               
            }         
           }
        
        ?>
             
            </select>
             </td>
           </tr>        
          <tr>
              <td>Year:</td>
              <td><input type="text" readonly class="form-control" name="year" value="<?php echo date('Y');?>" /></td>
          </tr>
          <tr>
             <td>Seasonal Forecast Map</td>
             <td><input type="file" name="img"></td>
           </tr>
           <tr>
              <td>Issue Date:</td>
                <td> <input type="date" required name="date"></td>
           
           </tr>


        <?php  } ?>
      
      
	      <tr>
          		<td>Overview:</td>
           	    <td><textarea class="form-control" rows = "3" name="overview" id="overview" placeholder="overview" /> <?php echo $over; ?></textarea>
        		</td>
           </tr>
           <tr>
          		<td>General Forecast:</td>
           	    <td><textarea class="form-control" rows = "3" required="true" name="general_forecast" id="forecast" placeholder="general forecast" /> <?php echo $gen; ?></textarea>
        		</td>
           </tr>
           
              
                
	    <input type="hidden" name="id" value="<?php echo $id; ?>" />

	    <tr>
        <td><input type="submit" value="<?php if($this->uri->segment(2) == 'update'){ echo 'UPDATE';}else{ echo 'Submit'; } ?>" name="submit" class="btn btn-primary">&nbsp

      <a  class="btn btn-default" href="<?php echo base_url().'index.php/Season'  ?>">Cancel</a>
	   </td>
    
     
   
   </tr>

    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
