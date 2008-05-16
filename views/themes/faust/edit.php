<?=form_open("edit/post/".$post->id,array("id" => "editform"))?>
	<p><?=form_label("Your post's body")?></p>
	<p><?=form_textarea("body",$post->body)?></p>
	<p><?=form_label("&nbsp;")?></p>
	<p><?=form_submit("","Save")?> <?=form_submit("","Cancel",'onClick="window.location=\''.base_url()."topic/".$this->uri->segment(3).'\';return false;"')?></p>
	<?=form_hidden("forum",$post->forum)?>
	<?=form_hidden("post",$post->url)?>
<?=form_close()?>