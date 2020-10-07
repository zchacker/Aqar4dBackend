<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {

  public function get_my_info($id){
    $this->db->where('id' , $id);
    return $this->db->get('user')->result();
  }

  public function edit_my_info($id , $data){
    $this->db->where('id' , $id);
    $this->db->update('user' , $data);
  }

  public function add_entity_estate($data){
    return $this->db->insert('real_estate' , $data);
  }

  public function edit_entity_estate($data , $id){
    $this->db->where('id' , $id);
    return $this->db->update('real_estate' , $data);
  }

  public function delete_enetity($id){
    $this->db->where('id' , $id);
    return $this->db->delete('real_estate');
  }

  public function add_file_data($data){
    return $this->db->insert('media' , $data);
  }

  public function get_my_entities($user_id){
    $this->db->where('add_by' ,$user_id );
    return $this->db->get('real_estate');
  }

  public function get_entities(){
    $this->db->order_by("id", "DESC");
    return $this->db->get('real_estate');
  }

  public function filter_entites($city , $type , $min_price , $max_price){
    $query = "SELECT * FROM real_estate";
    if($min_price == 0 && $max_price == 0){

      if(strlen($city) > 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND type = $type";
      }else if(strlen($city) > 0 && $type == 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' ";
      }else if(strlen($city) == 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE type = $type";
      }else if(strlen($city) == 0 && $type == 0){
        $query = "SELECT * FROM real_estate";
      }

    }else if($min_price == 0 && $max_price > 0){

      if(strlen($city) > 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND type = $type AND price BETWEEN $min_price AND $max_price ";
      }else if(strlen($city) > 0 && $type == 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND price BETWEEN $min_price AND $max_price ";
      }else if(strlen($city) == 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE type = $type AND price BETWEEN $min_price AND $max_price";
      }else if(strlen($city) == 0 && $type == 0){
        $query = "SELECT * FROM real_estate WHERE price BETWEEN $min_price AND $max_price";
      }

    }else if($min_price > 0 && $max_price == 0){

      if(strlen($city) > 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND type = $type AND price > $min_price ";
      }else if(strlen($city) > 0 && $type == 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND price > $min_price ";
      }else if(strlen($city) == 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE type = $type AND price > $min_price ";
      }else if(strlen($city) == 0 && $type == 0){
        $query = "SELECT * FROM real_estate WHERE price > $min_price ";
      }

    }else if($min_price > 0 && $max_price > 0){

      if(strlen($city) > 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND type = $type AND price BETWEEN $min_price AND $max_price";
      }else if(strlen($city) > 0 && $type == 0){
        $query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND price BETWEEN $min_price AND $max_price ";
      }else if(strlen($city) == 0 && $type != 0){
        $query = "SELECT * FROM real_estate WHERE type = $type AND price BETWEEN $min_price AND $max_price ";
      }else if(strlen($city) == 0 && $type == 0){
        $query = "SELECT * FROM real_estate WHERE price BETWEEN $min_price AND $max_price";
      }

    }

    //$query = "SELECT * FROM real_estate WHERE city LIKE '%$city%' AND type = $type AND  price BETWEEN $min_price AND $max_price ";
    return $this->db->query($query)->result();


  }

  public function search_query($query){
    $query = "SELECT * FROM real_estate WHERE title LIKE '%$query%' ";
    return $this->db->query($query)->result();
  }

  public function get_photo($real_estate_id){
    $this->db->where('for_real_estate' , $real_estate_id);
    $this->db->where('type' , 1);
    return $this->db->get('media');
  }

  public function get_real_estate_data($id){
    //$this->db->where('id' , $id);
    //return $this->db->get('real_estate');
    $qeury = "SELECT real_estate.* , real_eatate_type.name AS type_name , user.name AS user_name FROM `real_estate`
              JOIN real_eatate_type ON real_estate.type = real_eatate_type.id
              JOIN user ON user.id = real_estate.add_by
              WHERE real_estate.id = $id";

    return $this->db->query($qeury);
  }

  public function get_photos_for_real_estate($real_estate_id){
    $this->db->where('type' , 1);
    $this->db->where('for_real_estate' , $real_estate_id);
    return $this->db->get('media');
  }

  public function get_video_for_real_estate($real_estate_id){
    $this->db->where('type' , 2);
    $this->db->where('for_real_estate' , $real_estate_id);
    $this->db->limit(1);
    return $this->db->get('media');
  }

  public function get_provinces(){
    return $this->db->get('sa_provinces')->result();
  }

  public function get_all_cities(){
    return $this->db->get('sa_cities')->result();
  }

  public function get_cities($provinceid){
    $this->db->where('provinceId' , $provinceid);
    return $this->db->get('sa_cities')->result();
  }

  public function get_neighborhoods($cityid){
    $this->db->where('cityId' , $cityid);
    return $this->db->get('sa_neighborhoods')->result();
  }

}

?>
