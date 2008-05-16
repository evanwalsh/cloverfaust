<?php
class Admin_m extends Model {
	function Admin_m(){
		parent::model();
	}
	function yield($view){
		/*
		   Function: yield
		      See <common.php> for the same sort of thing
		*/
		if($this->common->getGroup() !== "1"){
			redirect("home");
		}
		else{
			$info = $this->common->getConfig();
			$data["siteName"] = $info["site"]["name"];
			$data["siteSubtitle"] = $info["site"]["subtitle"];
			$data["theme"] = $info["site"]["theme"];
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
			$opt = $this->uri->segment(3);
			if($view == "home"){
				$data["pageTitle"] = "Home";
			}
			elseif($view == "create"){
				if($opt == "forum"){
					$view = "newforum";
					$data["pageTitle"] = "New forum";
				}
				elseif($opt == "user"){
					$view = "newuser";
					$data["pageTitle"] = "New user";
				}
				else{
					redirect("admin");
				}
			}
			elseif($view == "edit"){
				if($opt == "forum"){
					$url = $this->uri->segment(4);
					if(!empty($url)){
						$view = "editforum";
						foreach($info["forums"] as $forum){
							$parts = explode("@",$forum);
							if($parts[1] == $url){
								$data["forum"] = $parts[0];
								$data["url"] = $parts[1];
							}
						}
						$data["pageTitle"] = "Edit forum: $data[forum]";
					}
					else{
						$this->common->setFlash("error","Forum not found");
						redirect("admin/forums");
					}
				}
				elseif($opt == "user"){
					$view = "edituser";
					$query = $this->db->get_where("users",array("id" => $this->uri->segment(4)));
					if($query->num_rows() > 0){
						$data["user"] = $query->row();
						$data["pageTitle"] = "Edit user: ".$data["user"]->name;
					}
					else{
						$this->common->setFlash("error","User not found");
						redirect("admin/users");
					}
				}
				else{
					redirect("admin/home");
				}
			}
			elseif($view == "options"){
				$data["perPage"] = $info["site"]["per-page"];
				$data["allowedTags"] = $info["site"]["allowed-tags"];
				$data["themes"] = $themes;
				$data["pageTitle"] = "Options";
			}
			elseif($view == "forums"){
				$this->load->model("theme");
				foreach($info["forums"] as $forum){
					$parts = explode("@",$forum);
					$forums[$parts[0]] = $parts[1];
				}
				$data["forums"] = $forums;
				$data["pageTitle"] = "Forums";
			}
			elseif($view == "users"){
				$offset = $this->uri->segment(3);
				if($offset < 0 || empty($offset)){
					$offset = 0;
				}
				$countq = $this->db->get("users");
				$count = $countq->num_rows();
				$this->load->library('pagination');
				$config['base_url'] = base_url()."admin/users";
				$config['total_rows'] = $count;
				$config['uri_segment'] = "3";
				$config['per_page'] = $info["site"]["per-page"];
				$config['num_links'] = "3";
				$this->pagination->initialize($config);
				$this->db->order_by("id","desc");
				$query = $this->db->get("users",$info["site"]["per-page"],$offset);
				$data["users"] = $query->result();
				$data["pageTitle"] = "Users";
			}
			elseif($view == "themes"){
				$themes = $this->getThemes();
				foreach($themes as $theme){
					$yaml = $this->spyc->load("views/themes/$theme/info.yml");
					$needed = array("name","author","version","description");
					foreach($needed as $need){
						if(empty($yaml[$need])){
							$yaml[$need] = "(unknown)";
						}
					}
					unset($yaml["database"]);
					unset($yaml["forums"]);
					$themes[$theme] = $yaml;
				}
				$data["themes"] = $themes;
				$data["pageTitle"] = "Themes";
				$data["siteTheme"] = $info["site"]["theme"];
			}
			$data["yield"] = $this->load->view("admin/$view",$data,true);
			$this->load->view("admin/layout",$data);
		}
	}
	function options(){
		if($this->common->getGroup() !== "1"){
			redirect("home");
		}
		else{
			$config = $this->common->getConfig();
			$opt = $this->uri->segment(3);
			if($opt == null){
				$config["site"]["name"] = $this->input->post("name");
				$config["site"]["subtitle"] = $this->input->post("subtitle");
				$config["site"]["per-page"] = $this->input->post("per-page");
				$config["forums"] = array_unique($config["forums"]);
				$done = $this->spyc->dump($config,4);
				$handle = fopen("config.php","w");
				$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
				fwrite($handle,$output);
				fclose($handle);
				$this->common->setFlash("message","Options saved");
				redirect("admin/options");
			}
			elseif($opt == "forum"){
				foreach($_POST as $key => $val){
					$parts = explode("_",$key);
					if($parts[0] == "forum"){
						$forums[] = $val."@".$parts[1];
					}
				}
				$config["forums"] = $forums;
				$done = $this->spyc->dump($config,4);
				$handle = fopen("config.php","w");
				$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
				fwrite($handle,$output);
				fclose($handle);
				$this->common->setFlash("message","Forum order saved");
				redirect("admin/forums");
			}
		}
	}
	function themeChange(){
		if($this->common->getGroup() !== "1"){
			redirect("home");
		}
		else{
			$theme = $this->uri->segment(3);
			$config = $this->common->getConfig();
			$config["site"]["theme"] = $theme;
			$config["forums"] = array_unique($config["forums"]);
			$done = $this->spyc->dump($config,4);
			$handle = fopen("config.php","w");
			$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
			fwrite($handle,$output);
			fclose($handle);
			$this->common->setFlash("message","Theme changed");
			redirect("admin/themes");
		}
	}
	function install(){
		if($this->common->getGroup() !== "1"){
			redirect("admin/themes");
		}
		else{
			$opt = $this->uri->segment(3);
			if($opt == "theme"){
				$config['upload_path'] = "./views/themes/";
				$config['allowed_types'] = "zip";
				$config['max_size']	= "300000";
				$this->load->library('upload',$config);
				$this->upload->do_upload("file");
				$data = $this->upload->data();
				$this->load->library("unzip");
				$config['fileName']  = $data["full_path"];
				$config['targetDir'] = "./views/themes/"; 
				$this->unzip->initialize($config);
				$this->unzip->unzipAll();
				unlink($data["full_path"]);
				$this->common->setFlash("message","New theme installed");
				redirect("admin/themes");
			}
			else{
				redirect("admin/home");
			}
		}
	}
	function getThemes(){
		/*
		   Function: getThemes
		      Gets all the currently installed themes and puts them in an array

		   Returns:
		      An array with all the themes in them
		*/
		// Gets all of the theme directories
		$this->load->helper('directory');
		$map = directory_map('views/themes', TRUE);
		foreach($map as $theme){
			if($theme !== "__MACOSX"){
				$themes[$theme] = $theme;
			}
		}
		return $themes;
	}
	function deleteR($dirname){
		if(is_dir($dirname)){
			$dir_handle = opendir($dirname);
		}
		while($file = readdir($dir_handle)){ 
			if($file !== "." && $file !== ".."){ 
				if(!is_dir($dirname."/".$file)){
					unlink($dirname."/".$file); 
				}
				else{
					deleteR($dirname."/".$file);
				}
			} 
		} 
		closedir($dir_handle); 
		rmdir($dirname);
	}
}
?>