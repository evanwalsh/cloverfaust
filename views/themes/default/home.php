<?if($this->common->loggedIn() == false):?>
<?=anchor("show/login","Login")?> / <?=anchor("show/signup","Sign up")?>
<?else:?>
<?=anchor("backend/logout","Logout")?>
<?endif;?>