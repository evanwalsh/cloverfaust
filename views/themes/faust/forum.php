<?if(!is_array($posts)):?>
	<h3><?=$posts?> You should <?=anchor("create/topic/".$this->uri->segment(3),"create one")?>.</h3>
<?else:?>
	<div class="newpost"><?=anchor("create/topic/".$this->uri->segment(3),"Create a new topic")?></div>
	<ol id="posts">
	<?foreach($posts as $post):?>
		<li class="listpost">
			<h3><?=anchor("show/topic/".$post->url,$post->title)?></h3>			
			<h4>by <?=$this->theme->getAuthor($post->author)?></h4>
			<h5><?=$this->theme->postStats($post->url,"replies")?> / Last reply on <?=$this->theme->postDate($post->lastpost)?></h5>
		</li>
	<?endforeach;?>
	</ol>
	<div class="newpost"><?=anchor("create/topic/".$this->uri->segment(3),"Create a new topic")?></div>
<?endif;?>
<?=$this->pagination->create_links()?>