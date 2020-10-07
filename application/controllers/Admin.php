<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{

  //this page is not require a login to show it

  public function __construct(){
    parent::__construct();
    $this->load->model("login_model");
    $this->load->model("admin_model");
    // $this->load->library('session');
    //$this->check_login();// to protect this class from non logged in users
    if( $this->uri->segment(2) != 'login')
      $this->check_login();// to protect this class from non logged in users
  }

  public function index(){
    $data['count_entities'] = $this->admin_model->count_entities()->result()[0]->total;
    $data['count_users'] = $this->admin_model->count_users()->result()[0]->total;
    $data['count_entities'] = $this->admin_model->count_entities()->result()[0]->total;

    $this->load->view("admin/tmp/header" , $data);
    $this->load->view("admin/index");
    $this->load->view("admin/tmp/footer");
  }

  public function real_estate(){

    $result = $this->admin_model->get_entities()->result();
    $data['entities'] = $result;

    $this->load->view("admin/tmp/header" , $data);
    $this->load->view("admin/real_estate");
    $this->load->view("admin/tmp/footer");

  }

  public function real_estate_archive(){
    $result = $this->admin_model->get_archive_entities()->result();
    $data['entities'] = $result;

    $this->load->view("admin/tmp/header" , $data);
    $this->load->view("admin/real_estate");
    $this->load->view("admin/tmp/footer");
  }

  public function members(){

    $result = $this->admin_model->get_members()->result();
    $data['members'] = $result;

    $this->load->view("admin/tmp/header" , $data);
    $this->load->view("admin/users");
    $this->load->view("admin/tmp/footer");
  }

  public function messages(){
    $this->load->view("admin/tmp/header");
    $this->load->view("admin/index");
    $this->load->view("admin/tmp/footer");
  }

  public function sales(){
    $data['count_entities'] = $this->admin_model->count_entities()->result()[0]->total;
    $data['count_users'] = $this->admin_model->count_users()->result()[0]->total;
    $data['count_entities'] = $this->admin_model->count_entities()->result()[0]->total;

    $this->load->view("admin/tmp/header" , $data);
    $this->load->view("admin/index");
    $this->load->view("admin/tmp/footer");
  }

  public function admins(){

    $data['count_entities'] = $this->admin_model->count_entities()->result()[0]->total;
    $data['count_users'] = $this->admin_model->count_users()->result()[0]->total;
    $data['count_entities'] = $this->admin_model->count_entities()->result()[0]->total;

    $this->load->view("admin/tmp/header");
    $this->load->view("admin/index");
    $this->load->view("admin/tmp/footer");
  }

  public function settings(){
    $this->load->view("admin/tmp/header");
    $this->load->view("admin/site_settings");
    $this->load->view("admin/tmp/footer");
  }

  public function delete_user($id){
    $this->admin_model->delete_members($id);
  }

  public function archive_enetity($id){
    $this->admin_model->archive($id);
  }

  public function unarchive_enetity($id){
    $this->admin_model->unarchive($id);
  }

  public function login(){
    $msg = '';

    if($_POST){

      $error_msg = '';

      $email_phone  = $_POST['email'];
      $pass         = $_POST['pass'];

      $result = $this->login_model->get_user($email_phone);
      $status = $result['status'];

      if($status && ($result['user_roll'] == 1)){
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
            redirect('admin');
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
    $this->load->view("admin/login" , $data);

  }

  public function logout(){
    $this->session->sess_destroy();
    redirect('admin');
  }



  private function check_login(){

    if(!$this->session->userdata('logged_in')){
      redirect('admin/login');
      die;
    }else{

      $email_phone  = $_SESSION['logged_in']['email'];
      $user_id      = $_SESSION['logged_in']['user_id'];
      $pass         = $_SESSION['logged_in']['pass'];

      $result = $this->login_model->get_user($email_phone);
      $status = $result['status'];

      if($status){

          $hash_in_database = $result['hash'];
          $auth = password_verify($pass , $hash_in_database);

          if(!$auth){
            redirect('admin/login');
            die;
          }

      }else{
        redirect('admin/login');
        die;
      }

    }

  }



}

?>
