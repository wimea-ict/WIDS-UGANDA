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
        <h2>USSD USER FEEDBACK</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
            <th>Date</th>
            <th>Phone/ Contact</th>
            <th>District</th>
            <th>Feedback</th>
            </tr>
            <!-- Amoko-------------------------------- -->
            <?php
            $start = 0;
            foreach ($ussd_feedback as $p)
            {
                ?>
                <tr>
                <td><?php echo ++$start ?></td>
                <td><?php echo $p['datetime']; ?></td>
      <td>+<?php  echo $p['phone']; ?></td>     
      <td><?php echo $p['district']; ?></td>
      <td><?php echo $p['feedback']; ?></td>
            </tr>

                <!-- Amoko-------------------------------- -->
                <?php
            }
            ?>
        </table>
    </body>
</html>