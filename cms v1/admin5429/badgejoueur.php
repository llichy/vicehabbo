<?php
include '../global.php';
$_GET['page'] = "badgejoueur";


if (isset($_GET['pseudo'])) {
    $NAME = $_GET['pseudo'];
    
    $check = $db->connect()->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $check->execute([$NAME]);
    $exists = $check->rowCount();
    if(!empty($NAME)){
    if($exists > 0){
        
        $row = $check->fetchAll();
    $sql = $db->connect()->prepare('INSERT INTO admin (user_id,username,action,date,ip) VALUES (?, ?, ?, ?, ?)');
    $sql->execute([$user->get('id'),$user->get('username'), "A consulter badge de ".$row[0]['username']." ", time(), $user->get('ip_last')]);
        $editor_mode = 'actif';
    } else {
        $message= "L'utilisateur n'existe pas!";
        $which = "danger";
    }
    } else {
    $message="Merci de mettre un pseudo";
    $which = "danger";
    }
}

if($_GET['supprimer'] != "") {
    $editor_mode = 'actif';
    
            $sql = $db->connect()->prepare('INSERT INTO admin (user_id,username,action,date,ip) VALUES (?, ?, ?, ?, ?)');
            $sql->execute([$user->get('id'),$user->get('username'), "Suppresion du badge de ".$row[0]['username']." ", time(), $user->get('ip_last')]);
            
        $suppression = $db->connect()->prepare("DELETE FROM users_badges WHERE id = ? ");
        $suppression->execute([$_GET['supprimer']]);

            $which = "success";
            $message="Le badge a été supprimé avec succès";
            }


include './tmp/header.php';



?>
<style>
.badgeGestion{position:relative;cursor:pointer;float:left;margin:0 0 10px 10px;border-radius:3px;width:calc(100%/9 + 8px);text-align:center;line-height:63px;height:63px;background:rgba(0,0,0,.09)}.zmdi{display:inline-block;font:normal normal normal 14px/1 'Material-Design-Iconic-Font';font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.badgeGestion[slot="1"]{background:rgba(255,152,0,.3)}.badgeGestion>img{vertical-align:middle}.croix{position:absolute;right:-5px;font-weight:700;top:-5px;color:#fff;background:#c62828;width:20px;height:20px;text-align:center;line-height:20px;font-size:12px;border-radius:50px;box-shadow:0 0 0 3px #fff}.tooltip{position:absolute;z-index:999999;background:rgba(0,0,0,.8);color:#fff;font-size:12px;border-radius:3px;padding:6px 8px}.tooltip:after{content:'';border:5px solid transparent;position:absolute}.tooltip[direction="top"]:after{border-top-color:rgba(0,0,0,.8);left:calc(50% - 5px);bottom:-10px}.tooltip[direction="right"]:after{border-right-color:rgba(0,0,0,.8);left:-10px;top:calc(50% - 5px)}.tooltip[direction="left"]:after{border-left-color:rgba(0,0,0,.8);right:-10px;top:calc(50% - 5px)}.tooltip[direction="bottom"]:after{border-bottom-color:rgba(0,0,0,.8);left:calc(50% - 5px);top:-10px}.tooltip>p{color:#fff}
</style>
            <div class="column is-9">
                <nav class="breadcrumb" aria-label="breadcrumbs">
                    <ul>
                                                 <li><a href="./">Administration</a></li>
                        <li><a href="./">Utilisateurs</a></li>
                        <li class="is-active"><a href="#" aria-current="page">Inventaire d'un joueur</a></li>
                    </ul>
                </nav>
<?PHP if(isset($message)) { ?>
<div class="notification is-<?= $which ?>">
  <?= $message ?>
</div>
 <?php } ?>

                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Badges d'un joueur
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

<?php if($editor_mode == 'actif'){ ?>

    <div class="box">
        Badges de <?= $row[0]['username']; ?>
    <div class="field">
                            <div class="con">
                                <div style="padding: 10px;">
                                   <table width="100%" style="margin-bottom: 10px;">
                                        <tr>
 <div class="badgelist">
                                        <?php
                                        
                                        $badgeurl = 'https://vicehabbo.fr/swf/c_images/album1584/';
                                        $query = $db->connect()->prepare('SELECT * FROM users_badges WHERE user_id = ? ORDER BY id DESC');
                                        $query->execute([$row[0]['id']]);

                                        $fetch = $query->fetchAll();

                                        if (count($fetch) < 1) {
                                            ?>
                                            <div class="error">
                                               <?= $row[0]['username']; ?> n'a aucun badge pour le moment
                                            </div>
                                            <?php
                                        } else {
                                                 for ($i = 0; $i < count($fetch); $i++) {
                                                $badgeid = $fetch[$i]['badge_code'];
                                                $badge_id = $fetch[$i]['id'];
                                                $slot = ($fetch[$i]['slot_id'] > 0) ? 'retirer' : 'porter';
                                                $slote = ($fetch[$i]['slot_id'] > 0) ? 1 : 0;
                                                ?>
                                                <div  class="badgeGestion" slot="<?= $slote; ?>" id="<?= $badgeid; ?>">
                                                    <img src="<?= $badgeurl . $badgeid; ?>.gif"/>
                                                    <a href="badgejoueur.php?pseudo=<?= $_GET['pseudo']; ?>&supprimer=<?= $badge_id; ?>" class="croix">X</a>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div> 
                                      </tr>
                                        </table>
                            </div>
                            </div>
    </div>

    </div>


        </div>
  </div>

<?php  } ?>
 
  

                        </div>
                  


            </div>
        </div>
    </div>

   <?php

   include './tmp/footer.php'; 
?>
