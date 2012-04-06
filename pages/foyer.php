<?php

function foyer() {
    $_SESSION['idIndividu'] = $_POST['idIndividu'];
    $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividu']);
    $menu = generationHeaderNavigation('foyer');
    if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_FOYER)) {
        $contenu = foyerContenu($_POST['idFoyer']);
    } else {
        $contenu = 'Vous n\'avez pas les droits pour afficher la fiche Foyer';
    }
    $retour = array('listeIndividu' => $listeIndividu, 'menu' => $menu, 'contenu' => $contenu);
    echo json_encode($retour);
}

function foyerContenu($idFoyer) {
    $contenu = '';
    $contenu .= '<h2>Foyer</h2>';
    $foyer = Doctrine_Core::getTable('foyer')->find($idFoyer);

    function sortFoyer($a, $b) {
        if ($a->chefDeFamille == 1) {
            return -1;
        }
        if ($b->chefDeFamille == 1) {
            return 1;
        }
        return ($a->dateNaissance < $b->dateNaissance) ? -1 : 1;
        return 0;
    }

    $individus = $foyer->individu;
    $individus = $individus->getData(); // convert from Doctrine_Collection to array
    usort($individus, 'sortFoyer');
    
    $contenu .= '
        <h3>Membres du foyer</h3>
        <ul class="list_classique">';
    foreach ($individus as $individu) {
        $contenu .= generateLigneMembreFoyer($individu);
    }
    $lienFamilles = Doctrine_Core::getTable('lienFamille')->findAll();
    $contenu .= '
        </ul>';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_CREATION_INDIVIDU)) {
        $contenu .= '
            <div id="newIndividu" value="add" class="bouton ajout">
                <i class="icon-add"></i>
                <span>Ajouter un individu</span>
            </div>';
    }
    $contenu .= '
        <div value="updateMembreFoyer" class="bouton modif update">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="formulaire" action="creation_individu">
            <h2>Individu</h2>
            <div class="colonne_droite">
                <div class="select classique" role="select_civilite">
                    <div id="form_1" class="option">Madame</div>
                    <div class="fleche_bas"> </div>
                </div>
                <div class="input_text">
                    <input id="form_2" class="contour_field requis" type="text" title="Nom" placeholder="Nom">
                </div>
                <div class="input_text">
                    <input id="form_3" class="contour_field requis" type="text" title="Prénom" placeholder="Prénom">
                </div>
                <div class="input_text">
                    <input id="form_4" class="contour_field date" type="text" title="Date de naissance" placeholder="Date de naissance">
                </div>
                <div class="select classique" role="select_lien_famille">
                    <div id="form_5" class="option" value=" ">Lien de famille</div>
                    <div class="fleche_bas"></div>
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
        <ul class="select_lien_famille">';
    
        
        $i = 0;
        foreach ($lienFamilles as $lienFamille) {
            $contenu .= '<li>
                <div value="'.$lienFamille->id.'">'.$lienFamille->lien.'</div>
            </li>';
            $i++;
        }
        $contenu .= '</ul>';
        $contenu .= generateInfoFoyer($foyer);
    return $contenu;
}

function generateInfoFoyer($foyer) {
    $secteurs = Doctrine_Core::getTable('secteur')->findAll();
    $types =  Doctrine_Core::getTable('type')->findAll();
    $bailleurs =  Doctrine_Core::getTable('bailleur')->findAll();
    $instructs =  Doctrine_Core::getTable('instruct')->findAll();
    $retour = '';
    $retour .= '
        <div><h3>Foyer ';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_FOYER)) {
        $retour .= '<span class="edit">';
    }
    $retour .= '</span></h3>
            <ul class="list_classique">
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">N° :</span>
                        <span><input type="text" class="contour_field input_num" id="numrue" value="'.$foyer->numRue.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Rue :</span>
                        <span><input type="text" class="contour_field input_char autoComplete" id="rue" table="rue" champ="rue" value="'.$foyer->rue->rue.'" valeur="'.$foyer->rue->id.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Secteur :</span>
                        <div class="select classique" role="select_secteur" disabled>';
    $retour .= $foyer->idSecteur == null || $foyer->idSecteur == ' ' ? '<div id="secteur" class="option">-----</div>':'<div id="secteur" class="option" value="'.$foyer->idSecteur.'">'.$foyer->secteur->secteur.'</div>';
    $retour .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Ville :</span>
                        <span><input type="text" class="contour_field input_char autoComplete" id="ville" table="ville" champ="libelle" value="'.$foyer->ville->libelle.'" valeur="'.$foyer->ville->id.'" disabled/></span>
                    </div>
               </li>
               <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Type :</span>
                        <div class="select classique" role="select_typelogement" disabled>';
