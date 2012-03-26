<?php

function form() {
    $table = $_POST['table'];
    switch ($table) {
         case 'creation_foyer':
             include_once('./pages/contenu.php');
             $tab = creationFoyer($_POST['civilite'], $_POST['nom'], $_POST['prenom']);
             $listeIndividu = creationListeByFoyer($tab['idFoyer'], $tab['idIndividu']);
             $menu = generationHeaderNavigation('foyer');
             $contenu = foyerContenu($tab['idFoyer']);
             $retour = array('listeIndividu' => $listeIndividu, 'menu' => $menu, 'contenu' => $contenu);
             echo json_encode($retour);
             break;
         case 'creation_utilisateur':
             include_once('./pages/contenu.php');
             createUser($_POST['login'], $_POST['pwd'], $_POST['nomcomplet']);
             $page = manageUser();
             $retour = array('tableau' =>$page);
             echo json_encode($retour);
             break;
        case 'creation_individu':
//            include_once('./pages/contenu.php');
//            include_once('./index.php');
            
            $newIndividu = createIndividu($_POST['idFoyer'], $_POST['civilite'], $_POST['nom'], $_POST['prenom'], $_POST['naissance'], $_POST['idlienfamille']);
            $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividuCourant']);
            $retour = array('listeIndividu' => $listeIndividu, 'newIndividu' => $newIndividu);
            echo json_encode($retour);
            break;
        case 'creation_credit':
            include_once('./pages/contenu.php');
            createCredit($_POST['idIndividu'], $_POST['organisme'], $_POST['mensualite'], $_POST['duree'], $_POST['total']);
            $budget = budget();
            $retour = array('budget' => $budget);
            echo json_encode($retour);
            break;
        case 'creation_action':
            include_once('./pages/action.php');
            createAction($_POST['date'], $_POST['typeaction'], $_POST['motif'], $_POST['suiteadonner'], $_POST['suitedonnee'], $_POST['instruct'], $_POST['idIndividu']);
            $action = action();
            $retour = array('action' => $action);
            echo json_encode($retour);
            break;
        case 'creation_aide_interne':
            include_once('./pages/aide.php');
            createAideInterne($_POST['typeaide'], $_POST['date'], $_POST['instruct'], $_POST['nature'], $_POST['proposition'], $_POST['etat'], $_POST['idIndividu'], $_POST['orga'], $_POST['urgence']);
            $aide = aide();
            $retour = array('aide' => $aide);
            echo json_encode($retour);
            break;
        case 'addBonInterne':
            include_once('./pages/aide.php');
            addBonInterne($_POST['idAide'], $_POST['instruct'], $_POST['dateprevue'], $_POST['dateeffective'], $_POST['montant'], $_POST['commentaire']);
            $detail = detailAideInterne();
            $retour = array('detail' => $detail);
            echo json_encode($retour);
            break;            
    }
}


function creationFoyer($civilite, $nom, $prenom) {
    include_once('./lib/config.php');
    $foyer = new Foyer();
    $foyer->dateInscription = time();
    $foyer->save();
    $individu = new Individu();
    $individu->civilite = $civilite;
    $individu->nom = $nom;
    $individu->prenom = $prenom;
    $individu->chefDeFamille = true;
    $individu->idFoyer = $foyer->id;
    $individu->save();
    
   
    createRevenu($individu->id);
    createDepense($individu->id);
    createDette($individu->id);
 
    return array('idFoyer' => $foyer->id, 'idIndividu' => $individu->id);
//    return creationListeByFoyer($foyer->id, $individu->id);
}

function createRevenu($idIndividu) {
    $revenu = new Revenu();
    $revenu->idIndividu = $idIndividu;
    $revenu->dateCreation = time();
    $revenu->save();
} 

function createDepense($idIndividu) {
    $depense = new Depense();
    $depense->idIndividu = $idIndividu;
    $depense->dateCreation = time();
    $depense->save();
}

function createDette($idIndividu) {
     
    $dette = new Dette();
    $dette->idIndividu = $idIndividu;
    $dette->dateCreation = time();
    $dette->save();
}

function createUser($login,$password,$nomcomplet) {
    include_once('./lib/config.php');
    $user = new User();
    $user->login = $login;
    $user->password = md5($password);
    $user->nomcomplet = $nomcomplet;
    $user->save();
    
}

function createIndividu($idFoyer, $civilite, $nom, $prenom, $dateNaissance, $idLienFamille) {
    include_once('./lib/config.php');
    include_once('./pages/contenu.php');
    
    $individu = new Individu();
    $individu->civilite = $civilite;
    $individu->nom = $nom;
    $individu->prenom = $prenom;
    $individu->idFoyer = $idFoyer;
    if ($dateNaissance != 0) {
        $date = explode('/', $dateNaissance);
        $individu->dateNaissance = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
    } else {
        $individu->dateNaissance = 0;
    }
    
    $individu->idLienFamille = $idLienFamille;
    $individu->save();
    createRevenu($individu->id);
    createDepense($individu->id);
    createDette($individu->id);
    return FoyerContenu($idFoyer);
}

function createCredit($idIndividu, $organisme, $mensualite, $duree, $total) {
    include_once('./lib/config.php');
    $credit = new Credit();
    $credit->organisme = $organisme;
    $credit->mensualite = $mensualite;
    $credit->dureeMois = $duree;
    $credit->totalRestant = $total;
    $credit->idIndividu = $idIndividu;
    $credit->dateAjout = time();
    $credit->save();
}
?>
