<?php
class Edit extends Controller {
	function Edit(){
		parent::Controller();
		$this->load->model("edit_m","m");
	}
	function index(){
		redirect();
	}
	function post(){
		if(empty($_POST)){
			$this->common->yield("edit","user");
		}
		else{
			$this->m->post();
		}
	}
	function account(){
		$this->m->account();
	}
	function forum(){
		$this->m->forum();
	}
	function user(){
		$this->m->user();
	}
}
?>