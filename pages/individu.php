<?php

function updateMembreFoyer() {
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
