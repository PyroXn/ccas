<?php
function aide() {
    $contenu = aideInterne();
    include_once('./pages/aideExterne.php');
    $contenu .= aideExterne();
    return $contenu;
}

function aideInterne() {
    $contenu = createCombo();
    $aidesInternes = Doctrine_Core::getTable('aideinterne')->findByIdIndividu($_POST['idIndividu']);
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $contenu .= '';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_CREATION_AIDE_INTERNE)) {
        $contenu .= '
            <div id="createAideInterne" class="bouton ajout" style="margin-right: 20px;">
                <i class="icon-add"></i>
                <span>Ajouter une aide interne</span>
            </div>';
    }
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_CREATION_AIDE_EXTERNE)) {
        $contenu .= '
            <div id="createAideExterne" class="bouton ajout">
                <i class="icon-add"></i>
                <span>Ajouter une aide externe</span>
            </div>';
    }
    $contenu .= '
        <h3>Aides Internes :</h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Date demande</th>
                            <th>Aide demandée</th>
                            <th>Etat</th>
                            <th>Nature</th>
                            <th>Avis</th>
                            <th>Montant</th>
                            <th>Date décision</th>
                            <th>Vigilance</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>';
    if (sizeof($aidesInternes) != null) {
        foreach($aidesInternes as $aideInterne) {
            $total = 0;
//            $bons = Doctrine_Core::getTable('bonaide')->findByIdAideInterne($aideInterne->id);
//            foreach($bons as $bon) {
//                $total += $bon->montant;
//            }
            $chemin = './document/'.$aideInterne->individu->idFoyer.'/'.$aideInterne->individu->id;
            $aideInterne->vigilance ? $contenu .= '<tr class="vigilance_ligne" name="'.$aideInterne->id.'">' :  $contenu .= '<tr name="'.$aideInterne->id.'">';
            $contenu .= '<td>'.getDatebyTimestamp($aideInterne->dateDemande).'</td>
                                    <td> '.$aideInterne->typeAideDemandee->libelle.'</td>
                                    <td> '.$aideInterne->etat.'</td>
                                    <td> '.$aideInterne->natureAide->libelle.'</td>
                                    <td> '.$aideInterne->avis.'</td>
                                    <td> '.$aideInterne->montanttotal.'€</td>
                                    <td> '.getDatebyTimestamp($aideInterne->dateDecision).'</td>';
                                    if ($aideInterne->vigilance) {
                                        $contenu .= '<td><span class="vigilance"></span></td>';
                                    } else {
                                        $contenu .= '<td></td>';
                                    }
                                    $contenu .= '<td><span class="edit_aide_interne" original-title="Afficher toutes les informations"></span> '.rapportExist($chemin, $aideInterne->id).' <span class="delete_aide aideInterne" original-title="Supprimer l\'aide"></span></td>
                                    
                        </tr>';
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=10 align=center>< Aucune aide interne n\'a été attribuée à cet individu > </td>
                     </tr>';
    }
    $contenu .= '</tbody></table></div>';
    $contenu .= '<div class="formulaire" action="creation_aide_interne">
        <h2>Aide interne</h2>
       <div class="colonne_droite">
            <div class="select classique" role="select_typeaide_interne">
                <div id="typeaideinterne" class="option requis">Type d\'aide</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="clearboth"></div>
            <div class="select classique" role="select_instruct2">
                <div id="instruct" class="option requis">Instructeur</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="clearboth"></div>
            <div class="select classique" role="select_orga">
                <div id="orga" class="option requis">Organisme</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <input id="date" class="contour_field input_date requis" type="text" title="Date" placeholder="Date de la demande d\'aide">
            </div>
            <div class="select classique" role="select_nature_interne">
                <div id="nature" class="option requis">Nature</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <input id="proposition" class="contour_field" type="text" title="Proposition" placeholder="Proposition">
            </div>
            <div class="select classique" role="select_etat">
                <div id="etat" class="option requis">Etat</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <span class="checkbox" id="urgence"></span> 
                <span class="attribut">Aide urgente</span>
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
</div>';
    return $contenu;
}

function detailAideInterne() {
    $aideInterne = Doctrine_Core::getTable('aideinterne')->findOneById($_POST['idAide']);
    $retour = headerAideInterne($aideInterne, false);
    $retour .= decisionAideInterne($aideInterne);
    $retour .= createCombo();
    return $retour;
}


