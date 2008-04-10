<?php
class Api extends Controller {
	function Api(){
		parent::Controller();
		$this->load->model("main","klei");
		$this->load->model("data","api");
	}
	function index(){
		redirect();
	}
	function get(){
		$this->api->getData();
	}
	function process(){
		$this->api->process();
	}
	function home(){
		$this->api->yield();
	}
}
?>