<?php
class Create_m extends Model{
	function Create_m(){
		parent::Model();
	}
	function topic(){
		$this->load->library('validation');
		$this->load->library("Spyc");
		$info = $this->spyc->load("config.php");
		$rules["title"]	= "required";
		$rules["body"] = "required";
		$this->validation->set_error_delimiters(null,null);
		$this->validation->set_rules($rules);
		$title = $this->input->post("title");
		$body = $this->input->post("body");
		$url = url_title($title);
		$forum = $this->uri->segment(3);
		$this->validation->set_fields($rules);
		if($this->validation->run() == FALSE){
			$this->common->setFlash("error",$this->validation->error_string);
			redirect("create/topic/$forum");
		}
		$query = $this->db->get_where("posts",array("url" => $url));
		if($query->num_rows() > 0){
			$url = $url."-".now();
		}
		if($this->session->userdata("editor") == "textile" || $this->session->userdata("editor") == null){
			$this->load->library("Textilite");
			$conv_body = $this->textilite->process($this->input->post("body"));
		}
		elseif($this->session->userdata("editor") == "html"){
			$conv_body = strip_tags($this->input->post("body"),$info["site"]["allowed-tags"]);
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
		redirect("topic/".$url);
	}
	function reply(){
		$this->load->library('validation');
		$this->load->library("Spyc");
		$info = $this->spyc->load("config.php");
		$rules["body"] = "required";
		$rules["forum"] = "required";
		$rules["origauthor"] = "required";
		$rules["post"] = "required";
		$this->validation->set_error_delimiters(null,null);
		$this->validation->set_rules($rules);
		if($this->validation->run() == FALSE){
			$this->common->setFlash("error",$this->validation->error_string);
			redirect("create/reply/$forum");
		}
		if($this->session->userdata("editor") == "textile" || $this->session->userdata("editor") == null){
			$this->load->library("Textilite");
			$conv_body = $this->textilite->process($this->input->post("body"));
		}
		$data = array(
			"title" => $this->input->post("title"),
			"url" => $this->uri->segment(3),
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
		redirect("topic/".$this->input->post("post"));
	}
	function forum(){
		if($this->common->getGroup() == 1){
			$name = $this->input->post("name");
			if(!empty($name)){
				$url = url_title($name);
				$this->load->library("Spyc");
				$conf = $this->spyc->load("config.php");
				$count = count($conf["forums"]);
				$conf["forums"][$count+1] = $name."@".$url;
				$conf["forums"] = array_unique($conf["forums"]);
				$done = $this->spyc->dump($conf,4);
				$handle = fopen("config.php","w");
				$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
				fwrite($handle,$output);
				fclose($handle);
				$this->common->setFlash("message","$name created");
				redirect("admin/forums");
			}
			else{
				$this->common->setFlash("error","No forum name entered");
				redirect("admin/create/forum");
			}
		}
		else{
			redirect();
		}
	}
	function user(){
		if($this->common->getGroup() == 1){
			$user = array(
				"name" => $this->input->post("username"),
				"password" => md5($this->input->post("password")),
				"email" => $this->input->post("email"),
				"group" => $this->input->posT("group"),
				"timezone" => $this->input->post("timezones"),
				"editor" => $this->input->post("editor"),
			);
			$this->db->insert("users",$user);
			$this->common->setFlash("message","User created");
			redirect("admin/users");
		}
		else{
			redirect();
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