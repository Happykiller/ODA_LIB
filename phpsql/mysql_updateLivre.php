<?php
//Config : Les informations personnels de l'instance (log, pass, etc)
require("../include/config.php");

//API Fonctions : les fonctions fournis de base par l'API
require("../API/php/fonctions.php");

//Header établie la connection à la base $connection
require("../API/php/header.php");

//Fonctions : Fonctions personnelles de l'instance
require("../php/fonctions.php");

//Mode debug
$modeDebug = false;

//Public ou privé (clé obligatoire)
$modePublic = true;

//Mode de sortie text,json,xml,csv
//pour xml et csv $object_retour->data["resultat"] doit contenir qu'un est unique array
$modeSortie = "json";

//Liens de test
// phpsql/mysql_updateLivre.php?milis=123450&ctrl=ok&id=6&dateParution=2013-05-13&donateur=Moi&resume=Le résumé ici&actif=1&fichier_ebook=truc.pdf

//Définition des entrants
$arrayInput = array(
    "id" => null,
    "dateParution" => null,
    "donateur" => null,
    "resume" => null,
    "actif" => null,
    "fichier_ebook" => null
);

//Définition des entrants optionel
$arrayInputOpt = array(
    "option" => null
);

//Récupération des entrants
$arrayValeur = recupInput($arrayInput,$arrayInputOpt);

//Object retour minima
// $object_retour->strErreur string
// $object_retour->data  string
// $object_retour->statut  string
// $object_retour->id_transaction  string
// $object_retour->metro  string

//--------------------------------------------------------------------------
$strSql = "UPDATE `".$prefixTable."tab_livres` 
SET `date_parution` = '".$arrayValeur["dateParution"]."'
, `donateur` = '".addSlashes($arrayValeur["donateur"])."'
,`resume` = '".nl2br(addSlashes($arrayValeur["resume"]))."'
,`actif` = ".$arrayValeur["actif"]."
,`fichier_ebook` = '".$arrayValeur["fichier_ebook"]."'
,`date_motif` = NOW()
WHERE 1=1
AND id = ".$arrayValeur["id"]."
;";
$req = $connection->prepare($strSql);

$resultat = new stdClass();
if(!($req->execute())){
    die('Erreur SQL:'.print_r($req->errorInfo(), true)." (".$strSql.")");
}else{
    $resultat->statut = "ok"; 
}
$req->closeCursor();
$object_retour->data["resultat"] = $resultat;

//--------------------------------------------------------------------------
if($modeDebug){
    print_r($strSql);
}

//---------------------------------------------------------------------------

//Cloture de l'interface
require("../API/php/footer.php");
?>