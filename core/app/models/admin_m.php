<?php
class Admin_m extends Model {
	function Admin_m(){
		parent::model();
	}
	function yield($view){
		$this->load->library("Spyc");
		$info = $this->spyc->load("config.php");
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
		if($view == "create"){
			$opt = $this->uri->segment(3);
			if($opt == "forum"){
				$view = "newforum";
				$data["pageTitle"] = "New forum";
			}
			else{
				redirect("admin");
			}
		}
		if($view == "options"){
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
			$data["pageTitle"] = "Options";
			$data["siteTheme"] = $info["site"]["theme"];
		}
		if($view == "forums"){
			$this->load->model("theme");
			$data["forums"] = $info["forums"];
			$data["pageTitle"] = "Forums";
		}
		$data["yield"] = $this->load->view("admin/$view",$data,true);
		$this->load->view("admin/layout",$data);
	}
	function options(){
		$config = $this->getConfig();
		$config["site"]["name"] = $this->input->post("name");
		$config["site"]["subtitle"] = $this->input->post("subtitle");
		$config["site"]["theme"] = $this->input->post("theme");
		$done = $this->spyc->dump($config,4);
		$handle = fopen("config.php","w");
		$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
		fwrite($handle,$output);
		fclose($handle);
		$this->common->setFlash("message","Options saved");
		redirect("admin/options");
	}
	function getConfig(){
		$this->load->library("Spyc");
		return $this->spyc->load("config.php");
	}
	function getThemes(){
		// Gets all of the theme directories
		$this->load->helper('directory');
		$map = directory_map('views/themes', TRUE);
		foreach($map as $theme){
			$themes[$theme] = $theme;
		}
		return $themes;
	}
}
?>