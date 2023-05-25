<?php
include '../global.php';

$_GET['page'] = "news";


    if(isset($_POST['titre']) || isset($_POST['desc']) || isset($_POST['image']) || isset($_POST['article'])) {
   $titre = htmlentities($_POST['titre']);
   $desc = htmlentities($_POST['desc']); 
   $image = $_POST['image'];
   $article = trim($_POST['article']);
      if($titre != "" && $desc != "" && $image != "" && $article != "") {
          
    $query3 = $db->connect()->prepare('INSERT INTO site_news (title, seo_link, topstory_image, snippet,body,datestr,staff,timestamp) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
    $query3->execute([$titre,"",$image,$desc,$article,time(),$user->get('id'), time()]);
    
    $message = "L'articlé a été ajouté, maintenant il est en attente d'approbation !";
    $which = "success";
    } else {
    $message = "Erreur lors de la publication";
    $which = "danger";
    }
  }


include './tmp/header.php';

   // if ($user->get('rank') > 5) {
   //      $user->end();
   // }


?>

            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                                                 <li><a href="./">Administration</a></li>
                        <li><a href="./">Articles</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Créer un article</a></li>
                    </ul>
                </nav>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="./scripts/ckeditor/ckeditor.js"></script>
<script src="./scripts/ckeditor/adapters/jquery.js"></script>

<?PHP if(isset($message)) { ?>
<div class="notification is-<?= $which ?>">
  <?= $message ?>
</div>
 <?php } ?>
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Créer un article
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                </a>
                            </header>
         

  

        <form name='editor' method='post' action="?do=add" class="box">
  <div class="field">
    <label class="label">Titre</label>
    <div class="control">
      <input class="input" name='titre' type="text" placeholder="titre">
    </div>
  </div>

    <div class="field">
    <label class="label">Description</label>
    <div class="control">
      <input class="input" name='desc' type="text" placeholder="description">
    </div>
  </div>

  <div class="field">
    <label class="label">Image</label>
    <div class="control">
      <input class="input" type="text" name='image' placeholder="image">
    </div>
  </div>

    <div class="field">
    <label class="label">Texte</label>
    <div class="control">
    <textarea cols="130" id="editor1" rows="10" name="article" class="span8"></textarea>
    <script>
    // THIS IS REQUIRED JAVASCRIPT FOR THE NEWS EDITOR
    CKEDITOR.replace( 'editor1' );
    </script>
    </div>
  </div>

  <button type="submit" class="button is-primary">Créer l'article</button>
</form>

  

                        </div>
                  


            </div>
        </div>
    </div>

   <?php

   include './tmp/footer.php'; 
?>