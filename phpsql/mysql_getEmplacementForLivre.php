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
// phpsql/mysql_getEmplacementForLivre.php?milis=123450&ctrl=ok&id_livre=49&histo=non&order=id&orderSens=asc

//Définition des entrants
$arrayInput = array(
    "id_livre" => null,
    "histo" => null,
    "order" => null,
    "orderSens" => null
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
$strFiltreId = "";
if($arrayValeur["histo"] == "non"){
    $strFiltreId = "AND a.id = (
    SELECT MAX(b.id)
        FROM  `".$prefixTable."tab_emplacement` b
        WHERE 1=1
        AND b.id_livre = ".$arrayValeur["id_livre"]."        
    )";
}

$strSql = "SELECT a.id,a.id_livre,a.emplacement,a.date_creation
        FROM  `".$prefixTable."tab_emplacement` a
        WHERE 1=1
        AND a.id_livre = ".$arrayValeur["id_livre"]."
        ".$strFiltreId."
        ORDER BY ".$arrayValeur["order"]." ".$arrayValeur["orderSens"]."
;";
$req = $connection->prepare($strSql);

$rows = array();
if($req->execute()){
    $rows = $req->fetch();
    $object_retour->data["resultat"] = $rows;
}else{
    die('Erreur SQL:'.print_r($req->errorInfo(), true)." (".$strSql.")");
}
$req->closeCursor();
    
//--------------------------------------------------------------------------
if($modeDebug){
    print_r($strSql);
}

//---------------------------------------------------------------------------

//Cloture de l'interface
require("../API/php/footer.php");
?>