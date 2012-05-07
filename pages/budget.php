<?php

function budget() {
    include_once('./lib/config.php');
    $ressource = Doctrine_Core::getTable('ressource')->getLastFicheRessource($_POST['idIndividu']);
    $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($_POST['idIndividu']);
    $dette = Doctrine_Core::getTable('dette')->getLastFicheDette($_POST['idIndividu']);
    $credits = Doctrine_Core::getTable('credit')->findByIdIndividu($_POST['idIndividu']);
    $contenu = '';
    $contenu .= afficherRessources($ressource);
    $contenu .= afficherDepenses($depense);
    $contenu .= '          
        <div>
            <h3>Dépenses habitation ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_BUDGET)) {
        $contenu .= '<span class="edit"></span>';
    }
    $contenu .= '</h3>
            <ul class="list_classique">
                <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Loyer : </span>
                    <span><input class="contour_field input_num" type="text" id="loyer" value="'.$depense->loyer.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">AL ou APL : </span>
                    <span><input class="contour_field input_num" type="text" id="apl" value="'.$ressource->aideLogement.'" disabled/></span>
               </div>
               <div class="colonne">
                    <span class="attribut">Résiduel : </span>
                    <span>'.($depense->loyer - $ressource->aideLogement).'</span>
                </div>
                </li>
            </ul>
            <div value="updateDepenseHabitation" class="bouton modif update">
                <i class="icon-save"></i>
                <span>Enregistrer</span>
            </div>
            <div class="clearboth"></div>
        </div>';
    $contenu .= afficherDettes($dette);
    $contenu .= afficherCredits($credits);
    
    $contenu .= 
        '<div class="formulaire" action="archive_ressource">
            <h2>Individu</h2>
            <div class="colonne_droite">
                <span>Etes-vous sur de vouloir archiver la fiche ressource ?</span>
                <div class="sauvegarder_annuler">
                    <div value="archive_ressource" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Oui</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Non</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="formulaire" action="archive_depense">
            <h2>Individu</h2>
            <div class="colonne_droite">
                <span>Etes-vous sur de vouloir archiver la fiche depense ?</span>
                <div class="sauvegarder_annuler">
                    <div value="archive_depense" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Oui</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Non</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="formulaire" action="archive_dette">
            <h2>Individu</h2>
            <div class="colonne_droite">
                <span>Etes-vous sur de vouloir archiver la fiche dette ?</span>
                <div class="sauvegarder_annuler">
                    <div value="archive_dette" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Oui</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Non</span>
                    </div>
                </div>
            </div>
        </div>';
    
    return $contenu;
}

function afficherRessources($ressource) {
    $retour = '<div><h3 role="ressource"><span>Ressources</span>  ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_BUDGET)) {
        $retour .= '<span class="edit"></span>';
    }
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_ARCHIVER_BUDGET)) {
        $retour .= '<span class="archive"></span> ';
    }
    $retour .= '<span class="timemaj">'.getDatebyTimestamp($ressource->dateCreation).'</span></h3>';
    $retour .= '<ul class="list_classique">
                    <li class="ligne_list_classique">
                        <div class="colonne_num">
                            <span class="attribut">Salaire : </span>
                            <span><input class="contour_field input_num" type="text" id="salaire" value="'.$ressource->salaire.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">All. Chômage : </span>
                            <span><input class="contour_field input_num" type="text" id="chomage" value="'.$ressource->chomage.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">All. familiales : </span>
                            <span><input class="contour_field input_num" type="text" id="revenuAlloc" value="'.$ressource->revenuAlloc.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">ASS : </span>
                            <span><input class="contour_field input_num" type="text" id="ass" value="'.$ressource->ass.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">AAH : </span>
                            <span><input class="contour_field input_num" type="text" id="aah" value="'.$ressource->aah.'" disabled/></span>
                        </div>
                    
                        <div class="colonne_num">
                            <span class="attribut">RSA Socle : </span>
                            <span><input class="contour_field input_num" type="text" id="rsaSocle" value="'.$ressource->rsaSocle.'" disabled/></span>
                        </div>
                    </li>
                    <li class="ligne_list_classique">
                        <div class="colonne_num">
                            <span class="attribut">RSA Activité : </span>
                            <span><input class="contour_field input_num" type="text" id="rsaActivite" value="'.$ressource->rsaActivite.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">Retraite compl  : </span>
                            <span><input class="contour_field input_num" type="text" id="retraitComp" value="'.$ressource->retraitComp.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">P. alimentaire : </span>
                            <span><input class="contour_field input_num" type="text" id="pensionAlim" value="'.$ressource->pensionAlim.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">P. de retraite : </span>
                            <span><input class="contour_field input_num" type="text" id="pensionRetraite" value="'.$ressource->pensionRetraite.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">P. d\'invalidité : </span>
                            <span><input class="contour_field input_num" type="text" id="invalide" value="'.$ressource->pensionInvalide.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">IJSS : </span>
                            <span><input class="contour_field input_num" type="text" id="ijss" value="'.$ressource->ijss.'" disabled/></span>
                        </div>
                    </li>
                <li class="ligne_list_classique">
                        <div class="colonne_num">
                            <span class="attribut">Autres revenus  : </span>
                            <span><input class="contour_field input_num" type="text" id="autreRevenu" value="'.$ressource->autreRevenu.'" disabled/></span>
                        </div>
                        <div class="colonne_num">
                            <span class="attribut">Nature : </span>
                            <span><input class="contour_field input_char" type="text" id="natureRevenu" value="'.$ressource->natureAutre.'" disabled/></span>
                        </div>
                   </li>
                </ul>
                <div value="updateRessource" class="bouton modif update">
                    <i class="icon-save"></i>
                    <span>Enregistrer</span>
                </div>
                <div class="clearboth"></div>
            </div>';
    return $retour;
}

