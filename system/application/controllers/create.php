<?php
class Create extends Controller {
    function Create(){
        parent::Controller();
		//$this->output->enable_profiler(true);
		$this->load->model("create_m","create");
    }
	function index(){
		redirect();
	}
	function topic(){
		if(empty($_POST)){
			$this->common->yield("post");
		}
	}
	function reply(){
		
	}
	function user(){
		
	}
	function forum(){
		
	}
}
?>