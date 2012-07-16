<?php

function updateChefDeFamille() {
    include_once('./lib/config.php');
    include_once('./pages/foyer.php');
    $individu = Doctrine_Core::getTable('individu')->findOneByIdFoyerAndChefDeFamille($_POST['idFoyer'], 1);
    
    //gestion du cas si il n'existe pas de chef de famille (ne doit pas arriver)
    if ($individu != null) {
        $individu->chefDeFamille = 0;
        $individu->save();
    }
    
    $individuNewChefFamille = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individuNewChefFamille->chefDeFamille = 1;
    $individuNewChefFamille->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'individu', $_SESSION['userId'], $individuNewChefFamille->id);
    
    echo foyerContenu($_POST['idFoyer']);
}

function createIndividu($idFoyer, $civilite, $nom, $prenom, $dateNaissance, $idLienFamille) {
    include_once('./lib/config.php');
    include_once('./pages/budget.php');
    include_once('./pages/foyer.php');
    
    $individu = new Individu();
    setWithoutNull($civilite, $individu, 'civilite');
    setWithoutNull($nom, $individu, 'nom');
    setWithoutNull($prenom, $individu, 'prenom');
    setWithoutNull($idFoyer, $individu, 'idFoyer');
    setDateWithoutNull($dateNaissance, $individu, 'dateNaissance');
    setWithoutNull($idLienFamille, $individu, 'idLienFamille');
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
