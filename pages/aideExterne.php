<?php

function aideExterne() {
    $aidesExternes = Doctrine_Core::getTable('aideexterne')->findByIdIndividu($_POST['idIndividu']);
    $organismesExternes = Doctrine_Core::getTable('organisme')->findByIdLibelleOrganisme(6);
    $naturesExternes = Doctrine_Core::getTable('type')->findByidlibelletype(6);
    $typesAidesExternes = Doctrine_Core::getTable('type')->findByidlibelletype(7);
    $instructs =  Doctrine_Core::getTable('instruct')->findByActif(1);
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $distributeurs = Doctrine_Core::getTable('organisme')->findByIdLibelleOrganisme(3);
    $contenu = '';
    $contenu .= '
        <h3>Aides Externes :</h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Date demande</th>
                            <th>Aide demandée</th>
                            <th>Etat</th>
                            <th>Nature</th>
                            <th>Organisme</th>
                            <th>Avis</th>
                            <th>Montant</th>
                            <th>Date décision</th>
                            <th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    if (sizeof($aidesExternes) != null) {
        foreach($aidesExternes as $aideExterne) {
            $i % 2 ? $contenu .= '<tr name="'.$aideExterne->id.'">' : $contenu .= '<tr class="alt" name="'.$aideExterne->id.'">';
            $contenu .= '<td>'.getDatebyTimestamp($aideExterne->dateDemande).'</td>
                                    <td> '.$aideExterne->typeAideDemandee->libelle.'</td>
                                    <td> '.$aideExterne->etat.'</td>
                                    <td> '.$aideExterne->natureAide->libelle.'</td>
                                    <td> '.$aideExterne->organisme->appelation.'</td>                                    
                                    <td> '.$aideExterne->avis.'</td>
                                    <td> '.$aideExterne->montantPercu.' €</td>
                                    <td> '.getDatebyTimestamp($aideExterne->dateDecision).'</td>
                                    <td><span class="edit_aide_externe" original-title="Afficher toutes les informations"></span></td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=9 align=center>< Aucune aide externe n\'a été attribuée à cet individu > </td>
                     </tr>';
    }

    $contenu .= '</tbody></table>';

    $contenu .= '<div class="formulaire" action="creation_aide_externe">
                   <h2>Aide Externe</h2>
                   <div class="colonne_droite">
                        <div class="select classique" role="select_typeaide_externe">
                            <div id="typeaideexterne" class="option requis">Type d\'aide</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_instruct">
                            <div id="instructexterne" class="option requis">Instructeur</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_orga_ext">
                            <div id="orgaext" class="option requis">Organisme</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="input_text">
                            <input id="dateaideexterne" class="contour_field input_date requis" type="text" title="Date" placeholder="Date - jj/mm/aaaa">
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_nature_externe">
                            <div id="natureaideexterne" class="option requis">Nature</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_distrib">
                            <div id="distrib" class="option requis">Distributeur</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_etat">
                            <div id="etatexterne" class="option requis">Etat</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="input_text">
                            <span class="checkbox" id="urgenceexterne"></span> 
                            <span class="attribut">Aide urgente</span>
                        </div>
                        <div class="input_text">
                            <input id="montantdemande" class="contour_field" type="text" title="Montant demandé" placeholder="Montant demandé">
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
    
    $contenu .= '<ul class="select_orga_ext">';
    foreach($organismesExternes as $organismeExterne) {
        $contenu .= '<li>
                        <div value="'.$organismeExterne->id.'">'.$organismeExterne->appelation.'</div>
                    </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '
        <ul class="select_etat">
            <li>
                <div value="En cours">En cours</div>
            </li>
            <li>
                <div value="Terminé">Terminé</div>
            </li>
        </ul>';
    
    $contenu .= '<ul class="select_typeaide_externe">';
    foreach($typesAidesExternes as $typeexterne) {
        $contenu .= '<li>
                        <div value="'.$typeexterne->id.'">'.$typeexterne->libelle.'</div>
                    </li>';
    }
    $contenu .= '</ul>';
    
    $contenu .= '<ul class="select_instruct">';
    foreach($instructs as $instruct) {
        $contenu .= '<li>
                                <div value="'.$instruct->id.'">'.$instruct->nom.'</div>
                           </li>';
    }
    $contenu .= '</ul>';
    
    $contenu .= '<ul class="select_nature_externe">';
    foreach($naturesExternes as $natureExterne) {
        $contenu .= '<li>
                         <div value="'.$natureExterne->id.'">'.$natureExterne->libelle.'</div>
                     </li>';
    }
    $contenu .= '</ul>';
    
    $contenu .= '<ul class="select_distrib">';
    foreach($distributeurs as $distrib) {
        $contenu .= '<li>
                         <div value="'.$distrib->id.'">'.$distrib->appelation.'</div>
                     </li>';
    }
    $contenu .= '</ul>';
    
    return $contenu;
}


function detailAideExterne() {
    $aideExterne = Doctrine_Core::getTable('aideexterne')->findOneById($_POST['idAide']);
    
    $contenu = "<h3><span>Fiche d'aide externe :</span><span class='edit'></span></h3>";
    $contenu .= '<ul class="list_classique">
                    <li class="ligne_list_classique">
                        <div class="colonne_classique">
                            <div class="affichage_classique">
                                <h2>Demandeur : </h2>
                                <div class="aff">'.$aideExterne->individu->nom.' '.$aideExterne->individu->prenom.'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Instructeur : </h2>
                                <div class="aff">
                                    <div class="select classique" role="select_instruct" disabled>
                                        <div id="instructexterne" class="option">'.$aideExterne->instruct->nom.'</div>
                                        <div class="fleche_bas"> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Date demande : </h2>
                                <div class="aff">'.getDatebyTimestamp($aideExterne->dateDemande).'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Montant demandé : </h2>
                                <div class="aff">'.$aideExterne->montantDemande.'</div>
                            </div>
                        </div>
                        <div class="colonne_classique">
                            <div class="affichage_classique">
                                <h2>Aide demandée : </h2>
                                <div class="aff">'.$aideExterne->typeAideDemandee->libelle.'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Organisme : </h2>
                                <div class="aff">'.$aideExterne->organisme->appelation.'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Nature : </h2>
                                <div class="aff">'.$aideExterne->natureAide->libelle.'</div>
                            </div>
                        </div>
                        <div class="colonne_classique">
                            <div class="affichage_classique">
                                <h2>Etat : </h2>
                                <div class="aff">'.$aideExterne->etat.'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Aide urgente : </h2>
                                <div class="aff">';
                                if($aideExterne->aideUrgente == 1) {
                                    $contenu .= '<span id="aideUrgente" class="checkbox checkbox_active" value="1" disabled></span>';
                                } else {
                                    $contenu .= '<span id="aideUrgente" class="checkbox" value="0" disabled></span>';
                                }
                                $contenu .='</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Distributeur : </h2>
                                <div class="aff">'.$aideExterne->distrib->appelation.'</div>
                            </div>
                        </div>
                    </li></ul>
                    <div value="updateDetailAideInterne" class="bouton modif update">
                        <i class="icon-save"></i>
                        <span>Enregistrer</span>
                    </div>
                    <div class="clearboth"></div></div>';
        if($aideExterne->avis == null) {
            if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_APPORTER_DECISION)) {
                $contenu .= '
                    <div id="updateDecision" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Apporter une décision</span>
                    </div>';
            }
            $contenu .= '<div id="decision">';
        }
        $contenu .= '<h3 id="idAide" value="'.$aideExterne->id.'">Décision :</h3>
                     <ul id="decisionRequis" class="list_classique">
                        <li class="ligne_list_classique">
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Montant per&ccedil;u : </h2>
                                    <div class="aff"><input class="contour_field input_num requis" type="text" id="montantPercu"  value="'.$aideExterne->montantPercu.'"></div>
                                </div>

                                <div class="affichage_classique">
                                    <h2>Commentaire : </h2>
                                    <div class="aff"><textarea class="contour_field input_char" type="text" id="commentaire">'.$aideExterne->commentaire.'</textarea></div>
                                </div>
                            </div>
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Date décision : </h2>
                                    <div class="aff"><input class="contour_field input_date requis" type="text" id="dateDecision" size="10" '.getDatebyTimestampInput($aideExterne->dateDecision).'></div>
                                 </div>
                            </div>
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Avis : </h2>
                                    <div class="aff">
                                        <div class="select classique" role="select_avis">';
            $contenu .= $aideExterne->avis == null ? '<div id="avis" class="option requis">-------</div>' : '<div id="avis" class="option requis" value="'. $aideExterne->avis.'">'.$aideExterne->avis.'</div>';  
            $contenu .= '                  
                                            <div class="fleche_bas"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li></ul>
        <div class="sauvegarder_annuler">
            <div value="updateDecisionExterne" class="bouton modif">
                <i class="icon-save"></i>
                <span>Enregistrer</span>
            </div>
            <div value="cancelDecisionExterne" class="bouton classique">
                <i class="icon-cancel icon-black"></i>
                <span>Annuler</span>
            </div>
        </div>';
    if($aideExterne->avis == null) {
        $contenu .= '</div>';
    }
    $contenu .= '
        <ul class="select_avis">
            <li>
                <div value="Accepté">Accepté</div>
            </li>
            <li>
                <div value="Refusé">Refusé</div>
            </li>
        </ul>';
    return $contenu;
}


