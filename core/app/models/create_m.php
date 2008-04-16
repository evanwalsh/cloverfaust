<?php
class Create_m extends Model{
	function Create_m(){
		parent::Model();
	}
	function topic(){
		$this->load->library('validation');
		$rules["title"]	= "required";
		$rules["body"] = "required";
		$this->validation->set_error_delimiters(null,null);
		$this->validation->set_rules($rules);
		$title = $this->input->post("title");
		$body = $this->input->post("body");
		$url = url_title($title);
		$forum = $this->uri->segment(3);
		$this->validation->set_fields($fields);
		if ($this->validation->run() == FALSE){
			$this->setFlash("error",$this->validation->error_string);
			redirect("create/post/$forum");
		}
		$query = $this->db->get_where("posts",array("url" => $url));
		if($query->num_rows() > 0){
			$url = $url."-".now();
		}
		if($this->session->userdata("editor") == "textile"){
			$this->load->library("Textile");
			$conv_body = $this->textile->TextileThis($body);
		}
		elseif($this->session->userdata("editor") == "markdown"){
			$this->load->library("Markdown");
			$conv_body = $this->markdown->transform($body);
		}
		$data = array(
			"title" => $title,
			"url" => $url,
			"author" => $this->session->userdata("id"),
			"body" => $body,
			"conv_body" => $conv_body,
			"forum" => $forum,
			"type" => "first",
			"time" => now(),
			"lastpost" => now(),
			"origauthor" => $this->session->userdata("id")
		);
		$this->db->insert("posts",$data);
		$this->common->setFlash("message","Post created");
		redirect("show/forum/".$this->input->post("forum"));
	}
	function reply(){
		// TODO $forum,$post
		$this->load->library("Textile");
		$this->load->library('validation');
		$rules["body"] = "required";
		$rules["forum"] = "required";
		$this->validation->set_error_delimiters(null,null);
		$this->validation->set_rules($rules);
		if ($this->validation->run() == FALSE){
			$this->common->setFlash("error",$this->validation->error_string);
			redirect("create/reply/$forum");
		}
		if($this->session->userdata("editor") == "textile"){
			$this->load->library("Textile");
			$conv_body = $this->textile->TextileThis($body);
		}
		elseif($this->session->userdata("editor") == "markdown"){
			$this->load->library("Markdown");
			$conv_body = $this->markdown->transform($body);
		}
		$data = array(
			"title" => $this->urlToTitle($this->uri->segment(3)),
			"url" => $this->input->post("post"),
			"author" => $this->session->userdata("id"),
			"body" => $this->input->post("body"),
			"conv_body" => $conv_body,
			"forum" => $this->input->post("forum"),
			"type" => "reply",
			"time" => now(),
			"lastpost" => now(),
			"origauthor" => $this->input->post("origauthor")
		);
		$this->db->insert("posts",$data);
		$this->db->where("url",$this->input->post("post"));
		$this->db->update("posts",array("lastpost" => now()));
		redirect("show/forum/".$forum."/".$post);
	}
	function forum(){
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
	function urlToTitle($url){
		$this->db->where("url",$url);
		$this->db->where("type","first");
		$query = $this->db->get("posts");
		$result = $query->row();
		return $result->title;
	}
}
?>