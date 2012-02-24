<?php

require_once './lib/config.php';
if ($_POST) {

    $q = $_POST['searchword'];

    $retour = '';
    $tableIndividus = Doctrine_Core::getTable('individu');
    $individus = $tableIndividus->likeNom($q)->execute();
    $retour .= '<div class="nb_individu">' . sizeof($individus) . '</div>';
    $i = 0;
    foreach ($individus as $individu) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair">';
        } else {
            $retour .= '<li class="impair">';
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
