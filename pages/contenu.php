<?php

function contenu() {
    $menu = $_POST['idMenu'];
    switch ($menu) {
        case 'foyer':
            include_once './pages/foyer.php';
            echo foyerContenu($_POST['idFoyer']);
            break;
        case 'generalites':
            echo generalite();
            break;
        case 'budget':
            include_once './pages/budget.php';
            echo budget();
            break;
        case 'aides':
            include_once './pages/aide.php';
            echo aide();
            break;
        case 'historique':
            include_once './pages/historique.php';
            echo affichageHistoriqueByIndividu();
            break;
        case 'documents':
            include_once './pages/document.php';
            echo getDocumentIndividu();
            break;
        case 'actions':
            include_once('./pages/action.php');
            echo action();
            break;
        case 'accueil':
            echo accueilContenu();
            break;
        case 'manageuser' :
            include_once('./pages/admin.php');
            echo manageUser();
            break;
        case 'managerole' :
            include_once('./pages/admin.php');
            echo manageRole();
            break;
        case 'document':
            include_once('./pages/document.php');
            echo getDocument();
            break;
        case 'accueilConfig':
            include_once('./pages/config.php');
            echo accueilConfig();
            break;
        case 'ecranTableStatique':
            include_once './pages/tableStatique.php';
            echo comboTableStatique();
            break;
        case 'historiqueGlobal':
            include_once './pages/historique.php';
            echo affichageHistorique();
            break;
    }
}

function generalite() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $situations = Doctrine_Core::getTable('situationmatri')->findAll();
    $nationalite = Doctrine_Core::getTable('nationalite')->findAll();
    $villes = Doctrine_Core::getTable('ville')->findAll();
    $liens = Doctrine_Core::getTable('lienfamille')->findAll();
    $etudes = Doctrine_Core::getTable('etude')->findAll();
    $professions = Doctrine_Core::getTable('profession')->findAll();
    $organismes = Doctrine_Core::getTable('organisme')->findAll();
    
    $contenu = '<h2>G&eacute;n&eacute;ralit&eacute;s</h2>';
    $contenu .= '
    <div>
        <h3><span>Informations personnelles</span>  <span class="edit"></span></h3>
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
$contenu .= $user->idSitMatri == null || ' ' ? '<div id="situation" class="option" value=" ">-----</div>' : '<div id="situation" class="option" value="'.$user->idSitMatri.'">'.$user->situationmatri->situation.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Nationalit&eacute; :</span>
                        <div class="select classique" role="select_natio" disabled>';
$contenu .= $user->idNationalite == null || ' ' ? '<div id="nationalite" class="option" value=" ">-----</div>' : '<div id="nationalite" class="option" value="'.$user->idNationalite.'">'.$user->nationalite->nationalite.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
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
$contenu .= $user->sexe == null || ' ' ? '<div id="sexe" class="option" value=" ">-----</div>' : '<div id="sexe" class="option" value="'.$user->sexe.'">'.$user->sexe.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Statut :</span>
                        <div class="select classique" role="select_statut" disabled>';
$contenu .= $user->idLienFamille == null || ' ' ? '<div id="statut" class="option" value=" ">-----</div>' : '<div id="statut" class="option" value="'.$user->idLienFamille.'">'.$user->lienfamille->lien.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="bouton modif update" value="updateInfoPerso">Enregistrer</div>
            <div class="clearboth"></div>
        </div>';
    
// CONTACT
    $contenu .= '
    <div>
        <h3><span>T&eacute;l&egrave;phone / Email</span>  <span class="edit"></span></h3>
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
    
// SITUATION PROFESSIONNELLE
    $contenu .= '
    <div class="colonne50">
        <h3><span>Situation professionnelle</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">';
$contenu .=      '<div class="colonne_large">
                    <span class="attribut">Profession :</span>
                    <div class="select classique" role="select_profession" disabled>';
$contenu .= $user->idNiveauEtude == null || ' ' ? '<div id="profession" class="option" value=" ">-----</div>' : '<div id="profession" class="option" value="'.$user->idProfession.'">'.$user->profession->profession.'</div>';  
$contenu .= '
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

// SITUATION SCOLAIRE
    $contenu .= '
    <div class="colonne50">
        <h3><span>Situation scolaire</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique" >
                <div class="colonne_large">
                    <span class="attribut">actuellement scolaris&eacute; :</span>';
                        if($user->scolarise == 1) {
                            $contenu .= '<span id="checkboxScolarise" class="checkbox checkbox_active" value="1"></span>';
                        } else {
                            $contenu .= '<span id="checkboxScolarise" class="checkbox"></span>';
                        }
     $contenu .='</div>
            </li>';
            if($user->scolarise == 1) {
                $contenu .= '<div class="scolarise">';
            } else {
                $contenu .= '<div class="scolarise" style="display:none">';
            }
    $contenu .='<li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">&Eacute;tablissement :</span>
                        <span><input class="contour_field input_char" type="text" id="etablissementscolaire" value="'.$user->etablissementScolaire.'" disabled/></span>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">Classe :</span>
                        <div class="select classique" role="select_etude" disabled>';
    $contenu .= $user->idNiveauEtude == null || ' ' ? '<div id="etude" class="option" value=" ">-----</div>' : '<div id="etude" class="option" value="'.$user->idNiveauEtude.'">'.$user->etude->etude.'</div>';  
    $contenu .= '
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </div>';
            if($user->scolarise == 1) {
                $contenu .= '<div class="nonscolarise" style="display:none">';
            } else {
                $contenu .= '<div class="nonscolarise">';
            }
    $contenu .='<li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">Niveau &eacute;tude :</span>
                        <div class="select classique" role="select_etude" disabled>';
    $contenu .= $user->idNiveauEtude == null || ' ' ? '<div id="etude" class="option" value=" ">-----</div>' : '<div id="etude" class="option" value="'.$user->idNiveauEtude.'">'.$user->etude->etude.'</div>';  
    $contenu .= '
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </div>
        </ul>
        <div class="bouton modif update" value="updateSituationScolaire">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
    