function afficherDepenses($depense) {
    $retour = '
        <div>
            <h3 role="depense">Dépenses ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_BUDGET)) {
        $retour .= '<span class="edit"></span>';
    }
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_ARCHIVER_BUDGET)) {
        $retour .= '<span class="archive"></span> ';
    }
    $retour .= '<span class="timemaj">'.getDatebyTimestamp($depense->dateCreation).'</span></h3>
            <ul class="list_classique">
                <li class="ligne_list_classique">
                    <div class="colonne_num">
                        <span class="attribut">Impôts revenu : </span>
                        <span><input class="contour_field input_num" type="text" id="impotRevenu" value="'.$depense->impotRevenu.'" disabled/></span>
                     </div>
                    <div class="colonne_num">
                        <span class="attribut">Impôts locaux : </span>
                        <span><input class="contour_field input_num" type="text" id="impotLocaux" value="'.$depense->impotLocaux.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">P. alimentaire :</span>
                        <span><input class="contour_field input_num" type="text" id="pensionAlim" value="'.$depense->pensionAlim.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Mutuelle : </span>
                        <span><input class="contour_field input_num" type="text" id="mutuelle" value="'.$depense->mutuelle.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Electricité : </span>
                        <span><input class="contour_field input_num" type="text" id="electricite" value="'.$depense->electricite.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Gaz : </span>
                        <span><input class="contour_field input_num" type="text" id="gaz" value="'.$depense->gaz.'" disabled/></span>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne_num">
                        <span class="attribut">Eau : </span>
                        <span><input class="contour_field input_num" type="text" id="eau" value="'.$depense->eau.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Chauffage :</span>
                        <span><input class="contour_field input_num" type="text" id="chauffage" value="'.$depense->chauffage.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Téléphonie : </span>
                        <span><input class="contour_field input_num" type="text" id="telephonie" value="'.$depense->telephonie.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Internet : </span>
                        <span><input class="contour_field input_num" type="text" id="internet" value="'.$depense->internet.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Télévision : </span>
                        <span><input class="contour_field input_num" type="text" id="television" value="'.$depense->television.'" disabled/></span>
                    </div>
                     <div class="colonne_num">
                        <span class="attribut">Assurance Voiture : </span>
                        <span><input class="contour_field input_num" type="text" id="assuranceVoiture" value="'.$depense->assuranceVoiture.'" disabled/></span>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne_num">
                        <span class="attribut">Assurance Habitation : </span>
                        <span><input class="contour_field input_num" type="text" id="assuranceHabitation" value="'.$depense->assuranceHabitation.'" disabled/></span>
                    </div>
                    <div class="colonne_num">
                        <span class="attribut">Autres Dépenses : </span>
                        <span><input class="contour_field input_num" type="text" id="autreDepense" value="'.$depense->autreDepense.'" disabled/></span>
                    </div>
                    <div class="colonne_large">
                        <span class="attribut">Détail : </span>
                        <span><textarea class="contour_field  input_char" type="text" id="natureDepense" disabled>'.$depense->natureDepense.'</textarea></span>
                    </div>
                </li>
            </ul>
            <div value="updateDepense" class="bouton modif update">
                <i class="icon-save"></i>
                <span>Enregistrer</span>
            </div>
            <div class="clearboth"></div>
        </div>';
    return $retour;
}

