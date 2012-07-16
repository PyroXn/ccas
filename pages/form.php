<?php
/*
 * Les formulaire lors du save arrive ici.
 */
function form() {
    $table = $_POST['table'];
    switch ($table) {
         case 'creation_foyer':
             include_once('./pages/foyer.php');
             $tab = creationFoyer($_POST['civilite'], $_POST['nom'], $_POST['prenom']);
             $listeIndividu = creationListeByFoyer($tab['idFoyer'], $tab['idIndividu']);
             $menu = generationHeaderNavigation('foyer');
             $contenu = foyerContenu($tab['idFoyer']);
             $retour = array('listeIndividu' => $listeIndividu, 'menu' => $menu, 'contenu' => $contenu);
             echo json_encode($retour);
             break;
         case 'creation_utilisateur':
             include_once('./pages/admin.php');
             createUser($_POST['login'], $_POST['pwd'], $_POST['nomcomplet'], $_POST['role']);
             $page = manageUser();
             $retour = array('tableau' =>$page);
             echo json_encode($retour);
             break;
        case 'creation_individu':
            include_once('./pages/individu.php');
            $newIndividu = createIndividu($_POST['idFoyer'], $_POST['civilite'], $_POST['nom'], $_POST['prenom'], $_POST['naissance'], $_POST['idlienfamille']);
            $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividuCourant']);
            $retour = array('listeIndividu' => $listeIndividu, 'newIndividu' => $newIndividu);
            echo json_encode($retour);
            break;
        case 'creation_credit':
            include_once('./pages/budget.php');
            createCredit($_POST['idIndividu'], $_POST['organisme'], $_POST['mensualite'], $_POST['duree'], $_POST['total']);
            $budget = budget();
            $retour = array('budget' => $budget);
            echo json_encode($retour);
            break;
        case 'creation_action':
            include_once('./pages/action.php');
            createAction($_POST['date'], $_POST['typeaction'], $_POST['motif'], $_POST['suiteadonner'], $_POST['suitedonnee'], $_POST['instruct'], $_POST['idIndividu']);
            $action = action();
            $retour = array('actions' => $action);
            echo json_encode($retour);
            break;
        case 'creation_aide_interne':
            include_once('./pages/aideInterne.php');
            createAideInterne($_POST['typeaide'], $_POST['date'], $_POST['instruct'], $_POST['nature'], $_POST['proposition'], $_POST['etat'], $_POST['idIndividu'], $_POST['orga'], $_POST['urgence']);
            $aide = aide();
            $retour = array('aide' => $aide);
            echo json_encode($retour);
            break;
        case 'creation_aide_externe':
            include_once('./pages/aideInterne.php');
            include_once('./pages/aideExterne.php');
            createAideExterne($_POST['typeaideexterne'], $_POST['date'], $_POST['instruct'], $_POST['natureexterne'], $_POST['distrib'], $_POST['etat'], $_POST['idIndividu'], $_POST['orgaext'], $_POST['urgence'], $_POST['montantDemande']);
            $aide = aide();
            $retour = array('aide' => $aide);
            echo json_encode($retour);
            break;
        case 'addBonInterne':
            include_once('./pages/aideInterne.php');
            addBonInterne($_POST['idAide'], $_POST['instruct'], $_POST['dateprevue'], $_POST['dateeffective'], $_POST['montant'], $_POST['commentaire'], $_POST['typebon']);
            $detail = detailAideInterne();
            $retour = array('detail' => $detail);
            echo json_encode($retour);
            break;
        case 'creation_role':
            include_once('./pages/admin.php');
            creationRole($_POST['designationRole']);
            $retour = manageRole();
            $retour = array('role' => $retour);
            echo json_encode($retour);
            break;
    }
}
?>
