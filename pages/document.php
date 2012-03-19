<?php

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
            <table border="0">
                <tr>
                    <td>Word</td>
                    <td>Excel</td>
                    <td>Texte</td>
                </tr>';
    foreach($arrayExtension as $tab) {
       
//        echo 'Fichier de type '.$tab;
//        echo $arrayExtension['txt'];
        foreach($tab as $t) {
             $contenu .= '<tr>';
             $extension = pathinfo($t, PATHINFO_EXTENSION);
             if($extension == 'xls') {
                 $contenu .= '<td></td><td>'.$t.'</td><td></td>';
             } else if($extension == 'doc' || $extension == 'docx') {
                 $contenu .= '<td>'.$t.'</td><td></td><td></td>';
             }
             $contenu .= '</tr></table>';
             echo $contenu;
        }
        
    }
    }
}
?>
