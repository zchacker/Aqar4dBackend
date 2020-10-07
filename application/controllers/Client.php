<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model("login_model");
    $this->load->model("client_model");
    // $this->load->library('session');
    $this->check_login();// to protect this class from non logged in users
  }

  public function index(){
      $this->entities();
  }

  // this to show all entitis that belong for user
  public function entities(){
    $my_id = $_SESSION['logged_in']['user_id'];
    $data['entities'] = $this->client_model->get_my_entities($my_id)->result();
    $this->load->view('tmp/header');
    $this->load->view('client/show_entities' , $data);
    $this->load->view('tmp/footer');

  }

  public function add_entity(){
    $error_msg = '';

    if($_POST){

      //var_dump($_FILES);
      //var_dump($_POST);
      //die;

      $title         = $_POST['title'];
      $price        = $_POST['price'];
      $description  = $_POST['description'];
      $type         = $_POST['type'];
      $lat          = $_POST['lat'];
      $lng          = $_POST['lng'];
      // $phone        = $_POST['phone'];
      $country      = $_POST['country'];
      $city         = $_POST['city'];
      $province     = $_POST['province'];
      $neighborhood = $_POST['neighborhood'];

      // add data to database
      $data = array(
        'title' => $title,
        'price' => $price,
        'description' => $description,
        'type' => $type,
        'lat' => $lat,
        'lng' => $lng,
        'country' => $country,
        'province' => $province,
        'city' => $city,
        'neighborhood' => $neighborhood,
        'add_by' => 1
      );
      $result = $this->client_model->add_entity_estate($data);

      // if the data was added corrently then go and upload files
      if($result){

        // here the last insert id for row in database
        $real_estate_id = $this->db->insert_id();

        // Count total files
        $countfiles = count($_FILES['images']['name']);

        // upload up to 29 photos
        if($countfiles > 29){
          $countfiles = 29;
        }

        // upload every file in database
        for($i = 0 ; $i < $countfiles ; $i++){

          if(!empty($_FILES['images']['name'][$i])){

            $new_name = time().'_'.uniqid(rand());// new name for the file
            $file_ext = pathinfo($_FILES["images"]["name"][$i], PATHINFO_EXTENSION);
            $new_full_file_name = $new_name.'.'.$file_ext;

            // Define new $_FILES array - $_FILES['file']
            $_FILES['image']['name'] = $_FILES['images']['name'][$i];
            $_FILES['image']['type'] = $_FILES['images']['type'][$i];
            $_FILES['image']['tmp_name'] = $_FILES['images']['tmp_name'][$i];
            $_FILES['image']['error'] = $_FILES['images']['error'][$i];
            $_FILES['image']['size'] = $_FILES['images']['size'][$i];

            $config['upload_path']          = './uploads';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 5000;
            $config['file_name']            = $new_full_file_name;
            $this->load->library('upload', $config);

            //var_dump($this->upload);

            if ( ! $this->upload->do_upload('image')) {
                $error = array('error' => $this->upload->display_errors());
                $error_msg = $error['error'];
            }else{
                $data = array('upload_data' => $this->upload->data());

                $file_data = array(
                  'for_real_estate' => $real_estate_id,
                  'from_user' => 1,
                  'media_path' => $data['upload_data']['file_name'],
                  'type' => 1
                );
                $file_result = $this->client_model->add_file_data($file_data);
                if($file_result){
                  $error_msg = '<p>تمت الاضافة بنجاح</p>';
                }
            }

          }

          //redirect(base_url().'home/add_entity');

        }// end of for loop

        // upload video if there any one
        if($_FILES['video']['error'] == 0){

          $new_name = time().'_'.uniqid(rand());// new name for the file
          $file_ext = pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);
          $new_full_file_name = $new_name.'.'.$file_ext;

          $config['upload_path']          = './uploads';
          $config['allowed_types']        = 'mp4|m4a|f4v';
          $config['max_size']             = 35000;
          $config['file_name']            = $new_full_file_name;

          $this->upload->initialize($config , TRUE);// here reset the upload settings

          //var_dump($this->upload);

          if ( ! $this->upload->do_upload('video')) {
              $error = array('error' => $this->upload->display_errors());
              $error_msg = $error['error'];
          }else{
              $data = array('upload_data' => $this->upload->data());
              $file_data = array(
                'for_real_estate' => $real_estate_id,
                'from_user' => 1,
                'media_path' => $data['upload_data']['file_name'],
                'type' => 2
              );
              $file_result = $this->client_model->add_file_data($file_data);
              if($file_result){
                $error_msg = '<p>تمت الاضافة بنجاح</p>';
              }
          }

        }// end of upload video

      }// end of add media data

    }// end of post data

    $data['error_msg'] = $error_msg;
    $this->load->view("tmp/header" , $data);
    $this->load->view("client/add_entity");
    $this->load->view("tmp/footer");

  }

  public function edit_entity($id){
    $error_msg = '';

    if($_POST){


      $title         = $_POST['title'];
      $price        = $_POST['price'];
      $description  = $_POST['description'];
      $type         = $_POST['type'];
      $lat          = $_POST['lat'];
      $lng          = $_POST['lng'];
      $phone        = $_POST['phone'];
      $email        = $_POST['email'];

      // add data to database
      $data = array(
        'title' => $title,
        'price' => $price,
        'description' => $description,
        'type' => $type,
        'lat' => $lat,
        'lng' => $lng,
        'phone' => $phone,
        'email' => $email,
        'add_by' => 1
      );

      $result = $this->client_model->edit_entity_estate($data , $id);
      if($result){
        $error_msg = '<div class="alert alert-success" role="alert">تم حفظ البيانات بنجاح</div>';
      }else{
        $error_msg = '<div class="alert alert-danger" role="alert">لم يتم الحفظ</div>';
      }

    }

    $real_estate = $this->client_model->get_real_estate_data($id);


    if($real_estate->num_rows() == 1){
      $data['error_msg'] = $error_msg;
      $data['real_estate'] = $real_estate->result()[0];
      $this->load->view("tmp/header" , $data);
      $this->load->view("client/edit_entity");
      $this->load->view("tmp/footer");
    }else{
      echo '<p>الرابط غير صحيح</p>';
    }

  }

  public function delete_enetity($id){

    // تحديد فقط المستخدم يحذف عقاراته فقط
    $this->client_model->delete_enetity($id);

  }

  public function messages(){
    $this->load->view('tmp/header');
    $this->load->view('client/messages');
    $this->load->view('tmp/footer');
  }

  public function edit_profile(){
    $user_id = $_SESSION['logged_in']['user_id'];
    if($_POST){
      $data = array(
        'name' => $_POST['name'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email']
      );
      $this->client_model->edit_my_info($user_id , $data);
    }
    $data['my_info'] = $this->client_model->get_my_info($user_id)[0];

    $this->load->view('tmp/header');
    $this->load->view('client/edit_profile' , $data);
    $this->load->view('tmp/footer');
  }

  public function edit_pass(){
    $data['error_msg'] = '';
    $user_id = $_SESSION['logged_in']['user_id'];
    if($_POST){

      $pass       = $_POST['pass'];
      $new_pass   = $_POST['new-pass'];
      $new_pass2  = $_POST['new-pass2'];

      $email_phone = $_SESSION['logged_in']['email'];
      $email  = $_SESSION['logged_in']['user_id'];
      $pass   = $_SESSION['logged_in']['pass'];
      $result = $this->login_model->get_user($email_phone);
      $status = $result['status'];
      

      if(strcmp($new_pass , $new_pass2) == 0){

      }

      $this->client_model->edit_my_info($user_id , $data);
    }
    $data['my_info'] = $this->client_model->get_my_info($user_id)[0];

    $this->load->view('tmp/header');
    $this->load->view('client/edit_pass' , $data);
    $this->load->view('tmp/footer');
  }

  private function check_login(){

    if(!$this->session->userdata('logged_in')){
      redirect('auth/login');
      die;
    }else{

      $email_phone = $_SESSION['logged_in']['email'];
      $email  = $_SESSION['logged_in']['user_id'];
      $pass   = $_SESSION['logged_in']['pass'];
      $result = $this->login_model->get_user($email_phone);
      $status = $result['status'];

      if($status){

          $hash_in_database = $result['hash'];
          $auth = password_verify($pass , $hash_in_database);

          if(!$auth){
            redirect('auth/login');
            die;
          }

      }else{
        redirect('auth/login');
        die;
      }

    }

  }

}

?>
