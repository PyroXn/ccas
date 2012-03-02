<?php

function form() {
    $table = $_POST['table'];
    switch ($table) {
         case 'creation_foyer':
             $listeIndividu = creationFoyer($_POST['civilite'], $_POST['nom'], $_POST['prenom']);
             $menu = generationHeaderNavigation('foyer');
             $retour = array('listeIndividu' => $listeIndividu, 'menu' => $menu);
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
            include_once('./pages/contenu.php');
            include_once('./index.php');
            
            $newIndividu = createIndividu($_POST['idFoyer'], $_POST['civilite'], $_POST['nom'], $_POST['prenom']);
            $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividuCourant']);
            $retour = array('listeIndividu' => $listeIndividu, 'newIndividu' => $newIndividu);
            echo json_encode($retour);
            break;
    }
}


function creationFoyer($civilite, $nom, $prenom) {
    include_once('./lib/config.php');
    $foyer = new Foyer();
    $foyer->save();
    $individu = new Individu();
    $individu->civilite = $civilite;
    $individu->nom = $nom;
    $individu->prenom = $prenom;
    $individu->chefDeFamille = true;
    $individu->idFoyer = $foyer->id;
    $individu->save();
    
    return creationListeByFoyer($foyer->id, $individu->id);
}

function createUser($login,$password,$nomcomplet) {
    include_once('./lib/config.php');
    $user = new User();
    $user->login = $login;
    $user->password = md5($password);
    $user->nomcomplet = $nomcomplet;
    $user->save();
    
}

function createIndividu($idFoyer, $civilite, $nom, $prenom) {
    include_once('./lib/config.php');
    $individu = new Individu();
    $individu->civilite = $civilite;
    $individu->nom = $nom;
    $individu->prenom = $prenom;
    $individu->idFoyer = $idFoyer;
    $individu->save();
    return FoyerContenu($idFoyer);
}
?>
