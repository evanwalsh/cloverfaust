<?=form_open("edit/forum/".$this->uri->segment(4))?>
	<h3>Forum name</h3>
	<?=form_input("newname",$forum)?>
	<?=form_hidden("oldname",$forum)?>
	<?=form_submit("","Edit")?>
<?=form_close()?>

<?=anchor("delete/forum/".$url,"Delete this forum",array("id" => "deleteforum","class" => "adminlink"))?>