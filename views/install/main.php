<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>cloverfaust installer &#8250; the only step</title>
		<link rel="stylesheet" href="<?=base_url()?>views/install/style.css"/>
		<meta name="date-created" value="Tue Apr 15 15:47:25 EDT 2008"/>
	</head>
	<body>
		<div id="wrap">
			<div id="head">
				<h1>cloverfaust installer</h1>
				<h2>release 001</h2>
			</div>
			<div id="content">
			
				<?=$this->validation->error_string;?>
				
				<?=form_open("install/go")?>
					
					<h3>Note: make sure the folder that Cloverfaust is installed is CHMOD'd to 777</h3>
					
					<div id="site">
						<h3>Site</h3>
						<ol>
							<li><?=form_label("Name")?> <?=form_input("name")?></li>
							<li><?=form_label("Subtitle")?> <?=form_input("subtitle")?></li>
						</ol>
					</div>

					<div id="db">
						<h3>Database</h3>
						<ol>
							<li><?=form_label("Host")?> <?=form_input("dbhost","localhost")?></li>
							<li><?=form_label("Username")?> <?=form_input("dbuser")?></li>
							<li><?=form_label("Password")?> <?=form_input("dbpass")?></li>
							<li><?=form_label("Database name")?> <?=form_input("db")?></li>
							<li><?=form_label("Prefix")?> <?=form_input("dbprefix","cf_")?></li>
						</ol>
					</div>

					<div id="admin">
						<h3>Admin user</h3>
						<ol>
							<li><?=form_label("Username")?> <?=form_input("user")?></li>
							<li><?=form_label("Password")?> <?=form_input("pass")?></li>
							<li><?=form_label("Email")?> <?=form_input("email")?></li>
							<li><?=form_label("Timezone")?> <?=timezone_menu()?></li>
						</ol>
					</div>
					
					<?=form_submit("install","Install",'id="submit"')?>

				<?=form_close()?>
				<div class="clr"></div>
			</div>
			<div id="footer">
				&copy; 2008 Evan Walsh
			</div>
		</div>
	</body>
</html>