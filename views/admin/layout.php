<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?=$siteName?> admin &#8250; <?=$pageTitle?></title>
		<link rel="stylesheet" href="<?=base_url()?>views/admin/css/style.css"/>
		<script src="<?=base_url()?>views/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/js/ui/ui.base.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/js/ui/ui.sortable.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/admin/js/main.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body id="body_<?=$this->uri->segment(2).$this->uri->segment(3)?>">
		<div id="head">
			<h1><?=$siteName?></h1>
			<h2>admin</h2>
		</div>
		<div id="wrap">
			<div id="content">
				<?=$message?>
				<?=$error?>
				<?=$yield?>
			</div>
			<div id="footer">
				
			</div>
		</div>
	</body>
</html>