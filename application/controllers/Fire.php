<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Fire extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(http_response_code()){
			show_error('Request only handled by cli');
		}
	}

	public function create( $file ){
		$file = ucfirst(str_replace(' ', '', $file));
		if(file_exists(APPPATH.'controllers'.DIRECTORY_SEPARATOR.$file.'.php')){
			echo 'File already exist.';
		}else{
			$handle = fopen(APPPATH.'controllers'.DIRECTORY_SEPARATOR.$file.'.php', 'w');
			$content = "<?php ";
			$content .= " \n defined('BASEPATH') OR exit('No direct script access allowed');";
			$content .= " \n /** Developer: Milan Soni";
			$content .= " \n  * Created Date: ".date('Y-m-d H:i:s');
			$content .= " \n  * Created By : CLI";
			$content .= " \n */ ";
			$content .= "\n \n class $file extends MY_Controller {";
			$content .= "\n \n \t public function __construct() {";
			$content .= "\n \t \t parent::__construct();";
			$content .= "\n \t }";
			$content .= "\n }";
			fwrite($handle, $content);

			echo 'Controller '.$file.'.php is created successfully.';
		}
	}
}
?>