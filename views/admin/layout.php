<!DOCTYPE<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?=$siteTitle?> &#8250; <?=$pageTitle?></title>
		<link rel="stylesheet" href="<?=base_url()?>views/admin/css/style.css"/>
		<script src="<?=base_url()?>views/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/themes/default/js/main.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body id="<?=$this->uri->segment(1).$this->uri->segment(2).$this->uri->segment(3).$this->klei->getGroup()?>">
		<div id="wrap">
			<div id="head">
				<h1><?=$siteTitle?></h1>
				<h2><?=$siteSubtitle?></h2>
				<div id="title"><?=$pageTitle?></div>
			</div>
			<div id="content">
				<div id="side" class="block">
					<h3>You can</h3>
					<ul>
						<li><?=anchor("admin","go home")?></li>
						<li><?=anchor(base_url(),"go to the admin home")?></li>
						<li><?=anchor("x/logout","logout")?></li>
					</ul>
				</div>
				<div id="main">
					<?=$yield?>
				</div>
			</div>
			<div id="footer">
				
			</div>
		</div>
		
		<!-- klei aeta :: {elapsed_time} :: all code by evan walsh -->
		
	</body>
</html>