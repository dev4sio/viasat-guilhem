<?php
class User_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_user($id = NULL){
        if(!empty($id)){
            $query = $this->db->get_where('user', array('id' => $id));
            return $query->row_array();
        }
        $query = $this->db->get_where('user', array('username' => $this->input->post('username')));
        return $query->row_array();
    }



    public function set_user(){

        $encrypt_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $encrypt_password,
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
        );

        return $this->db->insert('user', $data);
    }

    public function edit_user(){
        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
        );

        $this->db->where('id',$_SESSION['user']['id']);
        $this->db->update('user',$data);
    }


}
