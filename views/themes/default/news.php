<ol id="items">
<?foreach($news as $item):?>
	<li class="block item">
		<h3><?=anchor("display/news/".$item->url,$item->name)?> <span class="numposts"><?=$this->theme->numPosts($item->url)?> &nbsp;-&nbsp; <?=$this->theme->numTopics($item->url)?></span></h3>
	</li>
<?endforeach;?>
</ol>