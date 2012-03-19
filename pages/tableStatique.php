<?php

function generateEcranStatique($table) {
    $tableStatique = Doctrine_Core::getTable($table);

    $columnNames = $tableStatique->getColumnNames();
//    echo $table->getTypeOfColumn($columnName);

    $retour = '';
    $retour .= '<h3>Recherche</h3>
        <ul class="list_classique">
            <li id="ligneRechercheTableStaique" class="ligne_list_classique" table="'.$table.'">';
            foreach ($columnNames as $columnName) {
                if ($columnName != 'id') {
                    $retour .= generateColonneByType($tableStatique, $columnName, true);
                }
            }
        $retour .= '</li></ul>';
            
    
    $retour .= '
        <div id="newTableGenerique" class="bouton ajout" value="add" table="'.$table.'">Ajout '.$table.'</div>
        <h3>'.$table.'</h3>
        <ul id="contenu_table_statique" class="list_classique">';
    $retour .= generateContenuTableStatique($table, $tableStatique, $tableStatique->findAll());
    $retour .= '</ul>';
    $retour .= generateFormulaireByTable($tableStatique, $columnNames);
    return $retour;
}

function generateContenuTableStatique($table, $tableStatique, $search) {
    $retour = '';
    $i = 0;
    foreach ($search as $ligne) {
        $ligneData = $ligne->getData();
        $retour .= '<li class="ligne_list_classique">';
        foreach ($ligneData as $attribut) {
            if (array_search($attribut, $ligneData) != 'id') {
                $retour .= generateColonneByType($tableStatique, array_search($attribut, $ligneData), false, $attribut, true);
            }
        }
        $retour .= '<span class="delete_ligne droite" table="'.$table.'" idLigne="'.$ligne->id.'"></span><span class="edit_ligne droite" table="'.$table.'" idLigne="'.$ligne->id.'"></span></li>';
    }
    return $retour;
}

/*
 * AJOUTER EGALEMENT LA GESTION DES COMBOBOX SUR LES COLONNEs AYANT LEUR NOM COMMENCANT PAR ID (a voir si utile)
 */
function generateColonneByType($table, $columnName, $recherche=false, $attribut=null, $disabled=false) {
    $retour = '';
    $disabled = $disabled ? 'disabled' : '';
    $recherche = $recherche ? 'rechercheTableStatique' : '';
    $type = $table->getTypeOfColumn($columnName);
    switch ($type) {
        case 'string':
            $retour .= '
            <div class="colonne">
                <span class="attribut">'.$columnName.' : </span>
                <span><input class="contour_field input_char '.$recherche.'" type="text" columnName='.$columnName.' value="'.$attribut.'"'.$disabled.'/></span>
            </div>';
            break;
        case 'float' :
        case 'integer' :
            $retour .= '
            <div class="colonne">
                <span class="attribut">'.$columnName.' :</span>
                <span><input type="text" class="contour_field input_num" columnName='.$columnName.' value="'.$attribut.'"'.$disabled.'/></span>
            </div>';
            break;
        case 'boolean' :
            $retour .='
                <div class="colonne">
                    <span class="attribut">'.$columnName.' : </span>';
            if($attribut != null && $attribut == 1) {
                $retour .= '<span class="checkbox checkbox_active" value="1"'.$disabled.'></span></div>';
            } else {
                $retour .= '<span class="checkbox" value="0"'.$disabled.'></span></div>';
            };
            break;
    }
    return $retour;
}

function generateFormulaireByTable($table, $columnNames) {
    $retour = '';
    $retour .= '
    <div class="formulaire" action="edit_ligne">
            <h2>'.$table->getTableName().'</h2>
            <div class="colonne_droite">';
    foreach ($columnNames as $columnName) {
        if ($columnName != 'id') {
            $type = $table->getTypeOfColumn($columnName);
            switch ($type) {
                case 'float' :
                case 'string' :
                case 'integer' :
                    $retour .= '
                    <div class="input_text" columnName='.$columnName.'>
                        <input class="contour_field" type="text" title="'.$columnName.'" placeholder="'.$columnName.'">
                    </div>';
                    break;
                case 'boolean' :
                    $retour .='
                    <div columnName='.$columnName.'>
                        <span class="attribut">'.$columnName.' : </span>
                        <span class="checkbox" value="0"></span>
                    </div>';
                    break;
            };

        }
    }
    $retour .= '
            <div class="sauvegarder_annuler">
                <div class="bouton modif" value="saveTableStatique">Enregistrer</div>
                <div class="bouton classique" value="cancel">Annuler</div>
            </div>
        </div>
    </div>';
    return $retour;
}

function updateTableStatique() {
    include_once('./lib/config.php');
    $table = $_POST['table'];
    $tableStatique = Doctrine_Core::getTable($table);
    $columnNames = $tableStatique->getColumnNames();
    if (isset($_POST['idLigne'])) {
        $idLigne = $_POST['idLigne'];
        $ligne = $tableStatique->find($idLigne);
    
        foreach ($columnNames as $columnName) {
            if ($columnName != 'id') {
                $ligne->$columnName = $_POST[$columnName];
            }
        }
        $ligne->save();
    } else {
        $object = new $table();
        foreach ($columnNames as $columnName) {
            if ($columnName != 'id') {
                $object->$columnName = $_POST[$columnName];
            }
        }
        $object->save();
    }
    echo generateEcranStatique($table);
}

function deleteTableStatique() {
    include_once('./lib/config.php');
    $ligne = Doctrine_Core::getTable($_POST['table'])->find($_POST['idLigne']);
    $ligne->delete();
    echo generateEcranStatique($_POST['table']);
}


/*
 * La recherche n'inclus pour el moment seulement les champs text, float et int (pas les combo et pas les checkbox)
 */
function searchTableStatique() {
    include_once('./lib/config.php');
    $table = $_POST['table'];
    $tableStatique = Doctrine_Core::getTable($table);
    $columnNames = $tableStatique->getColumnNames();
    $req = '';
    $param = array();
    $premierPassage = true;
    foreach ($columnNames as $columnName) {
        if ($columnName != 'id') {
            $req .= $premierPassage ? $columnName.' like ? ' : 'and '.$columnName.' like ? ';
            $param[] = $_POST[$columnName].'%';
            $premierPassage = false;
        }
    }
    $search = $tableStatique->findByDql($req, $param);
    echo generateContenuTableStatique($table, $tableStatique, $search);
}
?>
