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
    Monthly
    <small> Forecast form</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() ?>index.php/Landing"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url() ?>index.php/Season"><i class="fa fa-dashboard"></i> Monthly Forecast</a></li>
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
          $summary = '';
          $weather_outlook = '';
          $introduction = '';
          $weather_outlook = '';

          if($this->uri->segment(2) == 'update'){
            $forecast_id = $this->uri->segment(3);
            $url = 'index.php/monthly_forecast/save_update/'.$forecast_id;

           // print_r($monthly_id_data);exit();
            foreach($monthly_id_data as $d){
              $summary =  $d['summary'];
              $date =  $d['date'];
              $weather_outlook =  $d['weather_outlook'];
              $introduction = $d['introduction'];
            }

            $head = strtoupper($this->uri->segment(2));
          }else{
            $url = 'index.php/monthly_forecast/save_forecast';
          }
          ?>
          <h3 class='box-title'>MONTHLY FORECAST <?=$head?></h3>


          <div class='box box-primary'>
            <form action="<?php echo site_url($url); ?>" method="post" enctype="multipart/form-data" ><table class='table table-bordered'>
             

               <td>Month From: <?php echo form_error('month_from') ?></td>
               <td><select id ="month_from" required="true" name="month_from" class="form-control"> 
                <option value="">Select Start Month</option>
                    <option value="January">January</option> 
               <option value="February" >February</option> 
               <option value="March">March</option> 
               <option value="April">April</option> 
               <option value="May">May</option> 
               <option value="June">June</option> 
               <option value="July">July</option> 
               <option value="August">August</option> 
               <option value="September">September</option> 
               <option value="October">October</option> 
               <option value="November">November</option> 
               <option value="December">December</option>                        
              </select></td>
            </tr>
            <tr>
              <td>Month To: <?php echo form_error('month_to') ?></td>
              <td><select id="month_to" name="month_to"  required class="form-control"> 
          <option value="">Select End Month</option>
              <?php?>
               <option value="January">January</option> 
               <option value="February" >February</option> 
               <option value="March">March</option> 
               <option value="April">April</option> 
               <option value="May">May</option> 
               <option value="June">June</option> 
               <option value="July">July</option> 
               <option value="August">August</option> 
               <option value="September">September</option> 
               <option value="October">October</option> 
               <option value="November">November</option> 
               <option value="December">December</option>                         
             </select></td>
           </tr>       
           <tr>
            <td>Year:</td>
            <td><input type="text" readonly class="form-control" name="year" value="<?php echo date('Y');?>" /></td>
          </tr>

         <tr>
          <td>Issue Date:</td>
          <td> <input type="date" required  value="<?=$date?>" name="date"></td>

        </tr>

      
      <tr>
        <td>Summary:</td>
        <td><textarea class="form-control" rows = "3" name="summary" id="summary" placeholder="Summary" /> <?php echo $summary; ?></textarea>
        </td>
      </tr>
      <tr>
        <td>Introduction:</td>
        <td><textarea class="form-control" rows = "3" required="true" name="introduction" id="forecast" placeholder="Introduction" /> <?php echo $introduction; ?></textarea>
        </td>
      </tr>
      <tr>
        <td>Weather Outlook:</td>
        <td><textarea class="form-control" rows = "3" required="true" name="weather_outlook" id="forecast" placeholder="Weather Outlook" /> <?php echo $weather_outlook; ?></textarea>
        </td>
      </tr>
 <?php  if($this->uri->segment(2) != 'update'){?>
      <tr>
           <td>Monthly Forecast Map</td>
           <td><input type="file" name="img"></td>
         </tr>
   <?php  } ?>


      <input type="hidden" name="id" value="<?php echo $id; ?>" />

      <tr>
        <td><input type="submit" value="<?php if($this->uri->segment(2) == 'update'){ echo 'UPDATE';}else{ echo 'Upload Forecast'; } ?>" name="submit" class="btn btn-primary">&nbsp

          <a  class="btn btn-default" href="<?php echo base_url().'index.php/monthly_forecast'  ?>">Cancel</a>
        </td>



      </tr>

    </table></form>
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
