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
    <li><a href="<?php echo base_url() ?>index.php/Season"><i class="fa fa-dashboard"></i> Seasonal Forecast</a></li>
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
            <form action="<?php echo  site_url('index.php/Advisory/create_action/'.$this->uri->segment(3))?>" method="post"  enctype="multipart/form-data" ><div class="table-responsive"><table class='table table-bordered'>
              <!-------------- AMoko ----------------->

              <tr>
                <td class="first">Language</td>
                <td> 
                  <select class="form-control" name="language" id="language" required>
                    <option value="">No Selected</option>
                    <?php foreach($languages as $row):?>
                      <option value="<?php echo $row->id;?>"><?php echo $row->language;?></option>
                    <?php endforeach;?>
                  </select>
                </td>
              </tr> 

              <tr ><td>Advisory Sector</td>
               <td class="first">
                <!-- <div style="overflow-y: scroll; background-color: #ffffff; width: 900px; height: 200px; min-height: 200px;"> -->

                  <div id="sector"></div>

                </div>
              </td>
              <input type="hidden" name="forecast_id" id ="forecast_id" value="<?php echo $this->uri->segment(3); ?>" />
            </tr>           

            <tr>
              <td class="first">Sub-region</td>
              <td> 


                <select class="form-control" name="region_id" id="region_id" required>
                  <option value="">No Selected</option>
                  <?php foreach($region_data as $dd){
                   ?>
                 }
                 <option value="<?php echo $dd['id'];?>"><?php echo $dd['sub_region_name'];?></option>
               <?php }?>
             </select>



           </td>
         </tr>


         <tr><td class="first">Advisory Summary:
         </td>
         <td><textarea class="form-control" rows="3" name="summary" id="summary" placeholder="Advisory Summary"></textarea>
         </td>        
       </tr>       
       

       <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        <!-- <a href="<?php //echo site_url('index.php/Advisory/'.$this->uri->segment(3)) ?>" class="btn btn-default">Cancel</a> -->
      </td></tr>

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
        url : "<?php echo base_url().'index.php/Advisory/get_advisory'?>",
        method : "POST",
        data : {id: id},
        success: function(data){
          var records = JSON.parse(data)
          var html = '<select class="form-control" name="sector_selected">';
          var i;
          for(i=0; i<records.length; i++){
            html +='<option value="';
            html += records[i].id;
            html +='">';
            html += records[i].minor_name;
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