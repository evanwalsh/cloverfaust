<?php
class Backend extends Model {
    function Backend(){
        parent::Model();
		//$this->output->enable_profiler(true);
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
	function process(){
		if($this->klei->getGroup() == "1"){
			$sec = $this->uri->segment(3);
			if($sec == "forum"){
				$newname = $this->input->post("newname");
				$oldname = url_title($this->input->post("oldname"));
				$this->db->where("forum",$oldname);
				$this->db->update("posts",array("forum" => url_title($newname)));
				$this->db->where("url",$oldname);
				$this->db->update("forums",array("name" => $newname,"url" => url_title($newname)));
				redirect("admin/forums");
			}
			if($sec == "user"){
				$id = $this->input->post("id");
				$username = $this->input->post("user");
				$email = $this->input->post("email");
				$newpass = $this->input->post("newpass");
				$group = $this->input->post("group");
				$invites = $this->input->post("invites");
				$data = array(
					"name" => $username,
					"email" => $email,
					"group" => $group,
					"invites" => $invites
				);
				if(!empty($newpass)){
					$data["password"] = md5($newpass);
				}
				$this->db->where("id",$id);
				$this->db->update("users",$data);
				redirect("admin/users");
			}
			if($sec == "news"){
				$id = $this->input->post("id");
				$title = $this->input->post("title");
				$url = url_title($title);
			}
			if($sec == "newforum"){
				$name = $this->input->post("name");
				if(!empty($name)){
					$url = url_title($name);
					$this->db->insert("forums",array("name" => $name,"url" => $url));
					redirect("admin/forums");
				}
				else{
					$this->klei->setFlash("error","No forum name entered");
					redirect("admin/create/forum");
				}
			}
			if($sec == "newnews"){
				
			}
		}
	}
	function delete(){
		if($this->klei->getGroup() == "1"){
			$sec = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			if(empty($id)){
				redirect("admin");
			}
			if($sec == "forum"){
				$this->db->where("forum",$id);
				$this->db->delete("posts");
				$this->db->where("url",$id);
				$this->db->delete("forums");
				redirect("admin/forums");
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
}
?>