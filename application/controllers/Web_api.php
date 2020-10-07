<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web_api extends CI_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model("login_model");
    $this->load->model("client_model");
    // $this->load->library('session');
  }

  public function get_provinces(){
      $sa_provinces = $this->client_model->get_provinces();
      echo '<select id="province" name="province" class="form-control" onchange="javascript:select_province(this)"  >';
      echo "<option  value='0'></option>";
      foreach ($sa_provinces as $key => $value) {
          echo "<option  value='$value->id'>$value->nameAr</option>";
      }
      echo '</select>';
  }

  public function get_citis(){
    //var_dump($_SERVER);
    if($_POST){
      $provinceid = $_POST['provinceid'];
      $sa_cities = $this->client_model->get_cities($provinceid);
      echo '<select id="city" name="city" class="form-control" onchange="javascript:select_city(this)" >';
      echo "<option  value='0'></option>";
      foreach ($sa_cities as $key => $value) {
          echo "<option  value='$value->id'>$value->nameAr</option>";
      }
      echo '</select>';
    }else{
      echo 'no form post';
    }
  }

  public function get_neighborhoods(){
    //var_dump($_SERVER);
    if($_POST){
      $cityid = $_POST['cityid'];
      $sa_cities = $this->client_model->get_neighborhoods($cityid);
      echo '<select id="neighborhood" name="neighborhood" class="form-control" onchange="javascript:select_neighborhood(this)"   >';
      echo "<option  value='0'></option>";
      foreach ($sa_cities as $key => $value) {
          echo "<option  value='$value->id'>$value->nameAr</option>";
      }
      echo '</select>';
    }else{
      echo 'no form post';
    }
  }

  public function cities_form(){
    if($_POST){
      $provinceid = $_POST['provinceid'];
      $sa_cities = $this->client_model->get_cities($provinceid);

      echo '<select id="city" name="city" class="form-control" onchange="javascript:select_city(this)" >';
      echo "<option  value='0'></option>";
      foreach ($sa_cities as $key => $value) {
          echo "<option  value='$value->id'>$value->nameAr</option>";
      }
      echo '</select>';
    }else{
      echo 'no form post';
    }
  }

  public function cities_table(){
    if($_POST){
      $provinceid = $_POST['provinceid'];
      $sa_cities = $this->client_model->get_cities($provinceid);

      foreach ($sa_cities as $key => $value) {
        echo "
        <tr>
          <td>$value->id</td>
          <td>$value->nameAr</td>
        </tr>
        ";
      }

    }else{
      echo 'no form post';
    }
  }

  public function neighborhoods_form(){
    //var_dump($_SERVER);
    if($_POST){
      $cityid = $_POST['cityid'];
      $sa_cities = $this->client_model->get_neighborhoods($cityid);
      foreach ($sa_cities as $key => $value) {
          echo "
          <tr>
            <td>$value->id</td>
            <td>$value->nameAr</td>
          </tr>
          ";
      }
    }else{
      echo 'no form post';
    }
  }

}

?>
