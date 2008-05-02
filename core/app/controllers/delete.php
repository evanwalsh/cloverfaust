<?php
class Delete extends Controller {
	function Delete(){
		parent::controller();
		$this->load->model("delete_m","m");
	}
	function index(){
		redirect();
	}
	function post(){
		$this->m->post();
	}
	function forum(){
		$this->m->forum();
	}
}
?>