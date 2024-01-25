<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user extends CI_Model
{
    function get_auto_increment_id()
    {
        $sql = "SHOW TABLE STATUS LIKE 'tbl_user'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getAllUser()
    {
        $query = $this->db->query("SELECT * FROM tbl_user");
        return $query->result_array();
    }

    public function getUserById($id){
        $sql = "SELECT * FROM tbl_user WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->first_row('array');
    }

    function updateUser($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_user', $data);
        return $this->db->affected_rows();
    }

    function checkUsername($username)
	{
        $where = array(
            'username' => $username
		);
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where($where);
		$query = $this->db->get();
		return $query->first_row('array');
    }

    function checkPassword($data)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where($data);
        $query = $this->db->get();
        return $query->first_row('array');
    }
}
