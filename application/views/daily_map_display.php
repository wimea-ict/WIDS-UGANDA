
        <!-- Main content -->
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Weather Information Dissemination System</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/ionicons/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/skins/_all-skins.min.css">
    <!--begin page css link-->
         <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/begin.css">
        
        
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url() ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url() ?>assets/frameworks/bootstrap/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url() ?>assets/frameworks/adminlte/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url() ?>assets/frameworks/adminlte/js/demo.js"></script>
        <!-- notifying -->
        <script src="<?php echo base_url() ?>assets/plugins/notify/notify.min.js"></script>
    <style>
       

       .wrapper{
         background-image: url("<?php echo base_url() ?>assets/frameworks/adminlte/img/trythis.PNG");
          
       }
       .main-sidebar{
         background-image: url("<?php echo base_url() ?>assets/frameworks/adminlte/img/trythis.PNG");
          
       }
       
    </style>
   
        
    </head>    
          
    
      <body>
       <!-- <section class='content'>
          <div class='row'>
            <div class='col-xs-5'>-->
              <div class='row' style="margin-left:  10px; margin-top: 25px;">
              <div class='panel panel-primary col-md-11' style="padding: 0px;">
                <div class='panel-heading'>
                   <?php    
               //print_r($advisories_data);exit();
                foreach ($advisories_data as $row1) {
                 $year = $row1['year'] ;
                }
                  ?>
                <?php echo strtoupper($division)." ".$year;?> DAILY FORECAST
                </div>
                <div class="panel-body">
                  <p>
                   

                   
                  </p>
                 <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
        <th>SECTOR</th>
        <!--<th>Region</th> -->
       <th>MESSAGE</th>
                </tr>
            </thead>
      <tbody>

                <?php    
               //print_r($advisories_data);exit();
                foreach ($advisories_data as $row1) {?>
                        <tr>
               
                            <td> <?php echo $row1['minor_name']?></td>
                            <td> <?php echo $row1['message_summary'];  ?></td>
                             </tr>
             
             <?php    }  ?>

              
                          
<?php

/*

NOTE: IMPORTANT:
BEFORE RETRIEVING THIS ADVISORY FROM THE ADVISORY TABLE, FIRST YOU HAVE TO RETRIEVE THE DATA FROM THE WRF MODEL TABLE IN THE DATABSE AND DISPLAY IT.. THEN AFTER RETRIEVING THIS DATA, DEPENDING ON THE DETAILS YOU RETRIEVE, YOU THEN WRITE SQL STATEMENTS TO CALL THE APPROPRIATE DATA FROM THE ADVISORY TABLE..

e.g TEMP = 30,
SELECT FROM ADVISORY WHERE TEMP == $TEMP


HENCE WE SHALL NEED A NEW ADVISORY TABLE WHICH HAS THE ADVISORIES TOGETHER WITH THE PARAMETERS ALONGSIDE EACH TYPE OF ADVISORY.


*/






                 ?>
 </tbody>
        </table>
        
       
                    </div><!-- /.box-body -->
              </div><!-- /.box -->
           <!-- </div><!-- /.col -->
          </div><!-- /.row -->
       <!-- </section><!-- /.content -->


                