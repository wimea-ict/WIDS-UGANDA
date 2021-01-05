<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**
 * 
 */
class USSD_model extends CI_model
{
	public $id = "id";
	public $table = "ussdmenulanguage";
	public $order = "ASC";
	public $language_table = "language_text_table";

	function __construct()
	{
		parent::__construct();
	}

    function subscriptions(){
        $this->db->select("phone, forecast, division_name, language, u.timestamp");
        $this->db->join('division AS d', 'd.id = u.district');
        $this->db->join('ussdmenulanguage AS l', 'l.id = u.language_id');
        return $this->db->order_by('u.id','DESC')->get('ussd_subscriptions AS u')->result();
    }

    function view_reply($id){
        $this->db->select('*');
        $this->db->from('feedback');
        $this->db->where('feedback.id',$id);
        $query = $this->db->get();
        return $query->result_array();
    }

	function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function checker($lang)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('language',$lang);
        return $this->db->get($this->table)->result();
    }

    function get_lang($lang)
    {
        return $this->db->get($this->table)->result();
    }

    function insert($data=array())
    {
    	$this->db->insert($this->table,$data); 
    	// $this->db->insert($menu, $data); 
    }
    function translations($menu, $data=array())
    {
    	// $this->db->insert($this->table,$data); 
    	$this->db->insert($menu, $data); 
    }
    
    function delete($table_name)
    {
        $this->db->where($this->language_table, $table_name);
        $this->db->delete($this->table);
    }

    function display_trans($table_name){
    	$this->db->select('ussdmenu.menudescription as eng, '.$table_name.'.menudescription as trans');
    	$this->db->from('ussdmenu');
    	$this->db->join($table_name, "$table_name.menuname = ussdmenu.menuname");
    	return $this->db->get()->result();
    }

    function display_lang($table_name){
    	$this->db->select('language');
    	$this->db->from($this->table);
    	$this->db->where('language_text_table', $table_name);
    	return $this->db->get()->result();
    }
    function updating($id, $feedback)
     {
        $sql = "UPDATE feedback SET reply= ? WHERE id = $id";
        return $this->db->query($sql, $feedback);
     }
    function Messages($message,$phoneNumber){ 

        $resp = "";
        try{
            $textmessage = urlencode($message);
            $ch = curl_init();
            curl_setopt_array($ch,array(
            CURLOPT_RETURNTRANSFER =>1,   
             CURLOPT_URL =>'http://simplysms.com/getapi.php?email=mnsabagwa@cit.ac.ug&password=XyZp3q7&sender=8777&message='.$textmessage.'&recipients='.$phoneNumber,
            CURLOPT_USERAGENT =>'Codular Sample cURL Request'));

            $resp = curl_exec($ch);

            curl_close($ch);
            
        }catch(Exception $e){}
        return $resp;

    }
}

    
?>