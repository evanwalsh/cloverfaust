<p><?=anchor("admin/create/user","Make a new user",array("class" => "add"))?></p>
<ul id="users">
<?foreach($users as $user):?>
	<li>
		<?=anchor("admin/edit/user/".$user->id,$user->name)?>
	</li>
<?endforeach;?>
</ul>
<?=$this->pagination->create_links()?>