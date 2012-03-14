<?php

function generateEcranStatique($table) {
    $tableStatique = Doctrine_Core::getTable($table)->findAll();

    $colonnes = Doctrine_Core::getTable($table)->getColumnNames();
    
    $retour = '';
    $retour .= '<h3>Recherche</h3>
        <ul id="membre_foyer_list">
            <li class="membre_foyer">';
            foreach ($colonnes as $colonne) {
                if ($colonne != 'id') {
                    $retour .= '
                    <div class="colonne">
                        <span class="attribut">'.$colonne.' : </span>
                        <span><input class="contour_field input_char" type="text"/></span>
                    </div>';
                }
            }
        $retour .= '</li></ul>';
            
    
    $retour .= '
        <div id="new'.$table.'" class="bouton ajout" value="add">Ajout '.$table.'</div>
        <h3>'.$table.'</h3>
        <ul id="membre_foyer_list">';
    
    $i = 0;
    foreach ($tableStatique as $ligne) {
        $ligneData = $ligne->getData();
        $retour .= '<li class="membre_foyer">';
        foreach ($ligneData as $attribut) {
            if (array_search($attribut, $ligneData) != 'id') {
                $retour .= '
                    <div class="colonne">
                        <span class="attribut">'.array_search($attribut, $ligneData).' : </span>
                        <span><input class="contour_field input_char" type="text" value="'.$attribut.'"/></span>
                    </div>';
            }
        }
        $retour .= '</li>';
    }
    $retour .= '</ul>';
    return $retour;
}

?>
