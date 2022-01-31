<?php 

class Contact_model extends CI_Model
{
	public function createData($data)
	{
		$query = $this->db->insert('contact',$data);
		return $query;
	}

	public function fetchAllData()
	{
		$query = $this->db->get('contact');
		return $query->result_array();
	}
	function view($id){
        $result = $this->db->get_where('contact',array('id'=>$id))->row_array();
        return $result;
    }
    public function delete($id)
    { 
        $query = $this->db->delete('contact', array('id' => $id));
        return $query;
    }
}