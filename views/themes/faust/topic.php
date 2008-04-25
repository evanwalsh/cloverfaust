<div class="post" id="post<?=$firstpost->id?>">
	<h4><?=$this->theme->getAuthor($firstpost->author)?></h4>
	<ul class="data">
		<li><?=$this->theme->postDate($firstpost->time)?></li>
		<li><?=$this->theme->postLink($firstpost->id,$firstpost->author,"delete")?></li>
		<li><?=$this->theme->postLink($firstpost->id,$firstpost->author,"edit")?></li>
	</ul>
	<div class="clr"></div>
	<div class="body">
		<?=$firstpost->conv_body?>
	</div>
</div>

<?foreach($posts as $post):?>
<div class="post" id="post<?=$post->id?>">
	<h4><?=$this->theme->getAuthor($post->author)?></h4>
	<ul class="data">
		<li><?=$this->theme->postDate($post->time)?></li>
		<li><?=$this->theme->postLink($post->id,$post->author,"delete")?></li>
		<li><?=$this->theme->postLink($post->id,$post->author,"edit")?></li>
	</ul>
	<div class="clr"></div>
	<div class="body">
		<?=$post->conv_body?>
	</div>
</div>
<?endforeach;?>

<?=$this->pagination->create_links()?>

<?if($loggedIn == true):?>
<?=anchor("create/reply/".$this->uri->segment(3),"Reply to this topic")?>
<?endif;?>