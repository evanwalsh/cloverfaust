<?=anchor("admin/create/forum","Make a new forum",array("id" => "newforum","class" => "adminlink"))?>
<?=form_open("admin/options/forum")?>
<ul id="forums">
<?foreach($forums as $name => $url):?>
	<li>
		<h3><?=anchor("admin/edit/forum/$url",$name,array("class" => "editforum"))?></h3>
		<h4><?=$this->theme->postStats($url,"allposts")?> / <?=$this->theme->postStats($url,"topics")?></h4>
		<?=form_hidden("forum_$url",$name)?>
	</li>
<?endforeach;?>
</ul>
<?=form_submit("save","Save order")?>
<?=form_close()?>