function headerAideInterne($aideInterne, $chargerCombo) {
    if ($chargerCombo) {
        createCombo();
    }
        $testaffichage = '
        <div class="colonne_classique">
            <div class="affichage_classique">
                <h2>Demandeur : </h2>
                <div class="aff">'.$aideInterne->individu->nom.' '.$aideInterne->individu->prenom.'</div>
            </div>
            <div class="affichage_classique">
                <h2>Instructeur : </h2>
                <div class="aff">
                    <div class="select classique" role="select_instruct2" disabled>
                        <div id="instruct" class="option requis" value="'.$aideInterne->instruct->id.'">'.$aideInterne->instruct->nom.'</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
            </div>
            <div class="affichage_classique">
                <h2>Date demande : </h2>
                <div class="aff"><input class="contour_field input_date requis" type="text" id="dateDemande" size="10" '.getDatebyTimestampInput($aideInterne->dateDemande).' disabled></div>
            </div>
        </div>
        <div class="colonne_classique">
            <div class="affichage_classique">
                <h2>Aide demandée : </h2>
                <div class="aff">
                    <div class="select classique" role="select_typeaide_interne" disabled>
                        <div id="typeaideinterne" class="option requis" value="'.$aideInterne->typeAideDemandee->id.'">'.$aideInterne->typeAideDemandee->libelle.'</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
            </div>
            <div class="affichage_classique">
                <h2>Organisme : </h2>
                <div class="aff">
                    <div class="select classique requis" role="select_orga" disabled>
                        <div id="orga" class="option requis" value="'.$aideInterne->organisme->id.'">'.$aideInterne->organisme->appelation.'</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
            </div>
            <div class="affichage_classique">
                <h2>Nature : </h2>
                <div class="aff">
                    <div class="select classique requis" role="select_nature_interne" disabled>
                        <div id="nature" class="option requis" value="'.$aideInterne->natureAide->id.'">'.$aideInterne->natureAide->libelle.'</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="colonne_classique">
            <div class="affichage_classique">
                <h2>Etat : </h2>
                <div class="aff">
                    <div class="select classique requis" role="select_etat" disabled>
                        <div id="etat" class="option requis" value="'.$aideInterne->etat.'">'.$aideInterne->etat.'</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
            </div>
            <div class="affichage_classique">
                <h2>Aide urgente : </h2>
                <div class="aff">';
                if($aideInterne->aideUrgente == 1) {
                    $testaffichage .= '<span id="aideUrgente" class="checkbox checkbox_active" value="1" disabled></span>';
                } else {
                    $testaffichage .= '<span id="aideUrgente" class="checkbox" value="0" disabled></span>';
                }
                $testaffichage .='</div>
            </div>
        </div>';
    
    $contenu = "<div id='headerAideInterne'><h3><span>Fiche d'aide interne :</span><span class='edit'></span></h3>";
    $contenu .= '
        <ul class="list_classique">
            <li class="ligne_list_classique">'.$testaffichage.'</li>
            <li class="ligne_list_classique">
                <div class="affichage_classique">
                    <h2>Proposition : </h2>
                    <div class="aff">
                        <textarea class="contour_field input_char" type="text" id="proposition" disabled>'. $aideInterne->proposition .'</textarea>
                    </div>
                </div>
            </li>
        </ul>
                <div value="updateDetailAideInterne" class="bouton modif update">
                    <i class="icon-save"></i>
                    <span>Enregistrer</span>
                </div>
                <div class="clearboth"></div></div>';
    return $contenu;
}

