<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Graph extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->config->set_item('theme', $this->config->item('country'));

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('Landing_model');
        $this->load->library('session');
        $this->load->model('User_feedback_model');
        $this->load->model('Late_upload_model');
        $this->load->database();
        include APPPATH . 'third_party/morris/landing_charts.php';
    }

    public function index()
    {
        //charts for north, east, central,west
        $this->data['line_chart1'] = $this->line_chart("north_line");
        $this->data['line_chart2'] = $this->line_chart("east_line");
        $this->data['line_chart3'] = $this->line_chart("west_line");
        $this->data['line_chart4'] = $this->line_chart("central_line");
        $this->data['line_chart2'] = $this->line_chart("east_line");
        echo "sdsd";
        exit();
        $this->load->view('template', $this->data);

    }

    /**
     * Display l victoria
     *
     * @brief Creates a line chart
     */
    private function line_chart($element_id)
    {
        $morris = new MorrisLineCharts($element_id);
        $morris->xkey = array('day');
        $morris->ykeys = array('R', 'S', 'D');
        $morris->labels = array('Maximum temperature', 'Minimum temperature', 'Wind Speed');
        $morris->data = $this->Landing_model->line_chart('east');
        return $morris->toJavascript();
    }

    //feedback
    public function feedback()
    {
        $data['change'] = 43;

        $data['bar_chart'] = $this->feedbackG("test_bar");

        $this->load->view('template', $data);
    }

    private function feedbackG($element_id)
    {
        $morris = new MorrisBarCharts($element_id);
        $morris->xkey = array('average');
        $morris->barSizeRatio = 0.3;
        // $morris->barGape =2;
        $morris->ykeys = array('R');
        // $morris->barColors = ['orange'];
        $morris->ymax = 10;
        $morris->labels = array('Accuracy', 'Applicability', 'Timeliness');
        $morris->stacked = true;

        $morris->data = $this->User_feedback_model->feedbackgraph();

        return $morris->toJavascript();
    }

    public function ussdRequest()
    {
        $data['change'] = 44;
        $data['bar_chart'] = $this->ussdRequestG("test_bar");
        $this->load->view('template', $data);
    }

    private function ussdRequestG($element_id)
    {
        $morris = new MorrisBarCharts($element_id);
        $morris->xkey = array('Requests');
        $morris->barSizeRatio = 0.1;
        $morris->barGape = 0.1;
        $morris->grid = false;
        $morris->ykeys = array('R');
        $morris->labels = array('Requests');
        $morris->stacked = false;
        $morris->data = $this->User_feedback_model->ussdrequest();
        return $morris->toJavascript();
    }

    public function trend()
    {
        $data['change'] = 45;
        $data['bar_chart'] = $this->trendG("test_bar");
        $this->load->view('template', $data);

    }

    private function trendG($element_id)
    {
        $morris = new MorrisBarCharts($element_id);
        $morris->xkey = array('average');
        $morris->barSizeRatio = 0.3;
        $morris->barGap = 7;
        $morris->resize = auto;
        $morris->ykeys = array('S', 'D', 'R');
        $morris->labels = array('Seasonal', 'Marine', 'Daily');
        $morris->stacked = false;
        $morris->data = $this->User_feedback_model->trend();
        return $morris->toJavascript();
    }

    public function requested_sectors()
    {
        $data['change'] = 125;

        $query_data = $this->User_feedback_model->trendSectors();
        $sectors_data = [];
        $dataPoints = array();
        $rects = array();
        $dataPoints1 = array();
        $rects1 = array();

        foreach ($query_data as $row) {

            $sector = $row['menuvalue'];
            $sectors = "SELECT Count(menuvalue) AS 'sectors_count' from ussdtransaction_new WHERE menuvalue  = '$sector'";
            $sectorsCount = $this->db->query($sectors)->row('sectors_count');
            $rects["y"] = $sectorsCount;
            $rects["label"] = $row["menuvalue"];
            $dataPoints[] = $rects;
            unset($rects);

            $rects1["y"] = $sectorsCount;
            $rects1["label"] = $row["menuvalue"];
            $dataPoints1[] = $rects1;
            unset($rects1);
        }

        $data['sectors_data'] = $dataPoints;
        $data['sectors2_data'] = $dataPoints1;
        $this->load->view('template', $data);

    }

    public function ussd_sessions()
    {
        $data['change'] = 135;
        $dataPoints = array();
        $rects = array();
        $dataPoints1 = array();
        $rects1 = array();
        // USSD daily user number  get_overall_users
        $user_nums = array();
        $user_nums2 = array();

        for ($i = 0; $i <= 7; $i++) {
            $user_nums[] = $this->User_feedback_model->get_users(date('Y-m-d', strtotime(date('Y-m-d') . '-' . $i . ' day')));
            $user_nums2[] = $this->User_feedback_model->get_overall_users(date('Y-m-d', strtotime(date('Y-m-d') . '-' . $i . ' day')));
        }

        $users = $user_nums;
        $users2 = $user_nums2;

        for ($i = 7; $i >= 0; $i--) {

            $rects["y"] = $users[$i][0]['count_users'];
            $rects["label"] = date('Y-m-d', strtotime(date('Y-m-d') . '-' . $i . ' day'));
            $dataPoints[] = $rects;
            unset($rects);

            $rects1["y"] = $users2[$i][0]['count_users'] - $users[$i][0]['count_users'];
            $rects1["label"] = date('Y-m-d', strtotime(date('Y-m-d') . '-' . $i . ' day'));

            $dataPoints1[] = $rects1;
            unset($rects1);
        }

        $data['session_data'] = $dataPoints;
        $data['overall_session_data'] = $dataPoints1;
        $this->load->view('template', $data);

    }

    public function web_visits()
    {
        $data['change'] = 134;

        $query_data = $this->User_feedback_model->trendWebVisits();
        $sectors_data = [];
        $dataPoints = array();
        $rects = array();

        foreach ($query_data as $row) {

            $page = $row['page'];
            $page_requests = "SELECT Count(page) AS 'page_visits' from pageview WHERE page  = '$page'";
            $VisitsCount = $this->db->query($page_requests)->row('page_visits');
            $rects["y"] = $VisitsCount;
            $rects["label"] = $row["page"];
            $dataPoints[] = $rects;
            unset($rects);

        }

        $data['graph_data'] = $dataPoints;
        $data['visits_data'] = $this->User_feedback_model->get_all_Visits();
        $data['daily_count'] = $this->User_feedback_model->get_daily_counts();
        $data['seasonal_count'] = $this->User_feedback_model->get_seasonal_counts();
        $this->load->view('template', $data);

    }

    private function trendSectors($element_id)
    {
        $morris = new MorrisBarCharts($element_id);
        $morris->xkey = array('average');
        $morris->barSizeRatio = 0.3;
        $morris->barGap = 7;
        $morris->resize = auto;
        $morris->ykeys = array('S', 'D', 'R');
        $morris->labels = array('average');
        $morris->stacked = false;
        $morris->data = $this->User_feedback_model->trendSectors();
        return $morris->toJavascript();
    }

    public function uploadTime()
    {

        $data['change'] = 138;
        function time_to_decimal($time)
        {
            $timeArr = explode(':', $time);
            $decTime = ($timeArr[0] * 60) + ($timeArr[1]) + ($timeArr[2] / 60);

            return $decTime;
        }
        // request for ajax data
        if ($this->input->is_ajax_request()) {

            header('Content-Type: application/json');

            $postData = $this->input->post("forecastperiod");
            $postDate = $this->input->post('forecastdate');

            if ($postData == 'early_morning') {

                $items = $this->Late_upload_model->get_period_data(1, $postDate);
                $data['chart_title'] = "Early morning Six hourly forecast Upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);

            } elseif ($postData == 'late_morning') {

                $items = $this->Late_upload_model->get_period_data(2, $postDate);
                $data['chart_title'] = "Late morning Six hourly forecast Upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);

            } else if ($postData == 'afternoon') {

                $items = $this->Late_upload_model->get_period_data(10, $postDate);
                $data['chart_title'] = "Afternoon Six hourly forecast Upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);

            } else if ($postData == 'late_afternoon') {

                $items = $this->Late_upload_model->get_period_data(3, $postDate);
                $data['chart_title'] = "Afternoon Six hourly forecast Upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);

            } else if ($postData == 'evening') {

                $items = $this->Late_upload_model->get_period_data(4, $postDate);
                $data['chart_title'] = "Evening Six hourly forecast Upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);

            } else if ($postData == '24hourly') {
                $items = $this->Late_upload_model->get_period_data(5, $postDate);
                $data['chart_title'] = "24 hourly forecast Upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);
            } else if ($postData == 'monthly') {
                $items = $this->Late_upload_model->get_monthly_data($postDate);
                $data['chart_title'] = "Monthly forecast upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);

            } else if ($postData == 'seasonal') {
                $items = $this->Late_upload_model->get_seasonal_data();
                $data['chart_title'] = "Seasonal forecast Upload Time ";
                $data['chart_data'] = $items;

                echo json_encode($data);

            }

        }
        // default graph to be displayed
        else {
            $items = [];
            $items = $this->Late_upload_model->get_period_data(1, null);
            $data['chart_title'] = "Early morning Six hourly forecast Upload Time";
            $data['chart_data'] = json_encode($items);
            //var_dump($items);
            $this->load->view('template', $data);

        }

    }

}
