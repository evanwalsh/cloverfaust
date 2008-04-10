<?foreach($users as $user):?>
	<div class="forum">
		<h3><?=$user->name?></h3>
		<h4><?=anchor("admin/edit/user/".$user->id,"Edit")?> / <?=anchor("admin/delete/user/".$user->id,"Delete")?></h4>
	</div>
<?endforeach;?>

<?=$this->pagination->create_links()?>