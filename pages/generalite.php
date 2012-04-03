<?php
function generalite() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    
    $contenu = '<h2>G&eacute;n&eacute;ralit&eacute;s</h2>';
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
$retour .= $user->idSitMatri == null || ' ' ? '<div id="situation" class="option" value=" ">-----</div>' : '<div id="situation" class="option" value="'.$user->idSitMatri.'">'.$user->situationmatri->situation.'</div>';  
$retour .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Nationalit&eacute; :</span>
                        <div class="select classique" role="select_natio" disabled>';
$retour .= $user->idNationalite == null || ' ' ? '<div id="nationalite" class="option" value=" ">-----</div>' : '<div id="nationalite" class="option" value="'.$user->idNationalite.'">'.$user->nationalite->nationalite.'</div>';  
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Date de naissance :</span>
                        <span>
                            <input class="contour_field input_date" type="text" size="10" id="datenaissance" value="'.getDatebyTimestamp($user->dateNaissance).'" disabled/>
                        </span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Lieu de naissance :</span>
                        <span><input type="text" class="contour_field input_char autoComplete" id="lieu" table="ville" champ="libelle" value="'.$user->ville->libelle.'" valeur="'.$user->ville->id.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Sexe :</span>
                        <div class="select classique" role="select_sexe" disabled>';
$retour .= $user->sexe == null || ' ' ? '<div id="sexe" class="option" value=" ">-----</div>' : '<div id="sexe" class="option" value="'.$user->sexe.'">'.$user->sexe.'</div>';  
$retour .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Statut :</span>
                        <div class="select classique" role="select_statut" disabled>';
$retour .= $user->idLienFamille == null || ' ' ? '<div id="statut" class="option" value=" ">-----</div>' : '<div id="statut" class="option" value="'.$user->idLienFamille.'">'.$user->lienfamille->lien.'</div>';  
$retour .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="bouton modif update" value="updateInfoPerso">Enregistrer</div>
            <div class="clearboth"></div>
        </div>';
return $retour;
}

function afficherContact($user) {
    $retour = '
    <div>
        <h3><span>T&eacute;l&egrave;phone / Email</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
    $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">T&eacute;l&agrave;phone :</span>
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
        <div class="bouton modif update" value="updateContact">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
    return $retour;
}

function afficherSituationPro($user) {
    $retour = '
    <div class="colonne50">
        <h3><span>Situation professionnelle</span> ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
        $retour .= '<span class="edit"></span>';
    }
        $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">';
$retour .=      '<div class="colonne_large">
                    <span class="attribut">Profession :</span>
                    <div class="select classique" role="select_profession" disabled>';
$retour .= $user->idNiveauEtude == null || ' ' ? '<div id="profession" class="option" value=" ">-----</div>' : '<div id="profession" class="option" value="'.$user->idProfession.'">'.$user->profession->profession.'</div>';  
$retour .= '
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne_large">
                    <span class="attribut">Employeur :</span>
                    <span><input class="contour_field input_char" type="text" id="employeur" value="'.$user->employeur.'" disabled/></span>
                </div> 
            </li>
            <li class="ligne_list_classique">
                <div class="colonne_large">
                    <span class="attribut">Inscription P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="dateinscriptionpe" value="'.getDatebyTimestamp($user->dateInscriptionPe).'" disabled/></span>
                </div>
                <div class="colonne_large">
                    <span class="attribut">N&deg; dossier P.E :</span>
                    <span><input class="contour_field input_char" type="text" id="numdossierpe" value="'.$user->numDossierPe.'" disabled/></span>
                </div>
            </li>    
            <li class="ligne_list_classique">
                <div class="colonne_large">
                    <span class="attribut">D&eacute;but droits P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutdroitpe" value="'.getDatebyTimestamp($user->dateDebutDroitPe).'" disabled/></span>
                </div>
                <div class="colonne_large">
                    <span class="attribut">Fin droits P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefindroitpe" value="'.getDatebyTimestamp($user->dateFinDroitPe).'" disabled/></span>
                </div> 
            </li>
        </ul>
        <div class="bouton modif update" value="updateSituationProfessionnelle">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
return $retour;
}

