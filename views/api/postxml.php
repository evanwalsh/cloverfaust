<?='<?xml version="1.0" encoding="utf-8"?>'."\n"?>
<post>
	<id><?=$id?></id>
	<?if($type == "first"):?>
<title><?=$title?></title>
	<?endif;?>
<url><?=$url?></url>
	<author><?=$author?></author>
	<type><?=$type?></type>
	<forum><?=$forum?></forum>
	<rawbody><?=$body?></rawbody>
	<htmlbody><?=$textile?></htmlbody>
	<time><?=$time?></time>
	<lastpost><?=$lastpost?></lastpost>
</post>