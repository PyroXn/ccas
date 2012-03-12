<?php
//
//function aide() {
//    $aidesExternes = Doctrine_Core::getTable('aideexterne')->findByIdIndividu($_POST['idIndividu']);
//    $contenu = '<h1>Aides Externes :</h1>
//                <ul id="membre_foyer_list">
//                    <li class="membre_foyer">
//                        <div class="colonne">
//                            <span><h3>Date demande :</h3></span>
//                        </div>
//                        <div class="colonne">
//                            <span><h3>Aide demandée :</h3></span>
//                        </div>
//                        <div class="colonne">
//                            <span><h3>Etat :</h3></span>
//                        </div>
//                        <div class="colonne">
//                            <span><h3>Nature :</h3></span>
//                        </div>
//                        <div class="colonne">
//                            <span><h3>Avis :</h3></span>
//                        </div>
//                        <div class="colonne">
//                            <span><h3>Montant :</h3></span>
//                        </div>
//                        <div class="colonne">
//                            <span><h3>Date décision :</h3></span>
//                        </div>
//                    </li>';
//    
//
//    foreach($aidesExternes as $aideExterne) {
//        $contenu .= '
//                    <li name="'.$aideExterne->id.'" class="membre_foyer">
//                        <div>
//                            <div class="colonne">
//                                <span>'.getDatebyTimestamp($aideExterne->dateDemande).'</span>
//                            </div>
//                            <div class="colonne">
//                                <span>'.$aideExterne->type->libelle.'</span>
//                            </div>
//                            <div class="colonne">
//                                <span>'.$aideExterne->etat.'</span>
//                            </div>
//                            <div class="colonne">
//                                <span>'.$aideExterne->nature.'</span>
//                            </div>
//                            <div class="colonne">
//                                <span>'.$aideExterne->avis.'</span>
//                            </div>
//                            <div class="colonne">
//                                <span>'.$aideExterne->montant.'</span>
//                            </div>
//                            <div class="colonne">
//                                <span>'.$aideExterne->dateDecision.'</span>
//                            </div>  
//                        </div>
//                    </li>';
//    }
//   $contenu .= '</ul>';
////       <div class="bouton modif" id="createCredit">Ajouter un crédit</div></div>
////       <div class="formulaire" action="creation_credit">
////       <div class="colonne_droite">
////             <div class="input_text">
////                <input id="organisme" class="contour_field" type="text" title="Organisme" placeholder="Organisme">
////            </div>
////            <div class="input_text">
////                <input id="mensualite" class="contour_field" type="text" title="Mensualite" placeholder="Mensualite">
////            </div>
////            <div class="input_text">
////                <input id="duree" class="contour_field" type="text" title="Durée" placeholder="Durée">
////            </div>
////            <div class="input_text">
////                <input id="total" class="contour_field" type="text" title="Total Restant" placeholder="Total Restant">
////            </div>
////            <div class="sauvegarder_annuler">
////                <div class="bouton modif" value="save">Enregistrer</div>
////                <div class="bouton classique" value="cancel">Annuler</div>
////            </div>
////
////       </div>
////       </div>';
//    return $contenu;
//}

?>
