<?php

require_once './lib/config.php';
if ($_POST) {

    $q = $_POST['searchword'];

    $retour = '<script type="text/javascript" src="./js/jsDynamique.js"></script>';
    $tableIndividus = Doctrine_Core::getTable('individu');
    $nb = $tableIndividus->likeNom($q)->count();
    if ($nb!=0) {
        $retour .= '<div class="nb_individu">' . $nb . '</div>';
    } else {
        $retour .= '<div class="nb_individu">Aucun r&#233;sultat</div>';
    }
    
    $i = 1;
    foreach ($tableIndividus->searchLikeByLimitOffset($q, 100, 0)->execute() as $individu) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair individu" id="' . $i . '">';
        } else {
            $retour .= '<li class="impair individu" id="' . $i . '">';
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
