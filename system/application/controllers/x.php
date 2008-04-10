<?php
class X extends Controller {
	function X(){
		parent::Controller();
		$this->load->model("main","klei");
	}
	function index(){
		redirect();
	}
	function login(){
		$this->klei->yield("login");
	}
	function logout(){
		$this->klei->doLogout();
	}
	function edit(){
		$this->klei->yield("edit");
	}
	function account(){
		$this->klei->yield("account");
	}
	function post(){
		$this->klei->yield("newpost");
	}
	function reply(){
		$this->klei->yield("reply");
	}
	function process(){
		$this->klei->process();
	}
	function invite(){
		$this->klei->yield("invite");
	}
	function activate(){
		$this->klei->yield("activate");
	}
	function search(){
		$this->klei->yield("search");
	}
	/*function zip(){
		$this->load->library('zip');
		$this->zip->read_dir(PUBPATH); 
		$this->zip->download("backup.zip");
		echo "Backup......done";
	}*/
}
?>