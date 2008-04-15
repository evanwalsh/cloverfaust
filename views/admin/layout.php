<!DOCTYPE<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?=$siteName?> &#8250; <?=$pageTitle?></title>
		<link rel="stylesheet" href="<?=base_url()?>views/admin/css/style.css"/>
		<script src="<?=base_url()?>views/js/jquery.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div id="head">
			<h1>clvrfst admin: <?=$siteName?></h1>
			<ul id="nav">
				<li class="current"><?=anchor("admin/home","Admin home")?></li>
				<li><?=anchor("show/home","Forum home")?></li>
				<li><?=anchor("backend/logout","Logout")?></li>
			</ul>
			<div class="clr"></div>
		</div>
		<div id="wrap">
			<div id="content">
				<?=$yield?>
			</div>
			<div id="footer">
				&copy; 2008 Evan Walsh
			</div>
		</div>
		
		<!-- klei aeta :: {elapsed_time} :: all code by evan walsh -->
		
	</body>
</html>