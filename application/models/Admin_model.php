<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

  // this is counters queries

  public function count_entities(){
    $query = "SELECT COUNT(*) as total FROM real_estate";
    return $this->db->query($query);
  }

  public function count_users(){
    $query = "SELECT COUNT(*) as total FROM user";
    return $this->db->query($query);
  }



  public function get_entities(){
    $this->db->where('deleted' , 0);
    $this->db->order_by("id", "DESC");
    return $this->db->get('real_estate');
  }

  public function get_archive_entities(){
    $this->db->where('deleted' , 1);
    $this->db->order_by("id", "DESC");
    return $this->db->get('real_estate');
  }

  public function get_members(){
    $this->db->where('deleted' , 0);
    return $this->db->get('user');
  }

  public function delete_members($id){

    $this->db->where('add_by' , $id);
    $data = array('deleted' => 1);
    $this->db->update('real_estate' , $data);

    $this->db->where('id' , $id);
    $data = array('deleted' => 1);
    return $this->db->update('user' , $data);
  }

  public function archive($id){
    $this->db->where('id' , $id);
    $data = array('deleted' => 1);
    return $this->db->update('real_estate' , $data);
  }

  public function unarchive($id){
    $this->db->where('id' , $id);
    $data = array('deleted' => 0);
    return $this->db->update('real_estate' , $data);
  }

}

?>
