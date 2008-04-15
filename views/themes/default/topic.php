<p class="post first">
	<h4><?=$this->theme->getAuthor($firstpost->author)?></h4>
	<h5><?=$this->theme->postDate($firstpost->time)?></h5>
	
	<?=$firstpost->conv_body?>
	
	<small class="adminlinks"><?=$this->theme->postLink($firstpost->id,$firstpost->author,"delete")?> or <?=$this->theme->postLink($firstpost->id,$firstpost->author,"edit")?> this</small>
	
</p>

<?foreach($posts as $post):?>
<p class="post">
	<h4><?=$this->theme->getAuthor($post->author)?></h4>
	<h5><a href="#post<?=$post->id?>"><?=$this->theme->postDate($post->time)?></a></h5>
	
	<?=$post->conv_body?>
	
	<small class="adminlinks"><?=$this->theme->postLink($firstpost->id,$firstpost->author,"delete")?> or <?=$this->theme->postLink($firstpost->id,$firstpost->author,"edit")?> this</small>
	
</p>
<?endforeach;?>

<?=$this->pagination->create_links()?>