<?=form_open("admin/process/user")?>
	<p><?=form_label("Username")?></p>
	<p><?=form_input("user",$user->name)?></p>
	<p><?=form_label("Email")?></p>
	<p><?=form_input("email",$user->email)?></p>
	<p><?=form_label("New password")?></p>
	<p><?=form_input("newpass")?></p>
	<p><?=form_label("User group")?></p>
	<p><?=form_dropdown("group",array("1" => "Admin","2" => "Member"),$user->group)?></p>
	<p><?=form_label("Invites")?></p>
	<p><?=form_input("invites",$user->invites)?></p>
	<?=form_hidden("id",$user->id)?>
	<p><?=form_submit("","Save")?></p>
<?=form_close()?>