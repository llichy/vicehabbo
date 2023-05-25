<?php

@session_start();
require_once "../inc/config.php";

if (empty($_POST['catalog_name']) || empty($_POST['page_id'])) {
    echo "Merci de remplir tous les champs";
}else { 

$id = $_POST['id'];
 
$catalog_name = $_POST['catalog_name'];
$page_id = $_POST['page_id'];
$cost_credits = $_POST['cost_credits'];
$cost_diamonds = $_POST['cost_diamonds'];
$amount = $_POST['amount'];
$limited_sells = $_POST['limited_sells'];
$limited_stack = $_POST['limited_stack'];


$type = $_POST['furniture_type'];
$width = $_POST['furniture_width'];
$length = $_POST['furniture_length'];
$stack_height = $_POST['furniture_stackheight'];
$interaction_type = $_POST['furniture_interactiontype'];
$interaction_modes_count = $_POST['furniture_modescount'];
$vending_ids = $_POST['furniture_vendingids'];
$can_stack = $_POST['furniture_canstack'];
$can_sit = $_POST['furniture_cansit'];
$is_walkable = $_POST['furniture_iswalkable'];
$allow_trade = $_POST['furniture_allowtrade'];
$allow_gift = $_POST['furniture_allowgift'];


	$req = $bdd->prepare('UPDATE catalog_items SET catalog_name = ?, page_id = ?, cost_credits = ?, cost_points = ?, amount = ?, limited_sells = ?,limited_stack = ? WHERE item_ids = ?');
	$req->execute([$catalog_name, $page_id, $cost_credits, $cost_diamonds, $amount, $limited_sells, $limited_stack, $id]);
	

	$req22 = $bdd->prepare('UPDATE items_base SET type = ?, width = ?, length = ?, stack_height = ?, interaction_type = ?, interaction_modes_count = ?, vending_ids = ?, allow_stack = ?, allow_sit = ?, allow_walk = ?, allow_trade= ?, allow_gift = ? WHERE id = ?');
	$req22->execute([$type, $width, $length, $stack_height, $interaction_type, $interaction_modes_count, $vending_ids, $can_stack, $can_sit, $is_walkable, $allow_trade, $allow_gift, $id]);


echo "ok";
}

?>