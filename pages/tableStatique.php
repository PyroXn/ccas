<?php

function generateEcranStatique($table) {
    $tableStatique = Doctrine_Core::getTable($table);

    $columnNames = $tableStatique->getColumnNames();
//    echo $table->getTypeOfColumn($columnName);

    $retour = '';
    $retour .= '<h3>Recherche</h3>
        <ul id="membre_foyer_list">
            <li class="membre_foyer">';
            foreach ($columnNames as $columnName) {
                if ($columnName != 'id') {
                    $retour .= generateColonneByType($tableStatique, $columnName);
                }
            }
        $retour .= '</li></ul>';
            
    
    $retour .= '
        <div id="new'.$table.'" class="bouton ajout" value="add">Ajout '.$table.'</div>
        <h3>'.$table.'</h3>
        <ul id="membre_foyer_list">';
    
    $i = 0;
    foreach ($tableStatique->findAll() as $ligne) {
        $ligneData = $ligne->getData();
        $retour .= '<li class="membre_foyer">';
        foreach ($ligneData as $attribut) {
            if (array_search($attribut, $ligneData) != 'id') {
                $retour .= generateColonneByType($tableStatique, array_search($attribut, $ligneData), $attribut);
            }
        }
        $retour .= '</li>';
    }
    $retour .= '</ul>';
    return $retour;
}

/*
 * AJOUTER EGALEMENT LA GESTION DES COMBOBOX SUR LES COLONNE AYANT LEUR NOM COMMENCANT PAR ID (a voir si utile)
 */
function generateColonneByType($table, $columnName, $attribut=null) {
    $retour = '';
    $type = $table->getTypeOfColumn($columnName);
    switch ($type) {
        case 'string':
            $retour .= '
            <div class="colonne">
                <span class="attribut">'.$columnName.' : </span>
                <span><input class="contour_field input_char" type="text" value="'.$attribut.'"/></span>
            </div>';
            break;
        case 'float' :
        case 'integer' :
            $retour .= '
            <div class="colonne">
                <span class="attribut">'.$columnName.' :</span>
                <span><input type="text" class="contour_field input_num" value="'.$attribut.'"/></span>
            </div>';
            break;
        case 'boolean' :
            $retour .='
                <div class="colonne">
                    <span class="attribut">'.$columnName.' : </span>';
            if($attribut != null && $attribut == 1) {
                $retour .= '<span id="assure" class="checkbox checkbox_active" value="1"></span></div>';
            } else {
                $retour .= '<span id="assure" class="checkbox" value="0"></span></div>';
            };
            break;
    }
    return $retour;
}

?>
