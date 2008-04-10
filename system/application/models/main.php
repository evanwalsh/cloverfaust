<?php
class Main extends Model {
    function Main(){
        parent::Model();
		//$this->output->enable_profiler(true);
    }
	function yield($view){
		$data["siteTitle"] = "cloverfaust"; //$this->getOption("sitetitle")
		$data["siteSubtitle"] = "crazy people with internet machines"; //$this->getOption("sitesubtitle")
		$data["theme"] = "default";
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
		$data["side"] = $this->load->view("themes/$data[theme]/side",$data,true);
		if($this->loggedIn() == FALSE && $view !== "activate" && $view !== "login"){
			redirect("x/login");
		}
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
			$data["pageTitle"] = $data["siteSubtitle"];
		}
		elseif($view == "forum"){
			$forum = $this->uri->segment(3);
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
				$config['base_url'] = base_url()."display/forum/".$forum;
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
				$data["pageTitle"] = "Viewing forum \"".$name->name."\"";
			}
			else{
				redirect("display/forums");
			}
		}
		elseif($view == "post"){
			$this->db->order_by("id","desc");
			$query = $this->db->get_where("posts",array("url" => $this->uri->segment(3),"type" => "first"));
			if($query->num_rows() > 0){
				$data["firstpost"] = $query->row();
			}
			else{
				redirect();
			}
			$offset = $this->uri->segment(4);
			if($offset < 0 || empty($offset)){
				$offset = 0;
			}
			$countq = $this->db->get_where("posts",array("type" => "reply","url" => $this->uri->Segment(3)));
			$count = $countq->num_rows();
			$this->load->library('pagination');
			$config['base_url'] = base_url()."display/post/".$this->uri->segment(3);
			$config['total_rows'] = $count;
			$config['uri_segment'] = "4";
			$config['per_page'] = "10";
			$config['num_links'] = "3";
			$this->pagination->initialize($config);
			$this->db->order_by("time","asc");
			$query2 = $this->db->get_where("posts",array("url" => $this->uri->segment(3),"type" => "reply"),10,$offset);
			$data["pageTitle"] = "Viewing post \"".$data["firstpost"]->title."\"";
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
		elseif($view == "invite"){
			$data["pageTitle"] = "Inviting a person";
			$query = $this->db->get_where("users",array("name" => $this->session->userdata("name")));
			$result = $query->row();
			if($result->invites < 1){
				$this->setFlash("error","You don't have any invites");
				redirect("display/forums");
			}
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
			$data["pageTitle"] = "Logging in";
		}
		elseif($view == "activate"){
			$data["pageTitle"] = "Activating an account";
			if($this->loggedIn()){
				$this->setFlash("message","Hey, you're already activated! What are you doing?");
				redirect("display/forums");
			}
		}
		/*elseif($view == "today"){
			//	Maybe in last 24 hours instead?
			//	Get current time and subtract 24 hours, etc
			$data["pageTitle"] = "Viewing all the posts that made been made today";
			$this->db->where("lastpost >= ".human_to_unix(gmdate("Y-m-d")." 12:00:00 AM"));
			$this->db->where("type","first");
			$this->db->order_by("lastpost","desc");
			$query = $this->db->get("posts");
			if($query->num_rows() > 0){
				$data["posts"] = $query->result();
			}
			else{
				$data["posts"] = "No posts have been made today!";
			}
		}*/
		elseif($view == "news"){
			$data["pageTitle"] = "Site news";
			$query = $this->db->get("news");
			$data["news"] = $query->result();
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
		elseif($view == "help"){
			$data["pageTitle"] = "Getting some help";
		}
		$data["yield"] = $this->load->view("themes/$data[theme]/$view",$data,true);
		$this->load->view("themes/$data[theme]/layout",$data);
	}	
	function process(){
		$sec = $this->uri->segment(3);
		// check to see if they are logged in
		if($this->loggedIn() == FALSE && $sec !== "login" && $sec !== "activate"){
			redirect("x/login");
		}
		// ok, they're cool.  Let them through
		if($sec == "reply"){
			$this->load->library("Textile");
			$this->load->library('validation');
			$rules["body"] = "required";
			$rules["forum"] = "required";
			$this->validation->set_error_delimiters(null,null);
			$this->validation->set_rules($rules);
			if ($this->validation->run() == FALSE){
				$this->setFlash("error",$this->validation->error_string);
				redirect("x/post/$forum");
			}
			$data = array(
				"title" => $this->urlToTitle($this->input->post("post")),
				"url" => $this->input->post("post"),
				"author" => $this->session->userdata("id"),
				"body" => $this->input->post("body"),
				"textile" => $this->textile->TextileThis($this->input->post("body")),
				"forum" => $this->input->post("forum"),
				"type" => "reply",
				"time" => now(),
				"lastpost" => now(),
				"origauthor" => $this->input->post("origauthor")
			);
			$this->db->insert("posts",$data);
			$this->db->where("url",$this->input->post("post"));
			$this->db->update("posts",array("lastpost" => now()));
			redirect("display/topic/".$this->input->post("post"));
		}
		if($sec == "login"){
			$user = $this->input->post("user");
			$pass = md5($this->input->post("pass"));
			$query = $this->db->get_where("users",array("name" => $user));
			if($query->num_rows() > 0){
				$info = $query->row();
				if($info->password == $pass){
					$this->load->helper("cookie");
					$this->session->set_userdata("id",$info->id);
					$this->session->set_userdata("name",$info->name);
					$this->session->set_userdata("group",$info->group);
					$this->session->set_userdata("timezone",$info->timezone);
					set_cookie("kleiblatt",$info->id.":".$info->password);
					$this->setFlash("message","Login successful");
					redirect("display/forums");
				}
				else{
					$this->setFlash("error","Invalid login");
					redirect("x/login");
				}
			}
			else{
				$this->setFlash("error","Invalid login");
				redirect("x/login");
			}
		}
		if($sec == "post"){
			$this->load->library("Textile");
			$this->load->library('validation');
			$rules["title"]	= "required";
			$rules["body"] = "required";
			$rules["forum"] = "required";
			$this->validation->set_error_delimiters(null,null);
			$this->validation->set_rules($rules);
			$title = $this->input->post("title");
			$body = $this->input->post("body");
			$forum = $this->input->post("forum");
			$url = url_title($title);
			$this->validation->set_fields($fields);
			if ($this->validation->run() == FALSE){
				$this->setFlash("error",$this->validation->error_string);
				redirect("x/post/$forum");
			}
			$query = $this->db->get_where("posts",array("url" => $url));
			if($query->num_rows() > 0){
				$url = $url."-".now();
			}
			$data = array(
				"title" => $title,
				"url" => $url,
				"author" => $this->session->userdata("id"),
				"body" => $body,
				"textile" => $this->textile->TextileThis($this->input->post("body")),
				"forum" => $forum,
				"type" => "first",
				"time" => now(),
				"lastpost" => now(),
				"origauthor" => $this->session->userdata("id")
			);
			$this->db->insert("posts",$data);
			$this->setFlash("message","Post created");
			redirect("display/forum/".$this->input->post("forum"));
		}
		if($sec == "edit"){
			$this->load->library("Textile");
			$this->load->library('validation');
			$body = $this->input->post("body");
			$rules["body"] = "required";
			$this->validation->set_rules($rules);
			$this->validation->set_error_delimiters(null,null);
			if ($this->validation->run() == FALSE){
				$this->setFlash("error",$this->validation->error_string);
				redirect("x/edit/".$this->input->post("id"));
			}
			$data = array(
				"body" => $body,
				"textile" => $this->textile->TextileThis($this->input->post("body")),
			);
			$this->db->where("url",$this->input->post("post"));
			$this->db->where("id",$this->input->post("id"));
			$this->db->update("posts",$data);
			$this->setFlash("message","Post edited");
			redirect("display/topic/".$this->input->post("post"));
		}
		if($sec == "delete"){
			if($this->loggedIn() == false){
				redirect();
			}
			$id = $this->uri->segment(4);
			$query = $this->db->get_where("posts",array("id" => $id));
			$data = $query->row();
			if($this->session->userdata("id") !== $data->author){
				redirect();
			}
			$forum = $data->forum;
			if($data->type == "reply"){
				$this->db->where("id",$id);
			}
			elseif($data->type == "first"){
				$this->db->where("url",$data->url);
			}
			$this->db->delete("posts");
			$this->setFlash("message","Post deleted");
			redirect("display/forum/".$forum);
		}
		if($sec == "invite"){
			$query = $this->db->get_where("users",array("id" => $this->session->userdata("id")));
			$result = $query->row();
			if($result->invites < 1){
				$this->setFlash("You don't have any invites");
				redirect("display/forums");
			}
			$this->load->library('validation');
			$email = $this->input->post("email");
			$name = $this->input->post("name");
			$rules["name"] = "required";
			$rules["email"] = "required";
			$this->validation->set_rules($rules);
			$this->validation->set_error_delimiters(null,null);
			if ($this->validation->run() == FALSE){
				$this->setFlash("error",$this->validation->error_string);
				redirect("x/invite");
			}
			else{
				$this->load->helper("email");
				if(!valid_email($email)){
					$this->setFlash("error","That isn't a valid email");
				}
				else{
					$this->load->library('email');
					$this->load->library('encrypt');
					$code = $this->encrypt->encode($this->session->userdata("name"));
					$message = "You have been invited to join cloverfaust.\r\n\r\nIf you accept, go to ".site_url("x/activate")." and enter this code: \r\n\r\n$code";
					$this->email->from('ditd@nothingconcept.com','cloverfaust');
					$this->email->to($email,$name);
					$this->email->subject('You have been invited to join cloverfaust');
					$this->email->message($message);
					$this->email->send();
					$this->setFlash("message","Thank you for inviting a person!");
					redirect("display/forums");
				}
			}
		}
		if($sec == "activate"){
			$this->load->library('encrypt');
			$decrypt = $this->encrypt->decode($code);
			$this->load->library('validation');
			$email = $this->input->post("email");
			$name = $this->input->post("name");
			$pass = $this->input->post("pass");
			$pass2 = $this->input->post("passdeux");
			$code = $this->input->post("code");
			$timezone = $this->input->post("timezones");
			$rules["email"] = "required|valid_email";
			$rules["name"] = "required";
			$rules["pass"] = "required|matches[pass]";
			$rules["passdeux"] = "required";
			$rules["code"] = "required";
			$this->validation->set_rules($rules);
			$this->validation->set_error_delimiters(null,null);
			if ($this->validation->run() == FALSE){
				$this->setFlash("error",$this->validation->error_string);
				redirect("x/activate");
			}
			else{
				$query = $this->db->get_where("users",array("name" => $decrypt));
				$result = $query->row();
				if($query->num_rows() > 0 && $name == $result->name || $email == $result->email){
					$this->setFlash("error","That username or email is already taken");
					redirect("x/activate");
				}
				$user = array(
					"name" => $name,
					"password" => md5($pass),
					"email" => $email,
					"timezone" => $timezone,
					"group" => 2,
					"invites" => 1
				);
				$this->db->where("name",$decrypt);
				$this->db->update("users",array("invites" => $result->invites-1));
				$this->db->insert("users",$user);
				$this->setFlash("message","You can now login with your chosen username and password");
				redirect("x/login");
			}
		}
		if($sec == "account"){
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
			$this->setFlash("message","Account details updated");
			redirect("display/forums");
		}
	}
	function loggedIn(){
		$id = $this->session->userdata("id");
		if(!empty($id)){
			return true;
		}
		else{
			return false;
		}
	}
	function doLogout(){
		$this->session->sess_destroy();
		redirect();
	}
	function getGroup(){
		return $this->session->userdata("group");
	}
	function setFlash($type,$message){
		if($type == "message"){
			$output = '<div class="message">'.$message.'</div>';
		}
		elseif($type == "error"){
			$output = '<div class="error">'.$message.'</div>';
		}
		$this->session->set_flashdata($type,$output);
	}
	function urlToTitle($url){
		$this->db->where("url",$url);
		$this->db->where("type","first");
		$query = $this->db->get("posts");
		$result = $query->row();
		return $result->title;
	}
	function getOption($opt){
		$this->db->cache_on();
		$query = $this->db->query("SELECT value FROM options WHERE `name` = '$opt'");
		$output = $query->row();
		$output = $output->value;
		return $output;
	}
}
?>