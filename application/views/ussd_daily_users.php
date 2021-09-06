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
                        USSD DAILY USERS
                        <small>Report</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i>USSD USERS LIST</a></li>
                    </ol>
                </section>
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  <h3 class='box-title'>USSD USERS USERS</h3>
<!------------------ Amoko -->

                      <div class='box box-primary'>
        <form action="<?php echo site_url('index.php/Landing/ussd_daily_users'); ?>" method="post" enctype="multipart/form-data" ><div class="table-responsive"><table class='table table-bordered'>

           
            <tr><td>Date Range:</td>
              <td> 
                Start Date<br>
                <input type="date" name="date_from" id="date_from" required>
             </td>
             <td>
               End Date: <br>
               <input type="date" name="date_to" id="date_to" required>
             </td>
           </tr>        
         
        
	    <tr >
        <td ><input type="submit" value="Request Report" name="submit" id="submit" class="btn btn-primary">
	   </td>
   </tr>

    </table></div></form>
    </div><!-- /.box-body -->
    <div class='box-body'   >


         <div id="sector"></div>
          <div class="box-body chart-responsive">
        <div id="chartContainer" style="height: 300px;width: 100%"></div>



    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
     </div>

        <script src="<?php echo base_url('assets/frameworks/jquery/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        </script>

    
    <script type="text/javascript">
        $(document).ready(function(){
 
            $('#submit').click(function(){ 
                var date_from= document.getElementById('date_from').value;
                 var date_to= document.getElementById('date_to').value;
                 
                $.ajax({
                    url : "<?php echo base_url().'index.php/Product/viewajax'?>",
                    method : "POST",
                    data : {date_to: date_to, date_from: date_from},
                    // async : true,
                    dataType : 'json',
                    success: function(data){
                         var html = '<center><h4><b>USSD USERS FROM '+ date_from + '  to ' +date_to;
                          html += ': </b>';

                         
                        var i;
                        var datt = data.length;
                       
                        for(i=0; i<data.length; i++){
                          i++;   

                        }
                      html+= '<b style="color:cornflowerblue;">'+i+ ' Unique users';
                      html+=' </b></h4></center>';
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
    <?php// echo $date_from;?>
                    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->


