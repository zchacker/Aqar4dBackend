<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

  public function add_user($data){

    // check if the email was in database or not
    $this->db->where('email' , $data['email']);
    $result = $this->db->get('user');
    $rows = $result->num_rows();

    if($rows == 0){// rows is 0

      // check if the phone was in database or not
      $this->db->where('phone' , $data['phone']);
      $result = $this->db->get('user');
      $rows = $result->num_rows();

      if($rows == 0){
        $this->db->insert('user' , $data);
        $user_id = $this->db->insert_id();
        $response = array('user_id' => $user_id , 'status' => true);
        return $response;
      }else{
        $error_msg = 'رقم الهاتف الذي أدخلته موجود مسبقا';
        $response = array('error' => $error_msg , 'status' => false );
        return $response;
      }
    }else{
      $error_msg = 'البريد الالكتروني الذي أدخلته موجود مسبقا';
      $response = array('error' => $error_msg , 'status' => false );
      return $response;
    }

  }

  public function get_user($email_phone){
    $this->db->where('email' ,$email_phone);
    $query = $this->db->get('user');
    $rows = $query->num_rows();

    if($rows == 1){
      $pass = $query->result()[0]->password;
      $user_id  = $query->result()[0]->id;
      $user_roll  = $query->result()[0]->roll;// 1 mean admin
      $response = array('user_id' => $user_id , 'user_roll' => $user_roll , 'hash' => $pass , 'status' => true );
      return $response;
    }else{

      $this->db->where('phone' ,$email_phone);
      $query = $this->db->get('user');
      $rows = $query->num_rows();

      if($rows == 1){
        $pass     = $query->result()[0]->password;
        $user_id  = $query->result()[0]->id;
        $user_roll  = $query->result()[0]->roll;// 1 mean admin
        $response = array('user_id' => $user_id , 'user_roll' => $user_roll , 'hash' => $pass , 'status' => true );
        return $response;
      }else{
        $response = array('hash' => '' , 'status' => false );
        return $response;
      }
    }

  }

}

?>
