<?php
class Backend_m extends Model {
    function Backend_m(){
        parent::Model();
    }
	function login(){
		/*
		   Function: login
		   Processes the login and redirects the user if needed
		*/
		$user = $this->input->post("user");
		$pass = md5($this->input->post("pass"));
		$query = $this->db->get_where("users",array("name" => $user));
		if($query->num_rows() > 0){
			$info = $query->row();
			if($info->password == $pass){
				$this->session->set_userdata("id",$info->id);
				$this->session->set_userdata("name",$info->name);
				$this->session->set_userdata("group",$info->group);
				$this->session->set_userdata("timezone",$info->timezone);
				$this->session->set_userdata("editor",$info->editor);
				$this->common->setFlash("message","Login successful");
				redirect("home");
			}
			else{
				$this->common->setFlash("error","Invalid login");
				redirect("login");
			}
		}
		else{
			$this->common->setFlash("error","Invalid login");
			redirect("login");
		}
	}
	function logout(){
		/*
		   Function: logout
		   Destroys the current session and redirects the user
		*/
		$this->session->sess_destroy();
		redirect();
	}
}
?>