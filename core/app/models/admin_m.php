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
		$data["pageTitle"] = "Admin";
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
		$data["yield"] = $this->load->view("admin/$view",$data,true);
		$this->load->view("admin/layout",$data);
	}
}
?>