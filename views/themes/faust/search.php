<?if(!is_array($posts)):?>
<h3>No results! Aw man!</h3>
<?else:?>
<h3>Results for '<?=$term?>'</h3>
<?foreach($posts as $post):?>
<div class="post" id="post<?=$post->id?>">
	<div class="listpost">
		<?$type = ($post->type == "first")? "posted" : "replied to"?>
		<h3><?=$this->theme->getAuthor($post->author)?> <?=anchor("show/topic/".$post->url."#post".$post->id,"$type topic '".$post->title."'")?></h3><br/>
		<h4><?=$this->theme->postDate($post->time)?></h4>
	</div>
</div>
<?endforeach;?>
<?endif;?>