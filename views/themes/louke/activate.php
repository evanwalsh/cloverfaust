<?=form_open("x/process/activate")?>
	<p><?=form_label("Choose a username")?></p>
	<p><?=form_input("name",null,"id=\"username\"")?></p>
	<p><?=form_label("Enter your email address")?></p>
	<p><?=form_input("email",null,"id=\"password\"")?></p>
	<p><?=form_label("Choose a password")?></p>
	<p><?=form_password("pass")?></p>
	<p><?=form_label("Confirm your password")?></p>
	<p><?=form_password("passdeux")?></p>
	<p><?=form_label("Choose your time zone")?></p>
	<p><?=timezone_menu()?></p>
	<p><?=form_label("Paste the code that you received in your invitation email")?></p>
	<p><?=form_textarea("code")?></p>
	<?=form_submit("","Activate")?>
<?=form_close()?>