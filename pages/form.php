<?php

function form() {
    $table = $_POST['table'];
    switch ($table) {
         case 'creation_foyer':
             $listeIndividu = creationFoyer($_POST['civilite'], $_POST['nom'], $_POST['prenom']);
             $menu = generationHeaderNavigation(1);
             $retour = array('listeIndividu' => $listeIndividu, 'menu' => $menu);
             echo json_encode($retour);
             break;
         case 'creation_utilisateur':
             createUser($_POST['login'], $_POST['pwd'], $_POST['nomcomplet']);
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
    $individu->idFoyer = $foyer->id;
    $individu->save();
    
    return creationListeByFoyer($foyer->id, $individu->id);
}

function createUser($login,$password,$nomcomplet) {
    include_once('./lib/config.php');
    $user = new User();
    $user->login = $login;
    $user->password = $password;
    $user->nomcomplet = $nomcomplet;
    $user->save();
    
}
?>
