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
// phpsql/mysql_insertLivre.php?milis=123450&ctrl=ok&titre=MonTitre&dateParution=2013-05-13d&donateur=Moi&resume=Le résumé ici

//Définition des entrants
$arrayInput = array(
    "titre" => null,
    "dateParution" => null,
    "donateur" => null,
    "resume" => null
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
$strSql = "INSERT INTO `".$prefixTable."tab_livres` (`titre`,`date_parution`,`donateur`,`resume`,`date_entree_lib`,`actif`,`date_creation`) 
    VALUES  
    ('".addSlashes($arrayValeur["titre"])."','".$arrayValeur["dateParution"]."','".addSlashes($arrayValeur["donateur"])."','".nl2br(addSlashes($arrayValeur["resume"]))."', NOW(), 1, NOW())
;";
$req = $connection->prepare($strSql);

$resultat = new stdClass();
if($req->execute()){
    $resultat->id = $connection->lastInsertId(); 
}else{
    $error = 'Erreur SQL:'.print_r($req->errorInfo(), true)." (".$strSql.")";
    $object_retour->strErreur = $error;
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