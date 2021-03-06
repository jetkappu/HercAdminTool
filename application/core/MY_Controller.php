<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $session_data  = array();
	public $check_perm = array();
	public $db_login;
	public $db_charmap;
	public $db_charmaplog;
	public $db_hat;
	public $ssh2_lib;
	public $global_data;
	public function __construct() {
		parent::__construct();

		$this->load->model('usermodel');
		$this->db_hat = $this->load->database('hat', TRUE, TRUE);
		//$this->output->enable_profiler(TRUE);
		if ($this->session->userdata('loggedin')) {
			// Load models
			$this->load->model('accountmodel');
			$this->load->model('adminmodel');
			$this->load->model('analysismodel');
			$this->load->model('itemmodel');
			$this->load->model('dashboardmodel');
			$this->load->model('servermodel');
			$this->load->model('gamelogmodel');
			$this->load->model('charmodel');
			$this->load->model('guildmodel');
			$this->load->model('bugmodel');
			$servers = $this->config->item('ragnarok_servers');
			$login_servers = $this->config->item('login_servers');
			$login_srv_id = $servers[$this->session->userdata('server_select')]['login_server_group'];
			$login_srv = $login_servers[$login_srv_id]['login_database_group'];
			$this->db_login = $this->load->database($login_srv, TRUE, TRUE);
			// Load Session data.
			$this->session_data = $this->session->userdata('loggedin');
			// Load permission lists and put all permissions into an array for easy retrieval
			$perm_list = $this->config->item('permissions');
			$this->check_perm = $this->usermodel->get_perms($this->session_data['group'],$perm_list);
			$this->maindatabase = $servers[$this->session->userdata('server_select')]['main_database_group'];
			$this->db_charmap = $this->load->database($this->maindatabase, TRUE, TRUE);
			$this->logdatabase = $servers[$this->session->userdata('server_select')]['log_database_group'];
			$this->db_charmaplog = $this->load->database($this->logdatabase, TRUE, TRUE);
			// Get list of groups with ID's so that we can display on header.
			$this->global_data['group_list'] = $this->adminmodel->list_groups_by_name();
			$this->load->vars($this->global_data);
		}				
   }
}