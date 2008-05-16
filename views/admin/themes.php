<?=form_open_multipart("admin/install/theme",array("id" => "themeinstall","class" => "installform"))?>
	<h3>Install a new theme</h3>
	<h4>Upload the zip archive containing the theme files</h4>
	<?=form_upload("file")?>
	<?=form_submit("","Install")?>
<?=form_close()?>
<ul id="themes">
<?foreach($themes as $name => $data):?>
	<li<?if($theme == $name):?> class="activetheme"<?endif;?>>
		<h3><?=$data["name"]?> <?=$data["version"]?></h3>
		<h4>by <?=anchor($data["url"],$data["author"])?></h4>
		<div class="themescr" style="background:url(<?=base_url()?>views/themes/<?=$name?>/screenshot.jpg)"></div>
		<?if($theme == $name):?><div class="hide"><?endif?><?=anchor("admin/themes/$name","Change to this theme")?><?if($theme == $name):?></div><?endif?>
	</li>
<?endforeach;?>
</ul>
<div class="clr"></div>