<div class="firstpost post">
	<h3><?=$firstpost->title?> <span class="author">by <?=$this->theme->getAuthor($firstpost->author)?></span></h3>
	<h4><?=mdate("%M %d %Y %h:%i%a",gmt_to_local($firstpost->time,$this->session->userdata("timezone")))?></h4>
	<div class="body">
		<?=$firstpost->conv_body?>
	</div>
	<?=$this->theme->postLink($firstpost->id,$firstpost->author,"delete")?>
	<?=$this->theme->postLink($firstpost->id,$firstpost->author,"edit")?>
	<div class="clr"></div>
</div>

<div class="reply"><?=anchor("create/reply/".$firstpost->url,"Add a reply",array("class" => "reply"))?></div>

<h3>Replies</h3>

<?=$this->pagination->create_links()?>

<?if(empty($posts)):?>
	<p>There aren't any replies yet!</p>
<?endif;?>

<?foreach($posts as $post):?>
<div class="post" id="post<?=$post->id?>">
	<div class="postinfo">
		<h3><?=$this->theme->getAuthor($post->author)?></h3>
		<h4><a href="#post<?=$post->id?>"><?=mdate("%M %d %Y %h:%i%a",gmt_to_local($post->time,$this->session->userdata("timezone")))?></a></h4>
		<?=$this->theme->adminLinks($post->id,$post->author)?>
	</div>
	<div class="body">
		<?=$post->conv_body?>
	</div>
	<div class="clr"></div>
</div>
<?endforeach;?>

<div class="reply"><?=anchor("create/reply//".$firstpost->url,"Add a reply",array("class" => "reply"))?></div>

<?=$this->pagination->create_links()?>