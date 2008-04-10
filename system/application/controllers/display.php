<?php
class Display extends Controller {
	function Display(){
		parent::Controller();
		$this->load->model("main","klei");
	}
	function index(){
		redirect("display/home");
	}
	function home(){
		$this->klei->yield("home");
	}
	function forums(){
		$this->klei->yield("forums");
	}
	function forum(){
		$this->klei->yield("forum");
	}
	function topic(){
		$this->klei->yield("post");
	}
	function news(){
		$this->klei->yield("news");
	}
	function help(){
		$this->klei->yield("help");
	}
}
?>