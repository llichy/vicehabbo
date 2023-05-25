<?php

@session_start();
require_once "./inc/config.php";


$subCategoryId = $_GET['id'];
$items = $_GET['items'];

 foreach($items as $item => $subCategoryId) {

	$req = $bdd->prepare("UPDATE catalog_items SET page_id = ? WHERE item_ids = ?");
	$req->execute(array($subCategoryId, $item));

}
?>