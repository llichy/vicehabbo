<?php
include '../global.php';
$_GET['page'] = "inventairejoueur";


if (isset($_GET['pseudo'])) {
    $NAME = $_GET['pseudo'];
    
    $check = $db->connect()->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $check->execute([$NAME]);
    $exists = $check->rowCount();
    if(!empty($NAME)){
    if($exists > 0){
        
        $row = $check->fetchAll();
    $sql = $db->connect()->prepare('INSERT INTO admin (user_id,username,action,date,ip) VALUES (?, ?, ?, ?, ?)');
    $sql->execute([$user->get('id'),$user->get('username'), "A consulter inventaire de ".$row[0]['username']." ", time(), $user->get('ip_last')]);
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
            $sql->execute([$user->get('id'),$user->get('username'), "Suppresion du mobis de ".$row[0]['username']." ", time(), $user->get('ip_last')]);
            
            $suppression = $db->connect()->prepare("DELETE FROM items WHERE id = ?");
            $suppression->execute([$_GET['supprimer']]);

            $which = "success";
            $message="Le mobis a été supprimé avec succès";
            }


include './tmp/header.php';

?>
<style>
.badgeGestion{position:relative;cursor:pointer;float:left;margin:0 0 10px 10px;border-radius:3px;width:calc(100%/9 + 8px);text-align:center;line-height:63px;height:63px;background:rgba(0,0,0,.09)}.zmdi{display:inline-block;font:normal normal normal 14px/1 'Material-Design-Iconic-Font';font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.badgeGestion[slot="1"]{background:rgba(255,152,0,.3)}.badgeGestion>img{vertical-align:middle;margin-top:12px}.croix{position:absolute;right:-5px;font-weight:700;top:-5px;color:#fff;background:#c62828;width:20px;height:20px;text-align:center;line-height:20px;font-size:12px;border-radius:50px;box-shadow:0 0 0 3px #fff}.tooltip{position:absolute;z-index:999999;background:rgba(0,0,0,.8);color:#fff;font-size:12px;border-radius:3px;padding:6px 8px}.tooltip:after{content:'';border:5px solid transparent;position:absolute}.tooltip[direction="top"]:after{border-top-color:rgba(0,0,0,.8);left:calc(50% - 5px);bottom:-10px}.tooltip[direction="right"]:after{border-right-color:rgba(0,0,0,.8);left:-10px;top:calc(50% - 5px)}.tooltip[direction="left"]:after{border-left-color:rgba(0,0,0,.8);right:-10px;top:calc(50% - 5px)}.tooltip[direction="bottom"]:after{border-bottom-color:rgba(0,0,0,.8);left:calc(50% - 5px);top:-10px}.tooltip>p{color:#fff}
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
                                    Inventaire d'un joueur
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
        Inventaire de <?= $row[0]['username']; ?>
    <div class="field">
                            <div class="con">
                                <div style="padding: 10px;">
                                   <table width="100%" style="margin-bottom: 10px;">
                                        <tr>
 <div class="badgelist">
                                        <?php
            $itemurl = 'https://vicehabbo.fr/swf/dcr/hof_furni/icons/';
            $query = $db->connect()->prepare('SELECT user_id, room_id, GROUP_CONCAT(item_id) item_id FROM items WHERE room_id = ? AND user_id = ? GROUP BY item_id HAVING COUNT(item_id)>0 ORDER BY id DESC;');
            $query->execute(["0", $row[0]['id']]);
            $fetch = $query->fetchAll();            
            $ok = $query->rowCount();
            if($ok > 0) {
            for ($i = 0; $i < count($fetch); $i++) {
            $itemid = $fetch[$i]['item_id'];
            $sql2 = $db->connect()->query("SELECT * FROM items WHERE item_id = '". $itemid ."' && room_id = '0' && user_id = '". $row[0]['id'] ."' ");
            $sql2fetch = $sql2->fetchAll();
            $items = $sql2fetch[0]['id'];
            $selectitems = $db->connect()->prepare('SELECT * FROM items_base WHERE id = ? ');
            $selectitems->execute([$itemid]);
            $fetchitems = $selectitems->fetchAll();
            $mobis = $fetchitems[0]['item_name'];

            $catalog_name = preg_replace('*', '_', $mobis);
            $texte = $fetchitems[0]['item_name'];
            $texte = str_replace('*', '_', $texte);
       
                                                ?>
                                                <div tooltip tooltip-direction="top" tooltip-content="Clique sur moi p" class="badgeGestion"  id="<?= $itemid; ?>">
                                                    <img src="<?= $itemurl . $texte; ?>_icon.png"/>
                                                    <span><?= $sql2->rowcount(); ?></span>
                                                    <a href="inventairejoueur.php?pseudo=<?= $_GET['pseudo']; ?>&supprimer=<?= $items; ?>" class="croix">X</a>
                                                </div>
                                                <?php
                                            }
                                            }else { echo "Il n'y a aucun mobis dans l'inventaire de ".$row[0]['username']." pour le moment !";}
                                        
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
