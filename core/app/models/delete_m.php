<?php
class Delete_m extends Model {
	function Delete_m(){
		parent::model();
	}
	function post(){
		$id = $this->uri->segment(3);
		if($this->common->loggedIn() == false){
			redirect();
		}
		else{
			$query = $this->db->get_where("posts",array("id" => $id));
			if($query->num_rows() < 0){
				redirect();
			}
			else{
				$data = $query->row();
				if($this->session->userdata("id") !== $data->author){
					redirect();
				}
				$forum = $data->forum;
				if($data->type == "reply"){
					$this->db->where("id",$id);
				}
				elseif($data->type == "first"){
					$this->db->where("url",$data->url);
				}
				$this->db->delete("posts");
				$this->common->setFlash("message","Post deleted");
				redirect("show/forum/".$forum);
			}
		}
	}
	function forum(){
		if($this->common->getGroup() == "1"){
			$id = $this->uri->segment(3);
			if(empty($id)){
				redirect("admin");
			}
			else{
				$config = $this->common->getConfig();
				foreach($config["forums"] as $key => $val){
					$parts = explode("@",$val);
					if($parts[1] == $id){
						$name = $parts[0];
						unset($config["forums"][$key]);
					}
				}
				$config["forums"] = array_unique($config["forums"]);
				$done = $this->spyc->dump($config,4);
				$handle = fopen("config.php","w");
				$output = "<?php if(!defined('BASEPATH'))exit();?>\n$done";
				fwrite($handle,$output);
				fclose($handle);
				$this->db->where("forum",$id);
				$this->db->delete("posts");
				$this->common->setFlash("message","$name, and all its posts, deleted");
				redirect("admin/forums");
			}
		}
		else{
			redirect();
		}
	}
	function user(){
		if($this->common->getGroup() == "1"){
			$sec = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			if(empty($id)){
				redirect("admin");
			}
			else{
				$this->db->where("id",$id);
				$this->db->delete("users");
				$this->db->where("author",$id);
				$this->db->delete("posts");
				redirect("admin/users");
			}
		}
		else{
			redirect();
		}
	}
}
?>