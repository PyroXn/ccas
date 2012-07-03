<?php
function generalite() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    
    $contenu = '';
    $contenu .= afficherInfoPerso($user);
    $contenu .= afficherContact($user);
    $contenu .= afficherSituationPro($user);
    $contenu .= afficherSituationScolaire($user);
    $contenu .= afficherCouvertureSocial($user);
    $contenu .= afficherMutuelle($user);
    $contenu .= afficherCAF($user);
    $contenu .= creationComboBox();

    return $contenu;
}

function afficherInfoPerso($user) {
    $retour = '
    <div>
        <h3><span>Informations personnelles</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
    $retour .= '</h3>
            <ul class="list_classique">
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Nom :</span>
                        <span><input class="contour_field input_char" type="text" id="nom" value="'.$user->nom.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Prenom :</span>
                        <span><input class="contour_field input_char" type="text" id="prenom" value="'.$user->prenom.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Situation Familiale :</span>
                        <div class="select classique" role="select_situation" disabled>';
$retour .= verifieValeurNull($user->idSitMatri) ? '
                            <div id="situation" class="option" value="">-----</div>' : '<div id="situation" class="option" value="'.$user->idSitMatri.'">'.$user->situationmatri->situation.'</div>';  
$retour .= '                <div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Nationalité :</span>
                        <div class="select classique" role="select_natio" disabled>';
$retour .= verifieValeurNull($user->idNationalite) ? '
                            <div id="nationalite" class="option" value="">-----</div>' : '<div id="nationalite" class="option" value="'.$user->idNationalite.'">'.$user->nationalite->nationalite.'</div>';  
$retour .= '                <div class="fleche_bas"> </div>
                        </div>
                    </div>
                
                    <div class="colonne">
                        <span class="attribut">Date de naissance :</span>
                        <span>
                            <input class="contour_field input_date" type="text" size="10" id="datenaissance" '.getDatebyTimestampInput($user->dateNaissance).' disabled/>
                        </span>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Lieu de naissance :</span>
                        <span><input type="text" class="contour_field input_char autoComplete" id="lieu" table="ville" champ="libelle" value="'.$user->ville->libelle.'" valeur="'.$user->ville->id.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Sexe :</span>
                        <div class="select classique" role="select_sexe" disabled>';
$retour .= verifieValeurNull($user->sexe) ? '
                            <div id="sexe" class="option" value="">-----</div>' : '<div id="sexe" class="option" value="'.$user->sexe.'">'.$user->sexe.'</div>';  
$retour .= '                <div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Statut :</span>
                        <div class="select classique" role="select_statut" disabled>';
$retour .= verifieValeurNull($user->idLienFamille) ? '
                            <div id="statut" class="option" value="">-----</div>' : '<div id="statut" class="option" value="'.$user->idLienFamille.'">'.$user->lienfamille->lien.'</div>';  
$retour .= '                <div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div value="updateInfoPerso" class="bouton modif update">
                <i class="icon-save"></i>
                <span>Enregistrer</span>
            </div>
            <div class="clearboth"></div>
        </div>';
return $retour;
}

function afficherContact($user) {
    $retour = '
    <div>
        <h3><span>Télèphone / Email</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
    $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Téléphone :</span>
                    <span><input class="contour_field input_char" type="text" id="telephone" value="'.$user->telephone.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Portable :</span>
                    <span><input class="contour_field input_char" type="text" id="portable" value="'.$user->portable.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Email :</span>
                    <span><input class="contour_field input_char" type="text" id="email" value="'.$user->email.'" disabled/></span>
                </div>
            </li>
        </ul>
        <div value="updateContact" class="bouton modif update">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="clearboth"></div>
    </div>';
    return $retour;
}

