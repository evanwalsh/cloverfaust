<?php
class Admin extends Controller {
	function Admin(){
		parent::Controller();
		$this->load->model("main","klei");
		$this->load->model("backend");
		$this->load->model("theme");
	}
	function index(){
		redirect("admin/main");
	}
	function main(){
		$this->backend->yield("main");
	}
	function forums(){
		$this->backend->yield("forums");
	}
	function users(){
		$this->backend->yield("users");
	}
	function edit(){
		$this->backend->yield("edit");
	}
	function delete(){
		$this->backend->delete();
	}
	function process(){
		$this->backend->process();
	}
	function create(){
		$this->backend->yield("create");
	}
}
?>