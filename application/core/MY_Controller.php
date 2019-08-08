<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MY_Controller extends CI_Controller {
	public $baseUrl;
	protected $data = null;
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		if(!$this->session->userdata('id')){
			redirect('auth/login', 'location');
			die;
		}

		if(!empty($this->session)){
			// $this->output->cache(1);
			define('USER_ID', $this->session->userdata('id'));
			define('USER_USERNAME', $this->session->userdata('username'));
			define('USER_FIRSTNAME', $this->session->userdata('firstname'));
			define('USER_LASTNAME', $this->session->userdata('lastname'));
			define('USER_EMAIL', $this->session->userdata('email'));
			define('USER_PHONE', $this->session->userdata('phone'));
			$this->session->set_userdata('last_time', time());
		}
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

	public function common_upload(){
		$this->load->library('upload');
	}

	public function readExcel( $file ){
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		// echo "<pre>"; print_r($spreadsheet);die;
		// read excel data and store into an array
		$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		return $xls_data;
	}

	public function export( $fileName = 'test.xlsx', $title = "Export excel", $sheetTitle = 'Test', $headerColumns = array(), $data = array(), $tmp = false ){

		$abc = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA'];

		$this->load->helper('download');

		if( !is_array($headerColumns) ){
            $headerColumns = explode(',', $headerColumns);
        }
        $length = count($headerColumns);
        $rowCount = 2;
        $index = 1;
        // set Header
        $start = $abc[0];
        $end = $abc[$length-1];

        $sheetData = array();
		$sheetData['title'] = $sheetTitle;

		// get employee list
		$spreadsheet = new Spreadsheet();
        //name the worksheet
		$sheet = $spreadsheet->getActiveSheet();

		if( !empty( $headerColumns ) )
        {
            foreach( $headerColumns as $key=>$header )
            {
                $spreadsheet->getActiveSheet()->SetCellValue($abc[$key].$rowCount,ucwords(str_replace("_"," ", $header)));
            }
        }

        // set bold header
        $spreadsheet->getActiveSheet()->getStyle($start.$index.":".$end.$index)->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle($start.$index.":".$end.$index)->getFont()->setSize(16);

		// set bold header
		$spreadsheet->getActiveSheet()->getStyle($start . $rowCount . ':'.$end . $rowCount)->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle($start . $rowCount . ':'.$end . $rowCount)->getFont()->setSize(12);
		// merge
		$spreadsheet->getActiveSheet()->mergeCells($start.$index.":".$end.$index);

		$spreadsheet->getActiveSheet()->setCellValue($start.$index, $title);

		$spreadsheet->getActiveSheet()->getStyle($start.$index.":".$end.$index)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);

		$spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(-1);

		// read data to active sheet
        if (!empty($data)) {
            foreach ($data as $row_data) {
                $rowCount++;
                foreach( $headerColumns as $k=>$header )
                {
                    $spreadsheet->getActiveSheet()->SetCellValue($abc[$k] . $rowCount, $row_data[$header]);
                }
                $index++;
            }
        }

        foreach(range($start,$end) as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $fileName . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}
}
?>