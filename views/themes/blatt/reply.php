<?=form_open("create/reply/".$this->uri->segment(3))?>
	<p><?=form_label("Your reply")?></p>
	<p><?=form_textarea("body")?></p>
	<p><?=form_label("&nbsp;")?></p>
	<p><?=form_submit("","Reply")?><?=form_submit("","Cancel",'onClick="window.location=\''.base_url()."show/topic/".$this->uri->segment(3).'\';return false;"')?></p>
	<?=form_hidden("title",$origpost->title)?>
	<?=form_hidden("forum",$origpost->forum)?>
	<?=form_hidden("origauthor",$origpost->author)?>
	<?=form_hidden("post",$origpost->url)?>
<?=form_close()?>