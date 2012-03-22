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
        <div class="bouton ajout" id="createAideInterne">Ajouter une aide interne</div> -&nbsp;&nbsp;&nbsp;&nbsp;<div class="bouton ajout" id="">Ajouter une aide externe</div>
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
                            <th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    foreach($aidesInternes as $aideInterne) {
        $i % 2 ? $contenu .= '<tr name="'.$aideInterne->id.'">' : $contenu .= '<tr class="alt" name="'.$aideInterne->id.'">';
        $contenu .= '<td>'.getDatebyTimestamp($aideInterne->dateDemande).'</td>
                                <td> '.$aideInterne->typeAideDemandee->libelle.'</td>
                                <td> '.utf8_decode($aideInterne->etat).'</td>
                                <td> '.utf8_decode($aideInterne->natureAide->libelle).'</td>
                                <td> '.utf8_decode($aideInterne->avis).'</td>
                                <td> MONTANT TOTAL</td>
                                <td> '.getDatebyTimestamp($aideInterne->dateDecision).'</td>
                                <td><span class="edit_aide_interne"></span></td>
                    </tr>';
        $i++;
    }
    $contenu .= '</tbody></table>';
    $contenu .= '<div class="formulaire" action="creation_aide_interne">
       <div class="colonne_droite">
             <div class="select classique" role="select_typeaide_interne">
                <div id="typeaideinterne" class="option">Type d\'aide</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <input id="date" class="contour_field" type="text" title="Date" placeholder="Date - jj/mm/aaaa">
            </div>
           <div class="select classique" role="select_instruct">
                <div id="instruct" class="option">Instructeur</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <input id="demandeur" class="contour_field" type="text" title="Demandeur" value="'.$individu->nom .' '.$individu->prenom.'" disabled />
            </div>
            <div class="select classique" role="select_nature">
                <div id="nature" class="option">Nature</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <span class="checkbox" id="urgence"></span> Aide urgente ?
            </div>
            <div class="select classique" role="select_orga">
                <div id="orga" class="option">Organisme</div>
                <div class="fleche_bas"> </div>
            </div>
            <div class="input_text">
                <input id="proposition" class="contour_field" type="text" title="Proposition" placeholder="Proposition">
            </div>
            <div class="select classique" role="select_etat">
                <div id="etat" class="option">Etat</div>
                <div class="fleche_bas"> </div>
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
                                <div value="'.$organisme->id.'">'.utf8_decode($organisme->appelation).'</div>
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
    $contenu .= '<ul class="select_typeaide_interne">';
