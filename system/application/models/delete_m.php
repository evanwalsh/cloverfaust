if($this->loggedIn() == false){
	redirect();
}
$id = $this->uri->segment(4);
$query = $this->db->get_where("posts",array("id" => $id));
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
$this->setFlash("message","Post deleted");
redirect("display/forum/".$forum);