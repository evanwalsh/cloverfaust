<?php
class Backend_m extends Model {
    function Backend_m(){
        parent::Model();
    }
	function yield($view){
		if($this->klei->getGroup() == "1"){
			$data["siteTitle"] = "cloverfaust";
			$data["siteSubtitle"] = "The private community app";
			$data["pageTitle"] = "Administrating";
			// error/message handling
			$data["message"] = null;
			$data["error"] = null;
			$flashMessage = $this->session->flashdata("message");
			$flashError = $this->session->flashdata("error");
			if(!empty($flashMessage)){
				$data["message"] = $flashMessage;
			}
			if(!empty($flashError)){
				$data["error"] = $flashError;
			}
			// yeah. we're done with that. let's move on
			if($view == "forums"){
				$data["pageTitle"] = "Editing the forums";
				$query = $this->db->get("forums");
				$data["forums"] = $query->result();
			}
			if($view == "users"){
				$data["pageTitle"] = "Editing the users";
				$offset = $this->uri->segment(3);
				if($offset < 0 || empty($offset)){
					$offset = 0;
				}
				$countq = $this->db->get("users");
				$count = $countq->num_rows();
				$this->load->library('pagination');
				$config['base_url'] = base_url()."admin/users/";
				$config['per_page'] = 10;
				$config['total_rows'] = $count;
				$config['uri_segment'] = 3;
				$config['num_links'] = 3;
				$this->pagination->initialize($config);
				$this->db->order_by("group","asc");
				$query = $this->db->get("users",10,$offset);
				$data["users"] = $query->result();
			}
			if($view == "edit"){
				$type = $this->uri->segment(3);
				$data["pageTitle"] = "Editing $type";
				if($type !== "users" && $type !== "forums" && $type !== "news"){
					redirect("admin");
				}
				$id = $this->uri->segment(4);
				if($type == "user"){
					$query = $this->db->get_where("users",array("id" => $id));
					$data["user"] = $query->row();
					$view = "edituser";
				}
				if($type == "forum"){
					$query = $this->db->get_where("forums",array("id" => $id));
					$data["forum"] = $query->row();
					$view = "editforum";
				}
				if($type == "news"){
					$query = $this->db->get_where("news",array("id" => $id));
					$data["item"] = $query->row();
					$view = "editnews";
				}
			}
			if($view == "create"){
				$sec = $this->uri->segment(3);
				if($sec == "forum"){
					$data["pageTitle"] = "Creating a forum";
					$view = "newforum";
				}
				if($sec == "news"){
					$data["pageTitle"] = "Creating a news item";
					$view = "newnews";
				}
			}
			$data["yield"] = $this->load->view("admin/$view",$data,true);
			$this->load->view("admin/layout",$data);
		}
		else{
			redirect();
		}
	}
	function login(){
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
				redirect("show/home");
			}
			else{
				$this->common->setFlash("error","Invalid login");
				redirect("show/login");
			}
		}
		else{
			$this->common->setFlash("error","Invalid login");
			redirect("show/login");
		}
	}
	function delete(){
		if($this->common->getGroup() == "1"){
			$sec = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			if(empty($id)){
				redirect("admin");
			}
			if($sec == "user"){
				$this->db->where("id",$id);
				$this->db->delete("users");
				$this->db->where("author",$id);
				$this->db->delete("posts");
				redirect("admin/users");
			}
		}
		else{
			redirect();
		}
	}
	function logout(){
		$this->session->sess_destroy();
		redirect();
	}
}
?>