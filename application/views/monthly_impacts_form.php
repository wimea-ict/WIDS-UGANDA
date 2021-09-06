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
    <small>Impact(s) Form</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url() ?>index.php/Landing"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo base_url() ?>index.php/monthly_forecast"><i class="fa fa-dashboard"></i> Monthly Forecast</a></li>
    <li><a href="#"><i class="fa fa-dashboard">Impacts</i>


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
            <form action="<?php echo  site_url('index.php/monthly_forecast/save_impacts/'.$this->uri->segment(3))?>" method="post"  enctype="multipart/form-data" ><div class="table-responsive"><table class='table table-bordered'>
             <input type="hidden" name="forecast_id" value="<?=$forecast_id?>">
             <tr><td class="first">Impact(s) Summary:
             </td>
             <td><textarea class="form-control" rows="6" name="impacts" id="impacts" placeholder="Enter Monthly Impacts"></textarea>
             </td>        
           </tr> 
           <tr><td colspan='2'><button type="submit" class="btn btn-primary"><?php echo $button ?></button>
            <a href="<?php echo site_url('index.php/monthly_forecast/impacts/'.$this->uri->segment(3)) ?>" class="btn btn-default">Cancel</a></td></tr>

          </table><div class="table-responsive"></form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
  <script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.3.1.js'?>"></script>
  <script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
