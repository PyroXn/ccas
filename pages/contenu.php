<?php

function contenu() {
    $menu = $_POST['idMenu'];
    switch ($menu) {
        case 'foyer':
            include_once './pages/foyer.php';
            echo foyerContenu($_POST['idFoyer']);
            break;
        case 'generalites':
            include_once './pages/generalite.php';
            echo generalite();
            break;
        case 'budget':
            include_once './pages/budget.php';
            echo budget();
            break;
        case 'aides':
            include_once './pages/aideInterne.php';
            echo aide();
            break;
        case 'historique':
            include_once './pages/historique.php';
            echo affichageHistoriqueByIndividu();
            break;
        case 'documents':
            include_once './pages/document.php';
            echo getDocumentIndividu();
            break;
        case 'actions':
            include_once('./pages/action.php');
            echo action();
            break;
        case 'accueil':
            echo accueilContenu();
            break;
        case 'manageuser' :
            include_once('./pages/admin.php');
            echo manageUser();
            break;
        case 'statistique' :
            include_once('./pages/statistiques.php');
            echo statistique();
            break;
        case 'managerole' :
            include_once('./pages/admin.php');
            echo manageRole();
            break;
        case 'document':
            include_once('./pages/document.php');
            echo getDocument();
            break;
        case 'accueilConfig':
            include_once('./pages/config.php');
            echo accueilConfig();
            break;
        case 'ecranTableStatique':
            include_once './pages/tableStatique.php';
            echo comboTableStatique();
            break;
        case 'historiqueGlobal':
            include_once './pages/historique.php';
            echo affichageHistorique();
            break;
        case 'tabcommission':
            include_once './pages/tabCommission.php';
            echo ecranTabCommission();
            break;
        case 'tableaubord':
            include_once './pages/tableauBord.php';
            echo tableauBord();
            break;
        case 'recapAides':
            include_once './pages/recapAides.php';
            echo recapAides();
            break;
        case 'gestionPass':
            include_once './pages/gestionCompte.php';
            echo gestionPass();
            break;
    }
}
?>
