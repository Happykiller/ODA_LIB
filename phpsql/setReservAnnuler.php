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
//Pour le text utiliser $strSorti pour la sortie.
//Pour le json $object_retour sera decoder
//Pour le xml et csv $object_retour->data["resultat"]->data doit contenir qu'un est unique array.
$modeSortie = "json";

//Liens de test
// phpsql/setReservAnnuler.php?milis=123450&id_livre=49&id_user=15

//Définition des entrants
$arrayInput = array(
    "id_livre" => null,
    "id_user" => null
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
$strSql = "UPDATE `".$prefixTable."tab_reservations`
    SET `date_annulation` = NOW()
    WHERE 1=1
    AND `id_livre` = :id_livre
    AND `id_user` = :id_user
    AND `date_retour` = '0000-00-00 00:00:00'
    AND `date_annulation` = '0000-00-00 00:00:00'
;";
$req = $connection->prepare($strSql);
$req->bindValue(":id_livre", $arrayValeur["id_livre"], PDO::PARAM_INT);
$req->bindValue(":id_user", $arrayValeur["id_user"], PDO::PARAM_INT);

$resultat = new stdClass();
$resultat->statut = "null"; 
if(!($req->execute())){
    $resultat->statut = "ko";
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