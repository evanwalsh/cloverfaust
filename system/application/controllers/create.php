<?php
class Create extends Controller {
    function Create(){
        parent::Controller();
		//$this->output->enable_profiler(true);
		$this->load->model("create_m","m");
    }
	function index(){
		redirect();
	}
	function topic(){
		if(empty($_POST)){
			$this->common->yield("post");
		}
		else{
			$this->m->topic();
		}
	}
	function reply(){
		if(empty($_POST)){
			$this->common->yield("reply");
		}
		else{
			$this->m->reply();
		}
	}
}
?>