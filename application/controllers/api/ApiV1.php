<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class ApiV1 extends REST_Controller {

    public function __construct() { 
        parent::__construct();
        
        // Load the user model
        $this->load->model('user');
        $this->load->helper('url');
    }
    
    public function login_post() {
        // Get the post data
        $email = $this->post('username');
        $password = $this->post('password');
        
        // Validate the post data
        if(!empty($email) && !empty($password)){
            
            // Check if any user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'email' => $email,
                'password' => $password,
                'status' => 1
            );
            $user = $this->user->getRows($con);
            
            if($user){
                // Set the response and exit
                $this->response([
                    'status' => TRUE,
                    'message' => 'User login successful.',
                    'data' => $user
                ], REST_Controller::HTTP_OK);
            }else{
                // Set the response and exit
                //BAD_REQUEST (400) being the HTTP response code
                $this->response([
                    'status' => FALSE,
                    'message' => 'Wrong email or password.',
                    'data' => array()
                ], REST_Controller::HTTP_OK);
            }
        }else{
            // Set the response and exit
            $this->response([
                    'status' => FALSE,
                    'message' => "Provide email and password.",
                    'data' => array()
                ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function general_data_get(){
        $qrUrl = base_url()."qr";

        $res = array();
        $resultDepartment = $this->db->get_where('departments', array('status'=>1))->result_array();
        $resultPlants = $this->db->get_where('plants', array('status'=>1))->result_array();
        $resultEquipments = $this->db->get_where('equipments', array('status'=>1))->result_array();
        $resultTags = $this->db->select("equipment_tags.*, equipments.name as equipment_name, plants.name as plant_name")
                                ->from("equipment_tags")
                                ->join("equipments", "equipments.id = equipment_tags.equipment_id", "LEFT")
                                ->join("plants", "plants.id = equipment_tags.plant_id", "LEFT")
                                ->get()
                                ->result_array();

        if(!empty($resultTags)){
            foreach($resultTags as &$tags){
                $tags['qr'] = $qrUrl.'/'.$tags['qr'];
            }
        }
        $res['departments'] = $resultDepartment;
        $res['plants'] = $resultPlants;
        $res['equipments'] = $resultEquipments;
        $res['equipment_tags'] = $resultTags;
        $this->response([
            'status' => TRUE,
            'message' => 'Data found.',
            'data' => $res
        ], REST_Controller::HTTP_OK);
    }
}