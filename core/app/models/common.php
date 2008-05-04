<?php
class Common extends Model{
	function Common(){
		parent::model();
		// $this->output->enable_profiler(TRUE); // debug :]
	}
	function yield($view,$access = false){
		/*
		   Function: yield
		   Displays a page and provides it with data

		   Parameters:
		      view - the page to be displayed
			  access - either "guest" or "user"; prevents guests or users from seeing certain pages

		   Returns:
		      The page wanted with extra data included
		*/
		// TODO: Author caching
		$this->load->library("Spyc");
		$info = $this->spyc->load("config.php"); // yaml <3
		$data["siteName"] = $info["site"]["name"];
		$data["siteSubtitle"] = $info["site"]["subtitle"];
		$data["theme"] = $info["site"]["theme"];
		$data["help"] = $info["site"]["help"];
		$data["loggedIn"] = $this->loggedIn(); // saves some db queries
		if($access == "guest" && $data["loggedIn"] == true){
			redirect("home");
		}
		elseif($access == "user" && $data["loggedIn"] == false){
			redirect("signup");
		}
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
			$data["pageTitle"] = $data["siteSubtitle"];
			$this->db->limit(10);
			$this->db->order_by("time","desc");
			$query = $this->db->get("posts");
			if($query->num_rows() > 0){
				$data["posts"] = $query->result();
			}
		}
		elseif($view == "forums"){
			if(!empty($info["forums"])){
				foreach($info["forums"] as $forum){
					$parts = explode("@",$forum);
					$forums[$parts[0]] = $parts[1];
				}
				$data["forums"] = $forums;
			}
			else{
				$data["forums"] = "No forums currently exists";
			}
			$data["pageTitle"] = "Forums";
		}
		elseif($view == "forum"){
			$forum = $this->uri->segment(2);
			foreach($info["forums"] as $val){
				$parts = explode("@",$val);
				$forums[$parts[0]] = $parts[1];
			}
			if(!empty($forum) && in_array($forum,$forums)){
				$this->db->order_by("lastpost","desc");
				$this->db->where("forum",$forum);
				$offset = $this->uri->segment(3);
				if($offset < 0 || empty($offset)){
					$offset = 0;
				}
				$query = $this->db->get_where("posts",array("type" => "first"),$info["site"]["per-page"],$offset);
				$countq = $this->db->get_where("posts",array("type" => "first","forum" => $forum));
				$count = $countq->num_rows();
				$this->load->library('pagination');
				$config['base_url'] = base_url()."forum/".$forum;
				$config['per_page'] = $info["site"]["per-page"];
				$config['total_rows'] = $count;
				$config['uri_segment'] = "3";
				$config['num_links'] = "3";
				$this->pagination->initialize($config);
				if($query->num_rows() >0){
					$data["posts"] = $query->result();
				}
				else{
					$data["posts"] = "No posts!";
				}
				$name = array_search($forum,$forums); // gets array key by value
				$data["pageTitle"] = "Forum: $name";
			}
			else{
				redirect("forums");
			}
		}
		elseif($view == "topic"){
			$post = $this->uri->segment(2);
			$this->db->order_by("id","desc");
			$query = $this->db->get_where("posts",array("url" => $post,"type" => "first"));
			if($query->num_rows() < 0){
				redirect();
			}
			else{
				$offset = $this->uri->segment(3);
				if($offset < 0 || empty($offset)){
					$offset = 0;
				}
				$countq = $this->db->get_where("posts",array("url" => $post));
				$count = $countq->num_rows();
				$this->load->library('pagination');
				$config['base_url'] = base_url()."topic/$post";
				$config['total_rows'] = $count;
				$config['uri_segment'] = "3";
				$config['per_page'] = $info["site"]["per-page"];
				$config['num_links'] = "3";
				$this->pagination->initialize($config);
				$this->db->order_by("time","asc");
				$query2 = $this->db->get_where("posts",array("url" => $post));
				$data["posts"] = $query2->result();
				$data["pageTitle"] = "Topic: ".$data["posts"][0]->title;
			}
		}
		elseif($view == "reply"){
			$query = $this->db->get_where("posts",array("url" => $this->uri->segment(3),"type" => "first"));
			if($query->num_rows() > 0){
				$data["origpost"] = $query->row();
				$data["pageTitle"] = "Replying to: ".$data["origpost"]->title;
			}
			else{
				redirect();
			}
		}
		elseif($view == "post"){
			$forum = $this->uri->segment(3);
			foreach($info["forums"] as $val){
				$parts = explode("@",$val);
				$forums[$parts[0]] = $parts[1];
			}
			if(!in_array($forum,$forums)){
				redirect("forums");
			}
			$data["pageTitle"] = "New topic: ".array_search($forum,$info["forums"]);
		}
		elseif($view == "account"){
			$this->db->where("id",$this->session->userdata("id"));
			$query = $this->db->get("users");
			$data["user"] = $query->row();
			$data["pageTitle"] = "Editing your account";
		}
		elseif($view == "edit"){
			$query = $this->db->get_where("posts",array("id" => $this->uri->segment(3)));
			if($query->num_rows() > 0){
				$data["post"] = $query->row();
				if($this->session->userdata("id") !== $data["post"]->author){
					redirect("forums");
				}
				$data["pageTitle"] = "Editing a post";
			}
			else{
				redirect();
			}
		}
		elseif($view == "login"){
			$data["pageTitle"] = "Login";
		}
		elseif($view == "search"){
			$data["term"] = $this->input->post("search");
			if(empty($data["term"])){
				$this->setFlash("error","No search term given");
				redirect("home");
			}
			$data["pageTitle"] = "Searching for $data[term]";
			// $offset = $this->uri->segment(3);
			// if($offset < 0 || empty($offset)){
			// 	$offset = 0;
			// }
			// 
			// $this->db->like("title",$data["term"]);
			// $this->db->or_like("body",$data["term"]);
			// $this->db->order_by("time","desc");
			// $countq = $this->db->get("posts");
			// $count = $countq->num_rows();
			// 
			// $this->load->library('pagination');
			// $config['base_url'] = base_url()."show/search";
			// $config['total_rows'] = $count;
			// $config['uri_segment'] = 3;
			// $config['per_page'] = 10;
			// $config['num_links'] = 3;
			// $this->pagination->initialize($config);
			$this->db->like("title",$data["term"]);
			$this->db->or_like("body",$data["term"]);
			$this->db->order_by("time","desc");
			// $this->db->limit(10,$offset);
			$query = $this->db->get("posts");
			$data["posts"] = $query->result();
		}
		elseif($view == "signup"){
			$data["pageTitle"] = "Signup";
		}
		elseif($view == "help"){
			$data["pageTitle"] = "Help";
		}
		$data["yield"] = $this->load->view("themes/$data[theme]/$view",$data,true);
		$this->load->view("themes/$data[theme]/layout",$data);
	}
	function setFlash($type,$message){
		/*
		   Function: setFlash
		   Sets a temporary message or error to be show on the next page only

		   Parameters:
		      type - either "message" or "error"
			  message - Whatever text you want the user to see

		   Returns:
		      Nothing.  It sets a flashdata value in the user's current session.
		*/
		$output = null;
		if($type == "message"){
			$output = '<div id="message">'.$message.'</div>';
		}
		elseif($type == "error"){
			$output = '<div id="error">'.$message.'</div>';
		}
		$this->session->set_flashdata($type,$output);
	}
	function getGroup($conv = false){
		/*
		   Function: getGroup
		   Gets the current group the user is in

		   Parameters:
		      convert - if set to true, it will change the group number to the text version of that group

		   Returns:
		      A number, 0 or 1, depending on the group.  0 is admin and 1 is normal user.
			  If you set convert to true, then it will return user or admin, instead.
		*/
		$group = $this->session->userdata("group");
		if($conv == true){
			if($group == 0){
				$group = "user";
			}
			if($group == 1){
				$group = "admin";
			}
		}
		return $group;
	}
	function loggedIn(){
		/*
		   Function: loggedIn
		   Checks to see if the current user is logged in or not

		   Returns:
		      True if the user is logged in, false if they aren't
		*/
		$id = $this->session->userdata("id");
		$query = $this->db->get_where("users",array("id" => $id));
		if(!empty($id) && $query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	function getConfig(){
		/*
		   Function: getConfig
		      Loads the current configuration from config.php

		   Returns:
		      An array with the current site's configuration settings
		*/
		$this->load->library("Spyc");
		return $this->spyc->load("config.php");
	}
}

?>