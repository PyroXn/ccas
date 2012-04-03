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

function updateContact() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->telephone = $_POST['telephone'];
    $individu->portable = $_POST['portable'];
    $individu->email = $_POST['email'];
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'télèphone / email', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateCaf() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->idCaisseCaf = $_POST['caf'];
    $individu->numAllocataireCaf = $_POST['numallocatairecaf'];
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'CAF', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateMutuelle() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->idCaisseMut = $_POST['mut'];
    $individu->CMUC = $_POST['cmuc'];
    $individu->numAdherentMut = $_POST['numadherentmut'];
    if($_POST['datedebutcouvmut'] != 0) {
        $date1 = explode('/', $_POST['datedebutcouvmut']);
        $individu->dateDebutCouvMut = mktime(0, 0, 0, $date1[1], $date1[0], $date1[2]);
    } else {
        $individu->dateDebutCouvMut = 0;
    }
    if($_POST['datefincouvmut'] != 0) {
        $date2 = explode('/', $_POST['datefincouvmut']);
        $individu->dateFinCouvMut = mktime(0, 0, 0, $date2[1], $date2[0], $date2[2]);
    } else {
        $individu->dateFinCouvMut = 0;
    }
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'mutuelle', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateCouvertureSociale() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->assure = $_POST['assure'];
    $individu->cmu = $_POST['cmu'];
    $individu->idCaisseSecu = $_POST['caisseCouv'];
    if($_POST['datedebutcouvsecu'] != 0) {
        $date1 = explode('/', $_POST['datedebutcouvsecu']);
        $individu->dateDebutCouvSecu = mktime(0, 0, 0, $date1[1], $date1[0], $date1[2]);
    } else {
        $individu->dateDebutCouvSecu = 0;
    }
    if($_POST['datefincouvsecu'] != 0) {
        $date2 = explode('/', $_POST['datefincouvsecu']);
        $individu->dateFinCouvSecu = mktime(0, 0, 0, $date2[1], $date2[0], $date2[2]);
    } else {
        $individu->dateFinCouvSecu = 0;
    }
    $individu->numSecu = $_POST['numsecu'];
    $individu->clefSecu = $_POST['clefsecu'];
    $individu->regime = $_POST['regime'];
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'couvertue sociale', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateSituationProfessionnelle() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->idProfession = $_POST['profession'];
    $individu->employeur = $_POST['employeur'];
    if($_POST['inscriptionpe'] != 0) {
        $date = explode('/', $_POST['inscriptionpe']);
        $individu->dateInscriptionPe = mktime(0,0,0,$date[1], $date[0], $date[2]);
    } else {
        $individu->dateInscriptionPe = 0;
    }
    $individu->numDossierPe = $_POST['numdossier'];
    if($_POST['debutdroit'] != 0) {
        $date1 = explode('/', $_POST['debutdroit']);
        $individu->dateDebutDroitPe = mktime(0, 0, 0, $date1[1], $date1[0], $date1[2]);
    } else {
        $individu->dateDebutDroitPe = 0;
    }
    if($_POST['findroit'] != 0) {
        $date2 = explode('/', $_POST['findroit']);
        $individu->dateFinDroitPe = mktime(0, 0, 0, $date2[1], $date2[0], $date2[2]);
    } else {
        $individu->dateFinDroitPe = 0;
    }
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'situation professionnelle', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateSituationScolaire() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->scolarise = $_POST['scolarise'];
    $individu->idNiveauEtude = $_POST['etude'];
    $individu->etablissementScolaire = $_POST['etablissementscolaire'];
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'situation scolaire', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateInfoPerso() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->nom = $_POST['nom'];
    $individu->prenom = $_POST['prenom'];
    $individu->idSitMatri = $_POST['situation'];
    $individu->idNationalite = $_POST['nationalite'];
    if($_POST['datenaissance'] != 0) {
        $date = explode('/', $_POST['datenaissance']);
        $individu->dateNaissance = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
    } else {
        $individu->dateNaissance = 0;
    }
    $individu->idVilleNaissance = $_POST['lieu'];
    $individu->sexe = $_POST['sexe'];
    $individu->idLienFamille = $_POST['statut'];
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'information personnelle', $_SESSION['userId'], $_POST['idIndividu']);
}
?>
