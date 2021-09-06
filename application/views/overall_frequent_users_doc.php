<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <!-- Amoko-------------------------------- -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>"/>
        <!-- Amoko-------------------------------- -->
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
        <h4 style="color: #72A0C1;">WIDS: 5 MOST FREQUENT USSD-USERS IN EACH DISTRICT </h4>
         <?php

         foreach ($division_data as $row) {
             $dd = "SELECT phone, COUNT(phone) AS MOST_FREQUENT from ussdtransaction_new WHERE menuvalue = '".$row['division_name']."' AND NOT phone = ' ' GROUP BY phone ORDER BY COUNT(phone) DESC LIMIT 5";
                        $ddd = $this->db->query($dd);
                       
                         ?>
        <h5><b><?php echo strtoupper($row['division_name'])?> MOST FREQUENT USSD USERS</b></h5>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                 <th width="80px">No</th>
            <th>Phone Number</th>
            <th>Frequency</th>
            </tr>
            <!-- Amoko-------------------------------- -->
            <?php
            $start = 0;
             foreach ($ddd->result_array() as $p) {
         
            
                ?>
                <tr>
              <tr>
                <td><?php echo ++$start ?></td>     
                  <td><?php echo $p['phone']; ?></td>
                  <td><?php echo $p['MOST_FREQUENT']; ?></td>
            </tr>

                <?php
            }
                ?>
         
        </table>
               <?php
            
        }
            ?>
    </body>
</html>