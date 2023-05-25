<?php
include '../global.php';
$_GET['page'] = "info";
include './tmp/header.php';

   // if ($user->get('rank') > 5) {
   //      $user->end();
   // }


?>

            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                                                 <li><a href="./">Administration</a></li>
                        <li><a href="./">Utilisateurs</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Informations d'un joueur</a></li>
                    </ul>
                </nav>


                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Chercher un joueur
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                </a>
                            </header>
         


          <form method='get' action="" class="box">
        <div class="field">
            <label class="label">Pseudo</label>
            <div class="control">
                <input class="input" name='pseudo' type="text" placeholder="Pseudo">
            </div>
        </div>

          <button type="submit" class="button is-primary">Rechercher</button>
    </form>
    <?php
    if (isset($_GET['pseudo'])) {

    $query52 = $db->connect()->prepare('SELECT * FROM users WHERE username = ?');
    $query52->execute([$_GET['pseudo']]);
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
<div class="columns">
    <div class="column is-6"> 

    <div class="field">
    <label class="label">Id</label>
    <div class="control">
    <input class="input" name='idd' type="text" disabled value="<?= $fetch52[0]['id']; ?>">
    </div>
    </div>

    <div class="field">
    <label class="label">Pseudo</label>
    <div class="control">
    <input class="input" name='pseudo' type="text" disabled value="<?= $fetch52[0]['username']; ?>">
    </div>
    </div>

        <div class="field">
        <label class="label">Mission</label>
        <div class="control">
        <input class="input" name='pseudo' type="text" disabled value="<?= $fetch52[0]['motto']; ?>">
        </div>
        </div>

        <div class="field">
        <label class="label">Rank</label>
        <div class="control">
        <input class="input" name='pseudo' type="text" disabled value="<?= $fetch52[0]['rank']; ?>">
        </div>
        </div>

        <div class="field">
        <label class="label">Dernière connexion</label>
        <div class="control">
        <input class="input" name='pseudo' type="text" disabled value="Il y a <?= $system->timeAgo($fetch52[0]['last_online']); ?>">
        </div>
        </div>

               <div class="field">
        <label class="label">Inscription</label>
        <div class="control">
        <input class="input" name='pseudo' type="text" disabled value="Il y a <?= $system->timeAgo($fetch52[0]['account_created']); ?>">
        </div>
        </div>

    </div>

    <div class="column is-6"> 

    <div class="field">
    <label class="label">look</label>
    <div class="control">
    <img src="<?= AVATAR ?><?=  $fetch52[0]['look'];?>&size=m">
    </div>
    </div>
<?php if ($user->get('rank') >= 16) { ?>
    <div class="field">
    <label class="label">Ip Inscription</label>
    <div class="control">
    <input class="input" name='pseudo' type="text" disabled value="<?= $fetch52[0]['ip_register']; ?>">
    </div>
    </div>
    <div class="field">
    <label class="label">Dernière ip</label>
    <div class="control">
    <input class="input" name='pseudo' type="text" disabled value="<?= $fetch52[0]['ip_last']; ?>">
    </div>
    </div>
<?php } ?>
    <div class="field">
    <label class="label">Mail</label>
    <div class="control">
    <input class="input" name='pseudo' type="text" disabled value="<?= $fetch52[0]['mail']; ?>">
    </div>
    </div>



    </div>

</div>
        </div>
  </div>

         <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Multicomptes
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                </a>
                            </header>
          
      <div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
              <tr>
                <th>#</th>
                <th>Pseudo</th>
                <th>look</th>
                <th>Ip inscription</th>
                <th>Dernière ip</th>
                <th>Dernière connexion</th>
                <th>Bannir</th>
              </tr>
              </thead>
              <tbody>
      <?php
        $query59 = $db->connect()->prepare('SELECT * FROM users WHERE ip_register = ? ORDER BY id LIMIT 0,100');
        $query59->execute([$fetch52[0]['ip_register']]);
        $fetch59 = $query59->fetchAll();
        for ($i = 0; $i < count($fetch59); $i++) {?>
            <tr>
            <td class="is-image-cell"><?= $fetch59[$i]['id'] ?></td>
            <td data-label="Name"><?= $fetch59[$i]['username'] ?></td>
            <td data-label="Company"><img src="<?= AVATAR ?><?= $fetch59[$i]['look'] ?>&size=s"></td>
            <td data-label="Company"><?= $fetch59[$i]['ip_register'] ?></td>
            <td data-label="Company"><?= $fetch59[$i]['ip_last'] ?></td>
            <td data-label="Company">Il y a <?= $system->timeAgo($fetch59[$i]['last_online']); ?></td>
            <td class="is-actions-cell">
            <a href="?ban=<?= $fetch59[$i]['id']?>">    <button class="button is-small is-danger" type="button">
            <span class="icon"><i class="fa fa-trash-o"></i></span>
            </button></a>
            </td>
            </tr>
            <?php  } ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>

 </div>



         <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Sessions ouvertes
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                </a>
                            </header>
          
      <div class="card-content">
        <div class="b-table has-pagination">
          <div class="table-wrapper has-mobile-cards">
            <table class="table is-fullwidth is-striped is-hoverable is-fullwidth">
              <thead>
              <tr>
                <th>#</th>
                <th>Pseudo</th>
                <th>look</th>
                <th>Navigateur</th>
                <th>IP</th>
                <th>Session ouvertes</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
            <?php
            $query59 = $db->connect()->prepare('SELECT * FROM cms_sessions WHERE user_id = ? ORDER BY id LIMIT 0,100');
            $query59->execute([$fetch52[0]['id']]);
            $fetch59 = $query59->fetchAll();
            for ($i = 0; $i < count($fetch59); $i++) { ?>
            <tr>
            <td class="is-image-cell"><?= $fetch59[$i]['user_id'] ?></td>
            <td data-label="Name"><?= $user->get('username', $fetch59[$i]['user_id']) ?></td>
            <td data-label="Company"><img src="<?= AVATAR ?><?= $user->get('look', $fetch59[$i]['user_id']) ?>&size=s"></td>
            <td data-label="Company"><?= $fetch59[$i]['navigateur'] ?></td>
            <td data-label="Company"><?= $fetch59[$i]['ip'] ?></td>
            <td data-label="Company">Il y a <?= $system->timeAgo($fetch59[$i]['times']); ?></td>
            <td class="is-actions-cell">
            <a href="?delete=<?= $fetch59[$i]['id']?>">    <button class="button is-small is-danger" type="button">
            <span class="icon"><i class="fa fa-trash-o"></i></span>
            </button></a>
            </td>
            </tr>
            <?php  } ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>

                                                        </div>
<?php }  } ?>
<!--
        <div class="field">
            <label class="label">Description</label>
            <div class="control">
                <input class="input" name='motto' type="text" value="<?php echo $user['motto']; ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">E-mail</label>
            <div class="control">
                <input class="input" type="mail" name='mail' value="<?php echo $user['mail']; ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">Rank</label>
            <div class="control">
                <input class="input" type="rank" name='rank' value="<?php echo $user['rank']; ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">Dernière IP</label>
            <div class="control">
                <input class="input" type="text" name='ip_last' value="<?php echo $user['ip_last']; ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">IP à l'inscription</label>
            <div class="control">
                <input class="input" type="text" name='ip_register' value="<?php echo $user['ip_register']; ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">Crédits</label>
            <div class="control">
                <input class="input" type="text" name='credits' value="<?php echo $user['credits']; ?>">
            </div>
        </div>

        <div class="field">
            <label class="label">BiboCash</label>
            <div class="control">
                <input class="input" type="text" name='bibocash' value="<?php echo $user['bibocash']; ?>">
            </div>
        </div>
-->
 
  

                        </div>
                  


            </div>
        </div>
    </div>

   <?php

   include './tmp/footer.php'; 
?>
