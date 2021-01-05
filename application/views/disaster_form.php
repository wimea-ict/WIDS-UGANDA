<!-- Main content -->
        <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>

                  <h3 class='box-title'>ADD NEW DISASTER</h3>
                      <div class='box box-primary'>
         <form action="<?php echo  site_url('index.php/Disaster/save/'.$this->uri->segment(3))?>" method="post"  enctype="multipart/form-data" ><table class='table table-bordered'>
	    <tr>
  

        	
        	<td>Region<?php echo form_error('region_id') ?></td>
            <td>
             <select name="region_id" class="form-control">
             <?php 

                 $sql1 = "SELECT * FROM  region";
                            $sql3= $this->db->query($sql1);
                            foreach ($sql3->result_array() as $row2) { ?>
                           <option value="<?php echo $row2['id']; ?>"><?php echo $row2['region_name']; ?></option>
                           <?php
                            }
        
        ?>

             </select>
       		 </td>
	    </tr>
      <tr>
        <td>Disaster description <?php echo form_error('disaster_desc') ?></td>
            <td>
          <textarea required  class="form-control" name="disaster_desc" id="disaster_desc" placeholder="Disaster description" value="<?php echo $disaster_desc; ?>" ></textarea>
        </td>
      <input type="hidden" name="id" value="<?php echo $idd; ?>" />
        
      </tr>

        <td colspan='2'>
        <input type="submit" class="btn btn-primary" value="Submit"/>
	    </td></tr>

    </table></form>
    </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
