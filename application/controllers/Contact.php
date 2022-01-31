<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('contact_model');
	}

	public function index()
	{
		$this->load->view('index');
	}

	public function create()
	{
		$name = $this->input->post('first_name');
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');
		$data = array(
			'first_name'	=> $name,
			'email' => $email,
			'mobile'	=> $mobile,
	        'status' => '1',
	        'created_by' => date('Y-m-d H:i:s'),
		);
		$insert = $this->contact_model->createData($data);
		echo json_encode($insert);
	}

	public function fetchData()
	{
		$resultList = $this->contact_model->fetchAllData();
		
		$result = array();
		$i = 1;
		foreach ($resultList as $key => $value) {
            $action = "<button class='btn btn-danger' onclick='remove(".$value['id'].")'>Delete</button>&nbsp;<button id='myBtn' class='btn btn-primary btn-lg editData' onclick='edit(".$value['id'].")'>Edit</button>";
			$result['data'][] = array(
				$i++,
				$value['first_name'],
				$value['email'],
				$value['mobile'],
				$value['created_by'],
				$action,
			);
		}
		echo json_encode($result);
	}
	public function delete()
	{
		  $id = $_POST['id'];
		  $data = $this->contact_model->delete($id);
		  echo json_encode($data);
	}
	public function edit(){
		$param = $_POST['id'];
	   if(!empty($param)){
		   
		   $contact = array(
			   'first_name' => $this->input->post('name'),
			   'mobile' => $this->input->post('mobile'),
			   'email' => $this->input->post('email'),
			   'status' => '1',
			   'created_by' => date('Y-m-d H:i:s'),
			   );
		 $this->db->where('id',$param);
		 $query = $this->db->update('contact',$contact);
		 if($query){
			   echo"200::Sucess";
			   exit;           
		 }else{ 
			 echo "305::Error Occured";
			 exit;
		 }
	   }
	}
	
	public function view(){
		$id = $_POST['id'];
	   $query = $this->contact_model->view($id);
	   echo json_encode($query);
	}
		 
	
}