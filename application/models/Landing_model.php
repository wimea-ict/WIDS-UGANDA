<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing_model extends CI_Model
{
    public $table = 'users';
    public $id = 'id';
    public $username = 'username';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_count_record($table)
    {
        $query = $this->db->count_all($table);
        return $query;
    }

    public function USSD_frequent_users($district_name)
    {

        $query = "SELECT phone, COUNT(phone) AS MOST_FREQUENT from ussdtransaction_new WHERE menuvalue = '" . $district_name . "' AND NOT phone = ' ' GROUP BY phone ORDER BY COUNT(phone) DESC LIMIT 10";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    //--------------Counting ussd accessed districts-----------------------------
    public function district_usage()
    {
        $date2 = '2020-01-01';
        //$date = date("Y-m-d");
        $query = "SELECT DISTINCT menuvalue FROM `ussdtransaction_new` WHERE menuvariable ='district' AND menuvalue != 'invaliddistrict' AND menuvalue != 'district' AND date >= '$date2' ORDER BY menuvalue ASC";
        // $this->db->order_by('menuvalue','ASC');
        $result = $this->db->query($query);

        return $result->result_array();
    }

    //--------------Counting ussd requested sectors-----------------------------
    public function requested_sectors()
    {

        //$date = date("Y-m-d");
        $query = "SELECT DISTINCT menuvalue FROM `ussdtransaction_new` WHERE menuvariable ='sector' AND menuvalue != ' ' ";
        // $this->db->order_by('menuvalue','ASC');
        $result = $this->db->query($query);

        return $result->result_array();
    }

    public function USSD_count_districts($district_name)
    {

        $date = date("Y-m-d");
        $query = "SELECT COUNT(menuvalue) as frequency FROM `ussdtransaction_new` WHERE menuvariable ='district' AND menuvalue = '$district_name' AND menuvalue != 'invaliddistrict'AND menuvalue != 'district' AND date >= '2020-01-01 00:00:00'";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    //---------------------------------------------------------------------------
    public function USSD_usage()
    {
        $date = date("Y-m-d");
        $this->db->select('*', 'COUNT(DISTINCTphone)');
        //$this->db->distinct();
        $this->db->from('ussdtransaction_new');
        // $this->db->like('date', "$date%");//to
        //return $query;
        return $this->db->count_all_results();
    }

    public function ussd_feedback()
    {
        $this->db->select('*');
        $this->db->from('feedback');
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('feedback');
    }

    public function get_count_USSD()
    {
        $date = date("Y-m-d");
        $this->db->select('COUNT(*)');
        $this->db->from('ussdtransaction_new');
        $this->db->like('menuvariable', "product"); //to
        // $this->db->like('date', "$date%");//to
        //return $query;
        return $this->db->count_all_results();
    }
    //count number of ussd on request
    public function ussd($from, $to)
    {

        $this->db->select('COUNT(*) as total');

        $this->db->from('ussdtransaction');

        $this->db->where('RecordDate >=', $from); //from

        $this->db->where('RecordDate <=', $to); //to

        $array = array('districtid IS NOT NULL' => null, 'regionid IS NOT NULL' => null, 'Level6 IS NOT NULL' => null,
            'subregionid IS NOT NULL' => null, 'Level0 IS NOT NULL' => null, 'Level7 IS NOT NULL' => null);

        $this->db->where($array);

        return $this->db->count_all_results();
    }
    //count the number of ussd users...'RecordData' <= '2018-05-13 09:57:36'
    public function ussd_count()
    {

        $this->db->select('COUNT(*) as total');

        $this->db->from('ussdtransaction');

        $this->db->where('RecordDate >=', '2019-01-01 00:00:00'); //from

        $this->db->where('RecordDate <=', '2019-03-26 00:00:00'); //to

        $array = array('districtid IS NOT NULL' => null, 'regionid IS NOT NULL' => null, 'Level6 IS NOT NULL' => null,
            'subregionid IS NOT NULL' => null, 'Level0 IS NOT NULL' => null, 'Level7 IS NOT NULL' => null);

        $this->db->where($array);

        return $this->db->count_all_results();

    }
    //Activate a user by changing the active field
    public function activate_user_status($id)
    {

        $sql = "UPDATE $this->table SET active = 1  WHERE id = $id";
        return (bool) $this->db->query($sql);
    }
    //Deactivate a user by changing the active field
    public function deactivate_user_status($id)
    {
        $sql = "UPDATE $this->table SET active = 0  WHERE id = $id";
        return (bool) $this->db->query($sql);
    }

    public function insert($data)
    {
        $sql = "INSERT INTO $this->table(ip_address,username, password, email, created_on, first_name, last_name, usertype, phone, active, first_time_login) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->query($sql, $data);
    }

    public function get_modem_imei()
    {
        $this->db->select('IMEI');
        $this->db->from('phones');
        return $this->db->get()->row('IMEI');
    }

    public function get_modem_network()
    {
        $this->db->select('NetName');
        $this->db->from('phones');
        return $this->db->get()->row('NetName');
    }

    public function get_signal_strength()
    {
        $this->db->select('Signal');
        $this->db->from('phones');
        return $this->db->get()->row('Signal');
    }

    public function get_modem_status()
    {
        $this->db->select('TimeOut');
        $this->db->from('phones');
        return $interval = strtotime(date('Y-m-d H:i:s')) - strtotime($this->db->get()->row('Timeout'));
        //$status = "ONLINE";
        //if($interval>20)
        //   $status = "OFFLINE";
        //return $status;
    }

    public function get_sms_server()
    {
        $this->db->select('Client');
        $this->db->from('phones');
        return $this->db->get()->row('Client');
    }

    public function disk_totalspace($dir = DIRECTORY_SEPARATOR)
    {
        return disk_total_space($dir);
    }

    public function disk_freespace($dir = DIRECTORY_SEPARATOR)
    {
        return disk_free_space($dir);
    }

    public function disk_usespace($dir = DIRECTORY_SEPARATOR)
    {
        return $this->disk_totalspace($dir) - $this->disk_freespace($dir);
    }

    public function disk_freepercent($dir = DIRECTORY_SEPARATOR, $display_unit = false)
    {
        if ($display_unit === false) {
            $unit = null;
        } else {
            $unit = ' %';
        }

        return round(($this->disk_freespace($dir) * 100) / $this->disk_totalspace($dir), 0) . $unit;
    }

    public function disk_usepercent($dir = DIRECTORY_SEPARATOR, $display_unit = false)
    {
        if ($display_unit === false) {
            $unit = null;
        } else {
            $unit = ' %';
        }

        return round(($this->disk_usespace($dir) * 100) / $this->disk_totalspace($dir), 0) . $unit;
    }

    public function memory_usage()
    {
        return memory_get_usage();
    }

    public function memory_peak_usage($real = true)
    {
        if ($real) {
            return memory_get_peak_usage(true);
        } else {
            return memory_get_peak_usage(false);
        }
    }

    public function memory_usepercent($real = true, $display_unit = false)
    {
        if ($display_unit === false) {
            $unit = null;
        } else {
            $unit = ' %';
        }

        return round(($this->memory_usage() * 100) / $this->memory_peak_usage($real), 0) . $unit;
    }

    //Function to draw the line graph for a region
    public function line_chart($region_id)
    {
        $sql = "SELECT date  as day, (max_temp/100) AS 'R', (min_temp/100) AS 'S', (wind/100) as D FROM daily_forecast WHERE region_id = $region_id ORDER by date ASC";
        return $this->db->query($sql)->result_array();
    }

//
    public function bar_chart($region_id)
    {
        $sql_vic = "SELECT date  as day,  ROUND(AVG((max_temp/100)),2) AS 'R',  ROUND(AVG((min_temp/100)),2) AS 'S',  ROUND(AVG((wind/100)),2) as D FROM daily_forecast WHERE region_id = $region_id group by date ";
        $vic = $this->db->query($sql_vic)->result_array();
        return $vic;
    }

    public function feedback($region_id)
    {
        $sql_vic = "SELECT date  as day,  ROUND(AVG((max_temp/100)),2) AS 'R',  ROUND(AVG((min_temp/100)),2) AS 'S',  ROUND(AVG((wind/100)),2) as D FROM daily_forecast WHERE region_id = $region_id  group by date ";
        $vic = $this->db->query($sql_vic)->result_array();
        return $vic[0];
    }

    //.................................

    // get all
    public function get_all()
    {
        return $this->db->get_where($this->table, array('active' => 1))->result();

    }

    //Retrieve all inactive users
    public function get_inactive_users()
    {
        return $this->db->get_where($this->table, array('active' => 0))->result();
    }
    // get data by id
    public function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    // update data
    public function update($id, $data)
    {

        $sql = "UPDATE $this->table SET username = ?, first_name = ?, last_name = ?, email = ?, usertype = ?, phone = ?  WHERE id = $id";
        return $this->db->query($sql, $data);
    }

    public function get_old_password($username)
    {
        $this->db->where($this->username, $username);
        return $this->db->get($this->table)->row();
    }

    public function update_old_password($username, $password)
    {
        $data = array(
            'password' => $password,
            'first_time_login' => 0,
        );
        $sql = "UPDATE $this->table SET password = ?, first_time_login = ?  WHERE username = '$username'";
        return (bool) $this->db->query($sql, $data);
    }

    public function timely_forecast()
    {

        $sql_morning = 'SELECT count(*) as count from daily_forecast where time=1 and ((date >= DATE_FORMAT(datetime, "%Y-%m-%d")and CAST(datetime As Time) <="23:50:00") OR
                        DATEDIFF(date,DATE_FORMAT(datetime, "%Y-%m-%d"))>1)';
        $sql_morning2 = "SELECT count(*) as count from daily_forecast where time=2 and ((date >= DATE_FORMAT(datetime, '%Y-%m-%d') and CAST(datetime As Time) <='05:50:00') OR
                         DATEDIFF(date,DATE_FORMAT(datetime, '%Y-%m-%d'))>1)";
        $sql_afternoon = "SELECT count(*) as count from daily_forecast where (time=3 OR time=10) and ((date >= DATE_FORMAT(datetime, '%Y-%m-%d') and CAST(datetime As Time) <='11:50:00') OR
                         DATEDIFF(date,DATE_FORMAT(datetime, '%Y-%m-%d'))>1)";
        $sql_evening = "SELECT count(*) as count from daily_forecast where time=4 and ((date >= DATE_FORMAT(datetime, '%Y-%m-%d') and CAST(datetime As Time) <='17:50:00') OR
                        DATEDIFF(date,DATE_FORMAT(datetime, '%Y-%m-%d'))>1)";
        $sql_24 = "SELECT count(*) as count from daily_forecast where time=5 and ((date >= DATE_FORMAT(datetime, '%Y-%m-%d') and CAST(datetime As Time) <='17:50:00') OR
                                                           DATEDIFF(date,DATE_FORMAT(datetime, '%Y-%m-%d'))>1)";

        $sum = ((int) $this->db->query($sql_morning)->result_array()[0]["count"] +
            (int) $this->db->query($sql_morning2)->result_array()[0]["count"] +
            (int) $this->db->query($sql_afternoon)->result_array()[0]["count"] +
            (int) $this->db->query($sql_evening)->result_array()[0]["count"] +
            (int) $this->db->query($sql_24)->result_array()[0]["count"]
        );
        return $sum;

    }
    public function late_daily_forecast()
    {
        $sql_morning = "SELECT count(*) as count from daily_forecast where (time=1 and
                        CAST(datetime AS TIME) >='23:50:00' AND DATEDIFF(DATE_FORMAT(date, '%Y-%m-%d'),DATE_FORMAT(datetime, '%Y-%m-%d'))<=1)
                        OR (time=1 and date < DATE_FORMAT(datetime, '%Y-%m-%d'))";
        $sql_morning2 = "SELECT count(*) as count from daily_forecast where (time=2 and
                         CAST(datetime AS TIME) >='05:50:00' AND DATEDIFF(DATE_FORMAT(date, '%Y-%m-%d'),DATE_FORMAT(datetime, '%Y-%m-%d'))<=1)
                         OR (time=2 and date < DATE_FORMAT(datetime, '%Y-%m-%d'))";
        $sql_afternoon = "SELECT count(*) as count from daily_forecast where ((time=3 OR time=10) and
                          CAST(datetime AS TIME) >='11:50:00' AND DATEDIFF(DATE_FORMAT(date, '%Y-%m-%d'),DATE_FORMAT(datetime, '%Y-%m-%d'))<=1)
                          OR (time=3 OR time=10 and date < DATE_FORMAT(datetime, '%Y-%m-%d'))";
        $sql_evening = "SELECT count(*) as count from daily_forecast where (time=4 and
                        CAST(datetime AS TIME) >='17:50:00' AND DATEDIFF(DATE_FORMAT(date, '%Y-%m-%d'),DATE_FORMAT(datetime, '%Y-%m-%d'))<=1)
                        OR (time=4  and date < DATE_FORMAT(datetime, '%Y-%m-%d'))";
        $sql_24 = "SELECT count(*)  as count from daily_forecast where (time=5 and
                        CAST(datetime AS TIME) >='17:50:00' AND DATEDIFF(DATE_FORMAT(date, '%Y-%m-%d'),DATE_FORMAT(datetime, '%Y-%m-%d'))<=1)
                        OR (time=5  and date < DATE_FORMAT(datetime, '%Y-%m-%d'))";

        $sum = (
            (int) $this->db->query($sql_morning)->result_array()[0]['count'] +
            (int) $this->db->query($sql_morning2)->result_array()[0]['count'] +
            (int) $this->db->query($sql_afternoon)->result_array()[0]['count'] +
            (int) $this->db->query($sql_evening)->result_array()[0]['count'] +
            (int) $this->db->query($sql_24)->result_array()[0]['count']
        );
        return $sum;
    }
    public function timely_seasonal()
    {
        $SOND = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE seasonal_forecast.year = YEAR(seasonal_forecast.created)
         AND season_months.abbreviation = 'SOND' AND MONTH(seasonal_forecast.created) >=7 AND MONTH(seasonal_forecast.created)<=12";
        $MAM = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE seasonal_forecast.year = YEAR(seasonal_forecast.created)
        AND season_months.abbreviation = 'MAM' AND MONTH(seasonal_forecast.created) >=2 AND MONTH(seasonal_forecast.created)<=5";
        $JJA = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE seasonal_forecast.year = YEAR(seasonal_forecast.created)
        AND season_months.abbreviation = 'JJA' AND MONTH(seasonal_forecast.created) >=5 AND MONTH(seasonal_forecast.created)<=8";
        $JF = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE seasonal_forecast.year = YEAR(seasonal_forecast.created)
        AND season_months.abbreviation = 'JF' AND MONTH(seasonal_forecast.created) >=1 AND MONTH(seasonal_forecast.created)<=2";

        $sum = (
            (int) $this->db->query($SOND)->result_array()[0]['count'] +
            (int) $this->db->query($MAM)->result_array()[0]['count'] +
            (int) $this->db->query($JJA)->result_array()[0]['count'] +
            (int) $this->db->query($JF)->result_array()[0]['count']
        );
        return $sum;

    }
    public function late_seasonal()
    {
        $SOND = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE seasonal_forecast.year < YEAR(seasonal_forecast.created)
                AND season_months.abbreviation = 'SOND' AND   MONTH(seasonal_forecast.created)>=1";
        $MAM = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE (seasonal_forecast.year = YEAR(seasonal_forecast.created)
               AND season_months.abbreviation = 'MAM'  AND MONTH(seasonal_forecast.created)>5 AND MONTH(seasonal_forecast.created)<=12) OR 
              seasonal_forecast.year < YEAR(seasonal_forecast.created) ";
        $JJA = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE (seasonal_forecast.year = YEAR(seasonal_forecast.created)
             AND season_months.abbreviation = 'JJA' AND MONTH(seasonal_forecast.created) >9 AND MONTH(seasonal_forecast.created)<=12 ) OR  
             seasonal_forecast.year < YEAR(seasonal_forecast.created)";
        $JF = "SELECT count(*) as count FROM seasonal_forecast INNER JOIN season_months on seasonal_forecast.season_id = season_months.id WHERE (seasonal_forecast.year = YEAR(seasonal_forecast.created)
        AND season_months.abbreviation = 'JF' AND MONTH(seasonal_forecast.created) >2 AND MONTH(seasonal_forecast.created)<=12)
      OR seasonal_forecast.year < YEAR(seasonal_forecast.created)";

        $sum = (
            (int) $this->db->query($SOND)->result_array()[0]['count'] +
            (int) $this->db->query($MAM)->result_array()[0]['count'] +
            (int) $this->db->query($JJA)->result_array()[0]['count'] +
            (int) $this->db->query($JF)->result_array()[0]['count']
        );
        return $sum;

    }
    public function timely_month(){
        $sql="SELECT count(*) as count FROM monthly_forecast  WHERE year >= YEAR(timestamp)
         AND MONTH(str_to_date(month_from,'%M')) <=MONTH(timestamp)";
         return (int) $this->db->query($sql)->result_array()[0]['count'];
    }
    public function late_month(){
        $sql="SELECT count(*) as count FROM monthly_forecast  WHERE year < YEAR(timestamp)
        OR  (MONTH(str_to_date(month_to,'%M')) > MONTH(timestamp) AND year=YEAR(timestamp))";
        return (int) $this->db->query($sql)->result_array()[0]['count'];
    }
    //.................................

    //function for getting dat for bar chart
    /*  function bar_chart(){

$sql_daily = "SELECT AVG(R) as R,AVG(S) as S, AVG(D) as D FROM (SELECT DATE(ReceivingDateTime) as day, SUM(CASE WHEN `Type` = 'received' THEN 1 ELSE 0 END) AS 'R', SUM(CASE WHEN `Type` = 'sent' THEN 1 ELSE 0 END) AS 'S', SUM(CASE WHEN `Type` = 'delivered' THEN 1 ELSE 0 END) as D FROM(SELECT ReceivingDateTime, 'received' `Type` FROM inbox UNION ALL SELECT SendingDateTime, 'sent' FROM sentitems UNION ALL SELECT DeliveryDateTime, 'delivered' FROM sentitems ) t GROUP by DATE(ReceivingDateTime) ORDER by DATE(ReceivingDateTime) ASC)tt";
$daily = $this->db->query($sql_daily)->result_array();

$sql_week = "SELECT AVG(R) as R,AVG(S) as S, AVG(D) as D FROM (SELECT WEEK(ReceivingDateTime) as week, SUM(CASE WHEN `Type` = 'received' THEN 1 ELSE 0 END) AS 'R', SUM(CASE WHEN `Type` = 'sent' THEN 1 ELSE 0 END) AS 'S', SUM(CASE WHEN `Type` = 'delivered' THEN 1 ELSE 0 END) as D FROM(SELECT ReceivingDateTime, 'received' `Type` FROM inbox UNION ALL SELECT SendingDateTime, 'sent' FROM sentitems UNION ALL SELECT DeliveryDateTime, 'delivered' FROM sentitems ) t GROUP by WEEK(ReceivingDateTime) ORDER by WEEK(ReceivingDateTime) ASC)tt";
$weekly = $this->db->query($sql_week)->result_array();

$sql_year = "SELECT AVG(R) as R,AVG(S) as S, AVG(D) as D FROM (SELECT YEAR(ReceivingDateTime) as year, SUM(CASE WHEN `Type` = 'received' THEN 1 ELSE 0 END) AS 'R', SUM(CASE WHEN `Type` = 'sent' THEN 1 ELSE 0 END) AS 'S', SUM(CASE WHEN `Type` = 'delivered' THEN 1 ELSE 0 END) as D FROM(SELECT ReceivingDateTime, 'received' `Type` FROM inbox UNION ALL SELECT SendingDateTime, 'sent' FROM sentitems UNION ALL SELECT DeliveryDateTime, 'delivered' FROM sentitems ) t GROUP by YEAR(ReceivingDateTime) ORDER by YEAR(ReceivingDateTime) ASC)tt";
$yearly = $this->db->query($sql_year)->result_array();

$data = array(
array_merge(array('average'=>'Daily Average'),$daily[0]),
array_merge(array('average'=>'Weekly Average'),$weekly[0]),
array_merge(array('average'=>'Yearly Average'),$yearly[0])
);

return $data;
}*/

}
