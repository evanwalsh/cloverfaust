<?=form_open("x/process/reply")?>
	<p><?=form_label("Your reply")?></p>
	<p><?=form_textarea("body")?></p>
	<p><?=form_submit("","Reply")?><?=form_submit("","Cancel",'onClick="window.location=\''.base_url()."display/topic/".$this->uri->segment(4).'\';return false;"')?></p>
	<?=form_hidden("forum",$this->uri->segment(3))?>
	<?=form_hidden("origauthor",$origpost->author)?>
	<?=form_hidden("post",$this->uri->segment(4))?>
<?=form_close()?>