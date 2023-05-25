<?php
if ($user->get('rank') < 5) {
$user->end(); 
}  
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= sitename ?> - Administration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <!-- Bulma Version 0.9.0-->
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.0/css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
</head>

<body>

    <!-- START NAV -->
    <nav class="navbar is-white">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item brand-text" href="#">
          <?= sitename ?> Administration
        </a>
                <div class="navbar-burger burger" data-target="navMenu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

        </div>
    </nav>
        <!-- END NAV -->
    <div class="container">
        <div class="columns">
            <div class="column is-3 ">
                <aside class="menu is-hidden-mobile">
                    <p class="menu-label">
                        General
                    </p>
                    <ul class="menu-list">
                        <li><a href="./" class="<?php if ($_GET['page'] == "dashboard") { echo "is-active"; } ?>">Dashboard</a></li>
                        <li><a href="https://vicehabbo.fr/admin5429/catalogmn/">Catalog Manager</a></li>
                         <li><a href="./economie.php" class="<?php if ($_GET['page'] == "economie") { echo "is-active"; } ?>">Economie</a></li>
                          <li><a href="./logscmd.php" class="<?php if ($_GET['page'] == "logscmd") { echo "is-active"; } ?>">Logs command</a></li>
                       <!-- <li><a>Customers</a></li>
                        <li><a>Other</a></li>-->
                    </ul>


                    <p class="menu-label">
                        Administration
                    </p>

                                        <ul class="menu-list">
                        <li>
                            <a class="<?php if ($_GET['page'] == "info" || $_GET['page'] == "inventairejoueur" || $_GET['page'] == "badgejoueur") { echo "is-active"; } ?>" >Utilisateur</a>
                            <ul>
                                <li><a <?php if ($_GET['page'] == "info") { ?>class="is-active"<?php } ?>href="./info.php">Info d'un joueur</a></li>
                                <li><a <?php if ($_GET['page'] == "inventairejoueur") { ?>class="is-active"<?php } ?> href="./inventairejoueur.php">Inventaire joueur</a></li>
                                <li><a <?php if ($_GET['page'] == "badgejoueur") { ?>class="is-active"<?php } ?> href="./badgejoueur.php">Badge joueur</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="menu-list">
                        <li>
                            <a class="<?php if ($_GET['page'] == "news" || $_GET['page'] == "editnews") { echo "is-active"; } ?>" >Articles</a>
                            <ul>
                                <li><a <?php if ($_GET['page'] == "news") { ?>class="is-active"<?php } ?>href="./news.php">Créer un article</a></li>
                                <li><a <?php if ($_GET['page'] == "editnews") { ?>class="is-active"<?php } ?> href="./managenews.php">Gestion des articles</a></li>
                            </ul>
                        </li>
                        <!--<li><a>Invitations</a></li>
                        <li><a>Cloud Storage Environment Settings</a></li>
                        <li><a>Authentication</a></li>
                        <li><a>Payments</a></li>-->
                    </ul>
                    <ul class="menu-list">
                        <li><a <?php if ($_GET['page'] == "badgeshop") { ?>class="is-active"<?php } ?>>Boutique</a>

                        <ul>
                                <li><a <?php if ($_GET['page'] == "badgeshop") { ?>class="is-active"<?php } ?>href="./badgeshop.php">Gestion des badges</a></li>
                            </ul>
</li>
                            <ul class="menu-list">
                        <li><a <?php if ($_GET['page'] == "clearenable") { ?>class="is-active"<?php } ?>>Base de données</a>

                        <ul>
                                <li><a <?php if ($_GET['page'] == "clearenable") { ?>class="is-active"<?php } ?>href="./clearenable.php">Clear enable</a></li>
                            </ul>
                        </li>
                    </ul>
                </aside>
            </div>