function createAideExterne($typeAide, $date, $instruct, $nature, $idDistrib, $etat, $idIndividu, $organisme, $urgence, $montantDemande) {
    $aide = new AideExterne();
    setDateWithoutNull($date, $aide, 'dateDemande');
    setWithoutNull($nature, $aide, 'nature');
    setWithoutNull($typeAide, $aide, 'idAideDemandee');
    setWithoutNull($instruct, $aide, 'idInstruct');
    setWithoutNull($etat, $aide, 'etat');
    setWithoutNull($idDistrib, $aide, 'idDistrib');
    setWithoutNull($idIndividu, $aide, 'idIndividu');
    setWithoutNull($organisme, $aide, 'idOrganisme');
    setWithoutNull($urgence, $aide, 'aideUrgente');
    setWithoutNull($montantDemande, $aide, 'montantDemande');
    $aide->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'aide externe', $_SESSION['userId'], $idIndividu);
}


function updateDecisionExterne() {
    include_once('./lib/config.php');
    $aide = Doctrine_Core::getTable('aideexterne')->find($_POST['idAide']);
    setWithoutNull($_POST['montantPercu'], $aide, 'montantPercu');
    setDateWithoutNull($_POST['dateDecision'], $aide, 'dateDecision');
    setWithoutNull($_POST['avis'], $aide, 'avis');
    setWithoutNull($_POST['commentaire'], $aide, 'commentaire');
    $aide->etat = 'Terminé';
    $aide->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'aide externe', $_SESSION['userId'], $aide->idIndividu);
    
    $retours = aide();
    $retour = array('aide' => $retours);
    echo json_encode($retour);  
}
?>
