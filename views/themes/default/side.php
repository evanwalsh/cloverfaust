<h3>You can</h3>
<ul>
	<li><?=anchor("display/home","go home")?></li>
	<li><?=anchor("display/forums","view the forums")?></li>
	<li><?=anchor("display/news","view the site news")?></li>
	<li><?=anchor("x/account","edit your account")?></li>
	<li><?=anchor("x/invite","invite someone")?></li>
	<li><?=anchor("display/help","get some help")?></li>
	<?if($this->klei->getGroup() == 1):?>
	<li class="adminlink"><?=anchor("admin","administrate")?></li>
	<?endif;?>
	<li><?=anchor("x/logout","logout")?></li>
	<li>Search</li>
	<li>
		<form action="<?=site_url("x/search")?>" method="post">
		<input type="text" name="search" id="searchbox"/>
		</form>
	</li>
</ul>