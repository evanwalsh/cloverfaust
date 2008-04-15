<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info...
|
*/

$hook['pre_controller'] = array(
	'class' => 'Install_hook',
	'function' => 'go',
	'filename' => 'Install_hook.php',
	'filepath' => 'hooks'
);

?>