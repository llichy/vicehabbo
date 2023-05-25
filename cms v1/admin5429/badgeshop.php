<?php
include '../global.php';

$_GET['page'] = "badgeshop";



        if (isset($_GET['do']) == "add") 
        {
        $name= $_POST['name'];
        $badgeid= $_POST['badgeid'];
        $stock= $_POST['stock'];
        $prix= $_POST['prix'];

        if (isset($badgeid) ||  isset($prix) ||  isset($stock)) 
        {
        if (!empty($badgeid) ||  !empty($prix) ||  !empty($stock)) {

        $sql = $db->connect()->prepare(" INSERT INTO cms_shop_badges (badge_id, name, prix, stock) VALUES (?, ?, ?, ?)");
        $sql->execute([$badgeid, $name, $prix, $stock]);
       // $sql2 = $db->connect()->prepare('INSERT INTO admin (user_id,username,action,date,ip) VALUES (?, ?, ?, ?, ?)');
        //$sql2->execute([$users[0]['id'],$users[0]['username'], "Ajout badge boutique ".$badgeid." ", time(), $users[0]['last_ip']]);
        $which = "success";
        $message="Le badge code ".$badgeid." a été ajouté avec succès.";
        } else {
        $which = "danger";
        $message = "Merci de remplir les champs vides.";
        }
        }

        }


    if (!empty($_GET['del'])) {
    $delete = isset($_GET['del']);
    //$sql = $db->connect()->prepare('INSERT INTO admin (user_id,username,action,date,ip) VALUES (?, ?, ?, ?, ?)');
       // $sql->execute([$users[0]['id'],$users[0]['username'], "Suppresion badge boutique id ".$_GET['del']." ", time(), $users[0]['last_ip']]);
        $suppression = $db->connect()->prepare("DELETE FROM cms_shop_badges WHERE id = ? ");
        $suppression->execute([$_GET['del']]);
    
    $which = "danger";  
    $message="Le badge id ".$_GET['del']." a été correctement supprimé !";
            }

include './tmp/header.php';

?>
            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                        <li><a href="./">Administration</a></li>
                        <li><a href="#">Boutique</a></li>
                        <li class="is-active"><a href="#" aria-current="page">BadgeShop</a></li>
                    </ul>
                </nav>

<?PHP if(isset($message)) { ?>
<div class="notification is-<?= $which ?>">
  <?= $message ?>
</div>
 <?php } ?>

<form class="box" method="post" action="?do=add">
    <h1 class="title">Ajouter un badge</h1>

  <div class="field">
    <label class="label">Titre du badge</label>
    <div class="control">
      <input class="input" type="text" name="name" placeholder="Titre du badge">
    </div>
  </div>

  <div class="field">
    <label class="label">Code du badge</label>
    <div class="control">
      <input class="input" type="text" name="badgeid" placeholder="Code du badge">
    </div>
  </div>

    <div class="field">
    <label class="label">Stock</label>
    <div class="control">
      <input class="input" type="text" name="stock" placeholder="Stock">
    </div>
  </div>

    <div class="field">
    <label class="label">Prix du badge</label>
    <div class="control">
      <input class="input" type="text" name="prix" placeholder="Prix du badge">
    </div>
  </div>


  <button type="submit" class="button is-primary">Ajouter le badge</button>
</form>      


<div class="box">
<h1 class="title">Liste des badges</h1>

<div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Stock</th>
                <th>Prix</th>
                <th>S</th>
              </tr>
              </thead>
              <tbody>
           
    <?php
    $query = $db->connect()->prepare('SELECT * FROM cms_shop_badges ORDER BY id DESC LIMIT 10');
    $query->execute();

    $fetch = $query->fetchAll();
    for ($i = 0; $i < count($fetch); $i++) { ?>
           <tr> <td class="is-image-cell"><?= $fetch[$i]['id'] ?></td>
                <td class="is-image-cell"><img src="https://images.habbo.com/c_images/album1584/<?= $fetch[$i]['badge_id'] ?>.gif"></td>
                <td data-label="Name"><?= $fetch[$i]['name'] ?></td>
                <td data-label="Company"><?= $fetch[$i]['stock'] ?></td>
                    <td data-label="Company"><?= $fetch[$i]['prix'] ?> Tokens</td>
                 <td class="is-actions-cell">
                   <a href="?del=<?= $fetch[$i]['id'] ?>">    <button class="button is-small is-danger" type="button">
                      <span class="icon"><i class="fa fa-trash-o"></i></span>
                    </button></a>
                </td>
           
              </tr> <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>

</div>   

              






                </div>
            </div>
        </div>
    </div>

   <?php

   include './tmp/footer.php'; 
?>