function afficherSituationPro($user) {
    $retour = '
    <div>
        <h3><span>Situation professionnelle</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
        $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">';
$retour .=      '<div class="colonne">
                    <span class="attribut">Profession :</span>
                    <div class="select classique" role="select_profession" disabled>';
$retour .= verifieValeurNull($user->idProfession) ? '
                        <div id="profession" class="option" value="">-----</div>' : '<div id="profession" class="option" value="'.$user->idProfession.'">'.$user->profession->profession.'</div>';  
$retour .= '            <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">Employeur :</span>
                    <span><input class="contour_field input_char" type="text" id="employeur" value="'.$user->employeur.'" disabled/></span>
                </div>
            </li>    
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Inscription P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="dateinscriptionpe" '.getDatebyTimestampInput($user->dateInscriptionPe).' disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">N° dossier P.E :</span>
                    <span><input class="contour_field input_char" type="text" id="numdossierpe" value="'.$user->numDossierPe.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Début droits P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutdroitpe" '.getDatebyTimestampInput($user->dateDebutDroitPe).' disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Fin droits P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefindroitpe" '.getDatebyTimestampInput($user->dateFinDroitPe).' disabled/></span>
                </div> 
            </li>
        </ul>
        <div value="updateSituationProfessionnelle" class="bouton modif update">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="clearboth"></div>
    </div>';
return $retour;
}

function afficherSituationScolaire($user) {
    $retour = '
    <div>
        <h3><span>Situation scolaire</span> ';
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
            $retour .= '<span class="edit"></span>';
        }
        $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique" >
                <div class="colonne">
                    <span class="attribut">Actuellement scolarisé :</span>';
                        if($user->scolarise == 1) {
                            $scolarise = '';
                            $retour .= '<span id="checkboxScolarise" class="checkbox checkbox_active" value="1" disabled></span>';
                        } else {
                            $scolarise = 'nonscolarise';
                            $retour .= '<span id="checkboxScolarise" class="checkbox" disabled></span>';
                        }
     $retour .='</div>
                <div class="colonne">
                    <span class="attribut">Etablissement :</span>
                    <span><input class="contour_field input_char" type="text" id="etablissementscolaire" value="'.$user->etablissementScolaire.'" disabled/></span>
                </div>
                <div id="ligneScolaire" class="colonne '.$scolarise.'">
                    <span class="attribut">Classe :</span>
                    <div class="select classique" role="select_etude" disabled>';
    $retour .= verifieValeurNull($user->idNiveauEtude) ? '
                        <div id="etude" class="option" value="">-----</div>' : '<div id="etude" class="option" value="'.$user->idNiveauEtude.'">'.$user->etude->etude.'</div>';  
    $retour .= '            <div class="fleche_bas"> </div>
                    </div>
                </div>
            </li>
        </ul>
        <div value="updateSituationScolaire" class="bouton modif update">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="clearboth"></div>
    </div>';
    return $retour;
}

function afficherCouvertureSocial($user) {
    $retour = '
    <div>
        <h3><span>Couverture sociale</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
    $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Assuré : </span>';
    if($user->assure == 1) {
        $retour .= '<span id="assure" class="checkbox checkbox_active" value="1" disabled></span>';
    } else {
        $retour .= '<span id="assure" class="checkbox" value="0" disabled></span>';
    }
                    
    $retour .= '</div>
                <div class="colonne">
                    <span class="attribut">N° :</span>
                    <span><input maxlength="13" class="contour_field input_numsecu" type="text" id="numsecu" value="'.$user->numSecu.'" size="13" disabled/></span>
                    <span><input maxlength="2" class="contour_field input_cle" type="text" id="clefsecu" value="'.$user->clefSecu.'" size="2" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Régime :</span>
                    <div class="select classique" role="select_regime" disabled>';
$retour .= verifieValeurNull($user->regime) ? '
                        <div id="regime" class="option" value="">-----</div>' : '<div id="regime" class="option" value="'.$user->regime.'">'.$user->regime.'</div>';                   
$retour .= '            <div class="fleche_bas"> </div>
                    </div>
                </div>
            </li>
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_couv" disabled>';
$retour .= verifieValeurNull($user->idCaisseSecu) ? '
                        <div id="caisseCouv" class="option" value="">-----</div>' : '<div id="caisseCouv" class="option" value="'.$user->idCaisseSecu.'">'.$user->secu->appelation.'</div>';                   
$retour .= '            <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">CMU : </span>';
    if($user->cmu == 1) {
        $retour .= '<span id="cmu" class="checkbox checkbox_active" value="1" disabled></span>';
    } else {
        $retour .= '<span id="cmu" class="checkbox" value="0" disabled></span>';
    }
    $retour .= '
                </div>
                <div class="colonne">
                    <span class="attribut">Date début droit :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutcouvsecu" '.getDatebyTimestampInput($user->dateDebutCouvSecu).' disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin de droits :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefincouvsecu" '.getDatebyTimestampInput($user->dateFinCouvSecu).' disabled/></span>
                </div>
            </li>
        </ul>
        <div value="updateCouvertureSocial" class="bouton modif update">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="clearboth"></div>
    </div>';
    return $retour;
}

