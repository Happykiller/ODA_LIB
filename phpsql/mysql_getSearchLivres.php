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
// phpsql/mysql_getSearchLivres.php?milis=123450&ctrl=ok&tags=php;sql;&titres=essai;

//Définition des entrants
$arrayInput = array(
    "tags" => null,
    "titres" => null
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
$strFiltreTitre = "";
if($arrayValeur["titres"] != ""){

    $strFiltreTitre .= " AND (";

    $out = preg_split("[;]", $arrayValeur["titres"]);

    foreach($out as $i => $v_titre)
    {
        if($v_titre != ""){
            if($strFiltreTitre ==" AND ("){
                $strFiltreTitre .= " a.titre like '%".$v_titre."%'";
            }else{
                $strFiltreTitre .= " OR a.titre like '%".$v_titre."%'";
            }
        }
    }

    $strFiltreTitre .= " )";
}

$strJointureTag = "";
$strCondJointureTag = "";
$strFiltreTag = "";
if($arrayValeur["tags"] != ""){
    $strJointureTag = " , `".$prefixTable."tab_tags` b";
    $strCondJointureTag = " AND a.id = b.id_livre";

    $strFiltreTag .= " AND (";

    $out = preg_split("[;]", $arrayValeur["tags"]);

    foreach($out as $i => $v_tag)
    {
        if($v_tag != ""){
            if($strFiltreTag ==" AND ("){
                $strFiltreTag .= " b.tag = '".$v_tag."'";
            }else{
                $strFiltreTag .= " OR b.tag = '".$v_tag."'";
            }
        }
    }

    $strFiltreTag .= " )";
}

$strSql = "SELECT a.`id`,a.`titre`,a.`date_parution`,a.`apercu`,a.`resume`,a.`fichier_ebook`,a.`donateur`
    ,a.`date_entree_lib`,a.`actif`,a.`date_creation`,a.`date_motif`
    FROM `".$prefixTable."tab_livres` a
    ".$strJointureTag."
    WHERE 1=1
    ".$strCondJointureTag."
    ".$strFiltreTitre."
    ".$strFiltreTag."
    order by a.titre asc
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