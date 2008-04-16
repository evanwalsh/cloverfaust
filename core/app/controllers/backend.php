<?php
class Backend extends Controller {
	function Backend(){
		parent::controller();
		$this->load->model("backend_m","m");
	}
	function login(){
		$this->m->login();
	}
	function logout(){
		$this->m->logout();
	}
	function themes(){
		$this->load->library("Spyc");
		$info = $this->spyc->load("views/themes/default/theme.yml");
		$themes = $this->m->getThemes();
		foreach($themes as $theme){
			$info = $this->spyc->load("views/themes/$theme/theme.yml");
			print_r($info);
		}
	}
}
?>