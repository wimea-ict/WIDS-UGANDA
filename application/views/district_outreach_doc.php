<!doctype html>
<html>
    <head>
        <title>USSD DISTRICT USAGE </title>
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
        <?php
        $district_counter = 0;
        foreach ($district_usage as $c)
        {
            ++$district_counter;
        }
        ?>
        <h3>OVERALL USSD DISTRICT COVERAGE SINCE JANUARY, 2020 (<?php echo $district_counter?> OUT OF 135 DISTRICTS IN DATABASE)</h3>
        <h4>Extracted on: <?php echo date('Y-m-d H:i:s');?></h4>

        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th width="80px">No</th>
                <th>DISTRICT</th>
                <th>REQUEST FREQUENCY</th>
            </tr>
            

<?php
$start = 0;
// print_r($city_data); exit();
foreach ($district_usage as $c)
{
$date = date("Y-m-d");
        $query = "SELECT COUNT(menuvalue) as frequency FROM ussdtransaction_new WHERE menuvariable ='district' AND menuvalue = '".$c['menuvalue']."' AND menuvalue != 'invaliddistrict'  AND date >= '2020-01-01 00:00:00'";
        $result = $this->db->query($query);
        
?>
<tr>
<td><?php echo ++$start ?></td>
<td><?php echo strtoupper($c['menuvalue']); ?></td>

<td>
    <?php
    foreach ($result->result_array() as $row) {
            $frequency = $row['frequency'];
           
     echo $frequency;
    }
      ?>
        
    </td>

</tr>
<?php
}
?>
</tbody>
        </table>
    </body>
</html>