<?if($this->common->loggedIn() == false):?>
<div id="greetz">
	<h3>Welcome to <?=$siteName?>!</h3>
	<p>Feel free to browse any of the various <?=anchor("show/forums","forums")?> or get started with posting by <?=anchor("show/signup","getting an account")?> or <?=anchor("show/login","logging in")?>.</p>
</div>
<?endif;?>
<h3>Recent posts</h3>
<ul id="recents">
<?foreach($posts as $post):?>
	<li class="<?=$post->type?>">
		<img src="<?=base_url()?>views/themes/faust/img/<?=$post->type?>.gif"/>
		<?=$this->theme->getAuthor($post->author)?> <?=($post->type == "first") ? "posted" : "replied to"?> <?=anchor("show/topic/".$post->url."#post".$post->id,$post->title)?>
		<span class="time"><?=timespan($post->time,gmt_to_local($time,$this->session->userdata("timezone")))?> ago</span>
	</li>
<?endforeach;?>
</ul>