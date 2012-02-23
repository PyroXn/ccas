<?php

include('./lib/config.php');
$retour = '';
$foyers = Doctrine_Core::getTable('Foyer');
$i = $_GET['last'] +1;
foreach ($foyers->searchByLimitOffset(100, $_GET['last'])->execute() as $foyer) {
    if ($i % 2 == 0) {
        $retour .= '<li class="pair foyer" id="' . $i . '">';
    } else {
        $retour .= '<li class="impair foyer" id="' . $i . '">';
    }
    $retour .= '
                            <a href="#">
                                <span class="label">' . $foyer->nom . ' ' . $foyer->prenom . ' ' . $foyer->id . '</span>
                            </a>
                        </li>';
    $i++;
}
echo $retour;
?>
