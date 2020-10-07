<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {

  public function add_token($data){
    return $this->db->insert('tokens' , $data);
  }

  public function get_real_eatate_type(){
    return $this->db->get('real_eatate_type')->result();
  }

  public function add_entity_estate($data){
    return $this->db->insert('real_estate' , $data);
  }

  public function add_file_data($data){
    return $this->db->insert('media' , $data);
  }

  public function get_my_data($user_id , $token){
    $this->db->where('token' , $token);
    $this->db->where('user_id' , $user_id);
    $result = $this->db->get('tokens');

    $resultBack = array();

    if($result->num_rows() == 1){

      $this->db->where('id' , $user_id);
      $user_data = $this->db->get('user');
      if($user_data->num_rows() == 1){
        $resultBack['success'] = true;
        $resultBack['result'] = $user_data->result();
      }else{
        $resultBack['success'] = false;
      }

    }else{
      $resultBack['success'] = false;
    }
    return $resultBack;

  }

  public function get_user_data($id){
    $this->db->where('id' , $id);
    return $this->db->get('user');
  }

  public function edit_my_info($data , $user_id){
    $this->db->where('id' , $user_id);
    return $this->db->update('user' , $data);
  }

  public function get_my_entities($user_id){
    // $query = "SELECT real_estate.* , media_tmp.media_path
    //           FROM real_estate
    //           LEFT JOIN(
    //                       SELECT s1.*
    //                   		FROM media as s1
    //                   		LEFT JOIN media AS s2
    //                   		ON s1.from_user = s2.from_user
    //                       LIMIT 1
    //           	        ) as media_tmp
    //          ON (real_estate.add_by = media_tmp.from_user )
    //          WHERE real_estate.add_by = $user_id";

    //return $this->db->query($query);
    $this->db->where('deleted' , 0);
    $this->db->where('add_by' ,$user_id );
    return $this->db->get('real_estate');
  }

  public function get_photo($entity_id){
    $this->db->where('for_real_estate' , $entity_id);
    $this->db->where('type' , 1); // 1 mean photo
    $this->db->limit(1);
    return $this->db->get('media');
  }

  public function get_video($entity_id){
    $this->db->where('for_real_estate' , $entity_id);
    $this->db->where('type' , 2); // 1 mean video
    $this->db->limit(1);
    return $this->db->get('media');
  }

  public function get_entities($page){
    $page = ($page - 1) * 20;
    $this->db->where('deleted' , 0);
    $this->db->order_by('id', 'DESC');
    $this->db->limit(20 , $page);
    return $this->db->get('real_estate');
  }

  public function get_one_entity($id){
    $this->db->where('deleted' , 0);
    $this->db->where('id' , $id);
    $this->db->limit(1);
    return $this->db->get('real_estate');
  }

  public function get_photos_for_entity($id){
    $this->db->where('type' , 1); // 1 mean photo
    $this->db->where('for_real_estate' , $id);
    return $this->db->get('media');
  }

  public function get_type_name($id){
    $this->db->where('id' , $id);
    $this->db->limit(1);
    return $this->db->get('real_eatate_type');
  }

  public function get_messages( $from_user_id , $to_user_id ){
    $query = "SELECT * FROM `messages` WHERE (from_user = $from_user_id OR to_user = $from_user_id) AND (to_user = $to_user_id OR from_user = $to_user_id)";
    return $this->db->query($query);
  }

  public function add_message($data){
    return $this->db->insert('messages' , $data);
  }

  public function delete_enetity($id){
    $data = array('deleted' => 1);
    $this->db->where('id' , $id);
    return $this->db->update('real_estate' , $data);
  }

  public function enetity_soldout($id){
    $data = array('soldout' => 1);
    $this->db->where('id' , $id);
    return $this->db->update('real_estate' , $data);
  }

  public function edit_entity($id , $data){
    $this->db->where('id' , $id);
    return $this->db->update('real_estate' , $data);
  }

  // this is for fillters and so on
  public function filter_by_select($page , $type){
      $page = ($page - 1) * 20;
      $query = "
              SELECT real_estate.* , real_eatate_type.name AS type_name FROM `real_estate`
              JOIN real_eatate_type ON real_eatate_type.id = real_estate.type
              WHERE real_eatate_type.name LIKE '%$type%' AND real_estate.deleted = 0
              ORDER BY real_estate.id DESC
              LIMIT $page , 20
              ";
      return $this->db->query($query);

  }

  public function search($page , $keyword){
    $page = ($page - 1) * 20;
    $query = "SELECT * FROM `real_estate` WHERE ( title LIKE '%$keyword%' OR city LIKE '%$keyword%' OR neighborhood LIKE '%$keyword%' ) AND ( deleted = 0 ) LIMIT $page , 20";
    return $this->db->query($query);
  }

}
?>
