<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugins{
	function init($ci){
		$this->ci = $ci;
	}
	function addHooks($hooks){
		if(is_array($hooks)){
			foreach($hooks as $hook){
				$this->hooks[$hook] = '';
			}
		}
		else{
			$this->hooks[$hook] = '';
		}
	}
	function getHooks(){
		return $this->hooks;
	}
	function setHook($hook,$function){
		if(empty($this->hooks[$hook])){
			$this->hooks[$hook] = $function;
		}
		else{
			$this->hooks[$hook] = explode("|",$this->hooks[$hook]);
			$this->hooks[$hook][] = $function;
			$this->hooks[$hook] = implode("|",$this->hooks[$hook]);
		}
	}
	function loadPlugins($plugins){
		if(is_array($plugins)){
			$sys = $this->ci;
			$plugins = array_unique($plugins);
			foreach($plugins as $plugin){
				require("plugins/$plugin/plugin.php");
			}
			return true;
		}
		else{
			return false;
		}
	}
	function runHook($hook){
		if(is_array($this->hooks[$hook])){
			$hooks = explode(",",$this->hooks[$hook]);
			foreach($hooks as $hook){
				$hook();
			}
			return true;
		}
		else{
			return false;
		}
	}
	function hooksExist($hook){
		$hooks = $this->hooks;
		if(!empty($hooks[$hook])){
			return true;
		}
		else{
			return false;
		}
	}
}

?>