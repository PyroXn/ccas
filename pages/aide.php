<?php
function aide() {
    
        //AFFICHAGE DES LISTES D'AIDES
        
            // AIDES INTERNES //
        $aidesInternes = Doctrine_Core::getTable('aideinterne')->findByIdIndividu($_POST['idIndividu']);
        $contenu = '<h3>Aides Internes :</h3>
                    <center>
                    <ul id="page_aide_interne">
                        <li class="membre_foyer">
                            <div class="colonne10">
                                <span><h3>Date demande</h3></span>
                            </div>
                            <div class="colonne">
                                <span><h3>Aide demandée</h3></span>
                            </div>
                            <div class="colonne10">
                                <span><h3>Etat</h3></span>
                            </div>
                            <div class="colonne10">
                                <span><h3>Nature</h3></span>
                            </div>
                            <div class="colonne10">
                                <span><h3>Avis</h3></span>
                            </div>
                            <div class="colonne10">
                                <span><h3>Montant</h3></span>
                            </div>
                            <div class="colonne10">
                                <span><h3>Date décision</h3></span>
                            </div>
                            <div class="colonne5">
                                <span><h3>Détails</h3></span>
                            </div>
                        </li>';

        foreach($aidesInternes as $aideInterne) {
            $contenu .= '<li name="'.$aideInterne->id.'" class="membre_foyer">
                            <div>

                                <div class="colonne10">
                                    <span>'.getDatebyTimestamp($aideInterne->dateDemande).'</span>
                                </div>
                                <div class="colonne">
                                    <span> '.$aideInterne->typeAideDemandee->libelle.'</span>
                                </div>
                                <div class="colonne10">
                                    <span allign="center"> '.utf8_decode($aideInterne->etat).'</span>
                                </div>
                                <div class="colonne10">
                                    <span> '.utf8_decode($aideInterne->nature).'</span>
                                </div>
                                <div class="colonne10">
                                    <span> '.utf8_decode($aideInterne->avis).'</span>
                                </div>
                                <div class="colonne10">
                                    <span> '.$aideInterne->montant.' &euro;</span>
                                </div>
                                <div class="colonne10">
                                    <span> '.getDatebyTimestamp($aideInterne->dateDecision).'</span>
                                </div>
                                <div class="colonne5">
                                    <img src="./templates/img/edit.png"></img>
                                </div>
                            </div>
                        </li>';
        }
        $contenu .= '</ul></center>';
   
        return utf8_encode($contenu);
    
}

function detailAideInterne() {
    $aideInterne = Doctrine_Core::getTable('aideinterne')->findOneById($_POST['idAide']);
    
    $contenu = "<h3>Fiche d'aide :</h3>";
    
    $contenu .= '<ul id="membre_foyer_list">
                     <li class="membre_foyer">
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
                     <li class="membre_foyer">
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
                     <li class="membre_foyer">
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
                     <ul id="membre_foyer_list">
                     <li class="membre_foyer">
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
                     <li class="membre_foyer">
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
                     <li class="membre_foyer">
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
                     <ul id="membre_foyer_list">
                         <li class="membre_foyer">
                            <span><textarea class="contour_field input_char" style="width:99%" type="text" id="rapport" >'.$aideInterne->rapport.'</textarea></span>
                         </li>
                     </ul>';
        
    return utf8_encode($contenu);
}

?>
