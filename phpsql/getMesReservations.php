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
// phpsql/getMesReservations.php?milis=123450&id_user=1

//Définition des entrants
$arrayInput = array(
    "id_user" => null
);

//Définition des entrants optionel
$arrayInputOpt = array(
    "id_user_filtre" => null
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
$strSql = "SELECT
    a.`id`, a.`id_livre`, a.`id_user`, a.`date_saisie`, a.`date_retrait`, a.`date_retour`, a.`date_annulation`, b.`titre`, (
        SELECT MIN(c.`id`)
        FROM `".$prefixTable."tab_reservations` c
        WHERE 1=1
        AND c.`id_livre` = a.`id_livre`
        AND c.`date_retour` = '0000-00-00 00:00:00'
        AND c.`date_annulation` = '0000-00-00 00:00:00'
    ) as 'id_resa_enCours'
    FROM `".$prefixTable."tab_reservations` a, `".$prefixTable."tab_livres` b
    WHERE 1=1
    AND a.`id_livre` = b.`id`
    AND a.`id_user` = :id_user
    AND a.`date_retour` = '0000-00-00 00:00:00'
    AND a.`date_annulation` = '0000-00-00 00:00:00'
    ORDER BY a.`id` asc
;";
$req = $connection->prepare($strSql);
$req->bindValue(":id_user", $arrayValeur["id_user"], PDO::PARAM_INT);

$resultats = new stdClass();
$resultats->data = array();
$resultats->nombre = 0;
$object_retour->data["resultat"] = $resultats;
if($req->execute()){
    $req->setFetchMode(PDO::FETCH_OBJ);
    $resultats->data = $req->fetchAll(PDO::FETCH_OBJ);
    $resultats->nombre = count($resultats->data);
    $object_retour->data["resultat"] = $resultats;
}else{
    $error = 'Erreur SQL:'.print_r($req->errorInfo(), true)." (".$strSql.")";
    $object_retour->strErreur = $error;
}
$req->closeCursor();

//--------------------------------------------------------------------------
if($modeDebug){
    print_r($strSql);
}

//---------------------------------------------------------------------------

//Cloture de l'interface
require("../API/php/footer.php");