function afficherDettes($dette) {
    $retour = '
        <div>
            <h3 role="dette">Dettes ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_BUDGET)) {
        $retour .= '<span class="edit"></span>';
    }
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_ARCHIVER_BUDGET)) {
        $retour .= '<span class="archive"></span> ';
    }
    $retour .= '<span class="timemaj">'.getDatebyTimestamp($dette->dateCreation).'</span></h3>
                <ul class="list_classique">
                    <li class="ligne_list_classique">
                        <div class="colonne">
                            <span class="attribut">Arriéré locatif : </span>
                            <span><input class="contour_field input_num" type="text" id="arriereLocatif" value="'.$dette->arriereLocatif.'" disabled/></span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Frais huissier : </span>
                            <span><input class="contour_field input_num" type="text" id="fraisHuissier" value="'.$dette->fraisHuissier.'" disabled/></span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Autres dettes : </span>
                            <span><input class="contour_field input_num" type="text" id="autreDette" value="'.$dette->autreDette.'" disabled/></span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Nature  :</span>
                            <span><input class="contour_field input_char" type="text" id="natureDette" value="'.$dette->natureDette.'" disabled/></span>
                        </div>
                    </li>
                    <li class="ligne_list_classique">
                        <div class="colonne">
                            <span class="attribut">Arriéré électricité : </span>
                            <span><input class="contour_field input_num" type="text" id="arriereElec" value="'.$dette->arriereElectricite.'" disabled/></span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Prestataire : </span>
                            <span><input class="contour_field input_char" type="text" id="prestaElec" value="'.$dette->prestaElec.'" disabled/></span>
                        </div>
                    </li>
                    <li class="ligne_list_classique">
                        <div class="colonne">
                            <span class="attribut">Arriéré gaz : </span>
                            <span><input class="contour_field input_num" type="text" id="arriereGaz" value="'.$dette->arriereGaz.'" disabled/></span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Prestataire : </span>
                            <span><input class="contour_field input_char" type="text" id="prestaGaz" value="'.$dette->prestaGaz.'" disabled/></span>
                        </div>
                    </li>
                </ul>
                <div value="updateDette" class="bouton modif update">
                    <i class="icon-save"></i>
                    <span>Enregistrer</span>
                </div>
                <div class="clearboth"></div>
            </div>';
    return $retour;
}

function afficherCredits($credits) {
    $retour ='
        <div class="colonne_large">
            <h3>Crédits ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_BUDGET)) {
        $retour .= '<span class="addElem"  id="createCredit" role="creation_credit"></span>';
    }
    $retour .= '</h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Organisme</th>
                            <th>Mensualité</th>
                            <th>Durée</th>
                            <th>Montant restant</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>';
                    if (sizeof($credits) != null) {
                        foreach($credits as $credit) {
                            $retour .= '
                                <tr name="'.$credit->id.'">
                                    <td>'.$credit->organisme.'</td>
                                    <td> '.$credit->mensualite.'€/mois</td>
                                    <td> '.$credit->dureeMois.' mois</td>
                                    <td> '.$credit->totalRestant.'</td>
                                    <td><span class="delete_credit"></span></td>
                                </tr>';
                        }
                    } else {
                        $retour .= '
                            <tr>
                                <td colspan=9 align=center>< Aucun crédit n\'est enregistré pour cet individu > </td>
                            </tr>';
                    }
                $retour .= '
                    </tbody>
                </table>
            </div>
        </div>
        <div class="formulaire" action="creation_credit">
            <h2>Crédit</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input id="organisme" class="contour_field requis" type="text" title="Organisme" placeholder="Organisme">
                </div>
                <div class="input_text">
                    <input id="mensualite" class="contour_field requis" type="text" title="Mensualite" placeholder="Mensualite">
                </div>
                <div class="input_text">
                    <input id="duree" class="contour_field requis" type="text" title="Durée" placeholder="Durée">
                </div>
                <div class="input_text">
                    <input id="total" class="contour_field requis" type="text" title="Total Restant" placeholder="Total Restant">
                </div>
                <div class="sauvegarder_annuler">
                    <div value="save" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Enregistrer</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="formulaire" action="suppression_credit">
            <h2>Crédit</h2>
            <div class="colonne_droite">
                <span>Etes-vous sur de vouloir supprimer le crédit.</span>
                <div class="sauvegarder_annuler">
                    <div value="delete_credit" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Oui</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Non</span>
                    </div>
                </div>
            </div>
        </div>';
    return $retour;
}

