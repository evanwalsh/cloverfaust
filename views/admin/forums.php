<ul>
<?foreach($forums as $name => $url):?>
	<li>
		<h3><?=$name?></h3>
		<h4><?=$this->theme->postStats($url,"allposts")?> / <?=$this->theme->postStats($url,"topics")?></h4>
	</li>
<?endforeach;?>
</ul>