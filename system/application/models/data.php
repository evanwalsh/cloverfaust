<?php
class Data extends Model {
    function Data(){
        parent::Model();
    }
	function getData(){
		$type = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		if(empty($id)){
			$this->klei->setFlash("error","No ID argument given to API");
			redirect("display/forums");
		}
		$part = explode(":",$type);
		if(array_key_exists("1",$part) == false){
			$this->klei->setFlash("error","No API output type given");
			redirect("display/forums");
		}
		if($part[0] == "post" && $part[1] == "json"){
			$this->db->where("id",$id);
			$query = $this->db->get("posts");
			if($query->num_rows() > 0){
				$this->load->library("json");
				$output = json_encode($query->row());
				echo $output;
			}
			else{
				echo '{"id":"0","title":"Error","body":"Post not found","textile":"Post not found"}';
			}
		} // end post:json
		elseif($part[0] == "post" && $part[1] == "xml"){
			$this->db->where("id",$id);
			$query = $this->db->get("posts");
			if($query->num_rows() > 0){
				header("Content-Type: application/xml; charset=utf-8");
				$data = $query->row();
				$data->author = $this->theme->getAuthor($data->author);
				$this->load->view("api/postxml",$data);
			}
		} // end post:xml
		elseif($part[0] == "topic" && $part[1] == "json"){
			$this->db->where("url",$id);
			$query = $this->db->get("posts");
			if($query->num_rows() > 0){
				$this->load->library("json");
				$output = json_encode($query->result());
				echo $output;
			}
			else{
				echo '{"id":"0","title":"Error","body":"Topic not found","textile":"Post not found"}';
			}
		} // end topic:json
		elseif($part[0] == "topic" && $part[1] == "xml"){
			$this->db->where("url",$id);
			$query = $this->db->get("posts");
			if($query->num_rows() > 0){
				header("Content-Type: application/xml; charset=utf-8");
				$data["posts"] = $query->result();
				$this->load->view("api/topicxml",$data);
			}
		} // end topic:xml
		elseif($part[0] == "user" && $part[1] == "json"){
			$this->db->where("author",$this->idToAuthor($id));
			$query = $this->db->get("posts",20);
			if($query->num_rows() > 0){
				$this->load->library("json");
				$output = json_encode($query->result());
				echo $output;
			}
			else{
				echo '{"id":"0","title":"Error","body":"No posts found","textile":"No posts found"}';
			}
		} // end user:json
		elseif($part[0] == "user" && $part[1] == "xml"){
			$this->db->where("author",$this->idToAuthor($id));
			$query = $this->db->get("posts",20);
			if($query->num_rows() > 0){
				header("Content-Type: application/xml; charset=utf-8");
				$data["posts"] = $query->result();
				$this->load->view("api/topicxml",$data);
			}
		}
		elseif($part[0] == "user" && $part[1] == "check"){
			$this->db->where("name",$id);
			$query = $this->db->get("users");
			if($query->num_rows() > 0){
				echo "Username already taken!";
			}
			else{
				echo "Username available!";
			}
		}
		else{
			$this->klei->setFlash("error","No API arguments given");
			redirect("display/forums");
		}
	}
	function yield(){
		$view = $this->uri->segment(3);
		$offset = $this->uri->segment(4);
		if($offset < 0){
			$offset = 0;
		}
		if($view == "recentreplies"){
			$this->load->helper("text");
			$this->db->where("author",$this->session->userdata("id"));
			$this->db->where("type","first");
			$get = $this->db->get("posts");
			if($get->num_rows() > 0){
				$posts = $get->result();
				$this->db->order_by("id","desc");
				$this->db->where("author !=",$this->session->userdata("id"));
				$this->db->where("origauthor",$this->session->userdata("id"));
				$this->db->where("type","reply");
				$query = $this->db->get("posts",5,$offset);
				if($query->num_rows() > 0 && $offset < 100){
					$data["posts"] = $query->result();
				}
				else{
					$data["posts"] = "There aren't any more recent replies to your topics";
				}
			}
			else{
				$data["posts"] = "You haven't posted any topics yet!";
			}
		}
		if($view == "recentposts"){
			$this->load->helper("text");
			$this->db->order_by("id","desc");
			$this->db->where("author !=",$this->session->userdata("id"));
			$query = $this->db->get("posts",5,$offset);
			if($query->num_rows() > 0 && $offset !== 100){
				$data["posts"] = $query->result();
			}
			else{
				$data["posts"] = "There aren't any more posts!";
			}
		}
		$this->load->view("api/$view",$data);
	}
	function process(){
		$type = $this->uri->segment(3);
		if($type == "edit"){
			$this->load->library("Textile");
			echo $this->textile->TextileThis($this->input->post("body"));
		}
	}
	function idToAuthor($id){
		$this->db->where("name",$id);
		$query = $this->db->get("users");
		if($query->num_rows() > 0){
			$output = $query->row();
		}
		else{
			$output->id = 0;
		}
		return $output->id;
	}
}
?>