$retour .= $foyer->typeLogement == null || $foyer->typeLogement == ' ' ? '<div id="typelogement" class="option">-----</div>':'<div id="typelogement" class="option" value="'.$foyer->typeLogement.'">'.$foyer->typelogement->libelle.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                </div>
                </div>
                   <div class="colonne">
                        <span class="attribut">Statut :</span>
                        <div class="select classique" role="select_statutlogement" disabled>';
$retour .= $foyer->typeAppartenance == null || $foyer->typeAppartenance == ' ' ? '<div id="statutlogement" class="option">-----</div>':'<div id="statutlogement" class="option" value="'.$foyer->typeAppartenance.'">'.$foyer->statutlogement->libelle.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                   </div>
                   <div class="colonne">
                        <span class="attribut">Surface :</span>
                        <span><input class="contour_field input_num" type="text" id="surface" value="'.$foyer->logSurface.'" disabled/></span>
                  </div>
                  <div class="colonne">
                        <span class="attribut">Date d\'entrée :</span>
                        <span><input class="contour_field input_date" type="text" id="dateentree" size="10" value="'.getDatebyTimestamp($foyer->logDateArrive).'" disabled/></span>
                  </div>
               </li>
               <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Bailleur :</span>
                        <div class="select classique" role="select_bailleur" disabled>';
$retour .= $foyer->idBailleur == null || $foyer->idBailleur == ' ' ? '<div id="bailleur" class="option">-----</div>':'<div id="bailleur" class="option" value="'.$foyer->idBailleur.'">'.$foyer->bailleur->nomBailleur.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Instructeur :</span>
                        <div class="select classique" role="select_instruct" disabled>';
$retour .= $foyer->idInstruct == null || $foyer->idInstruct == null ? '<div id="instruct" class="option">-----</div>':'<div id="instruct" class="option" value="'.$foyer->idInstruct.'">'.$foyer->instruct->nom.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                    </div>
                    <div class="colonne_large">
                        <span class="attribut_for_large">Note :</span>
                        <span><input class="contour_field input_char_for_large" type="text" id="note" value="'.$foyer->notes.'" disabled/></span>
                    </div>
               </li>
            </ul>';
       
$retour .= '
            <div value="updateFoyer" class="bouton modif update">
                <i class="icon-save"></i>
                <span>Enregistrer</span>
            </div>
            <div class="clearboth"></div>
        </div>';
 $retour .= situationFinanciere($foyer->id);
 // COMBO BOX
 $retour .= '<ul class="select_instruct">';
    foreach($instructs as $instruct) {
        $retour .= '<li>
                                <div value="'.$instruct->id.'">'.$instruct->nom.'</div>
                           </li>';
    }
    $retour .= '</ul>';
 $retour .= '<ul class="select_bailleur">';
    foreach($bailleurs as $bailleur) {
        $retour .= '<li>
                                <div value="'.$bailleur->id.'">'.$bailleur->nomBailleur.'</div>
                           </li>';
    }
    $retour .= '</ul>';
 $retour .= '<ul class="select_statutlogement">';
 foreach($types as $t) {
     if($t->categorie == 3) {
     $retour .= '<li>
                            <div value="'.$t->id.'">'.$t->libelle.'</div>
                        </li>';
     }
 }
 $retour .= '</ul>';
 $retour .= '<ul class="select_typelogement">';
 foreach($types as $t) {
     if($t->categorie == 4) {
     $retour .= '<li>
                            <div value="'.$t->id.'">'.$t->libelle.'</div>
                        </li>';
     }
 }
 $retour .= '</ul>';
    $retour .= '<ul class="select_secteur">';
    foreach($secteurs as $secteur) {
        $retour .= '<li>
                                <div value="'.$secteur->id.'">'.$secteur->secteur.'</div>
                           </li>';
    }
    $retour .= '</ul>';
    return $retour;
}

function generateLigneMembreFoyer($individu) {
    $retour = '
        <li class="ligne_list_classique" id_foyer='.$individu->idFoyer.' id_individu='.$individu->id.'>
            <div>
                <span class="label">' . $individu->nom . ' ' . $individu->prenom .'</span>
                <span class="date_naissance">'. date('d/m/Y', $individu->dateNaissance) .'</span>
                <span class="date_naissance">'. $individu->lienfamille->lien .'</span>';
                if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_INDIVIDU)) {
                    $retour .= '<span class="delete_individu droite"></span>';
                }
                $retour .= '<span class="droite"> Chef de famille ';
                
                if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_INDIVIDU)) {
                    if ($individu->chefDeFamille) {
                        $retour .= '<span class="checkboxChefFamille checkbox_active"></span>';
                    } else {
                        $retour .= '<span class="checkboxChefFamille"></span>';
                    }
                } else {
                    if ($individu->chefDeFamille) {
                        $retour .= '<span class="checkboxChefFamille checkbox_active" disabled></span>';
                    } else {
                        $retour .= '<span class="checkboxChefFamille" disabled></span>';
                    }
                }
                    
    $retour .= '</span>
                
            </div>
        </li>';
    
    return $retour;
}

