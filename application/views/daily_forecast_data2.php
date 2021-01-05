<!DOCTYPE html>
<html>
<head>
    <title>Daily_forecast Data List</title>
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
    <h2>Daily_forecast Data List</h2>
     <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
                <th>Temperature</th>
                <th>Wind Speed</th>
                <th>Wind Direction</th>
                <th>Wind Strength</th>
                <th>Region</th>
                <th>Date</th>
            </tr>
             <?php
            $start = 0;
            foreach ($daily_forecast_data as $p)
            {
                ?>
                 <tr>
                    <td><?php echo ++$start ?></td>    
                    <td><?php echo $p->mean_temp; ?></td>
                    <td><?php echo $p->wind; ?></td>
                    <td><?php echo $p->wind_direction; ?></td>      
                    <td><?php echo $p->wind_strength; ?></td>
                     <td><?php echo $p->region_name; ?></td>
                    <td><?php echo $p->datetime?></td>
                </tr>

                <!-- Amoko-------------------------------- -->
                <?php
            }
            ?>
    </table>
</body>
</html>