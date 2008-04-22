<?if(!is_array($forums)):?>
	<p><?=$forums?></p>
<?else:?>
	<ol id="forums">
	<?$alt = 0;foreach($forums as $name => $url):?>
		<li class="forum<?if($alt & 1):?> alt<?endif;?>">
			<h3><?=anchor("show/forum/".$url,$name)?></h3>
			<h4><?=$this->theme->postStats($url,"allposts")?> / <?=$this->theme->postStats($url,"topics")?></h4>
		</li>
		<?$alt++;?>
	<?endforeach;?>
	</ol>
<?endif;?>