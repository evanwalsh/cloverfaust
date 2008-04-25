<?php
class Backend extends Controller {
	function Backend(){
		parent::controller();
		$this->load->model("backend_m","m");
	}
	function login(){
		$this->m->login();
	}
	function logout(){
		$this->m->logout();
	}
	function nocache(){
		$this->db->cache_delete_all();
	}
}
?>