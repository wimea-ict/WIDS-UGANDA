<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class USSD extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->config->set_item('theme',$this->config->item('country'));
		$this->load->model('USSD_model');
		$this->load->model('Landing_model');
		$this->load->library('form_validation');
        $this->load->library('session');//Major_model	
        $this->load->dbforge();
        $this->dbforge = $this->load->dbforge($this->session->userdata('database_username'), TRUE);

    }

    public function index()
    {
    	$data = array(
    		'change' => 88,
    		'language' => $this->USSD_model->get_all()
    	);

    	$this->load->view('template', $data);
    }

    public function Subscriptions(){
    	$data = array(
    		'change' => 126,
    		'subscriptions' => $this->USSD_model->subscriptions()

    	);
    	$this->load->view('template', $data);
    }

    public function Subscription_messages(){
        $data = array(
            'change' => 136,
            'subscriptions' => $this->USSD_model->subscription_msges()

        );
        $this->load->view('template', $data);
    }

    public function Voice(){
        $data = array(
            'change' => 137,
            'subscriptions' => $this->USSD_model->voice_msges()

        );
        $this->load->view('template', $data);
    }

    

    public function UserFeedback()
    {
    	$data=array(
    		'change' => 118,
    		'ussd_feedback' => $this->Landing_model->ussd_feedback()
    	);
    	$this->load->view('template', $data);
    }

    public function addNew()
    {
    	$data['change'] = 89;
    	$this->load->view('template', $data);	
    }

    public function Reply(){
    	$this->uri->segment(3);
    	$data = array(
    		'change'	=> 119
    	);
    	$this->load->view('template',$data);
    }
    public function saveLanguage(){
    	$language = $this->input->post('language',TRUE);
    	$lang = $this->USSD_model->checker(trim($language));
    	$no = FALSE;
    	if($lang != null){

    		$this->session->set_flashdata('message','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Language already exists.</div>');

    	}else{
    		$menu =strtolower("ussdmenu".$language);
    		$daily_forecast =strtolower("daily_forecast_data_".$language);

    		$field = array(
    			'id' => array(
    				'type' => 'INT',
    				'constant' => 20,
    				'unique' => TRUE,
    				'unsigned' => TRUE,
    				'auto_increment' => TRUE
    			),
    			'menuname' => array(
    				'type' => 'VARCHAR',
    				'constraint' => '255'
    			),
    			'menudescription' => array(
    				'type' => 'VARCHAR',
    				'constraint' => '255'
    			)
    		);
    		$this->dbforge->add_field($field);


    		if($this->dbforge->create_table($menu)){
    			$datatoinsert = array(
    				$this->input->post('district',TRUE),
    				str_replace("\r\n", "-", $this->input->post('invalidistrict',TRUE)),
    				$this->input->post('prod',TRUE),
    				$this->input->post('back',TRUE),
    				$this->input->post('daily',TRUE),
    				$this->input->post('seasonal',TRUE),  
    				$this->input->post('dekadal',TRUE),
    				$this->input->post('feedback',TRUE),
    				$this->input->post('sects',TRUE),  
    				$this->input->post('submission',TRUE),
    				str_replace("\r\n", "-",$this->input->post('invalidinput',TRUE)),
    				str_replace("\r\n", "-",$this->input->post('no_data',TRUE)),
    				str_replace("\r\n", "-",$this->input->post('response_format',TRUE)),
    				str_replace("\r\n", "-", $this->input->post('End',TRUE)),
    				str_replace("\r\n", "-", $this->input->post('voiceEnd',TRUE)),
    				$this->input->post('wind',TRUE),  
    				$this->input->post('temp',TRUE),
    				$this->input->post('weather',TRUE),  
    				$this->input->post('summary',TRUE),
    				$this->input->post('feedbackhead',TRUE),  
    				$this->input->post('feedbackrep',TRUE)
    			);

    			$data_menu = array('district','invalidistrict','prod','back','daily','seasonal','dekadal','feedback','sects','Submission-opt','invalidinput','no_data','response_format','End','voicecall','wind','temp','wet','sum','feedbackdisp','feedbackrep');

    			$language = array(
    				'language' => $language,
    				'language_text_table' => $menu,
    				'forecast_table' => "seasonal_forecast_".strtolower($language),'daily' => "daily_forecast_data_".strtolower($language)
    			);

    			$this->USSD_model->insert($language);
    			for($i = 0; $i< count($data_menu); $i++){
    				$data_intert = array(
    					'menuname' => $data_menu[$i],
    					'menudescription' => $datatoinsert[$i]
    				);
    				$this->USSD_model->translations($menu,$data_intert);
    			}



    			$this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New language menu added successfully.</div>');
    		}else{
    			$this->session->set_flashdata('message','<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Database creation failed.</div>');
    		}
    	}



    	redirect('index.php/USSD'); 

    }

    function delete() 
    {
    	$forecast_table_name = $this->uri->segment(3);
    	$this->USSD_model->delete($forecast_table_name);
    	$tab = "".$forecast_table_name;


    	$daily_table = $this->uri->segment(4);
    	$tabling = "".$daily_table;

  		// $this->dbforge->drop_table($tabling);
    	$this->dbforge->drop_table($tab);
    	$this->session->set_flashdata('message','<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Language deleted.</div>');

    	redirect('index.php/USSD');
    }
    function read()
    {
    	$table = $this->uri->segment(3);
    	$data = array(
    		'change' => 90,
    		'language' => $this->USSD_model->display_lang($table),
    		'language_trans' => $this->USSD_model->display_trans($table)
    	);

    	$this->load->view('template', $data); 
    }


    public function ussd_hourly_users(){
    	$data = array(
    		'change'=>121
    	);
    	$this->load->view('template',$data);
    }
    
    public function DailyUsers(){
    	$data = array(
    		'change'=>117
    	);
    	$this->load->view('template',$data);
    }

    //------------View replied feedback--------------
    public function View_feedback_reply(){
    	$id = $this->uri->segment(3);
    	$reply_data = $this->USSD_model->view_reply($id);
    	$data = array(
    		'change'=>124,
    		'reply_data' => $reply_data
    	);
    	$this->load->view('template',$data);
    }
}


?>