foreach($typesaides as $type) {
    $contenu .= '<li>
                                <div value="'.$type->id.'">'.utf8_decode($type->libelle).'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_instruct">';
    foreach($instructs as $instruct) {
        $contenu .= '<li>
                                <div value="'.$instruct->id.'">'.utf8_decode($instruct->nom).'</div>
                           </li>';
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_nature">';
foreach($natures as $nature) {
    $contenu .= '<li>
                                <div value="'.$nature->id.'">'.utf8_decode($nature->libelle).'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    return utf8_encode($contenu);

}

function detailAideInterne() {
    $aideInterne = Doctrine_Core::getTable('aideinterne')->findOneById($_POST['idAide']);
    $typesaides = Doctrine_Core::getTable('type')->findByCategorie(1);
    
    $contenu = "<h3>Fiche d'aide :</h3>";
    
    $contenu .= '<ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">aide demandée : </span>
                              <span><input class="contour_field input_char" type="text" id="aideDemandee" value="'.utf8_decode($aideInterne->typeAideDemandee->libelle).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">date demande : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDemande" value="'.getDatebyTimestamp($aideInterne->dateDemande).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">organisme : </span>
                             <span><input class="contour_field input_char" type="text" id="organisme" value="'.utf8_decode($aideInterne->organisme->appelation).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                              <span class="attribut">demandeur : </span>
                              <span><input class="contour_field input_char" type="text" id="demandeur" value="'.utf8_decode($aideInterne->individu->nom).' '.utf8_decode($aideInterne->individu->prenom).'" disabled/></span>
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                             <span class="attribut">instructeur : </span>
                             <span><input class="contour_field input_char" type="text" id="instructeur" value="'.utf8_decode($aideInterne->instruct->nom).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">nature : </span>
                             <span><input class="contour_field input_char" type="text" id="nature" value="'.utf8_decode($aideInterne->natureAide->libelle).'" disabled/></span>
                             <span class="attribut">état : </span>
                             <span><input class="contour_field input_char" type="text" id="etat" value="'.utf8_decode($aideInterne->etat).'" disabled/></span>
                           
                         </div>
                         <div class="colonne">
                         <span class="attribut">aide urgente : </span>';
                             if($aideInterne->aideUrgente == 1) {
                                $contenu .= '<span id="aideUrgente" class="checkbox checkbox_active" value="1"></span>';
                             } else {
                                $contenu .= '<span id="aideUrgente" class="checkbox" value="0"></span>';
                             }
            $contenu .= '</div>
                         <div class="colonne50">
                             <span class="attribut">proposition : </span>
                             <span><textarea class="contour_field input_char" type="text" id="proposition">'.utf8_decode($aideInterne->proposition).'</textarea></span>
                         </div>
                     </li></ul>';
        if($aideInterne->avis == null) {
            $contenu .= '<div class="bouton modif" id="updateDecision">Apporter une décision</div>';
            $contenu .= '<div id="decision">';
        }
        $contenu .= '
                <h3 id="idAide" value="'.$aideInterne->id.'">Décision :</h3>
                     <ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">aide accordée : </span>
                              <div class="select classique" role="select_typeaide_interne">';
        $contenu .= $aideInterne->idAideAccordee == null ? '<div id="aideaccorde" class="option">Type d\'aide</div>' : '<div id="aideaccorde" class="option" value="'. $aideInterne->idAideAccordee .'">'.utf8_decode($aideInterne->typeAideAccordee->libelle).'</div>';  
        $contenu .= '
                                <div class="fleche_bas"> </div>
                            </div>
                         </div>
                         <div class="colonne">
                             <span class="attribut">date décision : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDecision" value="'.getDatebyTimestamp($aideInterne->dateDecision).'"></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">décideur : </span>
                             <span><input class="contour_field input_char" type="text" id="decideur" value="'.utf8_decode($aideInterne->instruct->nom).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">avis : </span>
                             <div class="select classique" role="select_avis">';
        $contenu .= $aideInterne->avis == null ? '<div id="avis" class="option">-----</div>' : '<div id="avis" class="option" value="'. utf8_decode($aideInterne->avis).'">'.utf8_decode($aideInterne->avis).'</div>';  
        $contenu .= '                  
                            <div class="fleche_bas"> </div>
                        </div>
                         </div>
                         <div class="colonne">
                             <span class="attribut">vigilance : </span>';
         if($aideInterne->vigilance == 1) {
            $contenu .= '<span id="vigilance" class="checkbox checkbox_active" value="1"></span>';
         } else {
            $contenu .= '<span id="vigilance" class="checkbox" value="0"></span>';
         }
    $contenu .= '
                         </div>
                        <div class="colonne_large">
                             <span class="attribut">commentaire : </span>
                             <span><textarea class="contour_field input_char" type="text" id="commentaire">'.utf8_decode($aideInterne->commentaire).'</textarea></span>
                         </div>
                     </li>
                 </ul>'; 
    $contenu .= '
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Type bon</th>
                            <th>Date remise prévue</th>
                            <th>Date remise effective</th>
                            <th>Remis par</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>';
    $i = 1;
    $bonAides = $aideInterne->bonAide;

    if (sizeof($bonAides) != null) {
        foreach($bonAides as $bonAide) {
            $i % 2 ? $contenu .= '<tr name="'.$bonAide->id.'">' : $contenu .= '<tr class="alt" name="'.$bonAide->id.'">';
            $contenu .= '<td>'.$bonAide->aideInterne->typeAideDemandee->libelle.'</td>
                                    <td> '.getDatebyTimestamp($bonAide->dateRemisePrevue).'</td>
                                    <td> '.getDatebyTimestamp($bonAide->dateRemiseEffective).'</td>
                                    <td> '.utf8_decode($bonAide->instruct->nom).'</td>                                
                                    <td> '.utf8_decode($bonAide->montant).'</td>
                                    <td><span class="edit_bon_aide"></span></td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=5 align=center>< Aucun bon n\'a encore été délivré pour cette aide > </td>
                     </tr>';
    }
    $contenu .= '</tbody></table></div>
                    <h3>Rapport :</h3>
                     <ul class="list_classique">
                         <li class="ligne_list_classique">
                            <span><textarea class="contour_field input_char" style="width:99%" type="text" id="rapport" >'.utf8_decode($aideInterne->rapport).'</textarea></span>
                         </li>
                     </ul>';
    $contenu .= '
        <div class="sauvegarder_annuler">
            <div class="bouton modif" value="updateDecisionInterne">Enregistrer</div>
            <div class="bouton classique" value="cancel">Annuler</div>
        </div>';
    if($aideInterne->avis == null) {
        $contenu .= '</div>';
    }
    // COMBO BOX
    $contenu .= '
        <ul class="select_avis">
            <li>
                <div value="Accepté">Accepté</div>
            </li>
            <li>
                <div value="Refusé">Refusé</div>
            </li>
        </ul>';
    $contenu .= '<ul class="select_typeaide_interne">';
    foreach($typesaides as $type) {
    $contenu .= '<li>
                                <div value="'.$type->id.'">'.utf8_decode($type->libelle).'</div>
                            </li>';
    }
    $contenu .= '</ul>';
    return utf8_encode($contenu);
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
    $aide->save();
    $retours = aide();
    $retour = array('aide' => $retours);
    echo json_encode($retour);  
}

function aideExterne() {
    $aidesExternes = Doctrine_Core::getTable('aideexterne')->findByIdIndividu($_POST['idIndividu']);
    $contenu = '
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
    foreach($aidesExternes as $aideExterne) {
        $i % 2 ? $contenu .= '<tr name="'.$aideExterne->id.'">' : $contenu .= '<tr class="alt" name="'.$aideExterne->id.'">';
        $contenu .= '<td>'.getDatebyTimestamp($aideExterne->dateDemande).'</td>
                                <td> '.$aideExterne->typeAideDemandee->libelle.'</td>
                                <td> '.utf8_decode($aideExterne->etat).'</td>
                                <td> '.utf8_decode($aideExterne->natureAide->libelle).'</td>
                                <td> '.utf8_decode($aideExterne->organisme->appelation).'</td>                                    
                                <td> '.utf8_decode($aideExterne->avis).'</td>
                                <td> '.$aideExterne->montantPercu.' &euro;</td>
                                <td> '.getDatebyTimestamp($aideExterne->dateDecision).'</td>
                                <td><span class="edit_aide_externe"></span></td>
                    </tr>';
        $i++;
    }
    $contenu .= '</tbody></table>';

    return utf8_encode($contenu);
}


?>
