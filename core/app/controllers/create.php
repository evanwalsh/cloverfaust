<?php
class Create extends Controller {
    function Create(){
        parent::Controller();
		$this->load->model("create_m","m");
    }
	function index(){
		redirect();
	}
	function topic(){
		if(empty($_POST)){
			$this->common->yield("post","user");
		}
		else{
			$this->m->topic();
		}
	}
	function reply(){
		if(empty($_POST)){
			$this->common->yield("reply","user");
		}
		else{
			$this->m->reply();
		}
	}
	function forum(){
		$this->m->forum();
	}
}
?>