function afficherMutuelle($user) {
    $retour = '
    <div>
        <h3><span>Mutuelle</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
    $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_mut" disabled>';
$retour .= verifieValeurNull($user->idCaisseMut) ? '
                        <div id="mutuelle" class="option" value="">-----</div>' : '<div id="mutuelle" class="option" value="'.$user->idCaisseMut.'">'.$user->mutuelle->appelation.'</div>';                   
$retour .= '            <div class="fleche_bas"> </div>
                    </div>
                </div>
            </li>
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">CMUC : </span>';
if($user->CMUC == 1) {
    $retour .= '<span id="cmuc" class="checkbox checkbox_active" disabled></span>';
} else {
    $retour .= '<span id="cmuc" class="checkbox" disabled></span>';
}
$retour .= '
                </div>
                <div class="colonne">
                    <span class="attribut">N° adhérent :</span>
                    <span><input class="contour_field input_char" type="text" id="numadherentmut" value="'.$user->numAdherentMut.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date début :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutcouvmut" '.getDatebyTimestampInput($user->dateDebutCouvMut).' disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefincouvmut" '.getDatebyTimestampInput($user->dateFinCouvMut).' disabled/></span>
                </div>
            </li>
        </ul>
        <div value="updateMutuelle" class="bouton modif update">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="clearboth"></div>
    </div>';
return $retour;
}

function afficherCAF($user) {
    $retour = '
    <div>
        <h3><span>CAF</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
    $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_caf" disabled>';
$retour .= verifieValeurNull($user->idCaisseCaf) ? '
                        <div id="caf" class="option" value="">-----</div>' : '<div id="caf" class="option" value="'.$user->idCaisseCaf.'">'.$user->caf->appelation.'</div>';                   
$retour .= '            <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">N° allocataire :</span>
                    <span><input class="contour_field input_char" type="text" id="numallocatairecaf" value="'.$user->numAllocataireCaf.'" disabled/></span>
                </div>
            </li>
        </ul>
        <div value="updateCaf" class="bouton modif update">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="clearboth"></div>
    </div>';
return $retour;
}

function updateInfoPerso() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    setWithoutNull($_POST['nom'], $individu, 'nom');
    setWithoutNull($_POST['prenom'], $individu, 'prenom');
    setWithoutNull($_POST['situation'], $individu, 'idSitMatri');
    setWithoutNull($_POST['nationalite'], $individu, 'idNationalite');
    setDateWithoutNull($_POST['datenaissance'], $individu, 'dateNaissance');
    setWithoutNull($_POST['lieu'], $individu, 'idVilleNaissance');
    setWithoutNull($_POST['sexe'], $individu, 'sexe');
    setWithoutNull($_POST['statut'], $individu, 'idLienFamille');
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'information personnelle', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateContact() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    setWithoutNull($_POST['telephone'], $individu, 'telephone');
    setWithoutNull($_POST['portable'], $individu, 'portable');
    setWithoutNull($_POST['email'], $individu, 'email');
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'téléphone / email', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateSituationProfessionnelle() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    setWithoutNull($_POST['profession'], $individu, 'idProfession');
    setWithoutNull($_POST['employeur'], $individu, 'employeur');
    setDateWithoutNull($_POST['inscriptionpe'], $individu, 'dateInscriptionPe');
    setWithoutNull($_POST['numdossier'], $individu, 'numDossierPe');
    setDateWithoutNull($_POST['debutdroit'], $individu, 'dateDebutDroitPe');
    setDateWithoutNull($_POST['findroit'], $individu, 'dateFinDroitPe');
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'situation professionnelle', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateSituationScolaire() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    setWithoutNull($_POST['scolarise'], $individu, 'scolarise');
    setWithoutNull($_POST['etude'], $individu, 'idNiveauEtude');
    setWithoutNull($_POST['etablissementscolaire'], $individu, 'etablissementScolaire');
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'situation scolaire', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateCouvertureSociale() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    setWithoutNull($_POST['assure'], $individu, 'assure');
    setWithoutNull($_POST['cmu'], $individu, 'cmu');
    setWithoutNull($_POST['caisseCouv'], $individu, 'idCaisseSecu');
    setDateWithoutNull($_POST['datedebutcouvsecu'], $individu, 'dateDebutCouvSecu');
    setDateWithoutNull($_POST['datefincouvsecu'], $individu, 'dateFinCouvSecu');
    setWithoutNull($_POST['numsecu'], $individu, 'numSecu');
    setWithoutNull($_POST['clefsecu'], $individu, 'clefSecu');
    setWithoutNull($_POST['regime'], $individu, 'regime');
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'couvertue sociale', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateMutuelle() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    setWithoutNull($_POST['mut'], $individu, 'idCaisseMut');
    setWithoutNull($_POST['cmuc'], $individu, 'CMUC');
    setWithoutNull($_POST['numadherentmut'], $individu, 'numAdherentMut');
    setDateWithoutNull($_POST['datedebutcouvmut'] , $individu, 'dateDebutCouvMut');
    setDateWithoutNull($_POST['datefincouvmut'] , $individu, 'dateFinCouvMut');
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'mutuelle', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateCaf() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    setWithoutNull($_POST['caf'], $individu, 'idCaisseCaf');
    setWithoutNull($_POST['numallocatairecaf'], $individu, 'numAllocataireCaf');
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'CAF', $_SESSION['userId'], $_POST['idIndividu']);
}

