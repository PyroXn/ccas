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

function getAnneeAndMois($arrayTimestamp) {
    $now = explode('/', date('d/m/Y', time()));
    $arrayYear = array();
    $arrayMonth= array();
    $nb = array();
    for($i=0; $i < count($arrayTimestamp); $i++) { // On parcourt tout les foyers
        $date = explode('/', date('d/n/Y', $arrayTimestamp[$i]));
        if(!in_array($date[2], $arrayYear)) { // année
            $arrayYear[] = $date[2];
            $nb[$date[2]] = 1;
            sort($arrayYear);
        } else {
            $nb[$date[2]] += 1;
        }
        if($now[2] == $date[2]) {
            if(!in_array($date[1], $arrayMonth)) {
                $arrayMonth[] = $date[1];
                $nb[$date[1]] = 1;
                sort($arrayMonth);
            } else {
                $nb[$date[1]] += 1;
            }
        }
        //$pos = array_search($date[2], $arrayYear);
//        if(!isset($arrayMonth[$date[2]])) {
//            $arrayMonth[$date[2]][] = $date[1];
//        }
//        if(!in_array($date[1], $arrayMonth[$date[2]])) {
//            $arrayMonth[$date[2]][] = $date[1];
//            sort($arrayMonth[$date[2]]);
//        }
    }
    // FONCTIONNE
//    $array = array();
//    for($i=0; $i < count($arrayTimestamp); $i++) {
//        $date = explode('/', date('d/n/Y', $arrayTimestamp[$i]));
//        if(!isset($array[$date[2]])) {
//            $array[$date[2]][] = $date[1];
//            ksort($array);
//        }
//        if(!in_array($date[1], $array[$date[2]])) {
//            $array[$date[2]][] = $date[1];
//            sort($array[$date[2]]);
//        }
//    }
//    
//    FONCTIONNE PAS
//    for($i=0; $i < count($arrayTimestamp); $i++) {
//        $date = explode('/', date('d/m/Y', $arrayTimestamp[$i]));
//        if(!in_array($date[2], $arrayYear)) {
//            $arrayYear[] = $date[2];
//            sort($arrayYear);
//            if(!isset($arrayMonth[$date[2]])) {
//                $arrayMonth[$date[2]][] = $date[1];
//                sort($arrayMonth[]);
//            }
//            if(!in_array($date[1], $arrayMonth[$date[2]])) {
//                $arrayMonth[$date[2]][] = $date[1];
//                //sort($arrayMonth[$date[2]]);
//            }
//        } 
//    }
//    return array('year' =>$arrayYear, 'month' => $arrayMonth);
    return array('year' => $arrayYear, 'month' => $arrayMonth, 'total' => $nb);
}

?>
