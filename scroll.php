<?php

include('./lib/config.php');
$retour = '';
$individus = Doctrine_Core::getTable('individu');
$i = $_GET['last'] +1;
$q = $_GET['searchword'];

foreach ($individus->searchLikeByLimitOffset($q, 100, $_GET['last'])->execute() as $individu) {
    if ($i % 2 == 0) {
        $retour .= '<li class="pair individu" id="' . $i . '">';
    } else {
        $retour .= '<li class="impair individu" id="' . $i . '">';
    }
    $retour .= '
                            <a href="#">
                                <span class="label" id_foyer="'. $individu->idFoyer .'" id_individu="'.$individu->id.'">' . $individu->nom . ' ' . $individu->prenom . '</span>
                            </a>
                        </li>';
    $i++;
}
echo $retour;


?>
