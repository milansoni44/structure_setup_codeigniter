<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	public $baseUrl;
	protected $data = null;
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->baseUrl = base_url();
		if(!in_array($_SERVER['REMOTE_ADDR'], $this->config->item('maintenance_ips')) && $this->config->item('maintenance_mode') == TRUE) {
      		include(APPPATH.'views/maintenance_view.php');
	        die();
	    }
		$this->load->helper('breadcrumb_helper');
		$this->load->model('MY_Model','model'); //Load the Model here   
	}

	public function load_content($content = NULL, $data = array()){
		$content = $this->load->view($content, $this->data, TRUE);
		$this->data['page_js'] = $this->get_string_between($content);
		$this->data['content'] = preg_replace('/@script[\s\S]+?@endscript/', '', $content);
		$this->load->view('layouts/main_layout', $this->data);
	}

	public function get_string_between($string, $start = '@script', $end = '@endscript'){
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}

	public function flash($type, $msg) {
		$this->session->set_flashdata($type, $msg);
	}
}
?>