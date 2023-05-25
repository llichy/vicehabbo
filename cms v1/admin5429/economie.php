<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../global.php';

$_GET['page'] = "economie";


	if(isset($_POST['addfurni'])){

	if(empty($_POST['items_base_id']) && empty($_POST['type'])){
		$which = "error";
		$message = "Merci de remplir les champs vides.";
	}else {
	$items_base_id = $_POST['items_base_id'];
	$categorie = $_POST['categorie'];
	$nombre = $_POST['nombre'];
	$prix = $_POST['prix'];
	$type = $_POST['type'];
	$ordre = $_POST['ordre'];

	$query3 = $db->connect()->prepare('INSERT INTO `economy_furniture` (`items_base_id`, `economy_categories_id`, `amount`, `points_type`,`points_amount`,`order`) VALUES(?, ?, ?, ?, ?, ?)');
	$query3->execute([$items_base_id,$categorie,$nombre,$type,$prix,$ordre]);

	$sql2 = $db->connect()->prepare('INSERT INTO admin (user_id,username,type,action,date,ip) VALUES (?, ?, ?, ?, ?, ?)');
	$sql2->execute([$user->get('id'),$user->get('username'), "economie", $items_base_id, time(), $user->get('ip_last')]);

	$which = "success";
	$message= "Le mobis a été ajouté avec succès";

	}
}


include './tmp/header.php';

?>
            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                        <li><a href="./">Administration</a></li>
                        <li><a href="#">Fondation</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Economie</a></li>
                    </ul>
                </nav>

<?PHP if(isset($message)) { ?>
<div class="notification is-<?= $which ?>">
  <?= $message ?>
</div>
 <?php } ?>

<form class="box" action="economie.php" method="post">
    <h1 class="title">Economie</h1>

  <div class="field">
    <label class="label">Id du mobis</label>
    <div class="control">
      <input class="input" type="text" name="items_base_id" placeholder="Id du mobis">
    </div>
  </div>

  <div class="field">
    <label class="label">Catégorie du mobis</label>
    <div class="control">

      <select class="input" name="categorie">
      <option value="1">Communs</option>
      <option value="2">Rares</option>
      <option value="3">Epiques</option>
      <option value="4">Legendaires</option>
      <option value="5">Mythiques</option>
      <option value="6">LTD</option>
      <option value="7">Tableaux</option>
       <option value="8">LTD</option>
      </select>

    </div>
  </div>


    <div class="field">
    <label class="label">Exemplaire</label>
    <div class="control">
      <input class="input" type="text" name="nombre" placeholder="Exemplaire de mobis">
    </div>
  </div>

  <div class="field">
    <label class="label">Prix</label>
    <div class="control">
      <input class="input" type="text" name="prix" placeholder="Prix">
    </div>
  </div>

    <div class="field">
    <label class="label">Point type</label>
    <div class="control">
      <input class="input" type="text" name="type" placeholder="La monnaie">
    </div>
  </div>

      <div class="field">
    <label class="label">Ordre</label>
    <div class="control">
      <input class="input" type="text" name="ordre" placeholder="Ordre du mobis">
    </div>
  </div>


  <button type="submit" name="addfurni" class="button is-primary">Ajouter le mobis</button>
</form>      


<div class="box">
<h1 class="title">Liste des derniers mobis ajoutés</h1>

<div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
              <tr>
                <th>#</th>
                <th>Id furni</th>
                <th>Par</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
           
    <?php
    $query = $db->connect()->prepare('SELECT * FROM admin WHERE type = ? ORDER BY id DESC LIMIT 10');
    $query->execute(["economie"]);

    $fetch = $query->fetchAll();
    for ($i = 0; $i < count($fetch); $i++) { ?>
           <tr> <td class="is-image-cell"><?= $fetch[$i]['id'] ?></td>
                <td class="is-image-cell"><?= $fetch[$i]['action'] ?></td>
                <td data-label="Name"><?= $fetch[$i]['username'] ?></td>
                <td data-label="Company">Il y a <?= $system->timeAgo($fetch[$i]['date']) ?></td>
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