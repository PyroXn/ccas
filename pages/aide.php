<?php
function aide() {
    $contenu = aideInterne();
    
    return $contenu;
}
function aideInterne() {
    
        //AFFICHAGE DES LISTES D'AIDES
        
            // AIDES INTERNES //
        $aidesInternes = Doctrine_Core::getTable('aideinterne')->findByIdIndividu($_POST['idIndividu']);
        $contenu = '
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
            $i % 2 ? $contenu .= '<tr>' : $contenu .= '<tr class="alt">';
            $contenu .= '<td>'.getDatebyTimestamp($aideInterne->dateDemande).'</td>
                                    <td> '.$aideInterne->typeAideDemandee->libelle.'</td>
                                    <td> '.utf8_decode($aideInterne->etat).'</td>
                                    <td> '.utf8_decode($aideInterne->nature).'</td>
                                    <td> '.utf8_decode($aideInterne->avis).'</td>
                                    <td> '.$aideInterne->montant.' &euro;</td>
                                    <td> '.getDatebyTimestamp($aideInterne->dateDecision).'</td>
                                    <td><img src="./templates/img/edit.png"></img></td>
                        </tr>';
            $i++;
        }
        $contenu .= '</tbody></table>';
   
        return utf8_encode($contenu);
    
}

function detailAideInterne() {
    $aideInterne = Doctrine_Core::getTable('aideinterne')->findOneById($_POST['idAide']);
    
    $contenu = "<h3>Fiche d'aide :</h3>";
    
    $contenu .= '<ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">aide demandée : </span>
                              <span><input class="contour_field input_char" type="text" id="aideDemandee" value="'.$aideInterne->typeAideDemandee->libelle.'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">date demande : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDemande" value="'.getDatebyTimestamp($aideInterne->dateDemande).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">organisme : </span>
                             <span><input class="contour_field input_char" type="text" id="organisme" value="'.$aideInterne->organisme->appelation.'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                              <span class="attribut">demandeur : </span>
                              <span><input class="contour_field input_char" type="text" id="demandeur" value="'.$aideInterne->individu->nom.' '.$aideInterne->individu->prenom.'" disabled/></span>
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne">
                             <span class="attribut">instructeur : </span>
                             <span><input class="contour_field input_char" type="text" id="instructeur" value="'.$aideInterne->instruct->nom.'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">nature : </span>
                             <span><input class="contour_field input_char" type="text" id="nature" value="'.utf8_decode($aideInterne->nature).'" disabled/></span>
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
                             <span><textarea class="contour_field input_char" type="text" id="proposition">'.$aideInterne->proposition.'</textarea></span>
                         </div>
                     </li></ul>';

        $contenu .= '<h3>Décision :</h3>
                     <ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">aide accordée : </span>
                              <span><input class="contour_field input_char" type="text" id="aideAcordee" value="'.$aideInterne->typeAideAccordee->libelle.'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">date décision : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDecision" value="'.getDatebyTimestamp($aideInterne->dateDecision).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">décideur : </span>
                             <span><input class="contour_field input_char" type="text" id="decideur" value="'.$aideInterne->instruct->nom.'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">avis : </span>
                             <span><input class="contour_field input_char" type="text" id="avis" value="'.utf8_decode($aideInterne->avis).'" disabled/></span>
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne50">
                             <span class="attribut">vigilance : </span>
                             <span><input class="contour_field input_char" type="text" id="vigilance" value="'.$aideInterne->vigilance.'" disabled/></span>
                         </div>
                     </li>
                     <li class="ligne_list_classique">
                         <div class="colonne">
                             <span class="attribut">montant : </span>
                             <span><input class="contour_field input_num" type="text" id="montant" value="'.$aideInterne->montant.'" disabled/></span>
                             <span class="attribut">quantité : </span>
                             <span><input class="contour_field input_num" type="text" id="quantite" value="'.$aideInterne->quantite.'" disabled/></span>
                             <span class="attribut">total : </span>
                             <span><input class="contour_field input_num" type="text" id="montantTotal" value="'.$aideInterne->montantTotal.'" disabled/></span>
                         </div>
                         <div class="colonne">
                         </div>
                         <div class="colonne50">
                             <span class="attribut">commentaire : </span>
                             <span><textarea class="contour_field input_char" type="text" id="commentaire">'.$aideInterne->commentaire.'</textarea></span>
                         </div>
                     </li>
                 </ul>
                 <h3>Rapport :</h3>
                     <ul class="list_classique">
                         <li class="ligne_list_classique">
                            <span><textarea class="contour_field input_char" style="width:99%" type="text" id="rapport" >'.$aideInterne->rapport.'</textarea></span>
                         </li>
                     </ul>';
        
    return utf8_encode($contenu);
}

?>
