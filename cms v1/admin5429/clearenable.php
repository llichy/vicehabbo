<?php
include '../global.php';

$_GET['page'] = "clearenable";


if(isset($_GET['empty_table'])) {
    $query = $db->connect()->prepare('TRUNCATE TABLE users_effects');
    $query->execute();
    $which = "success";
    $message= "La table a été vidée !";
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
                        <li><a href="./">Base de données</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Clear Enable</a></li>
                    </ul>
                </nav>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="./scripts/ckeditor/ckeditor.js"></script>
<script src="./scripts/ckeditor/adapters/jquery.js"></script>

<div class="notification is-warning">
  Cette page sert à vidé la table enable pour les coffres.
</div>

<?PHP if(isset($message)) { ?>
<div class="notification is-<?= $which ?>">
  <?= $message ?>
</div>
 <?php } ?>
 <form method="GET">
  <button type="submit" name="empty_table" value="true" class="button is-primary">Vider la table</button>
</form>


  

                        </div>
                  


            </div>
        </div>
    </div>

   <?php

   include './tmp/footer.php'; 
?>