function creationComboBox() {
    $situations = Doctrine_Core::getTable('situationmatri')->findAll();
    $nationalite = Doctrine_Core::getTable('nationalite')->findAll();
    $villes = Doctrine_Core::getTable('ville')->findAll();
    $liens = Doctrine_Core::getTable('lienfamille')->findAll();
    $etudes = Doctrine_Core::getTable('etude')->findAll();
    $professions = Doctrine_Core::getTable('profession')->findAll();
    $organismes = Doctrine_Core::getTable('organisme')->findAll();
    
    $retour = '<ul class="select_caf">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Caisse CAF') {
            $retour .= '
                    <li>
                        <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $retour .= '</ul>';
    
    $retour .= '<ul class="select_mut">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Mutuelle') {
            $retour .= '
                    <li>
                        <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $retour .= '</ul>';
    
    $retour .= '<ul class="select_couv">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Caisse SECU') {
            $retour .= '
                    <li>
                        <div  value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $retour .= '</ul>';
    
    $retour .= ' 
        <ul class="select_regime">
            <li>
                <div value="Local">Local</div>
            </li>
            <li>
                <div value="Général">Général</div>
            </li>
        </ul>';
    
    $retour .= ' <ul class="select_profession">';
    foreach($professions as $profession) {
        $retour .= '<li>
                        <div value="'.$profession->id.'">'.$profession->profession.'</div>
                   </li>';
    }
    $retour .= '</ul>';
    
    $retour .= ' <ul class="select_etude">';
    foreach($etudes as $etude) {
        $retour .= '<li>
                        <div value="'.$etude->id.'">'.$etude->etude.'</div>
                   </li>';
    }
    $retour .= '</ul>';
    
    $retour .= ' <ul class="select_statut">';
    foreach($liens as $lien) {
        $retour .= '<li>
                        <div value="'.$lien->id.'">'.$lien->lien.'</div>
                   </li>';
    }
    $retour .= '</ul>';
    
    $retour .= ' <ul class="select_ville">';
    foreach($villes as $ville) {
        $retour .= '<li>
                        <div value="'.$ville->id.'">'.$ville->libelle.'</div>
                    </li>';
    }
    $retour .= '</ul>';
    
    $retour .= ' <ul class="select_natio">';
    foreach($nationalite as $nat) {
        $retour .= '<li>
                        <div value="'.$nat->id.'">'.$nat->nationalite.'</div>
                   </li>';
    }
    $retour .= '</ul>';
    
    $retour .= ' <ul class="select_situation">';
    foreach($situations as $sit) {
        $retour .= '<li>
                        <div value="'.$sit->id.'">'.$sit->situation.'</div>
                   </li>';
    }
    $retour .= '</ul>';
    
    $retour .= ' 
        <ul class="select_sexe">
            <li>
                <div value="Homme">Homme</div>
            </li>
            <li value="Femme">
                <div value="Femme">Femme</div>
            </li>
        </ul>';
    
    return $retour;
}
?>
