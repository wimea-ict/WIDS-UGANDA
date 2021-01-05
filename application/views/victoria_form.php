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
                        Marine Forecast
                        <small> Form</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Marine Forecast</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Forecast form</a></li>
                    </ol>
                </section>
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

<!------------------ Amoko -->
<!-- Determining whether its an update of new data entry using the same form for both actions -->
        <?php 
              $head = '';
              $over = '';
              $gen = '';
                if($this->uri->segment(2) == 'update'){
                  $forecast_id = $this->uri->segment(3);
                  $url = 'index.php/Coastline/save_update/'.$forecast_id;
                  

                  foreach($data_before as $d){
                    $over =  $d['overview'];
                    $gen = $d['general_forecast'];
                  }

                  $head = strtoupper($this->uri->segment(2));
                }else{
                  $url = 'index.php/Victoria/saveforecast';
                }
           ?>
                  <h3 class='box-title'>MARINE FORECAST FORM</h3>
<!------------------ Amoko -->

                      <div class='box box-primary'>
        <form action="<?php echo site_url($url); ?>" method="post" enctype="multipart/form-data" ><div class="table-responsive"><table class='table table-bordered'>
          
           <tr>
             <td>Lannguage</td>
             <td>
               <select name="language" id="language" class="form-control" required>
                 <option>Select a language</option>
                 <?php
                  foreach ($languages as $ke) : ?>
                    <option value="<?=$ke['id']  ?>"><?=$ke['language']  ?></option>
                  <?php endforeach;  ?>
               </select>
             </td>
           </tr>
          
           <tr>
              <td>Issue Date:</td>
                <td> <input type="date" name="date" required></td>
           
           </tr>
           <tr>
              <td>Forecast Date:</td>
                <td> <input type="date" name="date1" required></td>
           
           </tr>

           <tr>
             <td>Forecast Map</td>
             <td><input type="file" name="img" required></td>
           </tr>

	   
           <tr>
          		<td>Advice:</td>
           	    <td><textarea class="form-control" rows = "3" name="advice" id="advice" required/></textarea>
        		</td>

           </tr>
           
              
                
	    <input type="hidden" name="id" value="<?php echo $id; ?>" />

	    <tr>
        <td><input type="submit" value="<?php if($this->uri->segment(2) == 'update'){ echo 'Update'; }else{ echo 'Submit'; } ?>" name="submit" class="btn btn-primary">&nbsp

       <a href="<?php echo base_url().'index.php/Victoria'  ?>" class="btn btn-default" >Cancel</a>
	   </td>
    

    
  
   </tr>

    </table></form></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
