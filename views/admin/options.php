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
		<select name="themes" id="themes">
		<?foreach($themes as $theme => $var):?>
			<option value="<?=$theme?>"><?=$var["name"]?> <?=$var["version"]?> by <?=$var["author"]?></option>
		<?endforeach;?>
		</select>
	</li>
</ul>