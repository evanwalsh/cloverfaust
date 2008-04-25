<?=form_open("admin/options")?>
<ul>
	<li>
		<h3>Site name</h3>
		<input type="text" name="name" value="<?=$siteName?>"/>
	</li>
	<li>
		<h3>Site subtitle</h3>
		<input type="text" name="subtitle" value="<?=$siteSubtitle?>"/>
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
		<?=form_submit("go","Save options")?>
	</li>
</ul>
<?=form_close()?>