<?php

function updateChefDeFamille() {
    include_once('./lib/config.php');
    include_once('./pages/contenu.php');
    $individu = Doctrine_Core::getTable('individu')->findOneByIdFoyerAndChefDeFamille(1, 1);
    $individu->chefDeFamille = 0;
    $individu->save();
    
    $individuNewChefFamille = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individuNewChefFamille->chefDeFamille = 1;
    $individuNewChefFamille->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'individu', $_SESSION['userId'], $individu->id);
    
    echo foyerContenu($_POST['idFoyer']);
}

function createIndividu($idFoyer, $civilite, $nom, $prenom, $dateNaissance, $idLienFamille) {
    include_once('./lib/config.php');
    include_once('./pages/budget.php');
    include_once('./pages/foyer.php');
    
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
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'individu', $_SESSION['userId'], $individu->id);
    
    createRessource($individu->id);
    createDepense($individu->id);
    createDette($individu->id);
    return FoyerContenu($idFoyer);
}

function deleteIndividu() {
    include_once('./lib/config.php');
    include_once('./pages/foyer.php');
    include_once('./index.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->delete();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Suppression, 'individu', $_SESSION['userId'], $_POST['idIndividu']);
    
    $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividuCourant']);
    $contenu = foyerContenu($_POST['idFoyer']);
    $retour = array('listeIndividu' => $listeIndividu, 'contenu' => $contenu);
    echo json_encode($retour);
}
?>
