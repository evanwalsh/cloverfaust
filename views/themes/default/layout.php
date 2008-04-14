<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?=$siteTitle?> &#8250; <?=$pageTitle?></title>
		<link rel="stylesheet" href="<?=base_url()?>views/themes/<?=$theme?>/css/style.css"/>
		<script src="<?=base_url()?>views/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/themes/<?=$theme?>/js/main.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body id="<?=$this->uri->segment(1).$this->uri->segment(2).$this->uri->segment(3)?>">
		<div id="wrap">
			<div id="head">
				<h1><?=$siteTitle?></h1>
				<h2><?=$siteSubtitle?></h2>
				<h3><?=$pageTitle?></h3>
			</div>
			<div id="content">
				<?=$message?>
				<?=$error?>
				<?=$yield?>
			</div>
			<div id="footer">
				
			</div>
		</div>
		
		<!-- clvrfst aeta :: {elapsed_time} is your lucky number :: by evan walsh -->
		
	</body>
</html>