<?=form_open("create/forum")?>
	<ul>
		<li>
			<h3>Forum name</h3>
			<?=form_input("name")?>
		</li>
		<li>
			<?=form_submit("","Create")?>
		</li>
	</ul>
<?=form_close()?>