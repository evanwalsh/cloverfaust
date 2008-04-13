<?php
class Show extends Controller {
	function Show(){
		parent::Controller();
	}
	function index(){
		redirect("show/home");
	}
	function home(){
		$this->common->yield("home");
	}
	function forums(){
		$this->common->yield("forums");
	}
	function forum(){
		$this->common->yield("forum");
	}
	function topic(){
		$this->common->yield("topic");
	}
	function account(){
		$this->common->yield("account");
	}
	function options(){
		$this->common->yield("options");
	}
	function help(){
		$this->common->yield("help");
	}
	function login(){
		$this->common->yield("login");
	}
}
?>