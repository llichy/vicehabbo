<?php
include '../global.php';

   // if ($user->get('rank') < 5) {
   //      $user->end();
   // }

$_GET['page'] = "dashboard";

include './tmp/header.php';

$query1 = $db->connect()->prepare('SELECT * FROM users WHERE online = ?');
$query1->execute([1]);
$data1 = $query1->rowCount();

$query2 = Database::connect()->prepare("SELECT * FROM users");
$query2->execute();
$data2 = $query2->rowCount();

$query3 = Database::connect()->prepare("SELECT * FROM bans");
$query3->execute();
$data3 = $query3->rowCount();

?>
            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                        <li><a href="#">Administration</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Dashboard</a></li>
                    </ul>
                </nav>

                <section class="hero is-info welcome is-small">
                    <div class="hero-body">
                        <div class="container">
                            <h1 class="title">
                                Salut, <?= $user->get('username') ?>.
                            </h1>
                            <h2 class="subtitle">
                                J'espère que tu passes une bonne journée !
                            </h2>
                        </div>
                    </div>
                </section>
                <section class="info-tiles">
                    <div class="tile is-ancestor has-text-centered">
                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <p class="title"><?= $data1 ?></p>
                                <p class="subtitle">En ligne</p>
                            </article>
                        </div>
                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <p class="title"><?= $data2 ?></p>
                                <p class="subtitle">Inscrits</p>
                            </article>
                        </div>
                        <div class="tile is-parent">
                            <article class="tile is-child box">
                                <p class="title"><?= $data3 ?></p>
                                <p class="subtitle">Bannis</p>
                            </article>
                        </div>
                    </div>
                </section>
                <div class="columns">
                    <div class="column is-6">
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    10 derniers inscrits
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                </a>
                            </header>
                            <div class="card-table">
                                <div class="content">
                                    <table class="table is-fullwidth is-striped">
                                        <tbody>
                                    <?php
                                    $query = $db->connect()->prepare('SELECT * FROM users ORDER BY id DESC LIMIT 10');
                                    $query->execute();
                                    $fetch = $query->fetchAll();
                                    
                                          for ($i = 0; $i < count($fetch); $i++) { ?>
                                            <tr>
                                                <td width="10%">
                                                    <img src="https://www.habbo.com/habbo-imaging/avatarimage?figure=<?= $fetch[$i]['look'] ?>&direction=3&head_direction=2&action=&gesture=nrm&headonly=1">
                                                </td>
                                                <td><?= $fetch[$i]['username'] ?></td> 
                                                <td class="level-right"><a class="button is-small is-primary" href="#">Voir</a></td>
                                            </tr>
                                        <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    10 derniers bannis
                                </p>
                                <a href="#" class="card-header-icon" aria-label="more options">
                  <span class="icon">
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </span>
                </a>
                            </header>
                            <div class="card-table">
                                <div class="content">
                                    <table class="table is-fullwidth is-striped">
                                        <tbody>
                                                                                <?php
                                    $query = $db->connect()->prepare('SELECT * FROM bans ORDER BY id DESC LIMIT 10');
                                    $query->execute();
                                    $fetch = $query->fetchAll();
                                    
                                          for ($i = 0; $i < count($fetch); $i++) { ?>
                                            <tr>
                                                <td width="5%"><i class="fa fa-bell-o"></i></td>
                                                <td><?= $fetch[$i]['username'] ?></td>
                                                
                                            </tr>
                                           <?php } ?>
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