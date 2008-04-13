<?php
class Common extends Model{
	function Common(){
		parent::model();
	}
	function yield($view){
		$data["siteTitle"] = $this->getOption("sitetitle");
		$data["siteSubtitle"] = $this->getOption("sitesubtitle");
		$data["theme"] = $this->getOption("theme");
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
		if($view == "home"){
			$data["pageTitle"] = "Home";
		}
		elseif($view == "forums"){
			$query = $this->db->get("forums");
			if($query->num_rows() > 0){
				$this->db->cache_on();
				$data["forums"] = $query->result();
			}
			else{
				$data["forums"] = "No forums currently exists";
			}
			$data["pageTitle"] = "Forums";
		}
		elseif($view == "forum"){
			$forum = $this->uri->segment(3);
			$post = $this->uri->segment(4);
			if(!empty($forum)){
				$this->db->order_by("lastpost","desc");
				$this->db->where("forum",$forum);
				$offset = $this->uri->segment(4);
				if($offset < 0 || empty($offset)){
					$offset = 0;
				}
				$query = $this->db->get_where("posts",array("type" => "first"),10,$offset);
				$countq = $this->db->get_where("posts",array("type" => "first","forum" => $forum));
				$count = $countq->num_rows();
				$this->load->library('pagination');
				$config['base_url'] = base_url()."show/forum/".$forum;
				$config['per_page'] = "10";
				$config['total_rows'] = $count;
				$config['uri_segment'] = "4";
				$config['num_links'] = "3";
				$this->pagination->initialize($config);
				if($query->num_rows() >0){
					$data["posts"] = $query->result();
				}
				else{
					$data["posts"] = "No posts!";
				}
				$nameq = $this->db->get_where("forums",array("url" => $forum));
				$name = $nameq->row();
				$data["pageTitle"] = "Forum: ".$name->name;
			}
			else{
				redirect("show/forums");
			}
		}
		elseif($view == "topic"){
			$post = $this->uri->segment(3);
			$this->db->order_by("id","desc");
			$query = $this->db->get_where("posts",array("url" => $post,"type" => "first"));
			if($query->num_rows() > 0){
				$data["firstpost"] = $query->row();
			}
			else{
				redirect();
			}
			$offset = $this->uri->segment(5);
			if($offset < 0 || empty($offset)){
				$offset = 0;
			}
			$countq = $this->db->get_where("posts",array("type" => "reply","url" => $this->uri->Segment(3)));
			$count = $countq->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url()."show/topic/$post";
			$config['total_rows'] = $count;
			$config['uri_segment'] = "4";
			$config['per_page'] = "10";
			$config['num_links'] = "3";
			$this->pagination->initialize($config);
			$this->db->order_by("time","asc");
			$query2 = $this->db->get_where("posts",array("url" => $this->uri->segment(3),"type" => "reply"),10,$offset);
			$data["pageTitle"] = "Topic: ".$data["firstpost"]->title;
			$data["posts"] = $query2->result();
		}
		elseif($view == "reply"){
			$query = $this->db->get_where("posts",array("url" => $this->uri->segment(4),"type" => "first"));
			$data["origpost"] = $query->row();
			$data["pageTitle"] = "Replying to \"".$data["origpost"]->title."\"";
		}
		elseif($view == "newpost"){
			$forum = $this->uri->segment(3);
			if(empty($forum)){
				redirect();
			}
			else{
				$data["forum"] = $forum;
			}
			$data["pageTitle"] = "Creating a new post";
		}
		elseif($view == "account"){
			$this->db->where("id",$this->session->userdata("id"));
			$query = $this->db->get("users");
			$data["user"] = $query->row();
			$data["pageTitle"] = "Editing your account";
		}
		elseif($view == "edit"){
			$query = $this->db->get_where("posts",array("id" => $this->uri->segment(3)));
			$data["post"] = $query->row();
			if($this->session->userdata("id") !== $data["post"]->author){
				redirect("display/forums");
			}
			$data["pageTitle"] = "Editing a post";
		}
		elseif($view == "login"){
			$data["pageTitle"] = "Login";
		}
		elseif($view == "search"){
			$data["term"] = $this->input->post("search");
			if(empty($data["term"])){
				$this->setFlash("error","No search term given");
				redirect("display/home");
			}
			$data["pageTitle"] = "Searching for $data[term]";
			$this->db->like("title",$data["term"]);
			$this->db->or_like("body",$data["term"]);
			$query = $this->db->get("posts");
			$data["posts"] = $query->result();
		}
		$data["yield"] = $this->load->view("themes/$data[theme]/$view",$data,true);
		$this->load->view("themes/$data[theme]/layout",$data);
	}
	function getOption($opt){
		// Gets a site option from the database
		$this->db->cache_on();
		$query = $this->db->query("SELECT value FROM options WHERE `name` = '$opt'");
		$output = $query->row();
		$output = $output->value;
		return $output;
	}
	function setFlash($type,$message){
		// Sets the temporary flash message to be displayed to the user
		if($type == "message"){
			$output = '<div class="message">'.$message.'</div>';
		}
		elseif($type == "error"){
			$output = '<div class="error">'.$message.'</div>';
		}
		$this->session->set_flashdata($type,$output);
	}
	function getGroup(){
		// Gets the usergroup of the current user
		return $this->session->userdata("group");
	}
	function loggedIn(){
		// Checks to see if the person is logged in or not
		$id = $this->session->userdata("id");
		if(!empty($id)){
			return true;
		}
		else{
			return false;
		}
	}
}

?>