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
                        USSD FREQUENT USERS
                        <small>Report</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i>USSD FREQUENT USERS </a></li>
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
        <form action="<?php echo base_url('index.php/Landing/most_frequent_users');?>" method="post" enctype="multipart/form-data" >
          <div class="table-responsive"> <table class='table table-bordered'>

           
            <tr><td>Select District</td>
              <td> 
                <select name="district" required class="form-control">
                 
                  <?php foreach($division_data as $row){?>
                  <option value="<?=$row['division_name']?>"> <?php echo $row['division_name'] ?></option>
                  <?php
                }
                  ?>
                </select>
                
             </td>
             
             <td ><input type="submit" value="View Report" name="submit" id="submit" class="btn btn-primary"></td>
           </tr>        
        
      

    </table></div>
  </form>

    <?php
      if(sizeof($frequent_users_data)>0){



    ?>

    <div class='box-body'>
        <div class="table-responsive"><table class="table table-bordered table-striped" id="mytable">
            <thead>
                <tr>
            <th width="80px">No</th>
            <th>Most Frequent Phone</th>
            <th>Frequency</th>
           </tr>
            </thead>
      <tbody>
            <?php
            $start = 0;
      if(isset($frequent_users_data)){
            foreach ($frequent_users_data as $p)
            {   ?>
                <tr>
        <td><?php echo ++$start ?></td>     
      <td><?php echo $p['phone']; ?></td>
      <td><?php echo $p['MOST_FREQUENT']; ?></td>
      
          </tr>
                <?php
            }
      
      }
            ?>
            </tbody>
        </table></div>
        <script src="<?php echo base_url('assets/frameworks/jquery/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        </script>
          <div class="box-tools pull-right">
       
       
       </div>
       <?php
        }
       ?>
                    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->


