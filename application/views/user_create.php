<style>
            #frmCheckPassword {
                border-top: #F0F0F0 2px solid;
                background: ;
                padding: 10px;
            }

            .demoInputBox {
                padding: 7px;
                border: #F0F0F0 1px solid;
                border-radius: 4px;
            }

            #password-strength-status {
                padding: 5px 10px;
                color: #FFFFFF;
                border-radius: 4px;
                margin-top: 5px;
            }

            .medium-password {
                background-color: #b7d60a;
                border: #BBB418 1px solid;
            }

            .weak-password {
                background-color: #ce1d14;
                border: #AA4502 1px solid;
            }

            .strong-password {
                background-color: #12CC1A;
                border: #0FA015 1px solid;
            }
        </style>
        
<section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
<div class='box box-primary'>

        <div>
            <h2 padding-left="50px">Create a New User</h2>
        </div>
        <form action="<?php echo $action; ?>" method="post"  enctype="multipart/form-data" >
        <table class='table table-bordered'>

	    <tr><td>First Name   <?php echo form_error('first_name') ;?></td>
             <td>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g Benjamin" value="<?=set_value('first_name')?>" required/>
	   </td>

	   </tr>

         <tr><td>Last Name <?php echo form_error('last_name') ?></td>
                <td> 
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="e.g Mwesiga" value="<?=set_value('last_name')?>" required/>
             </td>
            </tr>

	    <tr><td>Email Address <?php echo form_error('email') ?></td>
            <td>   <input type="text" name="email" id="email" class="form-control" placeholder="e.g mwesigab@gmail.com" value="<?=set_value('email')?>" required/>        </td>
        <tr>

	    <tr><td>Phone Number <?php echo form_error('phone_number') ?></td>
            <td>   <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="e.g 0700310267" value="<?=set_value('phone_number')?>" required/>        </td>
        <tr>

	    <tr><td>Choose Username <?php echo form_error('username') ?></td>
            <td>   <input type="text" name="username" id="username" class="form-control" placeholder="e.g mwesigab" value="<?=set_value('username')?>" required/> 
              <!-- <input type="hidden" name="usertype" id = "usertype" value="forecast"> -->
                   </td>
        <?php if ($_SESSION['usertype'] == 'administrator'){?>
        <tr>
            <td>User type</td>
            <td>
            <select name="usertype" id = "usertype" class="form-control" >
              <option value="forecast" > Forecaster</option>
              <option value="administrator" >Super Administrator</option>
              
            </select>
            </td>
        </tr>
        <?php
      }
        ?>



	    <tr><td>Password<?php echo form_error('pass') ?></td>
            <td>   <input type="password" name="pass" id="pass" class="form-control demoInputBox" onKeyUp="checkPasswordStrength();" placeholder="Enter your Password" value="<?=set_value('pass')?>"/> 
             <div id="password-strength-status"></div>     
              </td>
        </tr>
	    <tr><td>Confirm Password <?php echo form_error('passconf') ?></td>
            <td>   <input type="password" name="passconf" id="passconf" class="form-control" placeholder="Confirm Your Password" value="<?=set_value('pass_conf')?>"/>        </td>
        </tr>
	    <tr><td colspan='2'><button type="submit" id='submit' class="btn btn-primary" onKeyUp="checkPasswordStrength();">CREATE ACCOUNT</button>
	    <a href="<?php echo site_url('index.php/Landing/Users') ?>" class="btn btn-default">Cancel</a>
            </td>
        </tr>
    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
         <script>
        function checkPasswordStrength() {
            var number = /([0-9])/;
            var alphabets = /([a-zA-Z])/;
            var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
            if ($('#pass').val().length < 6) {
                $('#password-strength-status').removeClass();
                $('#password-strength-status').addClass('weak-password');
                $('#password-strength-status').html("Weak (should be atleast 6 characters.)");
                $('#submit').prop('disabled', true);
            } else {
                if ($('#pass').val().match(number) && $('#pass').val().match(alphabets) && $('#pass').val().match(special_characters)) {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('strong-password');
                    $('#password-strength-status').html("Strong");
                     $('#submit').prop('disabled', false);
                } else {
                    $('#password-strength-status').removeClass();
                    $('#password-strength-status').addClass('medium-password');
                    $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
                     $('#submit').prop('disabled', false);
                }
            }
        }
    </script>
