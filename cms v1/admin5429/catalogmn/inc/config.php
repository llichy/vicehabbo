<?php

/*
 * @nom: Catalog Manager 1.0 [Arctrurus]
 * @auteur: Jordan, Stown 
 */


/*
 * Connexion à la base de donnée
 */
 
try 
{
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=vicehabbo', 'vicehabbo', 'ViceHabbo7331*');		
}
catch (Exception $e)
{
	echo "<b>[ERREUR]</b> Connexion à la base de donnée introuvable. Verifier votre fichier de configuration.";
	exit;
}

/*
 * Configuration du site
 */

$siteurl = "https://vicehabbo.fr/admin5429/catalogmn"; //LIEN DU SITE EX: SITE.FR/CATALOG
$sitename = "vicehabbo"; //NOM DU SITE
$icone_link = "https://assets.vicehabbo.fr/c_images/catalogue/icon_"; // LIEN ICONE CATALOGUE EX :  SITE.FR/SWF/c_images/catalogue/icon_
$swf_icon_link = "https://assets.vicehabbo.fr/icons/"; // LIEN IMAGE MOBI EX : SITE.FR/SWF/dcr/dcr/hof_furni/icons/

?>
