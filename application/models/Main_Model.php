<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Main_model extends CI_Model {

  public function __construct() {
    parent::__construct(); 
  }

  // Fetch records
  public function getData($rowno,$rowperpage) {
 
    $this->db->select('*');
    $this->db->from('posts');
    $this->db->limit($rowperpage, $rowno);  
    $query = $this->db->get();
 
    return $query->result_array();
  }

  // Select total records
  public function getrecordCount() {

    $this->db->select('count(*) as allcount');
    $this->db->from('posts');
    $query = $this->db->get();
    $result = $query->result_array();
 
    return $result[0]['allcount'];
  }

  function save_upload($name,$email,$image){
    $data = array(
            'name' => $name,
            'email' => $email,
            'image' => $image
        );  
    $result= $this->db->insert('user',$data);
    return $result;
} 

}
