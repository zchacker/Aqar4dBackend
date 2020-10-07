<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model("login_model");
    $this->load->model("client_model");
  }

  public function index(){

  }

  public function register(){
    $msg = '';
    $result;
    $result['error']='';

    if($_POST){

      $status = false;

      if(strcmp($_POST['pass1'] , $_POST['pass2']) == 0){

        // roll = 2 mean it's user not admin
        $data = array(
          'name' => $_POST['name'],
          'phone' => $_POST['phone'],
          'email' => $_POST['email'],
          'password' => $this->hash_password($_POST['pass1']),
          'roll' => 2// this is client not admin
        );

        $result = $this->login_model->add_user($data);
        $status = $result['status'];

      }else{
        $result['error'] = 'كلمة المرور غير متطابقة';
      }


      $registred = false;

      if($status){

        $msg = '<div class="alert alert-success" role="alert">تم التسجيل</div>';
        $registred = true;

        $user_id = $result['user_id'];
        $sess_data = array(
        'user_id' => $user_id,
        'email' => $_POST['email'],
        'pass' => $_POST['pass1']
        );
        $this->session->set_userdata('logged_in', $sess_data);

      }else{
        $server_msg = $result['error'];
        //$msg = '<div class="alert alert-danger" role="alert">الايميل الذي ادخلته موجود مسبقا</div>';
        $msg = '<div class="alert alert-danger" role="alert">'.$server_msg.'</div>';
        $registred = false;
      }

      if($registred){
        redirect('client');
        //redirect('auth/login');
      }

    }

    $data['msg'] = $msg;
    $this->load->view("tmp/header" );
    $this->load->view("client/register_view" , $data );
    $this->load->view("tmp/footer");

  }

  public function login(){

    $msg = '';

    if($_POST){

      $error_msg = '';

      $email_phone  = $_POST['email'];
      $pass         = $_POST['pass'];

      $result = $this->login_model->get_user($email_phone);
      $status = $result['status'];

      if($status){
          $hash_in_database = $result['hash'];
          $auth = password_verify($pass , $hash_in_database);

          if($auth){

            $user_id = $result['user_id'];
            $sess_data = array(
            'user_id' => $user_id,
            'email' => $email_phone,
            'pass' => $pass
            );
            $this->session->set_userdata('logged_in', $sess_data);
            redirect('client');
            die;

          }else{
            $error_msg = 'رقم الهاتف, الايميل أو كلمة المرور خطأ';
            $msg = '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
          }

      }else{
        $error_msg = 'رقم الهاتف او البريد الالكتروني لا يوجد في سجلاتنا, الرجاء الاشتراك في الموقع';
        $msg = '<div class="alert alert-danger" role="alert">'.$error_msg.'</div>';
      }

    }

    $data['msg'] = $msg;
    $this->load->view("tmp/header" );
    $this->load->view("client/login_view" , $data);
    $this->load->view("tmp/footer");

  }

  public function logout(){
    $this->session->sess_destroy();
    redirect('/');
  }

  private function hash_password($password){
     return password_hash($password, PASSWORD_BCRYPT);
  }

}

?>
