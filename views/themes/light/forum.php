<?if(!is_array($posts)):?>
	<h3><?=$posts?> You should <?=anchor("create/topic/".$this->uri->segment(2),"create one")?>.</h3>
<?else:?>
	<?=anchor("create/topic/".$this->uri->segment(2),"Create a new topic",array("class" => "newpost"))?>
	<ol id="posts">
	<?foreach($posts as $post):?>
		<li class="listpost">
			<h3><?=anchor("topic/".$post->url,$post->title)?></h3>			
			<h4>by <?=$this->theme->getAuthor($post->author)?></h4>
			<h5><?=$this->theme->postStats($post->url,"replies")?> / Last reply on <?=$this->theme->postDate($post->lastpost)?></h5>
			<div class="clr"></div>
 		</li>
	<?endforeach;?>
	</ol>
	<?=anchor("create/topic/".$this->uri->segment(2),"Create a new topic",array("class" => "newpost"))?>
<?endif;?>
<?=$this->pagination->create_links()?>