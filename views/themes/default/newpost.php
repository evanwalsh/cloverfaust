<?=form_open("x/process/post")?>
	<p><?=form_label("Your post's title")?></p>
	<p><?=form_input("title")?></p>
	<p><?=form_label("Your post's body")?></p>
	<p><?=form_textarea("body")?></p>
	<p><?=form_submit("","Post")?><?=form_submit("","Cancel",'onClick="window.location=\''.base_url()."display/forum/".$forum.'\';return false;"')?></p>
	<?=form_hidden("forum",$forum)?>
<?=form_close()?>