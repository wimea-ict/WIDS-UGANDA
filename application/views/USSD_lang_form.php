<!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  <h3 class='box-title'>ADD NEW LANGUAGE</h3>
                      <div class='box box-primary'>
                        <br>
        <form action="<?php echo site_url('index.php/USSD/saveLanguage'); ?>" method="post"><div class="table-responsive"><table class='table table-bordered'>
      <tr>
          <td>Languge</td>
           <td>
             <input required type="text" name="language" class="form-control" id ="language" placeholder ="Enter Language">
           </td>
        </td>
       

      </tr>
      <tr>
        <td><b>English Form</b></td>
        <td><b>New Translation</b></td>
      </tr>
        <tr>
          <td>Please Enter Your District</td>
            <td>
              <input type="text" name="district" id="district" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Invalid district entered<br>Please enter your district</td>
            <td>
               <textarea maxlength="160" required rows="2" name="invalidistrict" id="invalidistrict" style="width: 100%" cols="70"></textarea>
            </td>
        </tr>

        <tr>
          <td>Select a product</td>
            <td>
              <input type="text" name="prod" id="prod" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Back</td>
            <td>
              <input type="text" name="back" id="back" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Daily Forecast</td>
            <td>
              <input type="text" name="daily" id="daily" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Seasonal Forecast</td>
            <td>
              <input type="text" name="seasonal" id="seasonal" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>10 Day Forecast</td>
            <td>
              <input type="text" name="dekadal" id="dekadal" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Give Feedback</td>
            <td>
              <input type="text" name="feedback" id="feedback" style="width: 100%" required>
           </td>
        </tr>
        

        <tr>
          <td>Select a sector</td>
            <td>
              <input type="text" name="sects" id="sects" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Confirm Submission</td>
            <td>
              <input type="text" name="submission" id="submission" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Unknown Input Option<br>0. Back</td>
            <td>
               <textarea maxlength="160" required rows="2" name="invalidinput" id="invalidinput" style="width: 100%" cols="70"></textarea>
            </td>
        </tr>
        <tr>
          <td>Sorry, the selected forecast data is currently unavailable.<br>Please try again later<br>1. Products<br>0. Enter district</td>
            <td>
               <textarea maxlength="160" required rows="4" name="no_data" id="no_data" style="width: 100%" cols="70"></textarea>
            </td>
        </tr>
        <tr>
          <td>Please Choose a Response format<br>1. Text Message<br>2. Audio</td>
            <td>
               <textarea maxlength="160" required rows="2" name="response_format" id="response_format" style="width: 100%" cols="70"></textarea>
            </td>
        </tr>
         <tr>
          <td>You will receive a message shortly<br>Thank you for Contacting Us.</td>
            <td>
               <textarea maxlength="160" required rows="2" name="End" id="End" style="width: 100%" cols="70"></textarea>
            </td>
        </tr>
        <tr>
          <td>You will receive a call shortly<br>Thank you for Contacting Us.</td>
            <td>
               <textarea maxlength="160" required rows="2" name="voiceEnd" id="voiceEnd" style="width: 100%" cols="70"></textarea>
            </td>
        </tr>
        <tr>
          <td>Wind Strength</td>
            <td>
              <input type="text" name="wind" id="wind" style="width: 100%" required>
           </td>
        </tr>



        <tr>
          <td>Temperature</td>
            <td>
              <input type="text" name="temp" id="temp" style="width: 100%" required>
           </td>
        </tr>
        
        <tr>
          <td>Weather</td>
            <td>
              <input type="text" name="weather" id="weather" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>Summary</td>
            <td>
              <input type="text" name="summary" id="summary" style="width: 100%" required>
           </td>
        </tr>
        <tr>
          <td>How can we best improve on our forecasts or services?</td>
          <td><input type="text" name="feedbackhead" id="feedbackhead" style="width: 100%" required></td>
        </tr>
        <tr>
          <td>Feedback recieved. Thank you for supporting us</td>
          <td><input type="text" name="feedbackrep" id="feedbackrep" style="width: 100%" required></td>
        </tr>
        

        
     
        
       
       
        

        <td colspan='2'>
          <input type="submit" class="btn btn-primary" value="Submit"/>
      </td></tr>

    </table></div></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
