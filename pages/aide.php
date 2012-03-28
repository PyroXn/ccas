<?php
function aide() {
    $contenu = aideInterne();
    $contenu .= aideExterne();
    
    return $contenu;
}

function aideInterne() {
    $organismes = Doctrine_Core::getTable('organisme')->findByIdLibelleOrganisme(5);
    $natures = Doctrine_Core::getTable('type')->findByCategorie(5);
    $typesaides = Doctrine_Core::getTable('type')->findByCategorie(1);
    $instructs =  Doctrine_Core::getTable('instruct')->findAll();
    $aidesInternes = Doctrine_Core::getTable('aideinterne')->findByIdIndividu($_POST['idIndividu']);
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $contenu = '
        <div class="bouton ajout" id="createAideInterne">Ajouter une aide interne</div> -&nbsp;&nbsp;&nbsp;&nbsp;<div class="bouton ajout" id="createAideExterne">Ajouter une aide externe</div>
        <h3>Aides Internes :</h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Date demande</th>
                            <th>Aide demand&eacute;e</th>
                            <th>Etat</th>
                            <th>Nature</th>
                            <th>Avis</th>
                            <th>Montant</th>
                            <th>Date d&eacute;cision</th>
                            <th>D&eacute;tails</th>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    if (sizeof($aidesInternes) != null) {
        foreach($aidesInternes as $aideInterne) {
            $total = 0;
            $bons = Doctrine_Core::getTable('bonaide')->findByIdAideInterne($aideInterne->id);
            foreach($bons as $bon) {
                $total += $bon->montant;
            }
            $i % 2 ? $contenu .= '<tr name="'.$aideInterne->id.'">' : $contenu .= '<tr class="alt" name="'.$aideInterne->id.'">';
            $contenu .= '<td>'.getDatebyTimestamp($aideInterne->dateDemande).'</td>
                                    <td> '.$aideInterne->typeAideDemandee->libelle.'</td>
                                    <td> '.$aideInterne->etat.'</td>
                                    <td> '.$aideInterne->natureAide->libelle.'</td>
                                    <td> '.$aideInterne->avis.'</td>
                                    <td> '.$total.'&euro;</td>
                                    <td> '.getDatebyTimestamp($aideInterne->dateDecision).'</td>
                                    <td><span class="edit_aide_interne"></span></td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=9 align=center>< Aucune aide interne n\'a &eacute;t&eacute; attribu&eacute;e &agrave; cet individu > </td>
                     </tr>';
    }
    $contenu .= '</tbody></table></div>';
    $contenu .= '<div class="formulaire" action="creation_aide_interne">
        <h2>Aide interne</h2>
       <div class="colonne_droite">
             <div class="select classique" role="select_typeaide_interne">
                <div id="typeaideinterne" class="option">Type d\'aide</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="clearboth"></div>
            <div class="select classique" role="select_instruct">
                <div id="instruct" class="option">Instructeur</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="clearboth"></div>
            <div class="select classique" role="select_orga">
                <div id="orga" class="option">Organisme</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <input id="date" class="contour_field" type="text" title="Date" placeholder="Date - jj/mm/aaaa">
            </div>
            <div class="select classique" role="select_nature_interne">
                <div id="nature" class="option">Nature</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <input id="proposition" class="contour_field" type="text" title="Proposition" placeholder="Proposition">
            </div>
            <div class="select classique" role="select_etat">
                <div id="etat" class="option">Etat</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <span class="checkbox" id="urgence"></span> 
                <span class="attribut">Aide urgente</span>
            </div>
            
            <div class="sauvegarder_annuler">
                <div class="bouton modif" value="save">Enregistrer</div>
                <div class="bouton classique" value="cancel">Annuler</div>
            </div>

       </div>
</div>';
    // COMBO BOX
    $contenu .= '<ul class="select_orga">';
foreach($organismes as $organisme) {
    $contenu .= '<li>
                                <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '
        <ul class="select_etat">
            <li>
                <div value="En cours">En cours</div>
            </li>
            <li>
                <div value="Termin&eacute;">Termin&eacute;</div>
            </li>
        </ul>';
    $contenu .= '<ul class="select_typeaide_interne">';
foreach($typesaides as $type) {
    $contenu .= '<li>
                                <div value="'.$type->id.'">'.$type->libelle.'</div>
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
    $contenu .= '<ul class="select_nature_interne">';
foreach($natures as $nature) {
    $contenu .= '<li>
                                <div value="'.$nature->id.'">'.$nature->libelle.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    return $contenu;

}

function detailAideInterne() {
    $aideInterne = Doctrine_Core::getTable('aideinterne')->findOneById($_POST['idAide']);
    $typesaides = Doctrine_Core::getTable('type')->findByCategorie(1);
    $decideurs = Doctrine_Core::getTable('decideur')->findAll();
    
    $testaffichage = '
        <div class="colonne_classique">
            <div class="affichage_classique">
                <h2>Demandeur : </h2>
                <div class="aff">'.$aideInterne->individu->nom.' '.$aideInterne->individu->prenom.'</div>
            </div>
            <div class="affichage_classique">
                <h2>Instructeur : </h2>
                <div class="aff">'.$aideInterne->instruct->nom.'</div>
            </div>
            <div class="affichage_classique">
                <h2>Date demande : </h2>
                <div class="aff">'.getDatebyTimestamp($aideInterne->dateDemande).'</div>
            </div>
        </div>
        <div class="colonne_classique">
            <div class="affichage_classique">
                <h2>Aide demand&eacute;e : </h2>
                <div class="aff">'.$aideInterne->typeAideDemandee->libelle.'</div>
            </div>
            <div class="affichage_classique">
                <h2>Organisme : </h2>
                <div class="aff">'.$aideInterne->organisme->appelation.'</div>
            </div>
            <div class="affichage_classique">
                <h2>Nature : </h2>
                <div class="aff">'.$aideInterne->natureAide->libelle.'</div>
            </div>
        </div>
        <div class="colonne_classique">
            <div class="affichage_classique">
                <h2>Etat : </h2>
                <div class="aff">'.$aideInterne->etat.'</div>
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
            <div class="affichage_classique">
                <h2>Proposition : </h2>
                <div class="aff">'.$aideInterne->proposition.'</div>
            </div>
        </div>
                         ';
    
    $contenu = "<h3>Fiche d'aide interne :</h3>";
    $contenu .= '<ul class="list_classique"><li class="ligne_list_classique">'.$testaffichage.'</li></ul>';
            
        if($aideInterne->avis == null) {
            $contenu .= '<div class="bouton modif" id="updateDecision">Apporter une d&eacute;cision</div>';
            $contenu .= '<div id="decision">';
        }
        $contenu .= '<h3 id="idAide" value="'.$aideInterne->id.'">D&eacute;cision :</h3>
                     <ul class="list_classique">
                         <li class="ligne_list_classique">
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Aide accord&eacute;e : </h2>
                                    <div class="aff">
                                        <div class="select classique" role="select_typeaide_interne">';
            $contenu .= $aideInterne->idAideAccordee == null ? '<div id="aideaccorde" class="option">Type d\'aide</div>' : '<div id="aideaccorde" class="option" value="'. $aideInterne->idAideAccordee .'">'.$aideInterne->typeAideAccordee->libelle.'</div>';  
            $contenu .= '
                                            <div class="fleche_bas"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="affichage_classique">
                                    <h2>Avis : </h2>
                                    <div class="aff">
                                        <div class="select classique" role="select_avis">';
            $contenu .= $aideInterne->avis == null ? '<div id="avis" class="option">-------</div>' : '<div id="avis" class="option" value="'. $aideInterne->avis.'">'.$aideInterne->avis.'</div>';  
            $contenu .= '                  
                                            <div class="fleche_bas"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Date d&eacute;cision : </h2>
                                    <div class="aff"><input class="contour_field input_date" type="text" id="dateDecision" size="10" value="'.getDatebyTimestamp($aideInterne->dateDecision).'"></div>
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
                                    <h2>D&eacute;cideur : </h2>
                                    <div class="aff">
                                        <div class="select classique" role="select_decideur">';
        $contenu .= $aideInterne->idDecideur == null ? '<div id="decideur" class="option">Decideur</div>' : '<div id="decideur" class="option" value="'. $aideInterne->idDecideur .'">'.$aideInterne->decideur->decideur.'</div>';  
        $contenu .= '
                                            <div class="fleche_bas"> </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="affichage_classique">
                                    <h2>Commentaire : </h2>
                                    <div class="aff"><textarea class="contour_field input_char" type="text" id="commentaire">'.$aideInterne->commentaire.'</textarea></div>
                                </div>
                            <div>
                         </li>
                     </ul>';
    $contenu .= '
        <h3>Bon d\'aide <span class="addElem" role="addBonInterne"></span></h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Type bon</th>
                            <th>Date remise pr&eacute;vue</th>
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
            $chemin = './document/'.$bonAide->aideInterne->individu->id.'/'.$bonAide->aideInterne->id;
            $i % 2 ? $contenu .= '<tr name="'.$bonAide->id.'">' : $contenu .= '<tr class="alt" name="'.$bonAide->id.'">';
            $contenu .= '<td>'.$bonAide->aideInterne->typeAideDemandee->libelle.'</td>
                                    <td> '.getDatebyTimestamp($bonAide->dateRemisePrevue).'</td>
                                    <td> '.getDatebyTimestamp($bonAide->dateRemiseEffective).'</td>
                                    <td> '.$bonAide->instruct->nom.'</td>                                
                                    <td> '.$bonAide->montant.'&euro;</td>
                                    <td>'.$bonAide->commentaire.'</td>
                                    <td>'.pdfExist($chemin, $bonAide->id).'</td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=6 align=center>< Aucun bon n\'a encore &eacute;t&eacute; d&eacute;livr&eacute; pour cette aide > </td>
                     </tr>';
    }
    $contenu .= '</tbody></table></div>
                 <h3>Rapport :</h3>
                     <ul class="list_classique">
                         <li class="ligne_list_classique">
                            <span><textarea class="contour_field input_char" style="width:99%; max-width:99%" type="text" id="rapport" >'.$aideInterne->rapport.'</textarea></span>
                         </li>
                     </ul>';
    $contenu .= '
        <div class="sauvegarder_annuler">
            <div class="bouton modif" value="updateDecisionInterne">Enregistrer</div>
            <div class="bouton classique" value="cancelDecisionInterne">Annuler</div>
        </div>';
    if($aideInterne->avis == null) {
        $contenu .= '</div>';
    }
    // COMBO BOX
    $contenu .= '<ul class="select_decideur">';
    foreach($decideurs as $decideur) {
    $contenu .= '<li>
                                <div value="'.$decideur->id.'">'.$decideur->decideur.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '
        <ul class="select_avis">
            <li>
                <div value="Accept&eacute;">Accept&eacute;</div>
            </li>
            <li>
                <div value="Refus&eacute;">Refus&eacute;</div>
            </li>
        </ul>';
    $contenu .= '<ul class="select_typeaide_interne">';
    foreach($typesaides as $type) {
    $contenu .= '<li>
                                <div value="'.$type->id.'">'.$type->libelle.'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    // FORMULAIRE
    $contenu .= '<div class="formulaire" action="addBonInterne" idAide="'.$aideInterne->id.'">
        <h2>Bon interne</h2>
           <div class="colonne_droite">
            <input type="hidden" id="idinstruct" value="'.$aideInterne->idInstruct.'">
             <div class="input_text">
                <input id="dateprevue" class="contour_field" type="text" title="Date" placeholder="Date de remise pr&eacute;vue">
            </div>
            <div class="input_text">
                <input id="dateeffective" class="contour_field" type="text" title="Date" placeholder="Date de remise &eacute;ffective">
            </div>
            <div class="input_text">
                <input id="montant" class="contour_field input_num" type="text" title="Montant" placeholder="Montant">
            </div>
            <div class="input_text">
                <input id="commentaireBon" class="contour_field" type="text" title="Commentaire" placeholder="Commentaire">
            </div>
            <div class="sauvegarder_annuler">
                <div class="bouton modif" value="save">Enregistrer</div>
                <div class="bouton classique" value="cancel">Annuler</div>
            </div>

           </div>
   </div>';
    return $contenu;
}

function createAideInterne($typeAide, $date, $instruct, $nature, $proposition, $etat, $idIndividu, $organisme, $urgence) {
    $aide = new AideInterne();
    if($date != 0) {
        $date1 = explode('/', $date);
        $aide->dateDemande = mktime(0, 0, 0, $date[1], $date1[0], $date1[2]);
    } else {
        $aide->dateDemande = 0;
    }
    $aide->nature = $nature;
    $aide->idAideDemandee = $typeAide;
    $aide->idInstruct = $instruct;
    $aide->etat = $etat;
    $aide->proposition = $proposition;
    $aide->idIndividu = $idIndividu;
    $aide->idOrganisme = $organisme;
    $aide->aideUrgente = $urgence;
    $aide->save();
}

function createAideExterne($typeAide, $date, $instruct, $nature, $idDistrib, $etat, $idIndividu, $organisme, $urgence, $montantDemande) {
    $aide = new AideExterne();
    if($date != 0) {
        $date1 = explode('/', $date);
        $aide->dateDemande = mktime(0, 0, 0, $date[1], $date1[0], $date1[2]);
    } else {
        $aide->dateDemande = 0;
    }
    $aide->nature = $nature;
    $aide->idAideDemandee = $typeAide;
    $aide->idInstruct = $instruct;
    $aide->etat = $etat;
    $aide->idDistrib = $idDistrib;
    $aide->idIndividu = $idIndividu;
    $aide->idOrganisme = $organisme;
    $aide->aideUrgente = $urgence;
    $aide->montantDemande = $montantDemande;
    $aide->save();
}

function updateDecisionInterne() {
    include_once('./lib/config.php');
    $aide = Doctrine_Core::getTable('aideinterne')->find($_POST['idAide']);
    $aide->idAideAccordee = $_POST['aide'];
    if($_POST['date'] != 0) {
        $date1 = explode('/', $_POST['date']);
        $aide->dateDecision = mktime(0, 0, 0, $date1[1], $date1[0], $date1[2]);
    } else {
        $aide->dateDecision = 0;
    }
    $aide->avis = $_POST['avis'];
    $aide->vigilance = $_POST['vigilance'];
    $aide->commentaire = $_POST['commentaire'];
    $aide->rapport = $_POST['rapport'];
    $aide->idDecideur = $_POST['decideur'];
    $aide->save();
    $retours = aide();
    $retour = array('aide' => $retours);
    echo json_encode($retour);  
}

function addBonInterne($idAide, $idInstruct, $datePrevue, $dateEffective, $montant, $commentaire) {
    include_once('./lib/config.php');
    $bon = new BonAide();
    $bon->idAideInterne = $idAide;
    $bon->idInstruct = $idInstruct;
    if($datePrevue != 0) {
        $date1 = explode('/', $datePrevue);
        $bon->dateRemisePrevue = mktime(0, 0, 0, $date1[1], $date1[0], $date1[2]);
    } else {
        $bon->dateRemisePrevue = 0;
    }
    if($dateEffective != 0) {
        $date2 = explode('/', $dateEffective);
        $bon->dateRemiseEffective = mktime(0, 0, 0, $date2[1], $date2[0], $date2[2]);
    }
    $bon->montant = $montant;
    $bon->commentaire = $commentaire;
    $bon->save();
    creationPDFBonInterne($bon);
}

function creationPDFBonInterne($bon) {
    // On génère le bon
    include_once('./lib/int2str.php');
    $beneficaire = $bon->aideInterne->individu->civilite .' '. $bon->aideInterne->individu->nom .' '. $bon->aideInterne->individu->prenom;
    $rue = $bon->aideInterne->individu->foyer->rue->rue;
    $num = $bon->aideInterne->individu->foyer->numRue;
    $idIndividu = $bon->aideInterne->individu->id;
    $lettres = int2str($bon->montant);
    $chemin = './document/'.$idIndividu;
    $idAide = $bon->aideInterne->id;
    $numBon = $bon->id;
    if(!is_dir($chemin)) {
        mkdir($chemin);
    }
    if(!is_dir($chemin.'/'.$idAide)) {
        mkdir($chemin.'/'.$idAide);
    }
    include_once('./lib/PDF/generateBon.php');
}

function aideExterne() {
    $aidesExternes = Doctrine_Core::getTable('aideexterne')->findByIdIndividu($_POST['idIndividu']);
    $organismesExternes = Doctrine_Core::getTable('organisme')->findByIdLibelleOrganisme(6);
    $naturesExternes = Doctrine_Core::getTable('type')->findByCategorie(6);
    $typesAidesExternes = Doctrine_Core::getTable('type')->findByCategorie(7);
    $instructs =  Doctrine_Core::getTable('instruct')->findAll();
    $individu = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $distributeurs = Doctrine_Core::getTable('organisme')->findByIdLibelleOrganisme(3);
    $contenu = '
        <h3>Aides Externes :</h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Date demande</th>
                            <th>Aide demand&eacute;e</th>
                            <th>Etat</th>
                            <th>Nature</th>
                            <th>Organisme</th>
                            <th>Avis</th>
                            <th>Montant</th>
                            <th>Date d&eacute;cision</th>
                            <th>D&eacute;tails</th>
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
                                    <td> '.$aideExterne->montantPercu.' &euro;</td>
                                    <td> '.getDatebyTimestamp($aideExterne->dateDecision).'</td>
                                    <td><span class="edit_aide_externe"></span></td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=9 align=center>< Aucune aide externe n\'a &eacute;t&eacute; attribu&eacute;e &agrave; cet individu > </td>
                     </tr>';
    }

    $contenu .= '</tbody></table>';

    $contenu .= '<div class="formulaire" action="creation_aide_externe">
                   <h2>Aide Externe</h2>
                   <div class="colonne_droite">
                        <div class="select classique" role="select_typeaide_externe">
                            <div id="typeaideexterne" class="option">Type d\'aide</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_instruct">
                            <div id="instruct" class="option">Instructeur</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_orga_ext">
                            <div id="orgaext" class="option">Organisme</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="input_text">
                            <input id="date" class="contour_field" type="text" title="Date" placeholder="Date - jj/mm/aaaa">
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_nature_externe">
                            <div id="natureexterne" class="option">Nature</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_distrib">
                            <div id="distrib" class="option">Distributeur</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="clearboth"></div>
                        <div class="select classique" role="select_etat">
                            <div id="etat" class="option">Etat</div>
                            <div class="fleche_bas"> </div>
                        </div>
                        <div class="input_text">
                            <span class="checkbox" id="urgence"></span> 
                            <span class="attribut">Aide urgente</span>
                        </div>
                        <div class="input_text">
                            <input id="montantdemande" class="contour_field" type="text" title="Montant demand&eacute;" placeholder="Montant demand&eacute;">
                        </div>
                        <div class="sauvegarder_annuler">
                            <div class="bouton modif" value="save">Enregistrer</div>
                            <div class="bouton classique" value="cancel">Annuler</div>
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
                <div value="Termin&eacute;">Termin&eacute;</div>
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
    
    $contenu = "<h3>Fiche d'aide externe :</h3>";
    $contenu .= '<ul class="list_classique">
                    <li class="ligne_list_classique">
                        <div class="colonne_classique">
                            <div class="affichage_classique">
                                <h2>Demandeur : </h2>
                                <div class="aff">'.$aideExterne->individu->nom.' '.$aideExterne->individu->prenom.'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Instructeur : </h2>
                                <div class="aff">'.$aideExterne->instruct->nom.'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Date demande : </h2>
                                <div class="aff">'.getDatebyTimestamp($aideExterne->dateDemande).'</div>
                            </div>
                            <div class="affichage_classique">
                                <h2>Montant demand&eacute; : </h2>
                                <div class="aff">'.$aideExterne->montantDemande.'</div>
                            </div>
                        </div>
                        <div class="colonne_classique">
                            <div class="affichage_classique">
                                <h2>Aide demand&eacute;e : </h2>
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
                    </li></ul>';
    
        $contenu .= '<h3>D&eacute;cision :</h3>
                     <ul class="list_classique">
                        <li class="ligne_list_classique">
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Montant per&ccedil;u : </h2>
                                    <div class="aff">'.$aideExterne->montantPercu.'</div>
                                </div>

                                <div class="affichage_classique">
                                    <h2>Commentaire : </h2>
                                    <div class="aff"><textarea class="contour_field input_char" type="text" id="commentaire">'.$aideExterne->commentaire.'</textarea></div>
                                </div>
                            </div>
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Date d&eacute;cision : </h2>
                                    <div class="aff">'.getDatebyTimestamp($aideExterne->dateDecision).'</div>
                                </div>
                            </div>
                            <div class="colonne_classique">
                                <div class="affichage_classique">
                                    <h2>Avis : </h2>
                                    <div class="aff">'.$aideExterne->avis.'</div>
                                </div>
                            </div>
                        </li></ul>';
    return $contenu;
}

function pdfExist($chemin, $idBon) {
    if(is_dir($chemin) && file_exists($chemin.'/'.$idBon.'.pdf')) {
        return '<a name="'.$chemin.'/'.$idBon.'.pdf" href="'.$chemin.'/'.$idBon.'.pdf" target="_blank">V</a>';
    } else {
        return '<a name="'.$chemin.'/'.$idBon.'.pdf" idBon="'.$idBon.'" class="create_bon_interne">C</a>';
    }
}

function createPDFBonInternetEtAffichage($idBon) {
    include_once('./lib/config.php');
    $bon = Doctrine_Core::getTable('bonaide')->find($idBon);
    creationPDFBonInterne($bon);
}
?>
