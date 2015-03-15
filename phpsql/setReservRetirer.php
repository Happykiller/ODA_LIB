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
// phpsql/setReservRetirer.php?milis=123450&id_livre=49

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
$strSql = "INSERT INTO  `".$prefixTable."tab_reservations` (
        `id_livre` ,
        `id_user`,
        `date_saisie`,
        `date_retrait`
    )
    VALUES (
        :id_livre , :id_user, NOW(), NOW()
    )
;";
$req = $connection->prepare($strSql);
$req->bindValue(":id_livre", $arrayValeur["id_livre"], PDO::PARAM_INT);
$req->bindValue(":id_user", $arrayValeur["id_user"], PDO::PARAM_INT);

$resultat = new stdClass();
$resultat->id = 0; 
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