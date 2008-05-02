<?=form_open_multipart("edit/account")?>
	<p><?=form_label("Your new password")?></p>
	<p><?=form_password("newpass")?></p>
	<p><?=form_label("Your new password (again)")?></p>
	<p><?=form_password("newpassdeux")?></p>
	<p><?=form_label("Your email address")?></p>
	<p><?=form_input("email",$user->email)?></p>
	<p><?=form_label("Your timezone")?>
	<p><?=timezone_menu($user->timezone)?></p>
	<p><?=form_label("Your editor of choice")?></p>
	<p><?=form_dropdown("editor",array("textile" => "Textile","html" => "Raw HTML"),$user->editor)?></p>
	<p><?=form_label("&nbsp;")?></p>
	<p><?=form_submit("","Change")?></p>
<?=form_close()?>