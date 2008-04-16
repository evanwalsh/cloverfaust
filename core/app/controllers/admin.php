<?php
class Admin extends Controller {
	function Admin(){
		parent::Controller();
		$this->load->model("admin_m","m");
	}
	function index(){
		redirect("admin/home");
	}
	function home(){
		$this->m->yield("main");
	}
	function forums(){
		$this->m->yield("forums");
	}
	function users(){
		$this->m->yield("users");
	}
	function create(){
		if(empty($_POST)){
			$this->m->yield("create");
		}
		else{
			$this->m->create();
		}
	}
	function delete(){
		if(empty($_POST)){
			$this->m->yield("create");
		}
		else{
			$this->m->create();
		}
	}
	function edit(){
		$this->m->edit();
	}
	function user(){
		$this->m->yield("user");
	}
	function forum(){
		$this->m->yield("forum");
	}
}
?>