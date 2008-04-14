<?=form_open("create/post/".$this->uri->segment(3))?>
	<p><?=form_label("Your post's title")?></p>
	<p><?=form_input("title")?></p>
	<p><?=form_label("Your post's body")?></p>
	<p><?=form_textarea("body")?></p>
	<p><?=form_submit("","Post")?><?=form_submit("","Cancel",'onClick="window.location=\''.base_url()."show/forum/".$this->uri->segment(3).'\';return false;"')?></p>
<?=form_close()?>