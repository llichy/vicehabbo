<?php

@session_start();
require_once "./inc/config.php";




$subCategoryId = $_GET['id'];
$caption = $_GET['caption'];


    $cata = $bdd->prepare('SELECT * FROM catalog_items WHERE page_id = ?');
$cata->execute([$subCategoryId]);
$furnitures = $cata->fetchAll();


    ?>

    <div id="items-<?= $subCategoryId; ?>">
    <p class="title is-6" style="margin-top: 10px"><?= $caption; ?></p>
    <?php
    foreach($furnitures as $item) { 

$cata2 = $bdd->prepare('SELECT * from items_base WHERE id = ?');
$cata2->execute([$item['item_ids']]);
$furniture = $cata2->fetch();
    	?>

    <div class="item tooltip" item-id="<?= $item['item_ids']; ?>" item-parent="<?= $item['page_id']; ?>" data-tooltip="<?= $furniture['item_name']; ?>">
        <img src="<?= $swf_icon_link ?><?= str_replace("*","_", $furniture['item_name']) ?>_icon.png">
    </div>
    <?php } ?>
</div>