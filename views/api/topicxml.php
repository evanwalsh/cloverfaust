<?='<?xml version="1.0" encoding="utf-8"?>'."\n"?>
<posts>
<?foreach($posts as $post):?>
	<post>
		<id><?=$post->id?></id>
<?if($post->type == "first"):?>
		<title><?=$post->title?></title>
<?endif;?>
		<url><?=$post->url?></url>
		<author><?=$this->theme->getAuthor($post->author)?></author>
		<type><?=$post->type?></type>
		<forum><?=$post->forum?></forum>
		<rawbody><?=$post->body?></rawbody>
		<htmlbody><?=$post->textile?></htmlbody>
		<time><?=$post->time?></time>
		<lastpost><?=$post->lastpost?></lastpost>
	</post>
<?endforeach;?>
</posts>