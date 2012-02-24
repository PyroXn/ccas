<?php

require_once './lib/config.php';
if ($_POST) {

    $q = $_POST['searchword'];

    $retour = '';
    $individus = Doctrine_Core::getTable('individu');
    $i = 0;
    foreach ($individus->likeNom($q)->execute() as $individu) {
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
