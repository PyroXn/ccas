<?php

function recapAides() {
    $typesaides = Doctrine_Core::getTable('type')->findByidlibelletypeOridlibelletype(1,7);
    $retour = '
        <div class="select classique court" role="select_pic">
            <div id="choixTableAide" class="option">-----</div>
            <div class="fleche_bas"> </div>
        </div>
        <div value="recapAidesGlobal" class="bouton ajout">
            <span>Récapitulatif global</span>
        </div>
        <ul class="select_pic">';
    foreach ($typesaides as $type) {
        $retour .= '<li><div value="'.$type->id.'">'.$type->libelle.'</div></li>';
    }
            
    $retour .= '</ul>';
    $retour .= '<div id="beneficiaire"></div>';
    return $retour;
}

function generateBeneficiaireAide($idType) {
    $type = Doctrine_Core::getTable('type')->find($idType);
    $retour = '<h3>Bénéficiaires</h3>';
    $aides;
    //aide interne
    if ($type->idlibelletype == 1) {
        $aides = Doctrine_Core::getTable('aideinterne')->findByavisAndetatAndidaideaccordee('accepté', 'terminé', $idType);
    //aide externe
    } else if ($type->idlibelletype == 7) {
        $aides = Doctrine_Core::getTable('aideexterne')->findByavisAndetatAndidaidedemandee('accepté', 'terminé', $idType);
    }
    $retour .= '
        <table class="tableau_classique" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="header">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse</th>
                    <th>Secteur</th>
                    <th>Année de naissance</th>
                    <th>Situation familiale</th>
                    <th>Somme</th>
                </tr>
            </thead>
            <tbody>';
    foreach($aides as $aide) {
        //tri des aides qui n'ont pas d'individu/foyer
        if ($aide->individu->id != null && $aide->individu->foyer->id != null) {
            $individu = $aide->individu;
            $foyer = $individu->foyer;
            $retour .= '<tr>
                    <td>'.$individu->nom.'</td>
                    <td>'.$individu->prenom.'</td>
                    <td>'.$foyer->numRue.' '.$foyer->rue->rue.' '.$foyer->ville->libelle.'</td>
                    <td>'.$foyer->secteur->secteur.'</td>
                    <td>'.date('d/m/Y', $individu->dateNaissance).'</td>
                    <td>'.$foyer->situationfamiliale->situation.'</td>';
            if ($aide instanceof AideInterne) {
                $retour .= '<td>'.$aide->montanttotal.'€</td>';
            } else if ($aide instanceof AideExterne) {
                $retour .= '<td>'.$aide->montantPercu.'€</td>';
            }
                $retour .= '</tr>';
        }
    }
    
    $retour .= '</tbody>
        </table>';
    return $retour;
}


function recapGlobal() {    
    //METTRE UN FUCKING LOADING (freeze all apli lors de l'utilisation, mange ta bdd)
    $typesaides = Doctrine_Core::getTable('type')->findByidlibelletypeOridlibelletype(1,7);
    $retour = '
        <h3>Recap global</h3>
        <div class="bubble tableau_classique_wrapper">
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                        <th>Type d\'aide</th>
                        <th>Nombre de FAMILLES bénéficiaires d\'aides facultatives Résidant sur la commune</th>
                        <th>Nombre de personnes bénéficiaires d\'aides facultatives Résidant hors commune</th>
                        <th>Nombre de FAMILLES bénéficiaires d\'aides facultatives Total</th>
                        <th>Montant des aides facultatives accordées</th>
                    </tr>
                </thead>
                <tbody>';
        foreach($typesaides as $type) {
            $retour .= '<tr>
                            <td>'.$type->libelle.'</td>';
            $aides;
            //difference entre aide interne et aide externe
            if($type->idlibelletype == 1) {
                $aides = Doctrine_Core::getTable('aideinterne')->findByavisAndetatAndidaideaccordee('accepté', 'terminé', $type->id);
            } else if($type->idlibelletype == 7) {
                $aides = Doctrine_Core::getTable('aideexterne')->findByavisAndetatAndidaidedemandee('accepté', 'terminé', $type->id);
            }
            $montant = 0;
            $famille = array();
            //calcul du montant et creation du tableau famille
            foreach($aides as $aide) {
                //tri des aides qui n'ont pas d'individu/foyer
                if ($aide->individu->id != null && $aide->individu->foyer->id != null) {
                    if ($aide instanceof AideInterne) {
                        $montant += $aide->montanttotal;
                    } else if ($aide instanceof AideExterne) {
                        $montant += $aide->montantPercu;
                    }
                    array_push($famille, $aide->individu->foyer);
                }
            }
            //suppression des doublons du tableau
            $famille = array_unique($famille);
            $residant = 0;
            //calcul du nombre de residant (id 20 = hayange)
            foreach($famille as $fa) {
                if ($fa->ville->id == 20) {
                    $residant += 1;
                }
            }
            $retour .= '<td>'.$residant.'</td>';
            $nonResidant = count($famille) - $residant;
            $retour .= '<td>'.$nonResidant.'</td>';
            $retour .= '<td>'.count($famille).'</td>';
            $retour .= '<td>'.$montant.'€</td>';
            $retour .= '</tr>';
        }
   
    $retour .= '</tbody>
            </table>';
    
    return $retour;
}

function testPic2() {
    $retour = '';
    $aidesInterne = Doctrine_Core::getTable('aideinterne')->findByavisAndetatAndidaideaccordee('accepté', 'terminé', 27);
    
//    $retour .= '<div> count query : ----> '.count($query->execute()).'</div>';
//    $retour .= '<div>'.count($aidesInterne).'</div>';
    $famille = array();
    foreach ($aidesInterne as $ai) {
        $retour .= '<div>'.$ai->id.' '.$ai->idIndividu.' '.$ai->individu->idFoyer.'</div>';
        if ($ai->individu->id != null && $ai->individu->foyer->id != null) {
            $retour .= '<b>'.$ai->montanttotal.'</b>';
            array_push($famille, $ai->individu->foyer);
        }
    }
//    $retour .= 'PRINT R '.print_r($famille);
    $familleunique = array_unique($famille);
    foreach ($famille as $f) {
        $retour .= '<div><b>'.$f->id.'</b></div>';
    }
    foreach ($familleunique as $f) {
        $retour .= '<div><i>'.$f->id.'</i></div>';
    }
    $retour .= '<div>'.count($famille).'</div>';
    $retour .= '<div>'.count($familleunique).'</div>';
    
    return $retour;
}


/* POUR VERIF REQUETE :
 * 
    SELECT distinct(i.idfoyer)
    FROM aideinterne as ai
    right join individu as i on i.id = ai.idindividu
    WHERE 
    avis = "accepté"
    and etat = "terminé"
    and idaideaccordee = 27
 * 
 * 
 * AVEC LE DELIRE DE LA VILLE : 

    SELECT distinct (i.idfoyer), f.idville
    FROM aideinterne as ai
    right join individu as i on i.id = ai.idindividu
    right join foyer as f on f.id = i.idfoyer
    WHERE 
    avis = "accepté"
    and etat = "terminé"
    and idaideaccordee = 27
 * 
 */
?>