function decisionAideInterne($aideInterne) {
    $contenu = '';
    if($aideInterne->avis == null) {
            if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_APPORTER_DECISION)) {
                $contenu .= '
                    <div id="updateDecision" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Apporter une décision</span>
                    </div>';
            }
            $contenu .= '<div id="decision">';
        }
        // Decision de l'aide
        $contenu .= '<div id="decisionAideInterne"><h3 id="idAide" value="'.$aideInterne->id.'">Décision :</h3>
                     <ul id="decisionRequis" class="list_classique">
                         <li class="ligne_list_classique">
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Aide accordée : </h2>
                                    <div class="aff">
                                        <div class="select classique" role="select_typeaide_interne">';
            $contenu .= $aideInterne->idAideAccordee == null ? '<div id="aideaccorde" class="option requis">Type d\'aide</div>' : '<div id="aideaccorde" class="option requis" value="'. $aideInterne->idAideAccordee .'">'.$aideInterne->typeAideAccordee->libelle.'</div>';  
            $contenu .= '
                                            <div class="fleche_bas"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="affichage_classique">
                                    <h2>Montant : </h2>
                                    <div class="aff"><input class="contour_field input_num" type="text" id="montantaide" value="'. $aideInterne->montant .'" ></div>
                                </div>
                                <div class="affichage_classique">
                                    <h2>Avis : </h2>
                                    <div class="aff">
                                        <div class="select classique" role="select_avis">';
            $contenu .= $aideInterne->avis == null ? '<div id="avis" class="option requis">-------</div>' : '<div id="avis" class="option requis" value="'. $aideInterne->avis.'">'.$aideInterne->avis.'</div>';  
            $contenu .= '                  
                                            <div class="fleche_bas"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Date décision : </h2>
                                    <div class="aff"><input class="contour_field input_date requis" type="text" id="dateDecision" size="10" '.getDatebyTimestampInput($aideInterne->dateDecision).'></div>
                                </div>
                                <div class="affichage_classique">
                                    <h2>Quantité : </h2>
                                    <div class="aff"><input class="contour_field input_num" type="text" id="quantiteaide" value="'. $aideInterne->quantite .'"></div>
                                </div>
                                <div class="affichage_classique">
                                    <h2>Vigilance : </h2>
                                    <div class="aff">';
                                    if($aideInterne->vigilance == 1) {
                                        $contenu .= '<span id="vigilance" class="checkbox checkbox_active" value="1"></span>';
                                    } else {
                                        $contenu .= '<span id="vigilance" class="checkbox" value="0"></span>';
                                    }
                                $contenu .= '
                                    </div>
                                </div>
                            </div>
                            
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Décideur : </h2>
                                    <div class="aff">
                                        <div class="select classique" role="select_decideur">';
        $contenu .= $aideInterne->idDecideur == null ? '<div id="decideur" class="option requis">Decideur</div>' : '<div id="decideur" class="option requis" value="'. $aideInterne->idDecideur .'">'.$aideInterne->decideur->decideur.'</div>';  
        $contenu .= '
                                            <div class="fleche_bas"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="affichage_classique">
                                    <h2>Montant total : </h2>
                                    <div class="aff"><input class="contour_field input_num" type="text" id="montanttotalaide" value="'. $aideInterne->montanttotal .'" disabled></div>
                                </div>
                            <div>
                         </li>
                         <li class="ligne_list_classique">
                            <div class="affichage_classique">
                                <h2>Commentaire : </h2>
                                <div class="aff"><textarea class="contour_field input_char" id="commentaire">'.$aideInterne->commentaire.'</textarea></div>
                            </div>
                        </li>
                     </ul>';
    if ($aideInterne->dateDecision != 0 && $aideInterne->dateDecision != '' && $aideInterne->dateDecision != ' ') {
    $contenu .= '
        <h3>Bon alimentaire / Mandat ';
    
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_CREATION_BON_INTERNE)) {
            $contenu .= '<span class="addElem" role="addBonInterne"></span>';
        }
        $contenu .= '</h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Type de bon</th>
                            <th>Aide</th>
                            <th>Date remise prévue</th>
                            <th>Date remise effective</th>
                            <th>Remis par</th>
                            <th>Montant</th>
                            <th>Commentaire</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    $bonAides = $aideInterne->bonAide;

    if (sizeof($bonAides) != null) {
        foreach($bonAides as $bonAide) {
            switch($bonAide->typeBon) {
                case BonAide::$BonAide:
                    $type = BonAide::$BonAideLibelle;
                    break;
                case BonAide::$MandatSecoursUrgence:
                    $type = BonAide::$MandatSecoursUrgenceLibelle;
                    break;
                case BonAide::$AutreMandat:
                    $type = BonAide::$AutreMandatLibelle;
                    break;
                case BonAide::$MandatRSA:
                    $type = BonAide::$MandatRSALibelle;
                    break;
                case BonAide::$BonAideUrgence:
                    $type = bonAide::$BonAideUrgenceLibelle;
                    break;
            }
            $chemin = './document/'.$bonAide->aideInterne->individu->idFoyer.'/'.$bonAide->aideInterne->individu->id.'/'.$bonAide->aideInterne->id;
            $i % 2 ? $contenu .= '<tr name="'.$bonAide->id.'">' : $contenu .= '<tr class="alt" name="'.$bonAide->id.'">';
            $contenu .= '<td>'.$type.'</td>
                                    <td>'.$bonAide->aideInterne->typeAideDemandee->libelle.'</td>
                                    <td> '.getDatebyTimestamp($bonAide->dateRemisePrevue).'</td>
                                    <td> '.getDatebyTimestamp($bonAide->dateRemiseEffective).'</td>
                                    <td> '.$bonAide->instruct->nom.'</td>                                
                                    <td> '.$bonAide->montant.'€</td>
                                    <td>'.$bonAide->commentaire.'</td>
                                    <td>'.pdfExist($chemin, $bonAide).'</td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=8 align=center>< Aucun bon n\'a encore été délivré pour cette aide > </td>
                     </tr>';
    }
    $contenu .= '</tbody></table></div>';
    }
     $contenu .= '<h3>Rapport :</h3>
                     <ul class="list_classique">
                         <li class="ligne_list_classique">
                            <span><textarea rows="8" class="contour_field input_char" style="width:99%; max-width:99%" type="text" id="rapport" >'.$aideInterne->rapport.'</textarea></span>
                         </li>
                     </ul>';
    $contenu .= '
        <div class="sauvegarder_annuler">
            <div value="updateDecisionInterne" class="bouton modif">
                <i class="icon-save"></i>
                <span>Enregistrer</span>
            </div>
            <div value="cancelDecisionInterne" class="bouton classique">
                <i class="icon-cancel icon-black"></i>
                <span>Annuler</span>
            </div>
        </div>';
    if($aideInterne->avis == null) {
        $contenu .= '</div>';
    }
    
     $contenu .= '</div>';
    // FORMULAIRE
    $contenu .= '<div class="formulaire" action="addBonInterne" idAide="'.$aideInterne->id.'">
        <h2>Bon interne</h2>
           <div class="colonne_droite">
            <input type="hidden" id="idinstruct" value="'.$aideInterne->idInstruct.'">
             <div class="select classique" role="select_typebon">
                <div id="typebon" class="option requis">Type de bon</div>
                <div class="fleche_bas"> </div>
            </div>
             <div class="input_text">
                <input id="dateprevue" class="contour_field input_date" type="text" title="Date" placeholder="Date de remise prévue">
            </div>
            <div class="input_text">
                <input id="dateeffective" class="contour_field input_date" type="text" title="Date" placeholder="Date de remise éffective">
            </div>
            <div class="input_text">
                <input id="montant" class="contour_field input_num" type="text" title="Montant" placeholder="Montant">
            </div>
            <div class="input_text">
                <input id="commentaireBon" class="contour_field" type="text" title="Commentaire" placeholder="Commentaire">
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
   </div>';
    return $contenu;
}

