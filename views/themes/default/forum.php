<?$timezone = $this->session->userdata("timezone");?>
<?if(!is_array($posts)):?>
	<h3><?=$posts?> You should <?=anchor("x/post/".$this->uri->segment(3),"create one")?>.</h3>
<?else:?>
	<div class="newpost head"><?=anchor("x/post/".$this->uri->segment(3),"Create a new topic")?></div>
	<ol id="posts">
	<?foreach($posts as $post):?>
		<li class="listpost block">
			<h3><?=anchor("display/topic/".$post->url,$post->title)?></h3>			
			<h4>by <?=$this->theme->getAuthor($post->author)?> &nbsp;-&nbsp; <?=$this->theme->numReplies($post->url)?></h4>
		</li>
	<?endforeach;?>
	</ol>
	<div class="newpost head"><?=anchor("x/post/".$this->uri->segment(3),"Create a new topic")?></div>
<?endif;?>
<?=$this->pagination->create_links()?>