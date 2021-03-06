<?php
class Theme extends Model {
    function Theme(){
        parent::Model();
    }
	function postStats($forum,$type,$single = false,$plural = false){
		if($type == "allposts"){
			$this->db->where("forum",$forum);
			if(empty($single)){
				$single = "post";
			}
			if(empty($plural)){
				$plural = "posts";
			}
		}
		if($type == "topics"){
			$this->db->where("forum",$forum);
			$this->db->where("type","first");
			if(empty($single)){
				$single = "topic";
			}
			if(empty($plural)){
				$plural = "topics";
			}
		}
		if($type == "replies"){
			$this->db->where("url",$forum);
			$this->db->where("type","reply");
			if(empty($single)){
				$single = "reply";
			}
			if(empty($plural)){
				$plural = "replies";
			}
		}
		$num = $this->db->count_all_results("posts");
		if($num > 1 || $num == 0){
			return $num." ".$plural;
		}
		else{
			return $num." ".$single;
		}
	}
	function postLink($id,$author,$type,$text = false,$before = false,$after = false){
		if(empty($text)){
			$text = ucwords($type);
		}
		if($this->common->getGroup() == 1 || $this->session->userdata("id") == $author){
			$output = $before;
			$output .= anchor("$type/post/".$id,$text,array("class" => $type."link","id" => $type."$id"));
			$output .= $after;
			return $output;
		}
	}
	function getAuthor($id){
		$this->db->where("id",$id);
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			$output = $query->row();
		}
		else{
			$output->name = '<span style="color:red">author not found</span>';
		}
		return $output->name;
	}
	function postDate($time,$format = "%M %d %Y %h:%i%a"){
		$timezone = $this->session->userdata("timezone");
		if(empty($timezone)){
			$timezone = "UTC";
		}
		return mdate($format,gmt_to_local($time,$timezone));
	}
}
?>