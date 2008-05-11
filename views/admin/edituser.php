

<?=form_open("edit/user/".$user->id)?>
	<ul>
		<li>
			<h3>Username</h3>
			<?=form_input("username",$user->name)?>
		</li>
		<li>
			<h3>Email</h3>
			<?=form_input("email",$user->email)?>
		</li>
		<li>
			<h3>New password</h3>
			<?=form_input("newpass")?>
		</li>
		<li>
			<h3>Group</h3>
			<?=form_dropdown("group",array(1 => "Admin",2 => "Member"),$user->group)?>
		</li>
		<li>
			<h3>Timezone</h3>
			<?=timezone_menu($user->timezone)?>
		</li>
		<li>
			<?=form_submit("","Edit")?>
			<?=anchor("delete/user/".$user->id,"Delete this user",array("class" => "delete"))?>
		</li>
	</ul>
<?=form_close()?>