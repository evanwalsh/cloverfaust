<?=form_open("backend/login",array("id" => "loginform"))?>
	<p><?=form_label("Username")?></p>
	<p><?=form_input("user")?></p>
	<p><?=form_label("Password")?></p>
	<p><?=form_password("pass")?></p>
	<?=form_submit("login","Login")?>
<?=form_close()?>