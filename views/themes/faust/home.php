<?if($this->common->loggedIn() == false):?>
<div id="greetz">
	<h3>Welcome to <?=$siteName?>!</h3>
	<p>Feel free to browse any of the various <?=anchor("forums","forums")?> or get started with posting by <?=anchor("signup","getting an account")?> or <?=anchor("login","logging in")?>.</p>
</div>
<?endif;?>
<h3>Recent posts</h3>
<ul id="recents">
<?if(is_array($posts)):?>
<?foreach($posts as $post):?>
	<li class="<?=$post->type?>">
		<img src="<?=base_url()?>views/themes/faust/img/<?=$post->type?>.gif"/>
		<?=$this->theme->getAuthor($post->author)?> <?=($post->type == "first") ? "posted" : "replied to"?> <?=anchor("topic/".$post->url."#post".$post->id,$post->title)?>
		<span class="time"><?=timespan($post->time,gmt_to_local($time,$this->session->userdata("timezone")))?> ago</span>
	</li>
<?endforeach;?>
<?else:?>
<p>No recents posts</p>
<?endif;?>
</ul>