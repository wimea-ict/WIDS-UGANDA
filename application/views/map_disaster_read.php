
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
   
        
    </head>    
          
    
      <body>
       <!-- <section class='content'>
          <div class='row'>
            <div class='col-xs-5'>-->
              <div class='row' style="margin-left:  10px; margin-top: 25px;padding-right: 30px">
              <div class='panel panel-primary col-md-11' style="padding: 0px;">
                <div class='panel-heading'>
                    Disaster Management
                </div>
                <div class="panel-body">
                 <table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
        <th>District</th>
        <!--<th>Region</th> -->
       <th>Message</th>
                </tr>
            </thead>
            <?php
              $season_id = 0;
               $flag = false;$count = 0; foreach ($seasonal_data as $Seasonal) :
                $season = "unknown";
                //-----COMMENTED OUT 'JF' season is not available
                if((date('m') == 1) || (date('m') == 2)) $season = 'MAM';
                else if((date('m') == 3) || (date('m') == 4)  || (date('m') == 5) ) $season = 'MAM';
                else if ((date('m') == 6) || (date('m') == 7)  || (date('m') == 8) ) $season = 'JJA';
                else $season = 'SOND';
                $flag = true;
                if($count == 0){ 
                  $season = $Seasonal['abbreviation'];
                    
                // Thie check the year and season we are currently in before desiding to display anything
                if(date('Y') == $Seasonal['year'] &&( ($Seasonal['abbreviation']) == $season)){
                     $season_id = $Seasonal['id'];
                }
                $count++;
              }
                  endforeach; 
              
              ?>
            <tbody>
              
                
                           <tr>
                            <td> <?php  

                            foreach($district as $dist){
                              echo $dist['division_name'];
                            }
                              ?></td>
                            <td>

                              <?php
                                $sqlx = "SELECT * from advisory JOIN division ON division.sub_region_id = advisory.region_id JOIN minor_sector ON advisory.sector = minor_sector.id JOIN major_sector ON major_sector.id = minor_sector.major_id WHERE forecast_id = '$season_id' AND major_sector.language_id = 1 AND division.id = '$id' AND advisory.sector = '$sector_id' ";
                                 $sql2= $this->db->query($sqlx);
                                 foreach ($sql2->result_array() as $row1) {
                                    echo $row1['message_summary']."<br>";

                                  } 

                              ?>
                            </td>

                          </tr>
          </tbody>
        </table>
       
                    </div>
              </div>
          </div>
        </body>



                