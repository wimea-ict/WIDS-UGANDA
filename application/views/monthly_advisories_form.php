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
<!-- <style type="text/css">
  .first{
    width: 2px;
  }
</style> -->
<section class="content-header">
  <h1>
    <small>Advisory Form</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() ?>index.php/Landing"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url() ?>index.php/monthly_forecast"><i class="fa fa-dashboard"></i> Monthly Forecast</a></li>
    <li><a href="#"><i class="fa fa-dashboard">Advisories</i>


    </a></li>
  </ol>
</section>
<section class='content'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box'>
        <div class='box-header'>

          <h3 class='box-title'>NEW FORECAST ADVISORY</h3>
          <div class='box box-primary'>
            <!------------- AMoko --------------->
            <form action="<?php echo  site_url($action.$this->uri->segment(3))?>" method="post"  enctype="multipart/form-data" ><div class="table-responsive"><table class='table table-bordered'>
              <!-------------- AMoko ----------------->
             <?php
             $message_summary = "";
               $sector_id = "";
                $minor_name = "";
                if (isset($monthly_advisory_data)) {
                  foreach ($monthly_advisory_data as $row) {
               $message_summary = $row['message_summary'];
               $sector_id = $row['sector_id'];
                $minor_name = $row['minor_name'];
             }
                }
            

             ?>

              <tr>
                <td >Advisory Sector</td>
                <td> 


                  <select class="form-control" name="sector_id" id="sector_id" required>
                    <?php
                     if ($minor_name != null) {
                      ?>
                      <option value="<?=$sector_id?>"><?=$minor_name?></option>
                    <?php   
                     }else{
                    ?>
                    <option value="">Select Sector</option>
                    <?php
                     }
                    ?>
                    
                    <?php foreach($sector_data as $dd){
                      if ($sector_id != $dd['id']) {
                     ?>
                   }
                   <option value="<?php echo $dd['id'];?>"><?php echo $dd['minor_name'];?></option>
                 <?php } } ?>
               </select>

             </td>
           </tr>

           <input type="hidden" name="forecast_id" value="<?=$forecast_id?>">
           <tr><td class="first">Advisory Summary:
           </td>
           <td><textarea class="form-control" rows="3" value="<?=$message_summary?>" name="message_summary" id="message_summary" placeholder="Advisory Summary"><?=$message_summary?></textarea>
           </td>        
         </tr>       


         <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
          <a href="<?php echo site_url('index.php/monthly_forecast/advisory_list/'.$parent_id) ?>" class="btn btn-default">Cancel</a></td></tr>

        </table><div class="table-responsive"></form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.3.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>

<script type="text/javascript">
  $(document).ready(function(){

    $('#language').change(function(){ 
      var id=$(this).val();
      $.ajax({
        url : "<?php echo base_url().'index.php/Product/get_advisory'?>",
        method : "POST",
        data : {id: id},
                    // async : true,
                    dataType : 'json',
                    success: function(data){

                      var html = '<select class="form-control" name="sector_selected">';
                      var i;
                      for(i=0; i<data.length; i++){
                        html +='<option value="';
                        html += data[i].id;
                        html +='">';
                        html += data[i].minor_name;
                        html +='</option>';   
                      }
                      html +='</select>';
                      $('#sector').html(html);
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                      alert(errorThrown);
                    }
                  });
      return false;
    }); 

  });
</script>       