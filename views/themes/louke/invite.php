<?=form_open("x/process/invite")?>
	<p><?=form_label("Enter the name of the person you want to invite")?></p>
	<p><?=form_input("name")?></p>
	<p><?=form_label("Enter their email address, too")?></p>
	<p><?=form_input("email")?></p>
	<?=form_submit("","Invite")?>
<?=form_close()?>