<?=anchor("admin/create/forum","Make a new forum",array("id" => "newforum","class" => "adminlink"))?>
<?=form_open("admin/options/forum")?>
<ul id="forums">
<?foreach($forums as $name => $url):?>
	<li>
		<div class="info">
			<h3><?=anchor("admin/edit/forum/$url",$name,array("class" => "editforum"))?></h3>
			<h4><?=$this->theme->postStats($url,"allposts")?> / <?=$this->theme->postStats($url,"topics")?></h4>
		</div>
		<img src="<?=base_url()?>views/admin/img/drag.png"/>
		<?=form_hidden("forum_$url",$name)?>
		<div class="clr"></div>
	</li>
<?endforeach;?>
</ul>
<?=form_submit("save","Save order")?>
<?=form_close()?>