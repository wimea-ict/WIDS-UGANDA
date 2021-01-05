<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>WIDS INSTALLATION</title>

  <!-- Font Icon -->
  <link rel="stylesheet" href="<?php echo base_url('assets/installer/fonts/material-icon/css/material-design-iconic-font.min.css')?>">

  <!-- Main css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/installer/css/style.css')?>">
</head>
<body>

  <div class="main">

    <section class="signup">
      <!-- <img src="images/signup-bg.jpg" alt=""> -->
      <div class="container">
        <div class="signup-content">
          <form method="POST" id="signup-form" class="signup-form">
            <h2 class="form-title">WIDS INSTALLATION SETUP</h2>
            <?php echo form_open('',array('class'=>'form','id'=>'db-form')); ?>
            <div class="form-group">
              <label for="exampleInputPassword1">System user Email</label>
              <!--  <input type="text" class="form-input" name="name" id="name" placeholder="System user password"/> -->
              <input type="text" name="system_email" class="form-input" placeholder="Syetme User  Email" required>
    
            </div>

            <div class="form-group">
              <label for="exampleInputPassword1">System user password</label>
              <!--  <input type="text" class="form-input" name="name" id="name" placeholder="System user password"/> -->
              <input type="password" name="systempassword" class="form-input" id="password" placeholder="System user password" required>
            </div>

            <div class="form-group">

             <label for="exampleInputEmail1">Database Name</label>
             <input type="text" name="database_name" class="form-input" placeholder="Database name" required>
           </div>
           <div class="form-group">

            <label for="exampleInputEmail1">Database username:</label>
            <input type="text" name="database_username" class="form-input"  placeholder="Database username" required>

          </div>

          <div class="form-group">

            <label for="exampleInputPassword1">Database Password:</label>
            <input type="password" name="database_password" class="form-input" id="exampleInputPassword1" placeholder="Database password">
            <input type='hidden' name="step" value="1">
          </div>

          <div class="form-group">

            <label for="exampleInputEmail1">Select Country for which you are installing the system:</label><br>
            <select class="form-input" id="country" name="country" required>
              <option value="Nigeria">Nigeria</option>
              <option value="Ghana">Ghana</option>
              <option value="South Sudan">South Sudan</option>
              <option value="Uganda">Uganda</option>
            </select>
          </div>

          <div class="form-group">
            <input type="submit" name="submit" id="submit" class="form-submit" value="SUBMIT"/>
          </div>
        </form>
        
      </div>
    </div>
  </section>

</div>

<!-- JS -->
<script src="<?php echo base_url('assets/installer/')?>vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets/installer/')?>js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>