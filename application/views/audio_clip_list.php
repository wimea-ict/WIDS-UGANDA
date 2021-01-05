<section class="content-header">
                    <h1>
                       Voice Clips
                        <small>Data tables</small>
                    </h1>
                    <ol class="breadcrumb">
                        <?php $this->session->set_flashdata('message', ''); ?>
                        <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Voice Clips</a></li>
                        <li><a href="#"><i class="fa fa-dashboard"></i> Data tables</a></li>
                    </ol>
                </section> 

                <section class='content'>
          <div class='row'>
            <div class='col-xs-12'>
              <div class='box'>
                <div class='box-header'>
                    <h3 class='box-title'>SEASONAL VOICE CLIP LIST 
                    <?php 
                    $link = "index.php/season/audio/".$this->uri->segment(3);
                    echo anchor(site_url($link ), '<i class="fa fa-plus"></i> Add New Audio Clip', 'class="btn btn-success btn-sm"');
                    ?>
                    </h3>
                </div>
                <div class='box-body'>
                    <table class="table table-bordered table-striped" id="mytable">
                        <thead>
                            <tr>
                                <th width="80px">No</th>
                                <th>Language</th>
                                <th>Clip Name</th>
                                <th>Play Clip</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
            
                                $start = 0;
                            if(isset($clips)){
                                foreach ($clips as $ad)
                                {
                                 ?>
                                    <tr>
                                        <td><?php echo ++$start ?></td>
                                        <td><?php  echo $ad['language'] ; ?></td>
                                        <td><?php  echo $ad['voice_name'].".mp3";  ?></td>  
                                        <td>
                                            <audio controls>
                                                <source src="<?php echo base_url('assets/audio').'/'.$ad['voice_name'].".mp3" ?>" type="audio/mp3">
                                                <source src="<?php echo base_url('assets/audio').'/'.$ad['voice_name'].".ogg" ?>" type="audio/ogg">
                                                <source src="<?php echo base_url('assets/audio').'/'.$ad['voice_name'].".wav" ?>" type="audio/wav">
                                            </audio></td>                          
                                        
                                        <td style="text-align:center" width="140px">
                                <?php 
                                    echo '  '; 
                                    echo anchor(site_url('index.php/season/audio_delete/'.$ad['id']),'<i class="fa fa-trash-o"></i>','title="delete" class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure, you want to delete this clip ?\')"'); 
                                
                                ?>
                                </td>
                                </tr>
                                    <?php
                                    }
                                
                                }
                                ?>
                        </tbody>
                    </table>
                    <script src="<?php echo base_url('assets/frameworks/jquery/jquery.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#mytable").dataTable();
            });
        </script>
                </div>
            </div>
            </div>
        </div>
    </section>