<?php
include '../global.php';
include './tmp/header.php';
?>
<div class="column is-9">
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="./">Administration</a></li>
            <li><a href="#">Boutique</a></li>
            <li class="is-active"><a href="#" aria-current="page">Add Badge</a></li>
        </ul>
    </nav>

    <?php if(isset($message)) { ?>
        <div class="notification is-<?= $which ?>">
            <?= $message ?>
        </div>
    <?php } ?>

    <form action="addbadge.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>

    <?php

    $target_dir = "swf/c_images/album1584/"; // répertoire où le fichier sera enregistré
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // chemin complet du fichier
    $uploadOk = 1; // variable pour vérifier si l'envoi est possible

    // Vérifie si le fichier est une image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Vérifie si le fichier existe déjà
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Vérifie la taille du fichier
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Autorise seulement certains types de fichiers
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Vérifie si $uploadOk est à 0 à cause d'une erreur
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // si tout est correct, essaye d'envoyer le fichier
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

   include './tmp/footer.php'; 
?>```
