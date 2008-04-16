<?php
class Delete_m extends Model {
	function Delete_m(){
		parent::model();
	}
	function post(){
		$id = $this->uri->segment(3);
		if($this->loggedIn() == false || $){
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
}
?>