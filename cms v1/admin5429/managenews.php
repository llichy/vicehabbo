<?php
include '../global.php';

$_GET['page'] = "editnews";

$modif = $_GET['modif'];


if(isset($_GET['noattente']) != "") {

$query = $db->connect()->prepare('UPDATE site_news SET attente = ? WHERE id = ?');
$query->execute([0,$_GET['noattente']]);

$which = "success";
$message= "L'article a été publié !";
}

if(isset($_GET['enattente']) != "") {

$query = $db->connect()->prepare('UPDATE site_news SET attente = ? WHERE id = ?');
$query->execute([1,$_GET['enattente']]);
$which = "success";
$message= "L'article a été mis en attente !"; 
}

if (isset($_GET['modifiernews']) != "") {
if(isset($_POST['titre']) || isset($_POST['desc']) || isset($_POST['image']) || isset($_POST['article'])) {
$titre = htmlentities($_POST['titre']);
$desc = htmlentities($_POST['desc']);
$image = $_POST['image'];
$article = trim($_POST['article']);
if($titre != "" && $desc != "" && $image != "" && $article != "") {
$query = $db->connect()->prepare('UPDATE site_news SET title = ?, datestr = ?, timestamp = ?, snippet = ?, body = ?, staff = ?, topstory_image = ? WHERE id = ?');
$query->execute([$titre, time(),time(),$desc,$article,$users[0]['id'],$image,$_GET['modifiernews']]);

$which = "success";
$message="L'article vient d'être modifié !";
} else {
$which = "danger";    
$message="Merci de remplir les champs vides !";
}
}
}   

if(isset($_GET['delete']) != "") 
{
$query = $db->connect()->prepare("DELETE FROM site_news WHERE id = ?");
$query->execute([$_GET['delete']]);
$which = "danger";  
$message="L'article id ".$_GET['delete']." a été correctement supprimé !";
}

include './tmp/header.php';


?>
            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                         <li><a href="./">Administration</a></li>
                        <li><a href="#">Articles</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Gestion des articles</a></li>
                    </ul>
                </nav>
                
<?PHP if(isset($message)) { ?>
<div class="notification is-<?= $which ?>">
  <?= $message ?>
</div>
 <?php } ?>

 <?php 
$query456 = $db->connect()->prepare('SELECT * FROM site_news WHERE attente = ?');
$query456->execute([1]);
$fetch456 = $query456->fetchAll();
?>


<div class="notification is-warning">
  <?= count($fetch456) ?> article(s) en attente d'approbation !
</div>
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Gerer les articles
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                </a>
                            </header>
  <?php if ($modif == "") { ?>        
      <div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
              <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Status</th>
                <th>A</th>
                <th>M</th>
                <th>S</th>
              </tr>
              </thead>
              <tbody>
                                    <?php
                                    $query = $db->connect()->prepare('SELECT * FROM site_news ORDER BY id DESC LIMIT 10');
                                    $query->execute();
                                    
                                    $fetch = $query->fetchAll();
                                    
                                    
                                    
                                        
                                         for ($i = 0; $i < count($fetch); $i++) { ?>
              <tr>
                <td class="is-image-cell"><?= $fetch[$i]['id'] ?></td>
                <td data-label="Name"><?= $fetch[$i]['title'] ?></td>
                <td data-label="Company"><?= $user->get('username', $fetch[$i]['staff']) ?></td>
                 <td data-label="Company"><?php if($fetch[$i]['attente'] == 1) { ?><b style="color:red">En attente</b><?php }else{?><b style="color:green">En ligne</b><?php }?></td>
                <td class="is-actions-cell">
<?php if($fetch[$i]['attente'] == 1) { ?>
                     <a href="?noattente=<?= $fetch[$i]['id']?>"><button class="button is-small is-primary" type="button">
                      <span class="icon"><i class="fa fa-check-square"></i></span>
                    </button></a>
<?php }else{?>
                    <a href="?enattente=<?= $fetch[$i]['id']?>"><button class="button is-small is-warning" type="button">
                    <span class="icon"><i class="fa fa-ban fa-fw"></i></span>
                    </button></a>
<?php }?>

                </td>
                <td class="is-actions-cell">
                     <a href="?modif=<?= $fetch[$i]['id']?>"><button class="button is-small is-primary" type="button">
                      <span class="icon"><i class="fa fa-pencil fa-fw"></i></span>
                    </button></a>
                </td>
                 <td class="is-actions-cell">
                   <a href="?delete=<?= $fetch[$i]['id']?>">    <button class="button is-small is-danger" type="button">
                      <span class="icon"><i class="fa fa-trash-o"></i></span>
                    </button></a>
                </td>
              </tr>
  <?php  }
                                    ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

                                <?php
    }
    ?>
<?php if ($modif != "") { ?>
    <?php   
    $query = $db->connect()->prepare('SELECT * FROM site_news WHERE id = ?');
    $query->execute([$modif]);

    $fetch = $query->fetchAll();

    ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="./scripts/ckeditor/ckeditor.js"></script>
<script src="./scripts/ckeditor/adapters/jquery.js"></script>

        <form name='editor' method='post' action="?modifiernews=<?php echo $modif; ?>" class="box">
  <div class="field">
    <label class="label">Titre</label>
    <div class="control">
      <input class="input" name='titre' type="text" value="<?= $fetch[0]['title']; ?>">
    </div>
  </div>

    <div class="field">
    <label class="label">Description</label>
    <div class="control">
      <input class="input" name='desc' type="text" value="<?= $fetch[0]['snippet']; ?>">
    </div>
  </div>

  <div class="field">
    <label class="label">Image</label>
    <div class="control">
      <input class="input" type="text" name='image' value="<?= $fetch[0]['topstory_image']; ?>">
    </div>
  </div>

    <div class="field">
    <label class="label">Texte</label>
    <div class="control">
    <textarea cols="130" id="editor1" rows="10" name="article" class="span8"><?= $fetch[0]['body']; ?></textarea>
    <script>
    // THIS IS REQUIRED JAVASCRIPT FOR THE NEWS EDITOR
    CKEDITOR.replace( 'editor1' );
    </script>
    </div>
  </div>

  <button type="submit" class="button is-primary">Modifier l'article</button>
</form>

<?php
}
?>
                        </div>
                  


            </div>
        </div>
    </div>

   <?php

   include './tmp/footer.php'; 
?>