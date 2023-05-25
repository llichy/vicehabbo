<?php

@session_start();
require_once "../inc/config.php";


if (empty($_POST['caption']) || empty($_POST['parent_id']) || empty($_POST['min_rank'])) {
    echo "Merci de remplir tous les champs";
}else { 
		$id = $_POST['id'];
		$caption = utf8_decode($_POST['caption']);
		$parent_id = $_POST['parent_id'];
		$icon_image	 = $_POST['icon_image'];
		$min_rank = $_POST['min_rank'];
		$enabled = $_POST['enabled'];
		$page_layout = $_POST['page_layout'];
		$page_strings_1 = $_POST['page_strings_1'];
		$page_strings_2 = $_POST['page_strings_2'];

	$req = $bdd->prepare("UPDATE catalog_pages SET caption = ?, parent_id = ?, icon_image = ?, min_rank = ?, enabled = ?, page_layout = ?, page_text1 = ?,page_text2 = ? WHERE id = ? LIMIT 1");
	$req->execute(array($caption, $parent_id, $icon_image, $min_rank, $enabled, $page_layout, $page_strings_1, $page_strings_2,$id));
echo "ok";
}

?>