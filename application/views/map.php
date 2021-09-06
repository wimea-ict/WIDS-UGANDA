<!DOCTYPE html>
<html><head>
         <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
  

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133419491-1"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 93%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0; 
      }
    </style>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-133419491-1');
    </script>

        <title>Weather Information Dissemination System</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/ionicons/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/adminlte.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/skins/_all-skins.min.css">
        <!--begin page css link-->
         <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/begin.css">
         <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/styles.css">
         <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/widgets.css">
         <link rel="stylesheet" href="<?php echo base_url() ?>assets/frameworks/adminlte/css/animate.css">

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
   
<script type="text/javascript" src="<?php echo base_url() ?>assets/frameworks/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/frameworks/gritter/gritter-conf.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/gritter/css/jquery.gritter.css" />


    </head>
  <body class="hold-transition skin-blue sidebar-mini" style="overflow-y: hidden;">
    <header class="main-header">
           <a href="#" class="logo" style="margin-left: 0px;"  >
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><b>W</b>IDS</span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg" ><h5>WEATHER INFORMATION DISSEMINATION SYSTEM</h5></span>
          </a>
          <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">

            <div class="navbar-custom-menu" style="margin-right: 30px">
              <ul class="nav navbar-nav">
                <li><?php echo anchor(site_url('index.php'), "<span class='glyphicon glyphicon-user'></span>" . strtoupper('home'));?></li>
                <li><?php echo anchor(site_url('index.php/Map/index'), "<span class='glyphicon glyphicon-globe'></span>" . strtoupper('Live Map'));?></li>

                <li><?php echo anchor(site_url('index.php/auth/load_login'), "<span class='glyphicon glyphicon-log-in'></span>" . strtoupper('Login'));?></li>
              </ul>
            </div>
                                
            </nav>
            
         </header>
   
  
       


  <div id="map"></div>

              <script>


        var map;
        var InforObj = [];
        var centerCords = {
            lat: 1.3733,
            lng: 32.2903
        };

        window.onload = function () {
            initMap();

        };
 
        function addMarkerInfo() {
            for (var i = 0; i < districts.length; i++) {
                var contentString = '<h4><center><b>' + districts[i].division_name +
                    '</b></center></h4><button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="disaster('+districts[i].id+')">Disaster Management</button><br/>'+
                    '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="agric_and_food('+districts[i].id+')">Agriculture and Food<br> Security Sector</button><br/>'+
                    '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="water('+districts[i].id+')">Water, Energy and<br> Hydro-Power generation</button><br/>'+
                    '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="health('+districts[i].id+')">Health Sector</button><br/>'+
                    '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="works('+districts[i].id+')">Infrastructure, Works and<br> Transport Sector</button><br/>';

            // var contentString = '<h4>' + districts[i].division_name +
            //         '</h4><button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="disaster()">Disaster</button><br/>'+
            // '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="foodbox()">Food Sector advisory</button><br/>'+
            // '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="roadbox()">Road Sector advisory</button><br/>'+
            // '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="waterbox()">Water Sector Advisory</button><br/>'+
            // '<button class="btn btn-primary col-md-12" style="margin-bottom: 10px" onclick="healthbox()">Health Sector advisory</button>'+
            // '';
                // const size = new google.maps.Size(2,5);
                const marker = new google.maps.Marker({
                    position: {lat: parseFloat(districts[i].lat), lng: parseFloat(districts[i].lng)},
                    map: map,
                    title: districts[i].division_name
                });
 
                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 250
                });
 
                marker.addListener('click', function () {
                    closeOtherInfo();
                    infowindow.open(marker.get('map'), marker);
                    InforObj[0] = infowindow;
                });
            }
        }
 
        function closeOtherInfo() {
            if (InforObj.length > 0) {
                /* detach the info-window from the marker ... undocumented in the API docs */
                InforObj[0].set("marker", null);
                /* and close it */
                InforObj[0].close();
                /* blank the array */
                InforObj.length = 0;
            }
        }
 
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: centerCords
            });
            addMarkerInfo();

        }
    </script>





          <div id="infowindow-content">
            <img src="" width="16" height="16" id="place-icon">
            <span id="place-name"  class="title"></span><br>
            <span id="place-address"></span>
            <span id="daily"></span> 

          </div>

           <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0dy46oTvw9PivnuoTzy_aa5LDp_8FNIo&libraries=places"></script> -->
           <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0dy46oTvw9PivnuoTzy_aa5LDp_8FNIo&callback=initMap"></script>

            <!-- <script src="<?php echo base_url() ?>assets/frameworks/adminlte/js/myscript.js"></script> -->
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frameworks/gritter/css/jquery.gritter.css" />
   
                              

  </body>
</html>


<!-- The windows for data -->
<script type="text/javascript">
  function disaster(id){
    window.open("/wids/index.php/map/disaster/"+id,"_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400");   
  }
  function agric_and_food(id){
    window.open("/wids/index.php/map/agric_and_food/"+id,"_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400");   
  }
  function water(id){
    window.open("/wids/index.php/map/water/"+id,"_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400");   
  }
  function health(id){
    window.open("/wids/index.php/map/health/"+id,"_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400");   
  }
  function works(id){
    window.open("/wids/index.php/map/works/"+id,"_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=600,height=400");   
  }
</script>