<?php
class Admin extends Controller {
	function Admin(){
		parent::Controller();
		$this->load->model("admin_m","m");
	}
	function index(){
		redirect("admin/main");
	}
	function main(){
		$this->m->yield("main");
	}
	function forums(){
		$this->m->yield("forums");
	}
	function users(){
		$this->m->yield("users");
	}
	function edit(){
		$this->m->yield("edit");
	}
	function delete(){
		$this->m->delete();
	}
	function process(){
		$this->m->process();
	}
	function create(){
		$this->m->yield("create");
	}
}
?>