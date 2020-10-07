<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobile_api extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model("login_model");
    $this->load->model("client_model");
    $this->load->model("api_model");
    // $this->load->library('session');

  }

  public function index(){

  }

  public function login(){

    if($_POST){

      $this->load->helper('string');
      $error_msg = '';

      $email = $_POST['email'];
      $pass  = $_POST['password'];

      $result = $this->login_model->get_user($email);
      $status = $result['status'];

      if($status){
          $hash_in_database = $result['hash'];
          $auth = password_verify($pass , $hash_in_database);

          if($auth){


            $user_id = $result['user_id'];
            $token =  random_string('alnum', 32);
            $email = $_POST['email'];

            $data = array(
              'token' => $token ,
              'email' => $email,
              'user_id' => $user_id
            );
            $result = $this->api_model->add_token($data);

            $user = new stdClass();
            $user->email = $email ;
            $user->user_id = $user_id;

            $jsonObj = new stdClass();
            $jsonObj->success = true;
            $jsonObj->token = $token;
            $jsonObj->user =$user;


            $json = json_encode($jsonObj);

            echo $json;

            // echo $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            die;

          }else{

            $jsonObj = new stdClass();
            $jsonObj->success = false;
            $jsonObj->server_msg = 'رقم الهاتف, الايميل أو كلمة المرور خطأ';

            $json = json_encode($jsonObj);

            echo $json;

            // echo $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
          }

      }else{

        $jsonObj = new stdClass();
        $jsonObj->success = false;
        $jsonObj->server_msg = 'رقم الهاتف او البريد الالكتروني لا يوجد في سجلاتنا, الرجاء الاشتراك في الموقع';

        $json = json_encode($jsonObj);

        echo $json;



      }

    }else{
      //echo $_POST;
      //echo $_SERVER['REQUEST_METHOD'];
      //var_dump($_POST);

      //echo $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      //echo '\r\n';
      //echo $content = trim(file_get_contents("php://input"));

    }

  }

  public function register(){

    $msg = '';
    $result;
    $result['error']='';

    if($_POST){

      $status = false;

      // roll = 2 mean it's user not admin
      $data = array(
        'name' => $_POST['name'],
        'type' => $_POST['type'],// this for client type if he indevidual or company
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'password' => $this->hash_password($_POST['password']),
        'roll' => 2// this is client not admin
      );

      $result = $this->login_model->add_user($data);
      $status = $result['status'];

      if($status){
        $jsonObj = new stdClass();
        $jsonObj->success = $status;
        $jsonObj->server_msg = 'تم التسجيل' ;
        $json = json_encode($jsonObj);
        echo $json;
      }else{
        $jsonObj = new stdClass();
        $jsonObj->success = $status;
        $jsonObj->server_msg = $result['error'];
        $json = json_encode($jsonObj);
        echo $json;
      }


    }

  }

  public function get_real_eatate_type(){
      $real_eatate_types = $this->api_model->get_real_eatate_type();

      $jsonObj = new stdClass();
      //$array = array(0 => 'اختر المنطقة');

      $id = 0;
      $jsonObj->$id = 'اختر النوع';

      foreach ($real_eatate_types as $key => $value) {
          $id = $value->id;
          $jsonObj->$id = $value->name;
      }
      //$jsonObj->provinces = $array;

      $json = json_encode($jsonObj , JSON_FORCE_OBJECT);
      echo $json;
  }

  public function get_real_eatate_type_for_filters(){
      $real_eatate_types = $this->api_model->get_real_eatate_type();

      $jsonObj = new stdClass();
      //$array = array(0 => 'اختر المنطقة');

      $id = 0;
      $jsonObj->$id = 'الكل';

      foreach ($real_eatate_types as $key => $value) {
          $id = $value->id;
          $jsonObj->$id = $value->name;
      }
      //$jsonObj->provinces = $array;

      $json = json_encode($jsonObj , JSON_FORCE_OBJECT);
      echo $json;
  }

  public function get_provinces(){
      $sa_provinces = $this->client_model->get_provinces();

      $jsonObj = new stdClass();
      //$array = array(0 => 'اختر المنطقة');

      $id = 0;
      $jsonObj->$id = 'اختر المنطقة';

      foreach ($sa_provinces as $key => $value) {
          $id = $value->id;
          $jsonObj->$id = $value->nameAr;
      }
      //$jsonObj->provinces = $array;

      $json = json_encode($jsonObj , JSON_FORCE_OBJECT);
      echo $json;
  }

  public function get_citis(){
    //var_dump($_SERVER);
    if($_POST){
      $provinceid = $_POST['provinceid'];
      $sa_cities = $this->client_model->get_cities($provinceid);

      $jsonObj = new stdClass();

      $id = 0;
      $jsonObj->$id = 'اختر المدينة';

      foreach ($sa_cities as $key => $value) {
        $id = $value->id;
        $jsonObj->$id = $value->nameAr;
      }

      $json = json_encode($jsonObj , JSON_FORCE_OBJECT);
      echo $json;

    }else{
      echo '';
    }
  }

  public function get_neighborhoods(){
    //var_dump($_SERVER);
    if($_POST){
      $cityid = $_POST['cityid'];
      $sa_cities = $this->client_model->get_neighborhoods($cityid);
      $jsonObj = new stdClass();

      $id = 0;
      $jsonObj->$id = 'اختر الحي';

      $array = array( 'اختر الحي');

      foreach ($sa_cities as $key => $value) {
        //$id = $value->id;
        //$jsonObj->$id = $value->nameAr;
        array_push($array , $value->nameAr);
      }

      $json = json_encode($array );
      echo $json;

    }else{
      echo '';
    }
  }

  public function add_entity(){
    //echo 'ok';
    //$i=0;
    $error_msg = "";

    if($_POST){

      $added_successfuly = true;

      $title        = $_POST['title'];
      $price        = $_POST['price'];
      $space        = $_POST['space'];
      $description  = $_POST['description'];
      $type         = $_POST['type'];
      $ad_type      = $_POST['ad_type'];
      $lat          = $_POST['lat'];
      $lng          = $_POST['lng'];
      $phone        = $_POST['phone'];
      $email        = $_POST['email'];
      $country      = $_POST['country'];
      $city         = $_POST['city'];
      $province     = $_POST['province'];
      $neighborhood = $_POST['neighborhood'];
      $add_by       = $_POST['add_by'];

      // add data to database
      $data = array(
        'title' => $title,
        'price' => $price,
        'space' => $space,
        'description' => $description,
        'type' => $type,
        'ad_type' => $ad_type,
        'lat' => $lat,
        'lng' => $lng,
        'country' => $country,
        'province' => $province,
        'city' => $city,
        'neighborhood' => $neighborhood,
        'add_by' => $add_by,
      );
      $result = $this->api_model->add_entity_estate($data);

      if($result){
        // then we upload images and video
        $this->load->library('upload');

        // here the last insert id for row in database
        $real_estate_id = $this->db->insert_id();

        if(isset($_FILES['images'])){

          // Count total files
          $countfiles = count($_FILES['images']['name']);
          //echo "files $countfiles ";

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
              $_FILES['image']['name']      = $_FILES['images']['name'][$i];
              $_FILES['image']['type']      = $_FILES['images']['type'][$i];
              $_FILES['image']['tmp_name']  = $_FILES['images']['tmp_name'][$i];
              $_FILES['image']['error']     = $_FILES['images']['error'][$i];
              $_FILES['image']['size']      = $_FILES['images']['size'][$i];


              $config['upload_path']          = './uploads';
              $config['allowed_types']        = 'png|jpg|jpeg';
              $config['max_size']             = 10000;
              $config['file_name']            = $new_full_file_name;

              //$this->load->library('upload', $config);
              $this->upload->initialize($config);// here reset the upload settings

              if ( ! $this->upload->do_upload('image')) {

                  $error = array('error' => $this->upload->display_errors());
                  //echo ' '.$error_msg = $error['error'];
                  //echo " type :  ".$_FILES['image']['type']." ";

              }else{

                  $data = array('upload_data' => $this->upload->data());

                  //print_r($data);
                  //echo " type :  ".$_FILES['image']['type']." ";

                  $file_data = array(
                    'for_real_estate' => $real_estate_id,
                    'from_user' => 1,
                    'media_path' => $data['upload_data']['file_name'],
                    'type' => 1
                  );

                  // add file to database
                  $file_result = $this->api_model->add_file_data($file_data);

                  if($file_result){
                    $error_msg = 'تمت الاضافة بنجاح';
                  }else{
                    $added_successfuly = false;
                    $error_msg = "error in photo";
                  }

              }


            }

          }// end of for loop upload images

        }

        if(isset($_FILES['video'])){
          // upload video if there any one
          if($_FILES['video']['error'] == 0){

            $new_name = time().'_'.uniqid(rand());// new name for the file
            $file_ext = pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);
            $new_full_file_name = $new_name.'.'.$file_ext;

            $config['upload_path']          = './uploads';
            $config['allowed_types']        = 'mp4|m4a|f4v';
            $config['max_size']             = 60000;
            $config['file_name']            = $new_full_file_name;

            $this->upload->initialize($config , TRUE);// here reset the upload settings

            //var_dump($this->upload);

            if ( ! $this->upload->do_upload('video')) {

                $error = array('error' => $this->upload->display_errors());
                $error_msg = $error['error'];

            } else {

                $data = array('upload_data' => $this->upload->data());
                $file_data = array(
                  'for_real_estate' => $real_estate_id,
                  'from_user' => 1,
                  'media_path' => $data['upload_data']['file_name'],
                  'type' => 2
                );
                $file_result = $this->api_model->add_file_data($file_data);
                if($file_result){
                  $error_msg = 'تمت الاضافة بنجاح';
                }else{
                  $added_successfuly = false;
                  $error_msg = "error in video";
                }
            }

          }// end of upload video
        }

        //echo 'ok you addedd the data';

      }else{
        $added_successfuly = false;
      }

      $json = new stdClass();
      if($added_successfuly){
        $json->success = true;
        $json->error_msg = $error_msg;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }else{
        $json->success = false;
        $json->error_msg = $error_msg;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }

    } else {

      $error_msg = "حدث خطأ فادح, الرجاء المحاولة لاحقاً";
      $json = new stdClass();
      $json->success = false;
      $json->error_msg = $error_msg;
      $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
      echo $json_to_client;
    }

  }

  public function edit_entity(){
    if($_POST){

      $added_successfuly = true;

      $entity_id    = $_POST['entity_id'];

      $title        = $_POST['title'];
      $price        = $_POST['price'];
      $space        = $_POST['space'];
      $description  = $_POST['description'];
      $type         = $_POST['type'];
      $ad_type      = $_POST['ad_type'];
      $lat          = $_POST['lat'];
      $lng          = $_POST['lng'];
      $phone        = $_POST['phone'];
      $email        = $_POST['email'];
      $country      = $_POST['country'];
      $city         = $_POST['city'];
      $province     = $_POST['province'];
      $neighborhood = $_POST['neighborhood'];

      // add data to database
      $data = array(
        'title' => $title,
        'price' => $price,
        'space' => $space,
        'description' => $description,
        'type' => $type,
        'ad_type' => $ad_type,
        'lat' => $lat,
        'lng' => $lng,
        'country' => $country,
        'province' => $province,
        'city' => $city,
        'neighborhood' => $neighborhood,
      );

      $result = $this->api_model->edit_entity($entity_id , $data);

      if($result){
        $json           = new stdClass();
        $json->success  = true;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }else{
        $json           = new stdClass();
        $json->success  = false;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }

    }
  }

  public function delete_enetity(){

    if($_POST){

      $entity_id = $_POST['entity_id'];
      $result = $this->api_model->delete_enetity($entity_id);

      if($result){
        $json           = new stdClass();
        $json->success  = true;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }else{
        $json           = new stdClass();
        $json->success  = false;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }

    }

  }

  public function entity_soldout(){
    if($_POST){

      $entity_id = $_POST['entity_id'];
      $result = $this->api_model->enetity_soldout($entity_id);

      if($result){
        $json           = new stdClass();
        $json->success  = true;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }else{
        $json           = new stdClass();
        $json->success  = false;
        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }

    }
  }

  public function get_my_data(){

    if($_POST){

      $token = $_POST['token']; //'B5kEmGFc6OJ7eXTCZiQp20j3SWLRAh1Y';
      $user_id = $_POST['user_id'] ;//'1';
      $result = $this->api_model->get_my_data($user_id , $token );

      if($result['success']){
        $json         = new stdClass();
        $json->success = true;
        $json->name   = $result['result'][0]->name;
        $json->phone  = $result['result'][0]->phone;
        $json->email  = $result['result'][0]->email;

        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
        // var_dump($json_to_client);
      }else{
        $json         = new stdClass();
        $json->success = false;

        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }
    }


  }

  public function edit_my_info(){

    if($_POST){

      $user_id  = $_POST['user_id'] ;
      $name     = $_POST['name'] ;
      $phone    = $_POST['phone'] ;
      $email    = $_POST['email'] ;

      $data = array(
        'name' => $name,
        'phone' => $phone,
        'email' => $email
      );

      $result = $this->api_model->edit_my_info($data , $user_id);

      $json          = new stdClass();
      $json->success = $result;
      $json->name   = $name;
      $json->phone  = $phone;
      $json->email  = $email;

      $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
      echo $json_to_client;

      //var_dump($result);

    }

  }

  public function get_my_entities(){

    if($_POST){
      $user_id  = $_POST['user_id'] ;
      $result = $this->api_model->get_my_entities($user_id)->result();

      //$result[0]->photo = 'i am here';
      //var_dump($result);

      $json = new stdClass();
      $json->success = true;
      $json->my_name =  @$this->api_model->get_user_data($user_id)->result()[0]->name;

      foreach ($result as $key => $value) {
        // code...
        $photo = @$this->api_model->get_photo( $value->id)->result()[0]->media_path;
        $value->photo = $photo;// add photo object to this ...

        $old_date_timestamp = strtotime($value->add_time);
        $new_date = date('Y-m-d', $old_date_timestamp);
        $value->add_time = $new_date;

      }

      $json->entities = $result;
      //var_dump($result);

      $json_to_client = json_encode($json );
      echo $json_to_client;
      // var_dump($result);
    }
  }

  public function get_all_entites($page){

    $result = $this->api_model->get_entities($page)->result();

    $json = new stdClass();
    $json->success = true;

    foreach ($result as $key => $value) {
      // code...

      $photo_data = $this->api_model->get_photo( $value->id );
      if($photo_data->num_rows() == 1){
        $photo = $photo_data->result()[0]->media_path;
        $value->photo = $photo;// add photo object to this ...
      }else{
        //$value->photo = NULL;
        $value->photo = 'house.png';
      }

      $old_date_timestamp = strtotime($value->add_time);
      $new_date = date('Y-m-d', $old_date_timestamp);
      $value->add_time = $new_date;

    }


    $json->entities = $result;


    $json_to_client = json_encode($json );
    echo $json_to_client;

  }

  public function filter_entity_by_type($page){

    if($_POST){
      $type = $_POST['type'];

      $result = $this->api_model->filter_by_select($page , $type)->result();

      $json = new stdClass();
      $json->success = true;

      foreach ($result as $key => $value) {
        // code...

        $photo_data = $this->api_model->get_photo( $value->id );
        if($photo_data->num_rows() == 1){
          $photo = $photo_data->result()[0]->media_path;
          $value->photo = $photo;// add photo object to this ...
        }else{
          //$value->photo = NULL;
          $value->photo = 'house.png';
        }

        $old_date_timestamp = strtotime($value->add_time);
        $new_date = date('Y-m-d', $old_date_timestamp);
        $value->add_time = $new_date;

      }


      $json->entities = $result;


      $json_to_client = json_encode($json );
      echo $json_to_client;

    }

  }

  public function search($page){

    if($_POST){

      $keyword = $_POST['keyword'];

      $result = $this->api_model->search($page , $keyword)->result();

      $json = new stdClass();
      $json->success = true;
      $json->keyword = $keyword;
      
      foreach ($result as $key => $value) {
        // code...

        $photo_data = $this->api_model->get_photo( $value->id );
        if($photo_data->num_rows() == 1){
          $photo = $photo_data->result()[0]->media_path;
          $value->photo = $photo;// add photo object to this ...
        }else{
          //$value->photo = NULL;
          $value->photo = 'house.png';
        }

        $old_date_timestamp = strtotime($value->add_time);
        $new_date = date('Y-m-d', $old_date_timestamp);
        $value->add_time = $new_date;

      }


      $json->entities = $result;


      $json_to_client = json_encode($json );
      echo $json_to_client;

    }
  }

  public function get_entity($id){

    $base_url = base_url();
    $json = new stdClass();
    $photo_array = array();
    $result = $this->api_model->get_one_entity($id);

    if($result->num_rows() == 1){

      $photo_result = $this->api_model->get_photos_for_entity($id)->result();
      foreach ($photo_result as $key => $value) {
        array_push($photo_array, $base_url.'uploads/'.$value->media_path );
      }

      $entity_data  = $result->result()[0];

      $user_data = $this->api_model->get_user_data($entity_data->add_by);
      $user_name = $user_data->result()[0]->name;
      $type = @$this->api_model->get_type_name($entity_data->type)->result()[0]->name;

      $video_url    = null;
      $video_query = $this->api_model->get_video($id);

      if($video_query->num_rows() == 1){
        $video_url = $base_url.'uploads/'.$video_query->result()[0]->media_path;
      }

      $json->success      = true;
      $json->id           = $entity_data->id;
      $json->title        = $entity_data->title;
      $json->type         = $type;
      $json->type_id      = $entity_data->type;
      $json->ad_type      = $entity_data->ad_type;
      $json->price        = $entity_data->price;
      $json->space        = $entity_data->space;
      $json->country      = $entity_data->country;
      $json->province     = $entity_data->province;
      $json->city         = $entity_data->city;
      $json->neighborhood = $entity_data->neighborhood;
      $json->description  = $entity_data->description;
      $json->lat          = $entity_data->lat;
      $json->lng          = $entity_data->lng;
      $json->phone        = $entity_data->phone;
      $json->email        = $entity_data->email;
      $json->add_time     = $entity_data->add_time;
      $json->add_by       = $entity_data->add_by;
      $json->adviserName  = $user_name;

      $old_date_timestamp = strtotime($json->add_time);
      $new_date = date('Y-m-d', $old_date_timestamp);
      $json->add_time = $new_date;

      $json->photos = $photo_array;
      $json->video  = $video_url;
      $json_to_client = json_encode($json );
      echo $json_to_client;

    }else{

      $json->success = true;
      $json->photos = $photo_array;
      $json_to_client = json_encode($json );
      echo $json_to_client;

    }

  }

  public function list_my_chat($user_id){

    $json = new stdClass();

    $query = "
        SELECT a.*
        FROM  messages a
        INNER JOIN (
          SELECT MAX( `id` ) AS id
          FROM  `messages` AS  `alt`
          WHERE  `alt`.`to_user` = $user_id
          OR  `alt`.`from_user` = $user_id
          GROUP BY  least(`to_user` ,  `from_user`), greatest(`to_user` ,  `from_user`)
        )b ON a.id = b.id
    ";
    $result = $this->db->query($query);

    if($result->num_rows() > 0 )
      $json->success = true;
    else
      $json->success = false;

    $chat_array = array();

    foreach ($result->result() as $key => $value) {
      // code...

      $object             = new stdClass();
      $object->id         = $value->id;
      $object->time       = $value->time;
      $object->from_user  = $value->from_user;
      $object->to_user    = $value->to_user;
      $object->body       = $value->body;
      $object->from_user_name = @$this->api_model->get_user_data($value->from_user)->result()[0]->name;
      $object->to_user_name   = @$this->api_model->get_user_data($value->to_user)->result()[0]->name;

      if($value->from_user == $user_id){
        $object->my_name = $object->from_user_name;
      }else{
        $object->my_name = $object->to_user_name;
      }

      if($value->to_user != $user_id){
        $object->other_participate_name = $object->to_user_name;
        $object->other_participate_id   = $value->to_user;
      }else{
        $object->other_participate_name = $object->from_user_name;
        $object->other_participate_id   = $value->from_user;
      }

      array_push($chat_array , $object);

      //$id = $value->id;
      //$json->$id = $object;

    }

    $json->chat_list = $chat_array;

    $json_to_client = json_encode($json);
    echo $json_to_client;
    //var_dump($json);

  }

  public function get_messages($from_user_id , $to_user_id){

    $result = $this->api_model->get_messages($from_user_id , $to_user_id)->result();
    $json = new stdClass();
    $messages_array = array();

    foreach ($result as $key => $value) {
      $msg_obj = new stdClass();
      $msg_obj->key            = $value->id;
      $msg_obj->from_user_name = @$this->api_model->get_user_data($value->from_user)->result()[0]->name;
      $msg_obj->to_user_name   = @$this->api_model->get_user_data($value->to_user)->result()[0]->name;
      $msg_obj->username       = $msg_obj->from_user_name;
      if($value->from_user == $from_user_id){
        $msg_obj->isCurrentUser = true;
      }else{
        $msg_obj->isCurrentUser = false;
      }
      $msg_obj->msg = $value->body;

      array_push($messages_array , $msg_obj);
    }

    $json->success  = true;
    $json->messages = $messages_array;
    $json_to_client = json_encode($json);
    echo $json_to_client;

  }

  public function add_message(){
    if($_POST){

      $from_user  = $_POST['from_user'];
      $to_user    = $_POST['to_user'];
      $body       = $_POST['body'];

      $data = array(
        'from_user' => $from_user,
        'to_user' => $to_user,
        'body' => $body
      );

      $this->api_model->add_message($data);
      $insert_id = $this->db->insert_id();

      $json = new stdClass();
      $json->success  = true;

      $msg_obj                  = new stdClass();
      $msg_obj->key             = $insert_id;
      $msg_obj->from_user_name  = @$this->api_model->get_user_data($from_user)->result()[0]->name;
      $msg_obj->to_user_name    = @$this->api_model->get_user_data($to_user)->result()[0]->name;
      $msg_obj->username        = $msg_obj->from_user_name;
      $msg_obj->isCurrentUser   = true;
      $msg_obj->msg             = $body;

      $json->messages = $msg_obj;

      $json_to_client = json_encode($json);
      echo $json_to_client;

    }
  }

  public function edit_password(){

    if($_POST){

      $user_id  = $_POST['user_id'] ;
      $old_pass = $_POST['old_pass'];
      $new_pass = $_POST['new_pass'];

      $user_data = $this->api_model->get_user_data($user_id)->result()[0];

      $hash_in_database = $user_data->password;
      $auth = password_verify($old_pass , $hash_in_database);

      if($auth){

        $data = array(
          'password' => $this->hash_password($new_pass) ,
        );

        $result = $this->api_model->edit_my_info($data , $user_id);

        $json          = new stdClass();
        $json->success = $result;

        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;

      }else{
        $json          = new stdClass();
        $json->success = false;

        $json_to_client = json_encode($json , JSON_FORCE_OBJECT);
        echo $json_to_client;
      }

    }

  }



  // this is aid function
  private function hash_password($password){
     return password_hash($password, PASSWORD_BCRYPT);
  }


}
?>
