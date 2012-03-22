<?php
function aide() {
    $contenu = aideInterne();
    $contenu .= aideExterne();
    
    return $contenu;
}

function aideInterne() {
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
                                <td> '.$aideInterne->montant.' &euro;</td>
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
                <span class="checkbox" id="urgence"></span>
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
    
    $contenu = "<h3>Fiche d'aide interne :</h3>";
    
    $contenu .= '<ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">Aide demandée : </span>
                              <span><input class="contour_field input_char" type="text" id="aideDemandee" value="'.utf8_decode($aideInterne->typeAideDemandee->libelle).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">Date demande : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDemande" value="'.getDatebyTimestamp($aideInterne->dateDemande).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">Organisme : </span>
                             <span><input class="contour_field input_char" type="text" id="organisme" value="'.utf8_decode($aideInterne->organisme->appelation).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                              <span class="attribut">Demandeur : </span>
                              <span><input class="contour_field input_char" type="text" id="demandeur" value="'.utf8_decode($aideInterne->individu->nom).' '.utf8_decode($aideInterne->individu->prenom).'" disabled/></span>
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                             <span class="attribut">Instructeur : </span>
                             <span><input class="contour_field input_char" type="text" id="instructeur" value="'.utf8_decode($aideInterne->instruct->nom).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">Nature : </span>
                             <span><input class="contour_field input_char" type="text" id="nature" value="'.utf8_decode($aideInterne->natureAide->libelle).'" disabled/></span>
                             <span class="attribut">État : </span>
                             <span><input class="contour_field input_char" type="text" id="etat" value="'.utf8_decode($aideInterne->etat).'" disabled/></span>
                           
                         </div>
                         <div class="colonne">
                         <span class="attribut">Aide urgente : </span>';
                             if($aideInterne->aideUrgente == 1) {
                                $contenu .= '<span id="aideUrgente" class="checkbox checkbox_active" value="1"></span>';
                             } else {
                                $contenu .= '<span id="aideUrgente" class="checkbox" value="0"></span>';
                             }
            $contenu .= '</div>
                         <div class="colonne50">
                             <span class="attribut">Proposition : </span>
                             <span><textarea class="contour_field input_char" type="text" id="proposition">'.utf8_decode($aideInterne->proposition).'</textarea></span>
                         </div>
                     </li></ul>';

        $contenu .= '<h3>Décision :</h3>
                     <ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">Aide accordée : </span>
                              <span><input class="contour_field input_char" type="text" id="aideAcordee" value="'.utf8_decode($aideInterne->typeAideAccordee->libelle).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">Date décision : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDecision" value="'.getDatebyTimestamp($aideInterne->dateDecision).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">Décideur : </span>
                             <span><input class="contour_field input_char" type="text" id="decideur" value="'.utf8_decode($aideInterne->instruct->nom).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">Avis : </span>
                             <span><input class="contour_field input_char" type="text" id="avis" value="'.utf8_decode($aideInterne->avis).'" disabled/></span>
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne50">
                             <span class="attribut">Vigilance : </span>
                             <span><input class="contour_field input_char" type="text" id="vigilance" value="'.$aideInterne->vigilance.'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">Montant : </span>
                             <span><input class="contour_field input_num" type="text" id="montant" value="'.$aideInterne->montant.'" disabled/></span>
                             <span class="attribut">Quantité : </span>
                             <span><input class="contour_field input_num" type="text" id="quantite" value="'.$aideInterne->quantite.'" disabled/></span>
                             <span class="attribut">Total : </span>
                             <span><input class="contour_field input_num" type="text" id="montantTotal" value="'.$aideInterne->montantTotal.'" disabled/></span>
                         </div>
                         <div class="colonne_large">';
    
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
                         </div>
                         <div class="colonne_large">
                             <span class="attribut">Commentaire : </span>
                             <span><textarea class="contour_field input_char" type="text" id="commentaire">'.utf8_decode($aideInterne->commentaire).'</textarea></span>
                         </div>
                     </li>
                 </ul>
                 <h3>Rapport :</h3>
                     <ul class="list_classique">
                         <li class="ligne_list_classique">
                            <span><textarea class="contour_field input_char" style="width:99%" type="text" id="rapport" >'.utf8_decode($aideInterne->rapport).'</textarea></span>
                         </li>
                     </ul>';
        
    return utf8_encode($contenu);
}