function afficherSituationScolaire($user) {
    $retour = '
    <div class="colonne50">
        <h3><span>Situation scolaire</span> ';
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_GENERALITES)) { 
            $retour .= '<span class="edit"></span>';
        }
        $retour .= '</h3>
        <ul class="list_classique">
            <li class="ligne_list_classique" >
                <div class="colonne_large">
                    <span class="attribut">actuellement scolaris&eacute; :</span>';
                        if($user->scolarise == 1) {
                            $retour .= '<span id="checkboxScolarise" class="checkbox checkbox_active" value="1"></span>';
                        } else {
                            $retour .= '<span id="checkboxScolarise" class="checkbox"></span>';
                        }
     $retour .='</div>
            </li>';
            if($user->scolarise == 1) {
                $retour .= '<div class="scolarise">';
            } else {
                $retour .= '<div class="scolarise" style="display:none">';
            }
    $retour .='<li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">&Eacute;tablissement :</span>
                        <span><input class="contour_field input_char" type="text" id="etablissementscolaire" value="'.$user->etablissementScolaire.'" disabled/></span>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">Classe :</span>
                        <div class="select classique" role="select_etude" disabled>';
    $retour .= $user->idNiveauEtude == null || ' ' ? '<div id="etude" class="option" value=" ">-----</div>' : '<div id="etude" class="option" value="'.$user->idNiveauEtude.'">'.$user->etude->etude.'</div>';  
    $retour .= '
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </div>';
            if($user->scolarise == 1) {
                $retour .= '<div class="nonscolarise" style="display:none">';
            } else {
                $retour .= '<div class="nonscolarise">';
            }
    $retour .='<li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">Niveau &eacute;tude :</span>
                        <div class="select classique" role="select_etude" disabled>';
    $retour .= $user->idNiveauEtude == null || ' ' ? '<div id="etude" class="option" value=" ">-----</div>' : '<div id="etude" class="option" value="'.$user->idNiveauEtude.'">'.$user->etude->etude.'</div>';  
    $retour .= '
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </div>
        </ul>
        <div class="bouton modif update" value="updateSituationScolaire">Enregistrer</div>
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
                    <span class="attribut">Assur&eacute; : </span>';
    if($user->assure == 1) {
        $retour .= '<span id="assure" class="checkbox checkbox_active" value="1"></span>';
    } else {
        $retour .= '<span id="assure" class="checkbox" value="0"></span>';
    }
                    
    $retour .= '</div>
                <div class="colonne">
                    <span class="attribut">N&deg; :</span>
                    <span><input maxlength="13" class="contour_field input_numsecu" type="text" id="numsecu" value="'.$user->numSecu.'" size="13" disabled/></span>
                    <span><input maxlength="2" class="contour_field input_cle" type="text" id="clefsecu" value="'.$user->clefSecu.'" size="2" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">R&eacute;gime :</span>
                    <div class="select classique" role="select_regime" disabled>';
$retour .= $user->regime == null || ' ' ? '<div id="regime" class="option" value=" ">-----</div>' : '<div id="regime" class="option" value="'.$user->regime.'">'.$user->regime.'</div>';                   
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
            </li>
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_couv" disabled>';
$retour .= $user->idCaisseSecu == null || ' ' ? '<div id="caisseCouv" class="option" value=" ">-----</div>' : '<div id="caisseCouv" class="option" value="'.$user->idCaisseSecu.'">'.$user->secu->appelation.'</div>';                   
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">CMU : </span>';
    if($user->cmu == 1) {
        $retour .= '<span id="cmu" class="checkbox checkbox_active" value="1"></span>';
    } else {
        $retour .= '<span id="cmu" class="checkbox" value="0"></span>';
    }
    $retour .= '
                </div>
                <div class="colonne">
                    <span class="attribut">Date d&eacute;but droit :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutcouvsecu" value="'.getDatebyTimestamp($user->dateDebutCouvSecu).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin de droits :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefincouvsecu" value="'.getDatebyTimestamp($user->dateFinCouvSecu).'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateCouvertureSocial">Enregistrer</div>
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
$retour .= $user->idCaisseMut == null || ' ' ? '<div id="mutuelle" class="option" value="">-----</div>' : '<div id="mutuelle" class="option" value="'.$user->idCaisseMut.'">'.$user->mutuelle->appelation.'</div>';                   
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                    <span class="attribut">CMUC : </span>';
if($user->CMUC == 1) {
    $retour .= '<span id="cmuc" class="checkbox checkbox_active"></span>';
} else {
    $retour .= '<span id="cmuc" class="checkbox"></span>';
}
$retour .= '
                </div>
                <div class="colonne">
                    <span class="attribut">N&deg; adh&eacute;rent :</span>
                    <span><input class="contour_field input_char" type="text" id="numadherentmut" value="'.$user->numAdherentMut.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date d&eacute;but :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutcouvmut" value="'.getDatebyTimestamp($user->dateDebutCouvMut).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefincouvmut" value="'.getDatebyTimestamp($user->dateFinCouvMut).'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateMutuelle">Enregistrer</div>
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
$retour .= $user->idCaisseCaf == null || ' ' ? '<div id="caf" class="option" value="">-----</div>' : '<div id="caf" class="option" value="'.$user->idCaisseCaf.'">'.$user->caf->appelation.'</div>';                   
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">N&deg; allocataire :</span>
                    <span><input class="contour_field input_char" type="text" id="numallocatairecaf" value="'.$user->numAllocataireCaf.'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateCaf">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
return $retour;
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

function updateCaf() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $individu->idCaisseCaf = $_POST['caf'];
    $individu->numAllocataireCaf = $_POST['numallocatairecaf'];
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
                <div value="G&eacute;n&eacute;ral">G&eacute;n&eacute;ral</div>
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
