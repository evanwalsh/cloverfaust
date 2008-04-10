<p><h4><?=anchor("admin/create/forum","Create a new forum")?></h4></p>
<?foreach($forums as $forum):?>
	<div class="forum">
		<h3><?=$forum->name?></h3>
		<h4><?=anchor("admin/edit/forum/".$forum->id,"Edit")?> / <?=anchor("admin/delete/forum/".$forum->url,"Delete")?></h4>
	</div>
<?endforeach;?>