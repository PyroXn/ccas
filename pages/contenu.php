<?php

function contenu() {
    $menu = $_POST['idMenu'];
    switch ($menu) {
        case 'foyer':
            echo foyerContenu();
            break;
        case 'generalites':
            echo 'generalites';
            break;
        case 'budget':
            echo 'budget';
            break;
        case 'aides':
            echo 'aides';
            break;
        case 'historique':
            echo 'historique';
            break;
        case 'accueil':
            echo accueilContenu();
            break;
    }
}

function foyerContenu() {
    return 'foyer';
}

?>