function createRessource($idIndividu) {
    $ressource = new Ressource();
    $ressource->idIndividu = $idIndividu;
    $ressource->dateCreation = time();
    $ressource->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'ressource', $_SESSION['userId'], $idIndividu);
} 

function createDepense($idIndividu) {
    $depense = new Depense();
    $depense->idIndividu = $idIndividu;
    $depense->dateCreation = time();
    $depense->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'depense', $_SESSION['userId'], $idIndividu);
}

function createDette($idIndividu) {
    $dette = new Dette();
    $dette->idIndividu = $idIndividu;
    $dette->dateCreation = time();
    $dette->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'dette', $_SESSION['userId'], $idIndividu);
}


function createCredit($idIndividu, $organisme, $mensualite, $duree, $total) {
    include_once('./lib/config.php');
    $credit = new Credit();
    $credit->organisme = $organisme;
    $credit->mensualite = $mensualite;
    $credit->dureeMois = $duree;
    $credit->totalRestant = $total;
    $credit->idIndividu = $idIndividu;
    $credit->dateAjout = time();
    $credit->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'credit', $_SESSION['userId'], $idIndividu);
}

function updateRessource() {
    include_once('./lib/config.php');
    $individu = Doctrine_Core::getTable('ressource')->getLastFicheRessource($_POST['idIndividu']);
    $individu->salaire = $_POST['salaire'];
    $individu->chomage = $_POST['chomage'];
    $individu->revenuAlloc = $_POST['revenuAlloc'];
    $individu->ass = $_POST['ass'];
    $individu->aah = $_POST['aah'];
    $individu->rsaSocle = $_POST['rsaSocle'];
    $individu->rsaActivite = $_POST['rsaActivite'];
    $individu->retraitComp = $_POST['retraitComp'];
    $individu->pensionAlim = $_POST['pensionAlim'];
    $individu->pensionInvalide = $_POST['pensionInvalide'];
    $individu->pensionRetraite = $_POST['pensionRetraite'];
    $individu->ijss = $_POST['ijss'];
    $individu->autreRevenu = $_POST['autreRevenu'];
    $individu->natureAutre = $_POST['natureAutre'];
    $individu->dateCreation = time();
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'ressource', $_SESSION['userId'], $_POST['idIndividu']);
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
    $individu->assuranceVoiture = $_POST['assuranceVoiture'];
    $individu->assuranceHabitation = $_POST['assuranceHabitation'];
    $individu->dateCreation = time();
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'depense', $_SESSION['userId'], $_POST['idIndividu']);
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
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'dette', $_SESSION['userId'], $_POST['idIndividu']);
}

function updateDepenseHabitation() {
    include_once('./lib/config.php');
    $ressource = Doctrine_Core::getTable('ressource')->getLastFicheRessource($_POST['idIndividu']);
    $ressource->aideLogement = $_POST['apl'];
    $ressource->save();
    
    $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($_POST['idIndividu']);
    $depense->loyer = $_POST['loyer'];
    $depense->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'depense habitation', $_SESSION['userId'], $_POST['idIndividu']);
}

function archiveRessource() {
    include_once('./lib/config.php');
    include_once('./pages/historique.php');
    createHistorique(Historique::$Archiver, 'ressource', $_SESSION['userId'], $_POST['idIndividu']);
    createRessource($_POST['idIndividu']);
    echo budget();
}

function archiveDepense() {
    include_once('./lib/config.php');
    include_once('./pages/historique.php');
    createHistorique(Historique::$Archiver, 'depense', $_SESSION['userId'], $_POST['idIndividu']);
    createDepense($_POST['idIndividu']);
    echo budget();
}

function archiveDette() {
    include_once('./lib/config.php');
    include_once('./pages/historique.php');
    createHistorique(Historique::$Archiver, 'dette', $_SESSION['userId'], $_POST['idIndividu']);
    createDette($_POST['idIndividu']);
    echo budget();
}

function deleteCredit() {
    include_once('./lib/config.php');
    $credit = Doctrine_Core::getTable('credit')->find($_POST['id']);
    $credit->delete();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Suppression, 'credit', $_SESSION['userId'], $credit->idIndividu);
    
    echo budget();   
}
?>
