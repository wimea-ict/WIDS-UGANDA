<!-- Main content -->

<section class="content-header">
                    <h1>
                        Seasonal
                        <small>Single Forecast form</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Seasonal Forecast</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Forecast form</a></li>
                    </ol>
                </section>

        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>


                  <h3 class='box-title'>SEASONAL FORECAST AUDIO UPLOAD</h3>
                      <div class='box box-primary'>
        <form action="<?php echo  site_url('index.php/Season/audio_upload')?>" method="post" enctype="multipart/form-data"><table class='table table-bordered'>
          
 <!-- get the regions for the dailyforecast_region table-->
         <tr>
             <td>Language</td>
             <td>
                 <select name="lang">
                     <?php foreach ($language as $k) { ?>
                            <option value="<?php echo $k['language_id'] ?>"><?php echo $k['language'] ?></option>
                      <?php  } ?>
                 </select>
             </td>
         </tr>
        <tr>
            <td>Audio Clip</td>
            <td><input type="file" class="form-control" required="" name="audio_clip" id="audio_clip" /> </td>
        </tr>
        <tr>
            <td colspan='2'>
              <input type="submit" class="btn btn-primary" value="Upload Clip" required />
               <a href="<?php echo site_url('index.php/Season/audio_list/'.$this->uri->segment(3)) ?>" class="btn btn-default">Cancel</a>
              <input type="hidden" name="identity" value="<?php echo $this->uri->segment(3); ?>">
            </td>
        </tr>
        

    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
