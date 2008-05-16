<?php

class Install_hook {
	function go($base){
		$base = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], "index.php"));
		if(!file_exists("config.php") && strpos($_SERVER['REQUEST_URI'],"/install/") == false){
			header("Location: ".$base."index.php/install/main");
		}
		elseif(file_exists("config.php") && strpos($_SERVER['REQUEST_URI'],"/install/") == true && strpos($_SERVER['REQUEST_URI'],"/install/done") == false){
			header("Location: ".$base."home");
		}
	}
}

?>