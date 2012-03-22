<?php
function aide() {
    $contenu = aideInterne();
//    $contenu .= aideExterne();
    
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
                <span class="checkbox" id="urgence"></span> Aide urgente ?
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

        $contenu .= '<h3>Décision :</h3>
                     <ul class="list_classique">
                     <li class="ligne_list_classique">
                         <div class="colonne50">
                              <span class="attribut">aide accordée : </span>
                              <span><input class="contour_field input_char" type="text" id="aideAcordee" value="'.utf8_decode($aideInterne->typeAideAccordee->libelle).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">date décision : </span>
                             <span><input class="contour_field input_num" type="text" id="dateDecision" value="'.getDatebyTimestamp($aideInterne->dateDecision).'" disabled/></span>
                         </div>
                         <div class="colonne">
                             <span class="attribut">décideur : </span>
                             <span><input class="contour_field input_char" type="text" id="decideur" value="'.utf8_decode($aideInterne->instruct->nom).'" disabled/></span>
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

?>
