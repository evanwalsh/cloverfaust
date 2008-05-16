<?=$this->pagination->create_links()?>

<?foreach($posts as $post):?>
<div class="post" id="post<?=$post->id?>">
	<h4><?=$this->theme->getAuthor($post->author)?></h4>
	<ul class="data">
		<li><a href="#post<?=$post->id?>" class="permalink"><?=$this->theme->postDate($post->time)?></a></li>
		<li><?=$this->theme->postLink($post->id,$post->author,"delete")?></li>
		<li><?=$this->theme->postLink($post->id,$post->author,"edit")?></li>
	</ul>
	<div class="clr"></div>
	<div class="body">
		<?=$post->conv_body?>
	</div>
</div>
<?endforeach;?>

<?if($loggedIn == true):?>
<?=anchor("create/reply/".$this->uri->segment(2),"Reply to this topic",array("class" => "newpost"))?>
<?endif;?>

<?=$this->pagination->create_links()?>