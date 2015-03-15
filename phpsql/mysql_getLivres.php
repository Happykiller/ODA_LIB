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
// phpsql/mysql_getLivres.php?milis=123450&ctrl=ok&id=1&order=id&orderSens=desc

//Définition des entrants
$arrayInput = array(
    "id" => null,
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
if($arrayValeur["id"] != ""){
    $strFiltreId = "AND a.id = ".$arrayValeur["id"]."";
}

//les fermés
$strSql = "SELECT a.`id`,a.`titre`,a.`date_parution`,a.`apercu`,a.`resume`,a.`fichier_ebook`,a.`donateur`
    ,a.`date_entree_lib`,a.`actif`,a.`date_creation`,a.`date_motif`
    FROM  `".$prefixTable."tab_livres` a
    WHERE 1=1
    ".$strFiltreId."
    ORDER BY ".$arrayValeur["order"]." ".$arrayValeur["orderSens"]."
;";
$req = $connection->prepare($strSql);

if($req->execute()){
    $req->setFetchMode(PDO::FETCH_OBJ);
    $resultats = new stdClass();
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
?>