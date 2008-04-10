<?=form_open("admin/process/forum")?>
	<p><?=form_label("Name")?></p>
	<p><?=form_input("newname",$forum->name)?></p>
	<?=form_hidden("oldname",$forum->name)?>
	<p><?=form_submit("","Save")?></p>
<?=form_close()?>