<?if(!is_array($posts)):?>
<h4><?=$posts?></h4>
<?else:?>
<?foreach($posts as $post):?>
<li>
	<h4><?=mdate("%M %d %Y %h:%i%a",gmt_to_local($post->time,$this->session->userdata("timezone")))?></h4>
	<h5><?=$this->theme->getAuthor($post->author)?> <?=anchor("display/topic/".$post->url."#post".$post->id,"replied")?> to <?=anchor("display/topic/".$post->url,$post->title)?></h5>
</li>
<?endforeach;?>
<?endif;?>