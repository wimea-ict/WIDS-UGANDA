<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
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
        </style>
    </head>
    <body>
        <h2>Alerts List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Name</th>
		<th>Issuetime</th>
		<th>Alertscol</th>
		
            </tr><?php
            foreach ($alerts_data as $alerts)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $alerts->name ?></td>
		      <td><?php echo $alerts->issuetime ?></td>
		      <td><?php echo $alerts->alertscol ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>