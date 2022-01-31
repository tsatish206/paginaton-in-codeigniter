<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function __construct(){ 
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('pagination');
    $this->load->model('Main_model');
  }

  public function index(){
    $this->load->view('user_view');
  }

  public function loadRecord($rowno=0){
    // Row per page
    $rowperpage = 2;
    // Row position
    if($rowno != 0){
      $rowno = ($rowno-1) * $rowperpage;
    } 
    // All records count
    $allcount = $this->Main_model->getrecordCount();
    // Get records
    $users_record = $this->Main_model->getData($rowno,$rowperpage); 
    // Pagination Configuration
    $config['base_url'] = base_url().'/User/loadRecord';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $allcount;
    $config['per_page'] = $rowperpage;
    $this->pagination->initialize($config);
    // Initialize $data Array
    $data['pagination'] = $this->pagination->create_links();
    $data['result'] = $users_record;
    $data['row'] = $rowno;
    echo json_encode($data); 
  }
  function add_project()
  {
    if(isset($_FILES["file"]["name"]))  
    {  
        $config['upload_path'] = './assets/images';  
        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
        $this->load->library('upload', $config);  
        if(!$this->upload->do_upload('file'))  
        {  
        echo $this->upload->display_errors();  
        }  
         
        $data = array('upload_data' => $this->upload->data());
        
        $name= $this->input->post('name');
        $email= $this->input->post('email');
        $image= $data['upload_data']['file_name']; 
        
        $result= $this->Main_model->save_upload($name,$email,$image);
        if($result){
            echo"200::Sucess";
            exit; 
        }else{
            echo"400::Failed";
            exit; 
        }
       
    }
    $this->load->view('user');

 }
}