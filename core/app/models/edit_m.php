<?php
class Edit_m extends Model{
	function Edit_m(){
		parent::model();
	}
	function post(){
		$this->load->library('validation');
		$body = $this->input->post("body");
		$rules["body"] = "required";
		$this->validation->set_rules($rules);
		$this->validation->set_error_delimiters(null,null);
		if ($this->validation->run() == FALSE){
			$this->common->setFlash("error",$this->validation->error_string);
			redirect("edit/post/".$this->input->post("id"));
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
			"body" => $body,
			"conv_body" => $conv_body
		);
		$this->db->where("url",$this->input->post("post"));
		$this->db->where("id",$this->input->post("id"));
		$this->db->update("posts",$data);
		$this->common->setFlash("message","Post edited");
		redirect("show/topic/".$this->input->post("post"));
	}
	function account(){
		$user = $this->session->userdata("name");
		$email = $this->input->post("email");
		$newpass = $this->input->post("newpass");
		$newpass2 = $this->input->post("newpassdeux");
		$timezone = $this->input->post("timezones");
		$data = array(
			"email" => $email,
			"timezone" => $timezone
		);
		if(!empty($newpass) && $newpass == $newpass2){
			$data["password"] = md5($newpass);
		}
		$this->db->where("name",$user);
		$this->db->update("users",$data);
		$this->common->setFlash("message","Account details updated");
		redirect("display/forums");
	}
	function user(){
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
	function forum(){
		$newname = $this->input->post("newname");
		$oldname = url_title($this->input->post("oldname"));
		$this->db->where("forum",$oldname);
		$this->db->update("posts",array("forum" => url_title($newname)));
		$this->db->where("url",$oldname);
		$this->db->update("forums",array("name" => $newname,"url" => url_title($newname)));
		redirect("admin/forums");
	}
}

?>