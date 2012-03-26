<?php

function getDocumentIndividu() {
    
    $dir_nom = './document/'.$_POST['idIndividu'];
    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
    $fichier= array(); // on déclare le tableau contenant le nom des fichiers
    $arrayExtension = array();
    while($element = readdir($dir)) {
            if($element != '.' && $element != '..') {
                    if (!is_dir($dir_nom.'/'.$element)) {$fichier[] = $element;}
            }
    }

    closedir($dir);
    
    
    $contenu = '
        <h3>Documents :</h3>
            <div class="bubble tableau_classique_wrapper">
                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr class="header">
                            <th>Nom document</th>
                            <th>Type fichier</th>
                            <th>Date dernière modification</th>
                        </tr>
                    </thead>
                    <tbody>';
    if(!empty($fichier)) {
        $i = 1;
        foreach($fichier as $file) {
            $extension = pathinfo($dir_nom.'/'.$file, PATHINFO_EXTENSION);

            $i % 2 ? $contenu .= '<tr name="'.$aideExterne->id.'">' : $contenu .= '<tr class="alt" name="'.$aideExterne->id.'">';
            $contenu .= '<td>'.getDatebyTimestamp($aideExterne->dateDemande).'</td>
                         <td> '.$aideExterne->typeAideDemandee->libelle.'</td>
                         <td> '.utf8_decode($aideExterne->etat).'</td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=9 align=center>< Aucune document n\'a été attribué à cet individu > </td>
                     </tr>';
    }

    $contenu .= '</tbody></table>';

    return utf8_encode($contenu);
}


function getDocument() {
    $dir_nom = './document'; // dossier listé (pour lister le répertoir courant : $dir_nom = '.'  --> ('point')
    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
    $fichier= array(); // on déclare le tableau contenant le nom des fichiers
    $dossier= array(); // on déclare le tableau contenant le nom des dossiers
    $arrayExtension = array();
    while($element = readdir($dir)) {
            if($element != '.' && $element != '..') {
                    if (!is_dir($dir_nom.'/'.$element)) {$fichier[] = $element;}
                    else {$dossier[] = $element;}
            }
    }

    closedir($dir);
    if(!empty($fichier)) {
        foreach($fichier as $file) {
            $extension = pathinfo($dir_nom.'/'.$file, PATHINFO_EXTENSION);
            if(!isset($arrayExtension[$extension])) {
                $arrayExtension[$extension][] = $dir_nom.'/'.$file;
            } else {
                $arrayExtension[$extension][] = $dir_nom.'/'.$file;
            }

        }
        $contenu = '
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
            <thead>
                <tr class="header">
                    <th>Word</th>
                    <th>Excel</th>
                    <th>Texte</th>
                    <th>PDF</th>
                    <th>Autres</th>
                </tr>
            </thead>
            <tbody>';
    foreach($arrayExtension as $tab) {
       
//        echo 'Fichier de type '.$tab;
//        echo $arrayExtension['txt'];
        foreach($tab as $t) {
             $contenu .= '<tr>';
             $extension = pathinfo($t, PATHINFO_EXTENSION);
             if($extension == 'xls') {
                 $contenu .= '
                     <td></td>
                     <td>'.$t.'</td>
                     <td></td>
                     <td></td>
                     <td></td>';
             } else if($extension == 'doc' || $extension == 'docx') {
                 $contenu .= '
                     <td>'.$t.'</td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>';
             } else if($extension == 'txt') {
                 $contenu .= '
                     <td></td>
                     <td></td>
                     <td>'.$t.'</td>
                     <td></td>
                     <td></td>';
             } else if($extension == 'pdf') {
                 $contenu .= '
                     <td></td>
                     <td></td>
                     <td></td>
                     <td>'.$t.'</td>
                     <td></td>';
             } else {
                 $contenu .= '
                     <td></td>
                     <td></td>
                     <td></td>
                     <td></td>
                     <td>'.$t.'</td>';
             }
             $contenu .= '</tr>';
             
        }
        
    }
    $contenu .= '</tbody></table>';
    $contenu .= '<div id="newDocument" class="bouton ajout">Ajouter un document</div>
                            <div class="formulaire" action="new_document">
                                   <div class="colonne_droite">
                                         <div class="input_text">
                                            <input id="document" class="contour_field" type="file">
                                        </div>
                                        <div class="sauvegarder_annuler">
                                            <div class="bouton modif" value="save">Enregistrer</div>
                                            <div class="bouton classique" value="cancel">Annuler</div>
                                        </div>
                                        
                                   </div>
                                   </div>';
    echo $contenu;
    }
}
?>