function createCombo() {
    $typesaides = Doctrine_Core::getTable('type')->findByidlibelletype(1);
    $organismes = Doctrine_Core::getTable('organisme')->findByIdLibelleOrganisme(5);
    $natures = Doctrine_Core::getTable('type')->findByidlibelletype(5); //nature
    $allinstructs =  Doctrine_Core::getTable('instruct')->findByActif(1);
    
    //decision aideinterne
    $decideurs = Doctrine_Core::getTable('decideur')->findAll();
   
    $contenu = '<ul class="select_decideur">';
    foreach($decideurs as $decideur) {
    $contenu .= '<li>
                                <div value="'.$decideur->id.'">'.$decideur->decideur.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '
        <ul class="select_avis">
            <li>
                <div value="Accepté">Accepté</div>
            </li>
            <li>
                <div value="Refusé">Refusé</div>
            </li>
        </ul>';
    $contenu .= '
        <ul class="select_etat">
            <li>
                <div value="En cours">En cours</div>
            </li>
            <li>
                <div value="Terminé">Terminé</div>
            </li>
        </ul>';
    $contenu .= '<ul class="select_instruct2">';
    foreach($allinstructs as $allinstruct) {
        $contenu .= '<li>
                                <div value="'.$allinstruct->id.'">'.$allinstruct->nom.'</div>
                           </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_nature_interne">';
    foreach($natures as $nature) {
    $contenu .= '<li>
                                <div value="'.$nature->id.'">'.$nature->libelle.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_orga">';
    foreach($organismes as $organisme) {
    $contenu .= '<li>
                                <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_typeaide_interne">';
    foreach($typesaides as $type) {
    $contenu .= '<li>
                                <div value="'.$type->id.'">'.$type->libelle.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_typebon">
                                <li>
                                    <div value="'.BonAide::$BonAide.'">'.BonAide::$BonAideLibelle.'</div>
                                </li>
                                <li>
                                    <div value="'.BonAide::$BonAideUrgence.'">'.BonAide::$BonAideUrgenceLibelle.'</div>
                                </li>
                                <li>
                                    <div value="'.BonAide::$MandatSecoursUrgence.'">'.BonAide::$MandatSecoursUrgenceLibelle.'</div>
                                </li>
                                <li>
                                    <div value="'.BonAide::$AutreMandat.'">'.BonAide::$AutreMandatLibelle.'</div>
                                </li>
                                <li>
                                    <div value="'.BonAide::$MandatRSA.'">'.BonAide::$MandatRSALibelle.'</div>
                                </li>
                            </ul>';
    return $contenu;
}

function rapportSocial($idAide) {
    include_once('lib/config.php');
    $aide = Doctrine_Core::getTable('aideinterne')->find($idAide);
    $retour = '<h2 id="numAide" idAide="'.$idAide.'">Création du rapport social</h2>';
    $retour .= '<h3>Motif de la demande</h3>
                        <ul class="list_classique">
                            <li class="ligne_list_classique">
                                <span><textarea rows="8" class="contour_field input_char" style="width:99%; max-width:99%" type="text" id="motif" >'.$aide->motifDemande.'</textarea></span>
                            </li>
                       </ul>
                       <h3>Evaluation sociale</h3>
                       <ul class="list_classique">
                            <li class="ligne_list_classique">
                                <span><textarea rows="14" class="contour_field input_char" style="width:99%; max-width:99%" type="text" id="evaluation" >'.$aide->evaluationSociale.'</textarea></span>
                            </li>
                        </ul>
                        <div class="sauvegarder_annuler">
                            <div value="create_rapport" class="bouton modif">
                                <i class="icon-save"></i>
                                <span>Créer le rapport social</span>
                            </div>
                            <div value="cancelRapport" class="bouton classique">
                                    <i class="icon-cancel icon-black"></i>
                                    <span>Annuler</span>
                            </div>
                        </div>';
    echo $retour;
}

function createAideInterne($typeAide, $date, $instruct, $nature, $proposition, $etat, $idIndividu, $organisme, $urgence) {
    $aide = new AideInterne();
    setDateWithoutNull($date, $aide, 'dateDemande');
    setWithoutNull($nature, $aide, 'nature');
    setWithoutNull($typeAide, $aide, 'idAideDemandee');
    setWithoutNull($instruct, $aide, 'idInstruct');
    setWithoutNull($etat, $aide, 'etat');
    setWithoutNull($proposition, $aide, 'proposition');
    setWithoutNull($idIndividu, $aide, 'idIndividu');
    setWithoutNull($organisme, $aide, 'idOrganisme');
    setWithoutNull($urgence, $aide, 'aideUrgente');
    $aide->save();
//    createPDFRapportSocial($idIndividu);
}


function updateDecisionInterne() {
    include_once('./lib/config.php');
    $aide = Doctrine_Core::getTable('aideinterne')->find($_POST['idAide']);
    setWithoutNull($_POST['aide'], $aide, 'idAideAccordee');
    setDateWithoutNull($_POST['date'], $aide, 'dateDecision');
    setWithoutNull($_POST['avis'], $aide, 'avis');
    setWithoutNull($_POST['vigilance'], $aide, 'vigilance');
    setWithoutNull($_POST['commentaire'], $aide, 'commentaire');
    setWithoutNull($_POST['rapport'], $aide, 'rapport');
    setWithoutNull($_POST['decideur'], $aide, 'idDecideur');
    setWithoutNull($_POST['montant'], $aide, 'montant');
    setWithoutNull($_POST['montanttotal'], $aide, 'montanttotal');
    setWithoutNull($_POST['quantite'], $aide, 'quantite');
    $aide->etat = 'Terminé';
    $aide->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'aide interne', $_SESSION['userId'], $aide->idIndividu);
    
    $retours = aide();
    $retour = array('aide' => $retours);
    echo json_encode($retour);  
}

function updateDetailAideInterne() {
    include_once('./lib/config.php');
    $aide = Doctrine_Core::getTable('aideinterne')->find($_POST['idAide']);
    setWithoutNull($_POST['idIndividu'], $aide, 'idIndividu');
    setWithoutNull($_POST['typeaideinterne'], $aide, 'idAideDemandee');
    setWithoutNull($_POST['etat'], $aide, 'etat');
    setWithoutNull($_POST['instruct'], $aide, 'idInstruct');
    setWithoutNull($_POST['orga'], $aide, 'idOrganisme');
    setWithoutNull($_POST['aideUrgente'], $aide, 'aideUrgente');
    setDateWithoutNull($_POST['dateDemande'], $aide, 'dateDemande');
    setWithoutNull($_POST['nature'], $aide, 'nature');
    setWithoutNull($_POST['proposition'], $aide, 'proposition');
    $aide->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'aide interne', $_SESSION['userId'], $aide->idIndividu);
    
    $retours = headerAideInterne($aide, true);
    $retour = array('aide' => $retours);
    echo json_encode($retour);  
}


function addBonInterne($idAide, $idInstruct, $datePrevue, $dateEffective, $montant, $commentaire, $typeBon) {
    include_once('./lib/config.php');
    $bon = new BonAide();
    setWithoutNull($idAide, $bon, 'idAideInterne');
    setWithoutNull($idInstruct, $bon, 'idInstruct');
    setDateWithoutNull($datePrevue, $bon, 'dateRemisePrevue');
    setDateWithoutNull($dateEffective, $bon, 'dateRemiseEffective');
    setWithoutNull($montant, $bon, 'montant');
    setWithoutNull($commentaire, $bon, 'commentaire');
    setWithoutNull($typeBon, $bon, 'typeBon');
    $bon->save();
    
    include_once('./pages/historique.php');
    switch($bon->typeBon) {
        case BonAide::$BonAide:
            createHistorique(Historique::$Creation, BonAide::$BonAideLibelle, $_SESSION['userId'], $bon->aideInterne->individu->id);
            creationPDFBonInterne($bon);
            break;
        case BonAide::$BonAideUrgence:
            createHistorique(Historique::$Creation, BonAide::$BonAideUrgenceLibelle, $_SESSION['userId'], $bon->aideInterne->individu->id);
            creationPDFBonInterne($bon);
            break;
        case BonAide::$MandatSecoursUrgence:
            createHistorique(Historique::$Creation, BonAide::$MandatSecoursUrgenceLibelle, $_SESSION['userId'], $bon->aideInterne->individu->id);
            createPDFMandat($bon);
            break;
        case BonAide::$AutreMandat:
            createHistorique(Historique::$Creation, BonAide::$AutreMandatLibelle, $_SESSION['userId'], $bon->aideInterne->individu->id);
            createPDFMandat($bon);
            break;
        case BonAide::$MandatRSA:
            createHistorique(Historique::$Creation, BonAide::$MandatRSALibelle, $_SESSION['userId'], $bon->aideInterne->individu->id);
            createPDFMandat($bon);
            break;
    }
    
}

function creationPDFBonInterne($bon) {
    // On génére le bon
    include_once('./lib/int2str.php');
    switch($bon->typeBon) {
        case BonAide::$BonAide:
            $typeBon = BonAide::$BonAideLibelle;
            break;
        case BonAide::$BonAideUrgence:
            $typeBon = BonAide::$BonAideUrgenceLibelle;
            break;
    }
    $beneficaire = $bon->aideInterne->individu->civilite .' '. $bon->aideInterne->individu->nom .' '. $bon->aideInterne->individu->prenom;
    $rue = $bon->aideInterne->individu->foyer->rue->rue;
    $num = $bon->aideInterne->individu->foyer->numRue;
    $idIndividu = $bon->aideInterne->individu->id;
    $lettres = int2str($bon->montant);
    $chemin = './document/'.$bon->aideInterne->individu->idFoyer;
    $idAide = $bon->aideInterne->id;
    $numBon = $bon->id;
    if(!is_dir($chemin)) {
        mkdir($chemin);
    }
    if(!is_dir($chemin.'/'.$bon->aideInterne->individu->id)) {
        mkdir($chemin.'/'.$bon->aideInterne->individu->id);
    }
    if(!is_dir($chemin.'/'.$bon->aideInterne->individu->id.'/'.$idAide)) {
        mkdir($chemin.'/'.$bon->aideInterne->individu->id.'/'.$idAide);
    }
    $chemin = $chemin.'/'.$bon->aideInterne->individu->id.'/'.$idAide;
    $dateBon = $bon->dateRemisePrevue;
    include_once('./lib/PDF/generateBon.php');
}




function rapportExist($chemin, $idAide) { // $chemin == ./IdFoyer/IdIndividu
    if(is_dir($chemin) && file_exists($chemin.'/RapportSocial_'.$idAide.'.pdf')) {
        return '<a name="'.$chemin.'/RapportSocial_'.$idAide.'.pdf" href="'.$chemin.'/RapportSocial_'.$idAide.'.pdf" target="_blank" class="open_doc" original-title="Ouvrir le rapport social"></a><span class="reload_rapport" original-title="Regénérer le rapport"></span>';
    } else {
        return '<a name="'.$chemin.'/RapportSocial_'.$idAide.'.pdf" idAide="'.$idAide.'" class="create_rapport_social creer" original-title="Créer le rapport social"></a>';
    }
}

function pdfExist($chemin, $bon) {
    if($bon->docRemis == 0) {
        switch($bon->typeBon) {
            case BonAide::$BonAide:
            case bonAide::$BonAideUrgence:
                if(is_dir($chemin) && file_exists($chemin.'/bonAlimentaire_'.$bon->id.'.pdf')) {
                    return '<a name="'.$chemin.'/bonAlimentaire_'.$bon->id.'.pdf" href="'.$chemin.'/bonAlimentaire_'.$bon->id.'.pdf" target="_blank" class="open_doc" original-title="Ouvrir le document"></a> - '.  docRemisBouton($bon);
                } else {
                    return '<a name="'.$chemin.'/bonAlimentaire_'.$bon->id.'.pdf" idBon="'.$bon->id.'" typeBon="'.$bon->typeBon.'" class="create_bon_interne creer" original-title="Générer le document"></a>';
                }
                break;
           case BonAide::$AutreMandat:
           case BonAide::$MandatRSA:
           case BonAide::$MandatSecoursUrgence:
                if(is_dir($chemin) && file_exists($chemin.'/Mandat_'.$bon->id.'.pdf')) {
                    return '<a name="'.$chemin.'/Mandat_'.$bon->id.'.pdf" href="'.$chemin.'/Mandat_'.$bon->id.'.pdf" target="_blank" class="open_doc" original-title="Ouvrir le document"></a> - '.  docRemisBouton($bon);
                } else {
                    return '<a name="'.$chemin.'/Mandat_'.$bon->id.'.pdf" idBon="'.$bon->id.'" typeBon="'.$bon->typeBon.'" class="create_bon_interne creer" original-title="Générer le document"></a>';
                }
                break;
        }
    } else {
         if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_ACCES_DOC_REMIS)) {
            switch($bon->typeBon) {
                case BonAide::$BonAide:
                case bonAide::$BonAideUrgence:
                    if(is_dir($chemin) && file_exists($chemin.'/bonAlimentaire_'.$bon->id.'.pdf')) {
                        return '<a name="'.$chemin.'/bonAlimentaire_'.$bon->id.'.pdf" href="'.$chemin.'/bonAlimentaire_'.$bon->id.'.pdf" target="_blank" class="open_doc" original-title="Ouvrir le document"></a>';
                    }
                    break;
                case BonAide::$AutreMandat:
                case BonAide::$MandatRSA:
                case BonAide::$MandatSecoursUrgence:
                    if(is_dir($chemin) && file_exists($chemin.'/Mandat_'.$bon->id.'.pdf')) {
                        return '<a name="'.$chemin.'/Mandat_'.$bon->id.'.pdf" href="'.$chemin.'/Mandat_'.$bon->id.'.pdf" target="_blank" class="open_doc" original-title="Ouvrir le document"></a>';
                    } 
                    break;
                    
            }
         }
    }
    
}

function createPDF($idBon) {
    include_once('./lib/config.php');
    $bon = Doctrine_Core::getTable('bonaide')->find($idBon);
    switch($bon->typeBon) {
        case BonAide::$BonAide:
        case BonAide::$BonAideUrgence:
            creationPDFBonInterne($bon);
            break;
       case BonAide::$AutreMandat:
       case BonAide::$MandatRSA:
       case BonAide::$MandatSecoursUrgence:
            createPDFMandat($bon);
            break;
    }
    
}

function createPDFRapportSocial($idIndividu, $motif, $evaluation, $idAide) {
    include_once('./lib/config.php');
    $motif = str_replace('à', '&agrave;', $motif);
    $evaluation = str_replace('à', '&agrave;', $evaluation);
    
    $aide = Doctrine_Core::getTable('aideinterne')->find($idAide);
    $aide->motifDemande = $motif;
    $aide->evaluationSociale = $evaluation;
    $aide->save();
    
    $individu = Doctrine_Core::getTable('individu')->find($idIndividu);
    $ressource = Doctrine_Core::getTable('ressource')->getLastFicheRessource($idIndividu);
//    $dette = Doctrine_Core::getTable('dette')->getLastFicheDette($idIndividu);
//    $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($idIndividu);
//    $credit = Doctrine_Core::getTable('credit')->findByIdindividu($idIndividu);
    $famille = $individu->foyer->individu;
    $salaireIndividu = $ressource->salaire;
    $salaireAutre = 0;
    $creditMensuel = 0;
    $totalCredit = 0;
    $nbEnfant = 0; 
    $salaireConjoint = 0;
    $totalDette = 0;
    
    $ijssFamille = 0;
    $rsaSocleFamille = 0;
    $rsaActiviteFamille = 0;
    $aahFamille = 0;
    $assFamille = 0;
    $chomageFamille = 0;
    $retraiteFamille = 0;
    $complementaireFamille = 0;
    $invaliditeFamille = 0;
    $pensionAlimFamille = 0;
    $autresRessourceFamille = 0;
    $prestationFamille = 0;
    $alFamille = 0;
    $loyerFamille = 0;
    $gazFamille = 0;
    $elecFamille = 0;
    $eauFamille = 0;
    $telFamille = 0;
    $chauffageFamille = 0;
    $televisionFamille = 0;
    $internetFamille = 0;
    $assuranceVoitureFamille = 0;
    $assuranceHabitationFamille = 0;
    $mutuelleFamille = 0;
    $impotRevenuFamille = 0;
    $impotLocauxFamille = 0;
    $pensionAlimChargeFamille = 0;
    $autresChargeFamille = 0;
    
    $totalChargesMensuelle = 0;
    $totalCharges = 0;
    $totalRessource = 0;
    $totalPrestation = 0;
    $totalGeneral = 0;
    $resteAVivre = 0;
    
    foreach($famille as $f) {
        $dette = Doctrine_Core::getTable('dette')->getLastFicheDette($f->id);
        if ($dette != null) {
            $totalDette += array_sum(array($dette->arriereLocatif, $dette->fraisHuissier, $dette->arriereElectricite, $dette->arriereGaz, $dette->autreDette));
        }
        
        $credit = Doctrine_Core::getTable('credit')->findByIdindividu($f->id);
        if ($credit != null) {
            foreach($credit as $c) {
                $creditMensuel += $c->mensualite;
                $totalCredit += $c->totalRestant;
            }
        }
         
        $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($f->id);
        if ($depense != null) {
            $loyerFamille += $depense->loyer;
            $gazFamille += $depense->gaz;
            $elecFamille += $depense->electricite;
            $eauFamille += $depense->eau;
            $telFamille += $depense->telephonie;
            $chauffageFamille += $depense->chauffage;
            $televisionFamille += $depense->television;
            $internetFamille += $depense->internet;
            $assuranceVoitureFamille += $depense->assuranceVoiture;
            $assuranceHabitationFamille += $depense->assuranceHabitation;
            $mutuelleFamille += $depense->mutuelle;
            $impotRevenuFamille += $depense->impotRevenu;
            $impotLocauxFamille += $depense->impotLocaux;
            $pensionAlimChargeFamille += $depense->pensionAlim;
            $autresChargeFamille += $depense->autreDepense;
        }
         
        $ressource = Doctrine_Core::getTable('ressource')->getLastFicheRessource($f->id);
        if ($ressource != null) {
            $ijssFamille += $ressource->ijss;
            $rsaSocleFamille += $ressource->rsaSocle;
            $rsaActiviteFamille += $ressource->rsaActivite;
            $aahFamille += $ressource->aah;
            $assFamille += $ressource->ass;
            $chomageFamille += $ressource->chomage;
            $retraiteFamille += $ressource->pensionRetraite;
            $complementaireFamille += $ressource->retraitComp;
            $invaliditeFamille += $ressource->pensionInvalide;
            $pensionAlimFamille += $ressource->pensionAlim;
            $autresRessourceFamille += $ressource->autreRevenu;
            $prestationFamille += $ressource->revenuAlloc;
            $alFamille += $ressource->aideLogement;
        }
        
        if ($individu->id != $f->id) {
            if($f->idLienFamille == LienFamille::$Epouse || $f->idLienFamille == LienFamille::$Compagne 
                    || $f->idLienFamille == LienFamille::$Epoux || $f->idLienFamille == LienFamille::$Compagnon 
                    || $f->idLienFamille == LienFamille::$ChefLuiMeme) {
                $conjoint =  Doctrine_Core::getTable('ressource')->getLastFicheRessource($f->id);
               
                if(isset($conjoint->salaire) && $conjoint->salaire > 0) {
                    $salaireConjoint += $conjoint->salaire;
                }
            } else {
                if ($f->idLienFamille == 1) {
                    $nbEnfant += 1;
                }
                $ressourceAutre = Doctrine_Core::getTable('ressource')->getLastFicheRessource($f->id);
                if($ressourceAutre != null) {
                    $salaireAutre += $ressourceAutre->salaire;
                }
            }
        }
   }
    
    $totalCharges = array_sum(array($loyerFamille, $gazFamille, $elecFamille, $eauFamille, $telFamille, $chauffageFamille, $televisionFamille, $internetFamille, 
        $assuranceVoitureFamille, $assuranceHabitationFamille, $mutuelleFamille, $impotLocauxFamille, $impotRevenuFamille, $pensionAlimChargeFamille, $autresChargeFamille));
    
    $totalRessource = array_sum(array($salaireIndividu, $salaireConjoint, $salaireAutre, $ijssFamille, $rsaActiviteFamille, 
        $rsaSocleFamille, $aahFamille, $assFamille, $chomageFamille, $retraiteFamille, $complementaireFamille, $invaliditeFamille, 
        $pensionAlimFamille, $autresRessourceFamille));
    
    $totalPrestation = array_sum(array($prestationFamille, $alFamille));
    

    $idFoyer = $individu->idFoyer;
    $chemin = './document/'.$idFoyer;
    if(!is_dir($chemin)) {
        mkdir($chemin);
    }
    if(!is_dir($chemin.'/'.$individu->id)) {
        mkdir($chemin.'/'.$individu->id);
    }
    $nomComplet = $individu->civilite .' '. $individu->nom.' '. $individu->prenom;
    include_once('./lib/PDF/generateRapport.php');   
    // On réaffiche la page aide
    $retour = aide();
    echo $retour;
}

function createPDFMandat($bon) {
    include_once('./lib/int2str.php');
    $nom = $bon->aideInterne->individu->nom ;
    $prenom = $bon->aideInterne->individu->prenom;
    $rue = $bon->aideInterne->individu->foyer->rue->rue;
    $num = $bon->aideInterne->individu->foyer->numRue;
    $ville = $bon->aideInterne->individu->ville->libelle;
    $idIndividu = $bon->aideInterne->individu->id;
    $lettres = int2str($bon->montant);
    $chemin = './document/'.$bon->aideInterne->individu->idFoyer;
    $idAide = $bon->aideInterne->id;
    $numBon = $bon->id;
    switch($bon->typeBon) {
        case BonAide::$MandatSecoursUrgence:
            $objet = BonAide::$MandatSecoursUrgenceLibelle;
            $article = '6561';
            $fonction = '5234';
            break;
        case BonAide::$AutreMandat:
            $objet = BonAide::$AutreMandatLibelle;
            $article = '6568';
            $fonction = '5234';
            break;
        case BonAide::$MandatRSA:
            $objet = BonAide::$MandatRSALibelle;
            $article = '6562';
            $fonction = '5234';         
    }
    if(!is_dir($chemin)) {
        mkdir($chemin);
    }
    if(!is_dir($chemin.'/'.$bon->aideInterne->individu->id)) {
        mkdir($chemin.'/'.$bon->aideInterne->individu->id);
    }
    if(!is_dir($chemin.'/'.$bon->aideInterne->individu->id.'/'.$idAide)) {
        mkdir($chemin.'/'.$bon->aideInterne->individu->id.'/'.$idAide);
    }
    $chemin = $chemin.'/'.$bon->aideInterne->individu->id.'/'.$idAide;
    $dateBon = $bon->dateRemisePrevue;
    include_once('./lib/PDF/generateMandat.php');
}

function cancelRapport() {
    include_once('./pages/aideInterne.php');
    $aide = aide();
    echo $aide;
}

function docRemisBouton($bon) {
    return '<a id="bonRemis" idBon="'.$bon->id.'" idAide="'.$bon->idAideInterne.'" class="doc_remis" original-title="Ce document a été remis"></a>';
}

function docRemis() {
    $idBon = $_POST['idBon'];
    $bon =  Doctrine_Core::getTable('bonaide')->find($idBon);
    $bon->docRemis = 1;
    $bon->save();
    
    $pageaide = detailAideInterne();
    echo $pageaide;
    
}

function deleteAide() {
    $idAide = $_POST['idAide'];
    $interne = $_POST['interne'];
    if ($interne == 'true') {
        $aide = Doctrine_Core::getTable('aideinterne')->find($idAide);
    } else {
        $aide = Doctrine_Core::getTable('aideexterne')->find($idAide);
    }
    $aide->delete();
    $aide = aide();
    echo $aide;  
}
?>
