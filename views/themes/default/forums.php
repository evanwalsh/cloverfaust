<?if(!is_array($forums)):?>
	<p><?=$forums?></p>
<?else:?>
	<ol id="forums">
	<?foreach($forums as $forum):?>
		<li class="block forum">
			<h3><?=anchor("display/forum/".$forum->url,$forum->name)?> <span class="numposts"><?=$this->theme->numPosts($forum->url)?> &nbsp;-&nbsp; <?=$this->theme->numTopics($forum->url)?></span></h3>
		</li>
	<?endforeach;?>
	</ol>
<?endif;?>