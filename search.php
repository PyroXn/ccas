<?php

require_once './lib/config.php';
if ($_POST) {

    $q = $_POST['searchword'];

    $retour = '';
    $tableIndividus = Doctrine_Core::getTable('individu');
    $retour .= '<div class="nb_individu">' . $tableIndividus->likeNom($q)->count() . '</div>';
    
    $i = 0;
    foreach ($tableIndividus->searchLikeByLimitOffset($q, 100, 0)->execute() as $individu) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair individu">';
        } else {
            $retour .= '<li class="impair individu">';
        }
        $retour .= '
                    <a href="#">
                        <span class="label">' . $individu->nom . ' ' . $individu->prenom . '</span>
                    </a>
                </li>';
        $i++;
    }
    echo $retour;
} else {
    
}
?>
