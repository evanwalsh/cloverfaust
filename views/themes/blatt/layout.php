<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?=$siteName?> &#8250; <?=$pageTitle?></title>
		<link rel="stylesheet" href="<?=base_url()?>views/themes/<?=$theme?>/css/style.css"/>
		<script src="<?=base_url()?>views/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/themes/<?=$theme?>/js/main.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body id="body_<?=$this->uri->segment(1).$this->uri->segment(2)?>">
		<div id="head">
			<h1><?=$siteName?></h1>
			<h2><?=$pageTitle?></h2>
		</div>
		<?if($loggedIn == true):?>
		<div id="info">
			<h2>Hey <?=$this->session->userdata("name")?>!</h2>
		</div>
		<?endif?>
		<?if($loggedIn == false):?>
		<div id="info">
			<?=form_open("backend/login",array("id" => "loginform","style" => "display:none;"))?>
				<p><?=form_label("Username")?> <?=form_input("user")?></p>
				<p><?=form_label("Password")?> <?=form_password("pass")?></p>
				<p><?=form_label("&nbsp;")?> <?=form_submit("login","Login")?></p>
			<?=form_close()?>
		</div>
		<?endif?>
		<div id="wrap">
			<div id="nav">
				<ul>
					<li><?=anchor("home","Home")?></li>
					<?if($loggedIn == false):?>
					<li><?=anchor("login","Login",'id="login"')?></li>
					<li><?=anchor("signup","Sign up")?></li>
					<?endif;?>
					<li><?=anchor("forums","Forums")?></li>
					<li><?=anchor("help","Help")?></li>
					<?if($loggedIn == true):?>
					<li><?=anchor("account","Account")?></li>
					<li><?=anchor("backend/logout","Logout")?></li>
					<?endif;?>
					<?if($this->common->getGroup() == 1):?>
					<li><?=anchor("admin","Admin")?></li>
					<?endif;?>
				</ul>
			</div>
			<div id="content">
				<?=$message?>
				<?=$error?>
				<?=$yield?>
			</div>
			<div id="footer">
				powered by <a href="http://cloverfaust.com">Cloverfaust</a> / &copy; <?=date(Y)?> <?=$siteName?>
			</div>
		</div>
		
		<!-- cloverfaust aeta :: {elapsed_time} is how much I love you :: by evan walsh -->
		
	</body>
</html>