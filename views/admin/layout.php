<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?=$siteName?> admin &#8250; <?=$pageTitle?></title>
		<link rel="stylesheet" href="<?=base_url()?>views/admin/css/style.css"/>
		<meta name="date-created" value="Sun Apr 20 17:42:04 EDT 2008"/>
	</head>
	<body>
		<div id="head">
			<h1><?=$siteName?></h1>
			<h2>admin</h2>
		</div>
		<div id="wrap">
			<div id="content">
				<?=$yield?>
			</div>
			<div id="footer">
				
			</div>
		</div>
	</body>
</html>