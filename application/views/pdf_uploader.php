<style type="text/css">
  .inv {
    display: none;
}

</style>
<section class="content-header">
                    <h1>
                        Daily
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
            <div class='col-xs-8 col-md-8'>
              <div class='box'>
                <div class='box-header'>


                  <h3 class='box-title'>DAILY FORECAST UPLOADER &nbsp;&nbsp; <i style="color: red"> Remaining Units:</i> <?=$remaining_units?></h3>
                      <div class='box box-primary'>
        <form action="<?php echo  site_url('index.php/CSV_file')?>" method="post" enctype="multipart/form-data">
          
 <!-- get the regions for the dailyforecast_region table-->
      <table class="table table-bordered">
        <tr>
          <td>Upload PDF Document</td>
        </tr> 

        <tr>
          <td>
            FILE FORMAT:
          </td>
          <td><select  id="target" name="file_type" class="form-control">
            <option value="">Select FILE Format</option>
             <option value="pdf">PDF UPLOAD</option>
             <option value="excel">EXCEL UPLOAD</option>
          </select>
        </td>
        </tr>
        <tr>
          <td>Choose File</td>
          <td>
            <div id="pdf" class="inv">
              <input type="file" name="file2" accept=".pdf" /><span style="color: red">Only .pdf format</span>
            </div>

            <div id="excel" class="inv">
              <input type="file" name="file22" accept=".xlsx" /><span style="color: red">Only .xls format</span>
            </div>
            </td>
        </tr>
       <tr>
         <td><br>
           <input class="btn btn-primary" type="submit" value="Upload Data" />
         </td>
       </tr>
          

    </table>
  </form>

    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

             <!-- alert box -->
           <div class='col-xs-4 col-md-4'>
              <div class='box'>
                <div class='box-header'>

                  <h3 class='box-title'><b>Convert PDF TO EXCEL HERE</b></h3><br>
             <p>     If the PDF conversion units run out, click on the button below to convert PDF to excel. After select 'EXCEL UPLOAD' option to automatically upload data.</p><br>
                  <p> <a class=" btn btn-success" target="_blank" href="https://pdftables.com/">CONVERT PDF TO EXCEL </a></p>
                </div>
              </div>
            </div>
          <!--  -->
       
        </section><!-- /.content -->

        <script>
          document
  .getElementById('target')
  .addEventListener('change', function () {
    'use strict';
    var vis = document.querySelector('.vis'),   
      target = document.getElementById(this.value);
    if (vis !== null) {
      vis.className = 'inv';
    }
    if (target !== null ) {
      target.className = 'vis';
    }
});
          
        </script>
