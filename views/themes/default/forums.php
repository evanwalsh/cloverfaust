<?if(!is_array($forums)):?>
	<p><?=$forums?></p>
<?else:?>
	<ol id="forums">
	<?$alt = 0;foreach($forums as $name => $url):?>
		<li class="forum<?if($alt & 1):?> alt<?endif;?>">
			<h3><?=anchor("show/forum/".$url,$name)?> <span class="numposts"><?=$this->theme->numPosts($url)?> &nbsp;-&nbsp; <?=$this->theme->numTopics($url)?></span></h3>
		</li>
		<?$alt++;?>
	<?endforeach;?>
	</ol>
<?endif;?>