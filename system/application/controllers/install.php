<?php
class Install extends Controller {
	function Install(){
		parent::Controller();
	}
	function index(){
		redirect("install/main");
	}
	function main(){
		$this->load->view("install/main");
	}
	function one(){
		$this->load->library("Spyc");
		$config["site"]["name"] = $this->input->post("name");
		$config["site"]["subtitle"] = $this->input->post("subtitle");
		$config["site"]["theme"] = "default";
		$config["database"]["host"] = $this->input->post("dbhost");
		$config["database"]["user"] = $this->input->post("dbuser");
		$config["database"]["pass"] = $this->input->post("dbpass");
		$config["database"]["db"] = $this->input->post("db");
		$config["database"]["prefix"] = $this->input->post("dbprefix");
		$config["forums"][$this->input->post("forum")] = url_title($this->input->post("forum"));
		$done = $this->spyc->dump($config,4);
		$handle = fopen("config.sample.php","w");
		$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
		fwrite($handle,$output);
		fclose($handle);
		echo "Hey, we're done";
	}
}
?>