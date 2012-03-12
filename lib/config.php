<?php

require_once './lib/Doctrine.php';
spl_autoload_register(array('Doctrine_Core', 'autoload'));
Doctrine_Core::loadModels('./modeles/'); //demande d'inclure les modèles se situant dans le dossier indiqué. 
//
//$cfg = 'modeles';
//$dossier = opendir($cfg);
//while ($fichier = readdir($dossier)) {
//    if (is_file($cfg . '/' . $fichier) && $fichier != '/' && $fichier != '.' && $fichier != '..') {
//        include_once $cfg . '/' . $fichier;
//    }
//}
//
//$dsn = 'mysql://freeh_21900_38:Hc3p4LEn@db1.free-h.org/freeh_db_21900';
$dsn = 'mysql://root:root@localhost/ccas';
$connexion = Doctrine_Manager::connection($dsn);
$connexion->setCollate('utf8_unicode_ci');
$connexion->setCharset('utf8');

/**
 *
 * @param type $level Indiquer l'autorisation spécifique : 0010 - 1000 - 0100 - 0001
 * @return Vrai si user autorisé
 */
function isAuthorized($level) {
    $find = false;
    $i = strlen($level)-1;
    while($level[$i] != 1) {
        $i--;
    }
    if(@$_SESSION['level'][$i] == 1) {
        return true;
    } else {
        // Renvoyer vers page indiquant les droits
        return false;
    }
}

function getDatebyTimestamp($timestamp) {
    return $timestamp == 0 ? '0' : date('d/m/Y', $timestamp);
}

?>