// COUVERTURE SOCIALE
    $contenu .= '
    <div>
        <h3><span>Couverture sociale</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Assur&eacute; : </span>';
    if($user->assure == 1) {
        $contenu .= '<span id="assure" class="checkbox checkbox_active" value="1"></span>';
    } else {
        $contenu .= '<span id="assure" class="checkbox" value="0"></span>';
    }
                    
    $contenu .= '</div>
                <div class="colonne">
                    <span class="attribut">N&deg; :</span>
                    <span><input maxlength="13" class="contour_field input_numsecu" type="text" id="numsecu" value="'.$user->numSecu.'" size="13" disabled/></span>
                    <span><input maxlength="2" class="contour_field input_cle" type="text" id="clefsecu" value="'.$user->clefSecu.'" size="2" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">R&eacute;gime :</span>
                    <div class="select classique" role="select_regime" disabled>';
$contenu .= $user->regime == null || ' ' ? '<div id="regime" class="option" value=" ">-----</div>' : '<div id="regime" class="option" value="'.$user->regime.'">'.$user->regime.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
            </li>
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_couv" disabled>';
$contenu .= $user->idCaisseSecu == null || ' ' ? '<div id="caisseCouv" class="option" value=" ">-----</div>' : '<div id="caisseCouv" class="option" value="'.$user->idCaisseSecu.'">'.$user->secu->appelation.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">CMU : </span>';
    if($user->cmu == 1) {
        $contenu .= '<span id="cmu" class="checkbox checkbox_active" value="1"></span>';
    } else {
        $contenu .= '<span id="cmu" class="checkbox" value="0"></span>';
    }
    $contenu .= '
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
    
// MUTUELLE
$contenu .= '
    <div>
        <h3><span>Mutuelle</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_mut" disabled>';
$contenu .= $user->idCaisseMut == null || ' ' ? '<div id="mutuelle" class="option" value="">-----</div>' : '<div id="mutuelle" class="option" value="'.$user->idCaisseMut.'">'.$user->mutuelle->appelation.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                    <span class="attribut">CMUC : </span>';
if($user->CMUC == 1) {
    $contenu .= '<span id="cmuc" class="checkbox checkbox_active"></span>';
} else {
    $contenu .= '<span id="cmuc" class="checkbox"></span>';
}
$contenu .= '
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

// CAF
$contenu .= '
    <div>
        <h3><span>CAF</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_caf" disabled>';
$contenu .= $user->idCaisseCaf == null || ' ' ? '<div id="caf" class="option" value="">-----</div>' : '<div id="caf" class="option" value="'.$user->idCaisseCaf.'">'.$user->caf->appelation.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
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

// COMBO BOX
$contenu .= '<ul class="select_caf">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Caisse CAF') {
            $contenu .= '
                    <li>
                        <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
$contenu .= '<ul class="select_mut">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Mutuelle') {
            $contenu .= '
                    <li>
                        <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_couv">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Caisse SECU') {
            $contenu .= '
                    <li>
                        <div  value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
    
    
    $contenu .= ' <ul class="select_regime">';
     $contenu .= '<li>
                                    <div value="Local">Local</div>
                            </li>
                            <li>
                                <div value="G&eacute;n&eacute;ral">G&eacute;n&eacute;ral</div>
                            </li>
                            </ul>';
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_profession">';
    foreach($professions as $profession) {
        $contenu .= '<li>
                                    <div value="'.$profession->id.'">'.$profession->profession.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
   $contenu .= ' <ul class="select_etude">';
    foreach($etudes as $etude) {
        $contenu .= '<li>
                                    <div value="'.$etude->id.'">'.$etude->etude.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_statut">';
    foreach($liens as $lien) {
        $contenu .= '<li>
                                    <div value="'.$lien->id.'">'.$lien->lien.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_ville">';
    foreach($villes as $ville) {
        $contenu .= '<li>
                                    <div value="'.$ville->id.'">'.$ville->libelle.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_natio">';
    foreach($nationalite as $nat) {
        $contenu .= '<li>
                                    <div value="'.$nat->id.'">'.$nat->nationalite.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_situation">';
    foreach($situations as $sit) {
        $contenu .= '<li>
                                    <div value="'.$sit->id.'">'.$sit->situation.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_sexe">
                                <li>
                                    <div value="Homme">Homme</div>
                                </li>
                                <li value="Femme">
                                    <div value="Femme">Femme</div>
                                </li>
                            </ul>';
    return $contenu;
}

?>
