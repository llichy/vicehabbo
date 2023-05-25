<?php
include '../global.php';

$_GET['page'] = "logscmd";

include './tmp/header.php';

?>
            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                        <li><a href="./">Administration</a></li>
                        <li><a href="#">Fondation</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Logs commande</a></li>
                    </ul>
                </nav>

          <form method='get' action="" class="box">
        <div class="field">
            <label class="label">Pseudo du joueur</label>
            <div class="control">
                <input class="input" name='idplayer' type="text" placeholder="Pseudo du joueur">
            </div>
        </div>

          <button type="submit" class="button is-primary">Rechercher</button>
    </form>
    <?php
    if (isset($_GET['idplayer'])) {

    $query52 = $db->connect()->prepare('SELECT * FROM users WHERE username = ?');
    $query52->execute([$_GET['idplayer']]);
    $fetch52 = $query52->fetchAll();
    if (count($fetch52) < 1) {
    ?>
    <div class="notification is-danger">
    Ce joueur n'existe pas
    </div>
    <?php
    } else {
    ?>
<div class="box">
<h1 class="title">Liste des dernières commandes de <?= $user->get('username', $fetch52[0]['id']); ?></h1>

<div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
              <tr>
                <th>#</th>
                <th>Action</th>
                <th>Params</th>
                <th>Par</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
           
    <?php
      $LogParPage=25;

      $retour_total= $db->connect()->prepare('SELECT COUNT(*) AS total FROM commandlogs WHERE user_id = ?');
      $retour_total->execute([$fetch52[0]['id']]);
      $donnees_total= $retour_total->fetch();
      $total=$donnees_total['total'];

      $nombreDePages=ceil($total/$LogParPage);

      if (isset($_GET['pages']) && is_numeric($_GET['pages']))
      {
      $pageActuelle=intval($_GET['pages']);

      if($pageActuelle>$nombreDePages)
      {
      $pageActuelle=$nombreDePages;
      }
      }
      else
      {
      $pageActuelle=1;
      }

      $premiereEntree=($pageActuelle-1)*$LogParPage;


      $query00 = $db->connect()->prepare('SELECT commandlogs.id,commandlogs.params,commandlogs.timestamp,commandlogs.command,commandlogs.user_id FROM commandlogs INNER JOIN users ON commandlogs.user_id = users.id WHERE user_id = ? ORDER BY commandlogs.id DESC LIMIT '.$premiereEntree.', '.$LogParPage.'');
      $query00->execute([$fetch52[0]['id']]);

      echo '<p align="center">Page : ';
      for($i=1; $i<=$nombreDePages; $i++)
      {

      if($i==$pageActuelle)
      {
      echo ' [ '.$i.' ] '; 
      }  
      else
      {
      echo ' <a href="logscmd.php?idplayer='.$fetch52[0]['id'].'&pages='.$i.'">'.$i.'</a> ';
      }
      }
      echo '</p>';
    
    while($queryfetch=$query00->fetch()) {
      ?>
           <tr> <td class="is-image-cell"><?= $queryfetch['id'] ?></td>
                <td data-label="Name"><?= $queryfetch['command'] ?></td>
                <td data-label="Name"><?= $queryfetch['params'] ?></td>
                <td data-label="Name"><?= $user->get('username', $queryfetch['user_id']) ?></td>
                <td data-label="Company">Il y a <?= $system->timeAgo($queryfetch['timestamp']) ?></td>
              </tr> <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>

</div>   
<?php }  } else {?>
<div class="box">
<h1 class="title">Liste des dernières commandes staffs</h1>

<div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
              <tr>
                <th>#</th>
                <th>Action</th>
                <th>Params</th>
                <th>Par</th>
                <th>Date</th>
              </tr>
              </thead>
              <tbody>
           
    <?php
      $LogParPage=25;

      $retour_total= $db->connect()->prepare('SELECT COUNT(*) AS total FROM commandlogs');
      $retour_total->execute([]);
      $donnees_total= $retour_total->fetch();
      $total=$donnees_total['total'];

      $nombreDePages=ceil($total/$LogParPage);

      if (isset($_GET['pages']) && is_numeric($_GET['pages']))
      {
      $pageActuelle=intval($_GET['pages']);

      if($pageActuelle>$nombreDePages)
      {
      $pageActuelle=$nombreDePages;
      }
      }
      else
      {
      $pageActuelle=1;
      }

      $premiereEntree=($pageActuelle-1)*$LogParPage;


      $query00 = $db->connect()->prepare('SELECT commandlogs.id,commandlogs.params,commandlogs.timestamp,commandlogs.command,commandlogs.user_id FROM commandlogs INNER JOIN users ON commandlogs.user_id = users.id ORDER BY commandlogs.id DESC LIMIT '.$premiereEntree.', '.$LogParPage.'');
      $query00->execute([]);

      echo '<p align="center">Page : ';
      for($i=1; $i<=$nombreDePages; $i++)
      {

      if($i==$pageActuelle)
      {
      echo ' [ '.$i.' ] '; 
      }  
      else
      {
      echo ' <a href="logscmd.php?pages='.$i.'">'.$i.'</a> ';
      }
      }
      echo '</p>';
    
    while($queryfetch=$query00->fetch()) {
      ?>
           <tr> <td class="is-image-cell"><?= $queryfetch['id'] ?></td>
                <td data-label="Name"><?= $queryfetch['command'] ?></td>
                <td data-label="Name"><?= $queryfetch['params'] ?></td>
                <td data-label="Name"><?= $user->get('username', $queryfetch['user_id']) ?></td>
                <td data-label="Company">Il y a <?= $system->timeAgo($queryfetch['timestamp']) ?></td>
              </tr> <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>

</div>   
 <?php } ?>



                </div>
            </div>
        </div>
    </div>

   <?php

   include './tmp/footer.php'; 
?>