function createAideInterne($typeAide, $date, $instruct, $nature, $proposition, $etat, $idIndividu) {
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
    $aide->save();
    $retour = aide();
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
    if (sizeof($aidesExternes) != null) {
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
    } else {
        $contenu .= '<tr>
                         <td colspan=9 align=center>< Aucune aide externe n\'a été attribuée à cette individu > </td>
                     </tr>';
    }

    $contenu .= '</tbody></table>';

    return utf8_encode($contenu);
}

function detailAideExterne() {
    $aideExterne = Doctrine_Core::getTable('aideexterne')->findOneById($_POST['idAide']);
    
    $contenu = "<h3>Fiche d'aide externe:</h3>";
    
    $contenu .= '<ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">Aide demandée : </span>
                              <span><input class="contour_field input_char" type="text" id="aideDemandee" value="'.utf8_decode($aideExterne->typeAideDemandee->libelle).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">Date demande : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDemande" value="'.getDatebyTimestamp($aideExterne->dateDemande).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">Organisme : </span>
                             <span><input class="contour_field input_char" type="text" id="organisme" value="'.utf8_decode($aideExterne->organisme->appelation).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                              <span class="attribut">Demandeur : </span>
                              <span><input class="contour_field input_char" type="text" id="demandeur" value="'.utf8_decode($aideExterne->individu->nom).' '.utf8_decode($aideExterne->individu->prenom).'" disabled/></span>
                         </div>
                         <div class="colonne">
                            <span class="attribut">Aide urgente : </span>';
                             if($aideExterne->aideUrgente == 1) {
                                $contenu .= '<span id="aideUrgente" class="checkbox checkbox_active" value="1"></span>';
                             } else {
                                $contenu .= '<span id="aideUrgente" class="checkbox" value="0"></span>';
                             }
            $contenu .= '</div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                             <span class="attribut">Instructeur : </span>
                             <span><input class="contour_field input_char" type="text" id="instructeur" value="'.utf8_decode($aideExterne->instruct->nom).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">Nature : </span>
                             <span><input class="contour_field input_char" type="text" id="nature" value="'.utf8_decode($aideExterne->natureAide->libelle).'" disabled/></span>
  
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                         </div>                         
                         <div class="colonne">
                                 <span class="attribut">État : </span>
                             <span><input class="contour_field input_char" type="text" id="etat" value="'.utf8_decode($aideExterne->etat).'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">Montant demandé : </span>
                             <span><input class="contour_field input_char" type="text" id="etat" value="'.$aideExterne->montantDemande.'" disabled/></span>
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                             <span class="attribut">Distributeur : </span>
                             <span><input class="contour_field input_char" type="text" id="etat" value="'.$aideExterne->distrib->appelation.'" disabled/></span>
                         </div>
                         </li></ul>';
            
    $contenu .= '<h3>Décision :</h3>
                     <ul class="list_classique">
                         <li class="ligne_list_classique">
                             <div class="colonne">
                                  <span class="attribut">Montant perçu : </span>
                                  <span><input class="contour_field input_char" type="text" id="aideAcordee" value="'.$aideExterne->montantPercu.'" disabled/></span>
                             </div>
                             <div class="colonne">
                             </div>
                             <div class="colonne">
                                 <span class="attribut">Date décision : </span>
                                 <span><input class="contour_field input_num" type="text" id="dateDecision" value="'.getDatebyTimestamp($aideExterne->dateDecision).'" disabled/></span>
                             </div>
                             <div class="colonne">
                                 <span class="attribut">Avis : </span>
                                 <span><input class="contour_field input_char" type="text" id="decideur" value="'.utf8_decode($aideExterne->avis).'" disabled/></span>
                             </div>
                         </li>
                         <li class="ligne_list_classique">
                             <div class="colonne_large">
                                 <span class="attribut">Commentaire : </span>
                                 <span><textarea class="contour_field input_char" type="text" id="proposition">'.utf8_decode($aideExterne->commentaire).'</textarea></span>
                             </div>
                         </li>
                     </ul>';
                    
        
    return utf8_encode($contenu);
}

?>
