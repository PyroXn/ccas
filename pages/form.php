<?php

function form() {
    $table = $_POST['table'];
    switch ($table) {
         case 'creation_foyer':
             creationFoyer($_POST['civilite'], $_POST['nom'], $_POST['prenom']);
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
}

?>
