<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
            tr{
                vertical-align: top;
            }
        </style>
    </head>
    <body>
        <h2>Major Sectors</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
               <th width="80px">No</th>
               <th>Language</th>
                <th>Major-Sector Name</th>  
            </tr>
            <?php
            foreach ($major_data as $re)
            {
                ?>
                <tr>
                    <td><?php echo ++$start ?></td>
            <td><?php  echo $re->language;?></td>

            <td><?php  echo $re->sector_name;?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>