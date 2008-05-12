<?php
class Edit_m extends Model{
	function Edit_m(){
		parent::model();
		$this->load->database();
	}
	function post(){
		$query = $this->db->get_where("posts",array("id" => $this->uri->segment(3)));
		if($query->num_rows() > 0){
			$post = $query->row();
			if($this->session->userdata("id") == $post->author){
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
					$this->load->library("Textilite");
					$conv_body = $this->textilite->process($this->input->post("body"));
				}
				elseif($this->session->userdata("editor") == "html"){
					$conv_body = strip_tags($this->input->post("body"),$info["allowed-tags"]);
				}
				$data = array(
					"body" => $body,
					"conv_body" => $conv_body
				);
				$this->db->where("url",$post->url);
				$this->db->where("id",$post->id);
				$this->db->update("posts",$data);
				$this->common->setFlash("message","Post edited");
				redirect("topic/".$post->url."#post".$post->id);
			}
			else{
				$this->common->setFlash("error","You don't have permission to edit that post");
			}
		}
		else{
			$this->common->setFlash("error","Post not found");
			redirect("home");
		}
	}
	function account(){
		$user = $this->session->userdata("name");
		$email = $this->input->post("email");
		$newpass = $this->input->post("newpass");
		$newpass2 = $this->input->post("newpassdeux");
		$timezone = $this->input->post("timezones");
		$editor = $this->input->post("editor");
		if($editor !== "textile" && $editor !== "html"){
			$editor = "textile";
		}
		$data = array(
			"email" => $email,
			"timezone" => $timezone,
			"editor" => $editor
		);
		if(!empty($newpass) && $newpass == $newpass2){
			$data["password"] = md5($newpass);
		}
		$this->db->where("name",$user);
		$this->db->update("users",$data);
		$this->session->sess_destroy();
		// $this->common->setFlash("message","Login needed to change account details");
		redirect("login");
	}
	function user(){
		if($this->common->getGroup() == "1"){
			$id = $this->uri->segment(3);
			$username = $this->input->post("username");
			$email = $this->input->post("email");
			$newpass = $this->input->post("newpass");
			$group = $this->input->post("group");
			$data = array(
				"name" => $username,
				"email" => $email,
				"group" => $group,
			);
			if(!empty($newpass)){
				$data["password"] = md5($newpass);
			}
			$this->db->where("id",$id);
			$this->db->update("users",$data);
			$this->common->setFlash("message","User edited");
			redirect("admin/users");
		}
		else{
			redirect();
		}
	}
	function forum(){
		if($this->common->getGroup() == "1"){
			$config = $this->common->getConfig();
			$newname = $this->input->post("newname");
			$oldname = $this->input->post("oldname");
			$config["forums"] = array_unique($config["forums"]);
			$key = array_search($oldname."@".url_title($oldname),$config["forums"]);
			$config["forums"]["$key"] = $newname."@".url_title($newname);
			$done = $this->spyc->dump($config,4);
			$handle = fopen("config.php","w");
			$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
			fwrite($handle,$output);
			fclose($handle);
			$this->db->where("forum",url_title($oldname));
			$this->db->update("posts",array("forum" => url_title($newname)));
			$this->common->setFlash("message","Forum edited");
			redirect("admin/forums");
		}
		else{
			redirect();
		}
	}
}

?>