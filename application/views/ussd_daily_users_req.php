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

          <h3 class='box-title'>USSD DAILY USERS</h3>
          <!------------------ Amoko -->
          <div class='box box-primary'>
            <form action="" method="post" enctype="multipart/form-data" >
              <div class="table-responsive"> <table class='table table-bordered'>
                <tr><td>Date Range:</td>
                  <td> 
                    Start Date<br>
                    <input class="form-control" type="date" name="date_from" id="date_from" required>
                  </td>
                  <td>
                   End Date: <br>
                   <input class="form-control" type="date" name="date_to" id="date_to" required>
                 </td>
                 <td>
                   Forecast: <br>
                   <select name="forecast" class="form-control">
                     <option value="0">All</option>
                     <option value="Daily Forecast">Daily Forrecast</option>
                     <option value="Seasonal Forecast">Seasonal Forecast</option>
                     <option value="Marine Forecast">Marine Forecast</option>
                   </select>
                 </td>
                 <td ><br><input type="submit" value="Generate Chart" name="submit" id="submit" class="btn btn-primary"></td>
               </tr>        



             </table></div>
           </form>
         </div><!-- /.box-body -->
         <div class='box-body'   >
          <?php
          if(isset($_POST['submit'])){

            $earlier = new DateTime($_POST['date_from']);
            $later = new DateTime($_POST['date_to']);
            $forecast = $_POST['forecast'];

            $diff = $later->diff($earlier)->format("%a");
         // echo $diff." days";


            $dataPoints = array();
            $rects = array();
            for ($i=$diff; $i >=0 ; $i--) { 
              $dated = date('Y-m-d', strtotime( $_POST['date_to'].'-'.$i.' day'));
              $qry = "SELECT COUNT(DISTINCT phone) AS count_users FROM ussdtransaction_new WHERE ussdtransaction_new.date BETWEEN '$dated 00:00:01' and '$dated 23:59:59'";

              if(strlen($forecast)>5){
                $qry .= " AND menuvalue = '".$forecast."'";
              }
              $query=$this->db->query($qry);
              foreach ($query->result_array()  as $dd) {
                $rects["y"] = $dd['count_users'];
              }
              $rects["label" ] = date('d M y', strtotime( $_POST['date_to'].'-'.$i.' day'));


              $dataPoints[] = $rects;
              unset($rects);
            }
            ?>



            <script>
              window.onload = function () {

                var chart = new CanvasJS.Chart("chartContainer", {
                  animationEnabled: true,
                  title: {
                    text: "USSD-WIDS Daily Usage Trend (<?=$diff?> Days)"
                  },
                  axisY: {
                    title: "Number of Users",
                    includeZero: false
                  },
                  axisX: {
                    title: "Date",
                    valueFormatString: "DD MMM"
                  },
                  data: [{
                    type: "area",
                    xValueFormatString: "DD MMM",
                    color: "#F08080",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                chart.render();

              }
            </script>
            <div id="chartContainer" style="height: 450px; max-width: 100%; margin: 0px auto;"></div>
          <?php }

          ?>

         <!-- <div id="sector"></div>
           <div id="chartContainer" style="height: 400px; max-width: 1000px; margin: 0px auto;"></div> -->
           <div class="box-body chart-responsive">


            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> -->


            <script src="<?php echo base_url('assets/frameworks/jquery/jquery.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
            <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
            <script type="text/javascript">
              $(document).ready(function () {
                $("#mytable").dataTable();
              });
            </script>


   <!--  <script type="text/javascript">
        $(document).ready(function(){
 
            $('#submit').click(function(){ 
                var date_from= document.getElementById('date_from').value;
                 var date_to= document.getElementById('date_to').value;
                 
                $.ajax({
                    url : "<?php //echo base_url().'index.php/Product/viewajax'?>",
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

      </script>   -->
      <?php// echo $date_from;?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->

</section><!-- /.content -->


