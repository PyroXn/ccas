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
    
    echo foyerContenu($_POST['idFoyer']);
}

function deleteIndividu() {
    include_once('./lib/config.php');
    include_once('./pages/contenu.php');
    include_once('./index.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->delete();
    $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividuCourant']);
    $contenu = foyerContenu($_POST['idFoyer']);
    $retour = array('listeIndividu' => $listeIndividu, 'contenu' => $contenu);
    echo json_encode($retour);
}

function updateRessource() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('revenu')->getLastFicheRessource($_POST['idIndividu']);
    $individu->salaire = $_POST['salaire'];
    $individu->chomage = $_POST['chomage'];
    $individu->revenuAlloc = $_POST['revenuAlloc'];
    $individu->ass = $_POST['ass'];
    $individu->aah = $_POST['aah'];
    $individu->rsaSocle = $_POST['rsaSocle'];
    $individu->rsaActivite = $_POST['rsaActivite'];
    $individu->retraitComp = $_POST['retraitComp'];
    $individu->pensionAlim = $_POST['pensionAlim'];
    $individu->pensionRetraite = $_POST['pensionRetraite'];
    $individu->autreRevenu = $_POST['autreRevenu'];
    $individu->natureAutre = $_POST['natureAutre'];
    $individu->dateCreation = time();
    $individu->save();
}

function updateDepense() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('depense')->getLastFicheDepense($_POST['idIndividu']);
    $individu->impotRevenu = $_POST['impotRevenu'];
    $individu->impotLocaux = $_POST['impotLocaux'];
    $individu->pensionAlim = $_POST['pensionAlim'];
    $individu->mutuelle = $_POST['mutuelle'];
    $individu->electricite = $_POST['electricite'];
    $individu->gaz = $_POST['gaz'];
    $individu->eau = $_POST['eau'];
    $individu->chauffage = $_POST['chauffage'];
    $individu->telephonie = $_POST['telephonie'];
    $individu->internet = $_POST['internet'];
    $individu->television = $_POST['television'];
    $individu->autreDepense = $_POST['autreDepense'];
    $individu->natureDepense = $_POST['natureDepense'];
    $individu->dateCreation = time();
    $individu->save();
}

function updateDette() {
    include_once('./lib/config.php');
    $dette = Doctrine_Core::getTable('dette')->getLastFicheDette($_POST['idIndividu']);
    $dette->arriereLocatif = $_POST['arriereLocatif'];
    $dette->fraisHuissier = $_POST['fraisHuissier'];
    $dette->autreDette = $_POST['autreDette'];
    $dette->natureDette = $_POST['natureDette'];
    $dette->arriereElectricite = $_POST['arriereElec'];
    $dette->prestaElec = $_POST['prestaElec'];
    $dette->arriereGaz = $_POST['arriereGaz'];
    $dette->prestaGaz = $_POST['prestaGaz'];
    $dette->dateCreation = time();
    $dette->save();
}

function updateDepenseHabitation() {
    include_once('./lib/config.php');
    $ressource = Doctrine_Core::getTable('revenu')->getLastFicheRessource($_POST['idIndividu']);
    $ressource->aideLogement = $_POST['apl'];
    $ressource->save();
    
    $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($_POST['idIndividu']);
    $depense->loyer = $_POST['loyer'];
    $depense->save();
}

function archiveRessource() {
    include_once('./lib/config.php');
    include_once('./pages/contenu.php');
    $ressource = new Revenu();
    $ressource->idIndividu = $_POST['idIndividu'];
    $ressource->dateCreation = time();
    $ressource->save();
    echo budget();
}

function generalite() {
    include_once('./lib/config.php');
    $liens = Doctrine_Core::getTable('lienfamille')->findAll();
    $situationMatris = Doctrine_Core::getTable('situationmatri')->findAll();
    $nationalites = Doctrine_Core::getTable('nationalite')->findAll();
    $villes = Doctrine_Core::getTable('ville')->findAll();
    
    $retour = '<select name="civilite" placeholder="Civilite">
                        <option value="1">Madame</option>
                        <option value="2">Monsieur</option>
                       </select>
                       <input type="text" name="nom" placeholder="Nom"/>
                       <input type="text" name="prenom" placeholder="Pr&eacute;nom"/>
                       <select name="lienfamille" placeholder="Lien de famille">';
    foreach($liens as $lien) {
        $retour .= '<option value="'.$lien->id.'">'.$lien->lien.'</option>';
    }
    $retour .= '</select>
                        <input type="checkbox" name="cheffamille" value="1"/> Chef de famille
                        <select name="situationmatri" placeholder="Situation familiale">';
    foreach($situationMatris as $situationMatri) {
        $retour .= '<option value="'.$situationMatri->id.'">'.$situationMatri->situation.'</option>';
    }
    $retour .= '</select>';
    $retour .= '<select name="nationalite">';
    foreach($nationalites as $nationalite) {
        $retour .= '<option value="'.$nationalite->id.'">'.$nationalite->nationalite.'</option>';
    }
    $retour .= '</select>';
    // Naissance
    $retour .= '<fieldset><legend>Naissance</legend>';
    $retour .= '<input type="text" name="datenaissance">';
    $retour .= '<select name="lieunaissance">';
    foreach($villes as $ville) {
        $retour .= '<option value="'.$ville->id.'">'.$ville->libelle.'</option>';
    }
    $retour .= '</select>';
    $retour .= '<select name="sexe">
                            <option value="1">Femme</option>
                            <option value="2">Homme</option>
                        </select>';
    $retour .= '</fieldset>';
    // Partie Contact
    $retour .= '<fieldset><legend>T&eacute;l&eacute;phone/Email</legend>';
    $retour .= '<input type="text" name="telephone" placeholder="Telephone"/>
                        <input type="text" name="portable" placeholder="Portable"/>
                        <input type="text" name="email" placeholder="Adresse Email"/>
                        </fieldset>';
    // Couverture sociale
    $retour .= '<fieldset><legend>Couverture sociale</legend>
                        <input type="checkbox" name="assure" value="1"/> Assur&eacute;
                        <input type="text" name="numerosecu" placeholder="Numero"/>
                        <input type="text" size="4" name="clesecu" placeholder="Cle"/>
                        <select name="regime">
                            <option value="1">Local</option>
                            <option value="2">General</option>
                        </select>
                        </fieldset>'; // Ajouter le choix de la caisse, dâte debut droit & date fin droit
    return $retour;
    
    
    
}
?>
