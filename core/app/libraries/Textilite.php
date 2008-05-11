<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class TextiLite{
	
	/*
		TextiLite:
			A lightweight version of Textile built with PHP by Evan Walsh
			Version 001

		Based on the work of:
			http://codeigniter.com/wiki/BBCode_Helper/
			http://codeigniter.com/forums/viewthread/69615/
			
		Supports:
			<br/> by the way of newline
			*Text* => <strong>Text</strong>
			_Text_ => <em>Text</em>
			!http://image.url! => <img src="http://image.url"/>
			"Text":http://text.url => <a href="http://text.url" title="Text">Text</a>
	*/

	function paragraph($text){
		$paragraphs = explode("\n\n", $text);
		$output = null;
		foreach($paragraphs as $paragraph) {
			$output .= "\n<p>".$paragraph."</p>\n";
		}
		return $output;
	}

	function textile($text = null){
		$regex = array(
			'/(.+)\n(.+)/',
			'/\*([^\*]+)\*/',
			'/\_([^\*]+)\_/',
			'/(!)((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))(!)/',
			'/(")(.*?)(").*?((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))/', 
		); 
		$replace = array(
			"$1<br/>$2",
			"<strong>$1</strong>",
			"<em>$1</em>",
			"<img src=\"$2\"/>",
			"<a href=\"$4\" title=\"$2\">$2</a>",
		); 
		return preg_replace($regex,$replace,$text);
	}
	
	function process($text){
		$text = strip_tags($text);
		$text = $this->paragraph($text);
		$text = $this->textile($text);
		return $text;
	}

}

?>