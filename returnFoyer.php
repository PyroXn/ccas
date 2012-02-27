<?php

require_once './lib/config.php';
$retour = '';
$foyer = Doctrine_Core::getTable('foyer')->find($_POST['idFoyer']);

$i = 1;
foreach ($foyer->individu as $individu) {
    if ($i % 2 == 0) {
        if ($individu->id == $_POST['idIndividu']) {
            $retour .= '<li class="pair individu current" id="' . $i . '">';
        } else {
            $retour .= '<li class="pair individu" id="' . $i . '">';
        }
    } else {
        if ($individu->id == $_POST['idIndividu']) {
            $retour .= '<li class="impair individu current" id="' . $i . '">';
        } else {
            $retour .= '<li class="impair individu" id="' . $i . '">';
        }
    }
    $retour .= '
                    <a href="#">
                        <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="'. $individu->id .'">' . $individu->nom . ' ' . $individu->prenom . ' </span>
                    </a>
                </li>';
    $i++;
}
echo $retour;
?>
