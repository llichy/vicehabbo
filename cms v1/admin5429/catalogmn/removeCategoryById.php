<?php

@session_start();
require_once "./inc/config.php";

 $id = $_GET['id'];



$query2 = $bdd->prepare('DELETE FROM catalog_pages WHERE id = ?');
$query2->execute([$id]);

header('location: ./');


?>
