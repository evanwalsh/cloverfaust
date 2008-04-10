<?php
class Theme extends Model {
    function Theme(){
        parent::Model();
    }
	function numPosts($forum){
		$this->db->where("forum",$forum);
		$num = $this->db->count_all_results("posts");
		if($num > 1 || $num == 0){
			return $num." posts";
		}
		else{
			return $num." post";
		}
	}
	function numTopics($forum){
		$this->db->where("forum",$forum);
		$this->db->where("type","first");
		$num = $this->db->count_all_results("posts");
		if($num > 1 || $num == 0){
			return $num." topics";
		}
		else{
			return $num." topic";
		}
	}
	function numReplies($forum){
		$this->db->where("url",$forum);
		$this->db->where("type","reply");
		$count = $this->db->count_all_results("posts");
		if($count > 1 || $count == 0){
			return $count." replies";
		}
		else{
			return $count." reply";
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
	function adminLinks($id,$author){
		if($this->klei->getGroup() == 1 && $this->session->userdata("id") == $author || $this->session->userdata("id") == $author){
			return '<div class="adminlinks">'.anchor("x/process/delete/".$id,"Delete",array("class" => "deletelink","id" => "delete$id"))." ~ ".anchor("x/edit/".$id,"Edit",array("class" => "editlink","id" => "edit$id"))."</div>";
		}
	}
}
?>