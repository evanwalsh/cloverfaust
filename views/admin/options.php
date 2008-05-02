<?=form_open("admin/options")?>
<ul>
	<li>
		<h3>Site name</h3>
		<?=form_input("name",$siteName)?>
	</li>
	<li>
		<h3>Site subtitle</h3>
		<?=form_input("subtitle",$siteSubtitle)?>
	</li>
	<li>
		<h3>Theme</h3>
		<select name="theme" id="themes">
		<?foreach($themes as $theme => $var):?>
			<option value="<?=$theme?>"<?if($siteTheme == $theme) echo ' selected="selected"'?>><?=$var["name"]?> <?=$var["version"]?> by <?=$var["author"]?></option>
		<?endforeach;?>
		</select>
	</li>
	<li>
		<h3>Posts per page</h3>
		<?=form_dropdown("per-page",array(5 => 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20),$perPage)?>
	</li>
	<li>
		<h3>Allowed HTML tags</h3>
		<?=form_input("allowed-tags",$allowedTags)?>
	</li>
	<li>
		<h3>RSS enabled <?=form_checkbox("rss","yes",$rss)?></h3>
	<li>
		<?=form_submit("go","Save options")?>
	</li>
</ul>
<?=form_close()?>