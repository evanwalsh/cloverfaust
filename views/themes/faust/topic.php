<p class="post" id="post<?=$firstpost->id?>">
	<h4><?=$this->theme->getAuthor($firstpost->author)?></h4>
	<h5><?=$this->theme->postDate($firstpost->time)?></h5>
	
	<?=$firstpost->conv_body?>
	
	<small class="adminlinks"><?=$this->theme->postLink($firstpost->id,$firstpost->author,"delete")?> <?=$this->theme->postLink($firstpost->id,$firstpost->author,"edit","before","after")?></small>
	
</p>

<?foreach($posts as $post):?>
<p class="post" id="post<?=$post->id?>">
	<h4><?=$this->theme->getAuthor($post->author)?></h4>
	<h5><a href="#post<?=$post->id?>"><?=$this->theme->postDate($post->time)?></a></h5>
	
	<?=$post->conv_body?>
	
	<small class="adminlinks"><?=$this->theme->postLink($firstpost->id,$firstpost->author,"delete")?> <?=$this->theme->postLink($firstpost->id,$firstpost->author,"edit")?></small>
	
</p>
<?endforeach;?>

<?=$this->pagination->create_links()?>

<?=anchor("create/reply/".$this->uri->segment(3),"Reply to this topic")?>