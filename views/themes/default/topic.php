<?=$firstpost->title?> <span class="author">by <?=$this->theme->getAuthor($firstpost->author)?></span>
<?=mdate("%M %d %Y %h:%i%a",gmt_to_local($firstpost->time,$this->session->userdata("timezone")))?>
<?=$firstpost->conv_body?>
<?=$this->theme->postLink($firstpost->id,$firstpost->author,"delete")?>
<?=$this->theme->postLink($firstpost->id,$firstpost->author,"edit")?>

<?=anchor("create/reply/".$firstpost->url,"Add a reply",array("class" => "reply"))?>

<?foreach($posts as $post):?>
<?=$this->theme->getAuthor($post->author)?>
<a href="#post<?=$post->id?>"><?=mdate("%M %d %Y %h:%i%a",gmt_to_local($post->time,$this->session->userdata("timezone")))?></a>
<?=$this->theme->adminLinks($post->id,$post->author)?>
<?=$post->conv_body?>
<?endforeach;?>

<?=$this->pagination->create_links()?>