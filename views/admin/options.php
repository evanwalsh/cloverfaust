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
		<h3>Posts per page</h3>
		<?=form_dropdown("per-page",array(5 => 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20),$perPage)?>
	</li>
	<li>
		<?=form_submit("go","Save options")?>
	</li>
</ul>
<?=form_close()?>