function situationFinanciere($idFoyer) {
    include_once('./lib/config.php');
    $individus = Doctrine_Core::getTable('individu')->findByIdFoyer($idFoyer);
    
    $totalRessource = 0;
    $totalDepense = 0;
    $totalDette = 0;
    $totalCredit = 0;
    
    foreach($individus as $individu) {
        $ressource = Doctrine_Core::getTable('ressource')->getLastFicheRessource($individu->id);
        $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($individu->id);
        $dette = Doctrine_Core::getTable('dette')->getLastFicheDette($individu->id);
        $credits = Doctrine_Core::getTable('credit')->findByIdIndividu($individu->id);
        if(isset($ressource->id)) {
            $arrayRessource = array($ressource->salaire, $ressource->chomage, $ressource->revenuAlloc, $ressource->ass, $ressource->aah, $ressource->rsaSocle,
                                            $ressource->rsaActivite, $ressource->pensionAlim, $ressource->pensionRetraite, $ressource->retraitComp, $ressource->autreRevenu, $ressource->aideLogement);
            $totalRessource =  $totalRessource + array_sum($arrayRessource);
        }
        if(isset($depense->id)) {
            $arrayDepense = array($depense->impotRevenu, $depense->impotLocaux, $depense->pensionAlim, $depense->mutuelle, $depense->electricite, $depense->gaz,
                                            $depense->eau, $depense->chauffage, $depense->telephonie, $depense->internet, $depense->television, $depense->assurance, $depense->credit,
                                            $depense->autreDepense, $depense->loyer);
            $totalDepense = $totalDepense + array_sum($arrayDepense);
        }
        if(isset($dette->id)) {
            $arrayDette = array($dette->arriereLocatif, $dette->fraisHuissier, $dette->arriereElectricite, $dette->arriereGaz, $dette->autreDette);
            $totalDette = $totalDette + array_sum($arrayDette);
        }
        
            foreach($credits as $credit) {
                $totalCredit = $totalCredit + $credit->mensualite;
            }
    }
        $contenu = '<div><h3>Situation financière de la famille</h3>';
        $contenu .= '
            <ul class="list_classique">
                    <li class="ligne_list_classique">
                        <div class="colonne">
                            <span class="attribut">Total ressources :</span>
                            <span>'.$totalRessource.'€</span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Total dépenses :</span>
                            <span>'.$totalDepense.'€</span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Total dettes :</span>
                            <span>'.$totalDette.'€</span>
                        </div>
                        <div class="colonne">
                            <span class="attribut">Total credits :</span>
                            <span>'.$totalCredit.'€</span>
                        </div>
                    </li>
            </ul>
            </div>';
        return $contenu;
}

function updateFoyer() {
    include_once('./lib/config.php');
    $foyer = Doctrine_Core::getTable('foyer')->find($_POST['idFoyer']);
    $foyer->numRue = $_POST['numrue'];
    $foyer->idRue = $_POST['rue'];
    $foyer->idSecteur = $_POST['secteur'];
    $foyer->idVille = $_POST['ville'];
    $foyer->idBailleur = $_POST['bailleur'];
    $foyer->typeLogement = $_POST['type'];
    $foyer->typeAppartenance = $_POST['statut'];
    $foyer->logSurface = $_POST['surface'];
    $foyer->idInstruct = $_POST['instruct'];
    $foyer->notes = $_POST['notes'];
    if($_POST['dateentree'] != 0) {
        $date = explode('/', $_POST['dateentree']);
        $foyer->logDateArrive = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
    } else {
        $foyer->logDateArrive = 0;
    }
    $foyer->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'foyer', $_SESSION['userId'], Doctrine_Core::getTable('individu')->findOneByIdFoyerAndChefDeFamille($_POST['idFoyer'], true));
}

function creationFoyer($civilite, $nom, $prenom) {
    include_once('./lib/config.php');
    $foyer = new Foyer();
    $foyer->dateInscription = time();
    $foyer->save();
    $individu = new Individu();
    $individu->civilite = $civilite;
    $individu->nom = $nom;
    $individu->prenom = $prenom;
    $individu->chefDeFamille = true;
    $individu->idFoyer = $foyer->id;
    $individu->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'foyer', $_SESSION['userId'], $individu->id);
    include_once('./pages/budget.php');
    createRessource($individu->id);
    createDepense($individu->id);
    createDette($individu->id);
    
    return array('idFoyer' => $foyer->id, 'idIndividu' => $individu->id);
}

?>
