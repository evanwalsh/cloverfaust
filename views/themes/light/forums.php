<?if(!is_array($forums)):?>
	<p><?=$forums?></p>
<?else:?>
	<ol id="forums">
	<?$alt = 0;foreach($forums as $name => $url):?>
		<li class="forum<?if($alt & 1):?> alt<?endif;?>">
			<h3><?=anchor("forum/".$url,$name)?> <span class="poststat"><?=$this->theme->postStats($url,"allposts")?> / <?=$this->theme->postStats($url,"topics")?></span></h3>
			<div class="clr"></div>
		</li>
		<?$alt++;?>
	<?endforeach;?>
	</ol>
<?endif;?>