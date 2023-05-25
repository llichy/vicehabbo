<?php

@session_start();
require_once "./inc/config.php";
?>

<script>
Sortable.create(categories, {
    onEnd: function(event) {
        var categories = { };
        
        $("#categories .category").each(function(index) {
            var categoryId = $(this).attr("id");
            categories[index] = categoryId;
        });

        $.get(hostname + "/setOrderCategoryById.php", {
            categories: categories,
        })
        .done(function(content) {
        });
    }
});
</script>
<div id="categories">
    <?php
    $navigationId = $_GET['id'];

$cata = $bdd->prepare('SELECT * FROM catalog_pages WHERE parent_id = ? ORDER by order_num ASC');
$cata->execute([$navigationId]);
$categories = $cata->fetchAll();

    foreach($categories as $category) { ?>
        <!-- Catégorie -->
        <div id="<?= $category['id']; ?>" class="category">
            <a category-id="<?= $category['id']; ?>" category-parent="<?= $category['parent_id']; ?>" category-caption="<?= $category['caption']; ?>" class="panel-block droppable" >
            <img src="<?= $icone_link ?><?= $category['icon_image']; ?>.png"> 
                <span><?= utf8_encode($category['caption']) ?> <b>[ID: <?= $category['id'] ?>]</b></span>  
            </a>

            <!-- Sous-catégories -->
            <div class="subCategories" category-id="<?= $category['id']; ?>">
                
            </div>
            <!-- Sous-catégories -->
        </div>
        <!-- Catégorie -->
    <?php } ?>
</div>