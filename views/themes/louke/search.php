<?if(!is_array($posts)):?>
<h3>No results! Aw man!</h3>
<?else:?>
<h3>Results for '<?=$term?>'</h3>
<?foreach($posts as $post):?>
<div class="post" id="post<?=$post->id?>">
	<div class="searchpost">
		<?$type = ($post->type == "first")? "Posted" : "Replied to"?>
		<h3><?=$this->theme->getAuthor($post->author)?> <?=anchor("display/topic/".$post->url."#post".$post->id,"$type topic '".$post->title."'")?></h3>
	</div>
</div>
<?endforeach;?>
<?endif;?>