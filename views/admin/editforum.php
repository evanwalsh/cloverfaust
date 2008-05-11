<?=anchor("delete/forum/".$url,"Delete this forum",array("id" => "deleteforum","class" => "adminlink"))?>

<?=form_open("edit/forum/".$this->uri->segment(4))?>
	<ul>
		<li>
			<h3>Forum name</h3>
			<?=form_input("newname",$forum)?>
		</li>
		<?=form_hidden("oldname",$forum)?>
		<li>
			<?=form_submit("","Edit")?>
		</li>
<?=form_close()?>