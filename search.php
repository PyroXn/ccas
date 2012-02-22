<?php

include('./config.php');
if ($_POST) {

    $q = $_POST['searchword'];

    $retour = '';
    $foyers = Doctrine_Core::getTable('Foyer');
    $i = 0;
    foreach ($foyers->likeNom($q)->execute() as $foyer) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair">';
        } else {
            $retour .= '<li class="impair">';
        }
        $retour .= '
                    <a href="#">
                        <span class="label">' . $foyer->nom . ' ' . $foyer->prenom . '</span>
                    </a>
                </li>';
        $i++;
    }
    echo $retour;
} else {
    
}
?>
