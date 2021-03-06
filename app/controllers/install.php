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
	function go(){
		$this->load->library("Spyc");
		$this->load->library("validation");
		$rules['name'] = "required";
		$rules['subtitle'] = "required";
		$rules['dbhost'] = "required";
		$rules['dbuser'] = "required";
		$rules['dbpass'] = "required";
		$rules['db'] = "required";
		$rules['user'] = "required";
		$rules['pass'] = "required";
		$rules['email'] = "required";
		$this->validation->set_rules($rules);
		if($this->validation->run() == FALSE){
			$this->load->view("install/main");
		}
		else{
			$this->load->helper("string");
			$config["site"]["name"] = $this->input->post("name");
			$config["site"]["subtitle"] = $this->input->post("subtitle");
			$config["site"]["theme"] = "light";
			$config["site"]["per-page"] = 10;
			$config["site"]["encryption-key"] = random_string('unique');
			$config["database"]["host"] = $this->input->post("dbhost");
			$config["database"]["user"] = $this->input->post("dbuser");
			$config["database"]["pass"] = $this->input->post("dbpass");
			$config["database"]["db"] = $this->input->post("db");
			$config["database"]["prefix"] = $this->input->post("dbprefix");
			$config["forums"][] = "My Forum@".url_title("My forum");
			$done = $this->spyc->dump($config,4);
			$handle = fopen("config.php","w");
			$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
			fwrite($handle,$output);
			fclose($handle);
			$handle = fopen(".htaccess","w");
			$output = "RewriteEngine on
			RewriteCond $1 !^(index\.php|robots\.txt|favicon\.ico|views)
			RewriteRule ^(.*)$ index.php/$1 [L,QSA]";
			fwrite($handle,$output);
			fclose($handle);
			sleep(2); // The file won't write without this
			$user = array(
				"name" => $this->input->post("user"),
				"password" => md5($this->input->post("pass")),
				"email" => $this->input->post("email"),
				"group" => "1",
				"timezone" => $this->input->post("timezones"),
				"editor" => "textile"
			);
			$postTable = 'CREATE TABLE IF NOT EXISTS `'.$this->input->post("dbprefix").'posts` (
			  `id` int(11) NOT NULL auto_increment,
			  `title` varchar(500) NOT NULL,
			  `url` varchar(500) NOT NULL,
			  `author` int(11) NOT NULL,
			  `body` text NOT NULL,
			  `conv_body` text NOT NULL,
			  `forum` varchar(500) NOT NULL,
			  `type` varchar(500) NOT NULL,
			  `time` varchar(500) NOT NULL,
			  `lastpost` varchar(500) NOT NULL,
			  `origauthor` int(11) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1;';
			$userTable = 'CREATE TABLE IF NOT EXISTS `'.$this->input->post("dbprefix").'users` (
			  `id` int(11) NOT NULL auto_increment,
			  `name` varchar(500) NOT NULL,
			  `password` varchar(500) NOT NULL,
			  `email` varchar(500) NOT NULL,
			  `group` int(11) NOT NULL,
			  `timezone` varchar(500) NOT NULL,
			  `editor` varchar(500) NOT NULL,
			  PRIMARY KEY  (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1;';
			$this->load->database();
			$this->db->query($postTable);
			$this->db->query($userTable);
			$this->db->insert("users",$user);
			redirect("install/done");
		}
	}
	function done(){
		$this->load->view("install/done");
	}
}
?>