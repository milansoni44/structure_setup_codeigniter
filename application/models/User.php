<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        
        $this->userTbl = 'users';
    }

    /*
     * Get rows from the users table
     */
    function getRows($params = array()){
        // echo "<pre>"; print_r($params);die;
        $resultUser = $this->db->select("users.id AS `user_id`, users.first_name, users.last_name, users.username, users.email, users.phone, user_types.id AS `role_id`, user_types.name AS `role`")
                 ->from("users")
                 ->join("user_roles", "user_roles.user_id = users.id", "LEFT")
                 ->join("user_types", "user_types.id = user_roles.user_type_id", "LEFT")
                 ->where("users.status", 1)
                 ->where("(users.email = '{$params['conditions']['email']}' OR users.username = '{$params['conditions']['email']}')")
                 ->where("users.password", $params['conditions']['password'])
                 ->get()
                 ->row_array();

        if(!empty($resultUser)){
            $resultDepartment = $this->db->query("SELECT 
                                                `user_departments`.`department_id`, 
                                                `departments`.`name` AS `department_name`
                                            FROM `user_departments`
                                            LEFT JOIN `users` ON `users`.`id` = `user_departments`.`user_id`
                                            LEFT JOIN `departments` ON `departments`.`id` = `user_departments`.`department_id`
                                            WHERE `user_departments`.`user_id` = {$resultUser['user_id']}
                                            ")->result_array();

            $resultUser['departments'] = $resultDepartment;
        }

        return $resultUser;
    }
    
    /*
     * Insert user data
     */
    public function insert($data){
        //add created and modified date if not exists
        if(!array_key_exists("created", $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("modified", $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }
        
        //insert user data to users table
        $insert = $this->db->insert($this->userTbl, $data);
        
        //return the status
        return $insert?$this->db->insert_id():false;
    }
    
    /*
     * Update user data
     */
    public function update($data, $id){
        //add modified date if not exists
        if(!array_key_exists('modified', $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }
        
        //update user data in users table
        $update = $this->db->update($this->userTbl, $data, array('id'=>$id));
        
        //return the status
        return $update?true:false;
    }
    
    /*
     * Delete user data
     */
    public function delete($id){
        //update user from users table
        $delete = $this->db->delete('users',array('id'=>$id));
        //return the status
        return $delete?true:false;
    }

}