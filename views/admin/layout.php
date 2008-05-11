<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?=$siteName?> admin &#8250; <?=$pageTitle?></title>
		<link rel="stylesheet" href="<?=base_url()?>views/admin/css/style.css"/>
		<script src="<?=base_url()?>views/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/js/ui/ui.core.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/js/ui/ui.sortable.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?=base_url()?>views/admin/js/main.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body id="body_<?=$this->uri->segment(2).$this->uri->segment(3)?>">
		<div id="wrap">
			<div id="head">
				<h1><?=$siteName?></h1>
				<h2>admin &#8250; <?=$pageTitle?></h2>
			</div>
			<ul id="nav">
			<li><img src="<?=base_url()?>views/admin/img/house.png"/> <?=anchor("admin/home","Home")?></li>
				<li><img src="<?=base_url()?>views/admin/img/table.png"/> <?=anchor("admin/forums","Forums")?></li>
				<li><img src="<?=base_url()?>views/admin/img/user.png"/> <?=anchor("admin/users","Users")?></li>
				<li><img src="<?=base_url()?>views/admin/img/layout.png"/> <?=anchor("admin/themes","Theme")?></li>
				<li><img src="<?=base_url()?>views/admin/img/cog.png"/> <?=anchor("admin/options","Options")?></li>
				<li><img src="<?=base_url()?>views/admin/img/world_go.png"/> <?=anchor("home","Board &raquo;")?></li>
			</ul>
			<div id="content">
				<?=$message?>
				<?=$error?>
				<?=$yield?>
			</div>
			<div id="footer">
				<p>&copy; 2008 Evan Walsh. Powered by <?=anchor("http://cloverfaust.com","Cloverfaust")?>. Icons by <?=anchor("http://www.famfamfam.com/lab/icons/silk/","Mark James")?></p>
			</div>
		</div>
	</body>
</html>