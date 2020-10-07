<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{

  //this page is not require a login to show it
  // this contoller to show all data for all users without requier to login

  public function __construct(){
    parent::__construct();
    $this->load->model("login_model");
    $this->load->model("client_model");

    // $this->load->library('session');
  }

  // this is main page of website
  public function index($page = 1){
    $data;

    if($_POST) {

        if(strcmp($_POST['search_btn'] , 'filter') == 0){

          $city       = '';
          $type       = '';
          $min_price  = 0;
          $max_price  = 0;

          $city       = $_POST['city'];
          $type       = $_POST['type'];

          if(strlen($_POST['min-price']) > 0)
            $min_price  = $_POST['min-price'];

          if(strlen($_POST['max-price']) > 0)
            $max_price  = $_POST['max-price'];

          $data['results'] = $this->client_model->filter_entites($city , $type , $min_price , $max_price);

        } else if(strcmp($_POST['search_btn'] , 'query') == 0) {

          $query  = $_POST['query'];
          $data['results'] = $this->client_model->search_query($query);

        }

        //var_dump($_POST);
        // $data['results'] = $this->client_model->get_entities()->result();

    } else {
        $data['results'] = $this->client_model->get_entities()->result();
    }

    $data['cities'] = $this->client_model->get_all_cities();
    $this->load->view("tmp/header" , $data);
    $this->load->view("index" , $data);
    $this->load->view("tmp/footer" , $data);


  }

  public function entities(){
    $this->load->view('tmp/header');
    $this->load->view('client/show_entities');
    $this->load->view('tmp/footer');
  }

  public function entity($id){

    $real_estate_data = $this->client_model->get_real_estate_data($id);
    $rows = $real_estate_data->num_rows();

    if($rows == 1){
      $data['real_estate'] = $real_estate_data->result()[0];

      $type = $data['real_estate']->type;
      $type_string = "";
      if($type == 1){
        $type_string = 'بيع';
      }elseif($type == 2){
        $type_string = 'شراء';
      }elseif($type == 3){
        $type_string = 'إيجار';
      }

      $data['type_string'] = $type_string;

      $this->load->view('tmp/header' , $data);
      $this->load->view('entity');
      $this->load->view('tmp/footer');

    }else{
      echo 'الرابط خطأ' . $rows;
    }

  }

  public function real_estate($id){

  }

  public function GIS(){
    $data['provinces'] = $provinces = $this->client_model->get_provinces();
    $this->load->view('GIS' , $data);
  }

}
?>
