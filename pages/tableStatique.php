<?php

//TODO marche pas avec bailleur et instruct
function comboTableStatique() {
    $retour = '
        <div class="select classique court" role="select_table_statique">
            <div id="choixTableStatique" class="option" value="bailleur">Bailleurs</div>
            <div class="fleche_bas"> </div>
        </div>
        <ul class="select_table_statique">
            <li>
                <div table="bailleur">Bailleurs</div>
            </li>
            <li>
                <div table="decideur">Decideurs</div>
            </li>
            <li>
                <div table="etude">Etudes</div>
            </li>
            <li>
                <div table="instruct">Instructeurs</div>
            </li>
            <li>
                <div table="lienfamille">Liens familiaux</div>
            </li>
            <li>
                <div table="nationalite">Nationalites</div>
            </li>
            <li>
                <div table="organisme">Organismes</div>
            </li>
            <li>
                <div table="profession">Professions</div>
            </li>
            <li>
                <div table="rue">Rues</div>
            </li>
            <li>
                <div table="secteur">Secteurs</div>
            </li>
            <li>
                <div table="situationfamiliale">Situations familiales</div>
            </li>
            <li>
                <div table="situationmatri">Situations matrimoniales</div>
            </li>
            <li>
                <div table="type">Types</div>
            </li>
            <li>
                <div table="ville">Villes</div>
            </li> 
        </ul>';
    $retour .= generateEcranStatiqueEnTab('bailleur');
    return $retour;
}

function generateEcranStatique($table) {
    $tableStatique = Doctrine_Core::getTable($table);

    $columnNames = $tableStatique->getColumnNames();
//    echo $table->getTypeOfColumn($columnName);

    $retour = '<div id="tableStatique">';
    $retour .= '<h3>Recherche</h3>
        <ul class="list_classique">
            <li id="ligneRechercheTableStatique" class="ligne_list_classique" table="'.$table.'">';
            foreach ($columnNames as $columnName) {
                if ($columnName != 'id') {
                    $retour .= generateColonneByType($tableStatique, $columnName, true);
                }
            }
        $retour .= '</li></ul>';
            
    
    $retour .= '
        <div id="newTableGenerique" class="bouton ajout" value="add" table="'.$table.'">
            <i class="icon-add"></i>
            <span>Ajout '.$table.'</span>
        </div>
        <h3>'.$table.'</h3>
        <ul id="contenu_table_statique" class="list_classique">';
    $retour .= generateContenuTableStatique($table, $tableStatique, $tableStatique->findAll());
    $retour .= '</ul>';
    $retour .= generateFormulaireByTable($tableStatique, $columnNames);
    $retour .= '</div>';
    return $retour;
}

function generateContenuTableStatique($table, $tableStatique, $search) {
    $retour = '';
    $i = 0;
    foreach ($search as $ligne) {
        $ligneData = $ligne->getData();
        $arrayKey = array_keys($ligneData);
        $u = 0;
        $retour .= '<li class="ligne_list_classique">';
        foreach ($ligneData as $attribut) {
            if ($arrayKey[$u] != 'id') {
                $retour .= generateColonneByType($tableStatique, $arrayKey[$u], false, $attribut, true);
            }
            $u++;
        }
        $retour .= '<span class="delete_ligne droite" table="'.$table.'" idLigne="'.$ligne->id.'"></span><span class="edit_ligne droite" table="'.$table.'" idLigne="'.$ligne->id.'"></span></li>';
        $i++;
    }
    return $retour;
}

/*
 * AJOUTER EGALEMENT LA GESTION DES COMBOBOX SUR LES COLONNEs AYANT LEUR NOM COMMENCANT PAR ID (a voir si utile)
 */
function generateColonneByType($table, $columnName, $recherche=false, $attribut=null, $disabled=false) {
    $columnName = strtolower($columnName);
    $retour = '';
    $disabled = $disabled ? 'disabled' : '';
    $recherche = $recherche ? 'rechercheTableStatique' : '';
    $type = $table->getTypeOfColumn($columnName);
    switch ($type) {
        case 'string':
            $cantBeNull = $table->getColumnDefinition($columnName);
            $cantBeNull['notnull'] == 1 ? $class = 'requis' : $class = '';
            $retour .= '
            <div class="colonne">
                <span class="attribut">'.$columnName.' : </span>
                <span><input class="contour_field input_char '.$recherche.' '.$class.'" type="text" columnName='.$columnName.' value="'.$attribut.'"'.$disabled.'/></span>
            </div>';
            break;
        case 'float' :
        case 'integer' :
            if (preg_match('#^id[a-zA-Z]+#', $columnName)) {
                $columnName = substr($columnName, 2);
                $retour .= '
                <div class="colonne">
                    <span class="attribut">'.$columnName.' :</span>
                    <span><input type="text" class="contour_field input_char autoComplete" id="'.$columnName.'" table="'.$columnName.'" champ="libelle" value="'.$attribut.'"'.$disabled.'/></span>
                </div>';        
            } else {
                $cantBeNull = $table->getColumnDefinition($columnName);
                $cantBeNull['notnull'] == 1 ? $class = 'requis' : $class = '';
                $retour .= '
                <div class="colonne">
                    <span class="attribut">'.$columnName.' :</span>
                    <span><input type="text" class="contour_field input_num '.$class.'" columnName='.$columnName.' value="'.$attribut.'"'.$disabled.'/></span>
                </div>';
            }
            
            break;
        case 'boolean' :
            $retour .='
                <div class="colonne">
                    <span class="attribut">'.$columnName.' : </span>';
            if($attribut != null && $attribut == 1) {
                $retour .= '<span class="checkbox checkbox_active" value="1" columnName='.$columnName.' '.$disabled.'></span></div>';
            } else {
                $retour .= '<span class="checkbox" value="0" columnName='.$columnName.' '.$disabled.'></span></div>';
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
                    if (preg_match('#^id[a-zA-Z]+#', $columnName)) {
                        $columnNameId = $columnName;
                        $columnName = substr($columnName, 2);
                        $retour .= '
                        <div class="select classique" columnName='.$columnNameId.' role="select_'.$columnName.'">
                            <div class="option requis">------</div>
                            <div class="fleche_bas"></div>
                        </div>';
                        $cleEtrangere = Doctrine_Core::getTable($columnName)->findAll();
                        $retour .= '<ul class="select_'.$columnName.'">';
                        foreach($cleEtrangere as $cle) {
                        $retour .= '<li>
                                <div value="'.$cle->id.'">'.$cle->libelle.'</div>
                           </li>';
                        }
                        $retour .= '</ul>';
                    } else {
                        $cantBeNull = $table->getColumnDefinition($columnName);
                        $cantBeNull['notnull'] == 1 ? $class = 'requis' : $class = '';
                        $retour .= '
                        <div class="input_text" columnName='.$columnName.'>
                            <input class="contour_field '.$class.'" type="text" title="'.$columnName.'" placeholder="'.$columnName.'">
                        </div>';
                    }
                    break;
                case 'boolean' :
                    $retour .='
                    <div columnName='.$columnName.'>
                        <span class="checkbox" value="0"></span>
                        <span class="attribut">'.$columnName.'</span>
                    </div>';
                    break;
            };

        }
    }
    $retour .= '
            <div class="sauvegarder_annuler">
                <div value="saveTableStatique" class="bouton modif">
                    <i class="icon-save"></i>
                    <span>Enregistrer</span>
                </div>
                <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                </div>
            </div>
        </div>
    </div>';
    return $retour;
}




function generateEcranStatiqueEnTab($table) {
    $tableStatique = Doctrine_Core::getTable($table);

    $columnNames = $tableStatique->getColumnNames();
//    echo $table->getTypeOfColumn($columnName);

    $retour = '<div id="tableStatique">';
    $retour .= '<h3>Recherche</h3>
        <ul class="list_classique">
            <li id="ligneRechercheTableStatique" class="ligne_list_classique" table="'.$table.'">';
            foreach ($columnNames as $columnName) {
                if ($columnName != 'id') {
                    $retour .= generateColonneByType($tableStatique, $columnName, true);
                }
            }
        $retour .= '</li></ul>';
            
    
    $retour .= '
        <div id="newTableGenerique" class="bouton ajout" value="add" table="'.$table.'">
            <i class="icon-add"></i>
            <span>Ajout '.$table.'</span>
        </div>
        <h3>'.$table.'</h3>';
    $retour .= '
        <div class="bubble tableau_classique_wrapper">
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">';
                        foreach ($columnNames as $columnName) {
                            if ($columnName != 'id') {
                                if (preg_match('#^id[a-zA-Z]+#', $columnName)) {
                                    $columnName = substr($columnName, 2);
                                }
                                $retour .= '<th>'.$columnName.'</th>';
                            }
                        }
            $retour .= '<th></th>
                        <th></th>
                    </tr>
                </thead><tbody id="contenu_table_statique">';
    $retour .= generateContenuTableStatiqueEnTab($table, $tableStatique, $tableStatique->findAll());
    $retour .= '</tbody></table></div>';
    $retour .= generateFormulaireByTable($tableStatique, $columnNames);
    $retour .= '</div>';
    return $retour;
}

function generateContenuTableStatiqueEnTab($table, $tableStatique, $search) {
    $retour = '';
    $i = 0;
    foreach ($search as $ligne) {
        $ligneData = $ligne->getData();
        $arrayKey = array_keys($ligneData);
        $u = 0;
        $i%2 ? $retour .= '<tr>' : $retour .= '<tr class="alt">';
        foreach ($ligneData as $attribut) {
            if ($arrayKey[$u] != 'id') {
                $retour .= generateColonneByTypeEntab($tableStatique, $arrayKey[$u], false, $attribut, true);
            }
            $u++;
        }
        $retour .= '<td class="icon"><span class="edit_ligne" table="'.$table.'" idLigne="'.$ligne->id.'"></span></td>
                    <td class="icon"><span class="delete_ligne" table="'.$table.'" idLigne="'.$ligne->id.'"></span></td>
                </tr>';
        $i++;
    }
    return $retour;
}

/*
 * AJOUTER EGALEMENT LA GESTION DES COMBOBOX SUR LES COLONNEs AYANT LEUR NOM COMMENCANT PAR ID (a voir si utile)
 */
function generateColonneByTypeEnTab($table, $columnName, $recherche=false, $attribut=null, $disabled=false) {
    $columnName = strtolower($columnName);
    $retour = '';
    $disabled = $disabled ? 'disabled' : '';
    $recherche = $recherche ? 'rechercheTableStatique' : '';
    $type = $table->getTypeOfColumn($columnName);
    switch ($type) {
        case 'string':
            $retour .= '<td class="'.$recherche.'" columnName='.$columnName.'>'.$attribut.'</td>';
            break;
        case 'float' :
        case 'integer' :
                if (preg_match('#^id[a-zA-Z]+#', $columnName)) {
                    $columnNameId = $columnName;
                    $columnName = substr($columnName, 2);
                    if ($attribut != 0) {
                        $cleEtrangere = Doctrine_Core::getTable($columnName)->findOneBy("id", $attribut);
                        $retour .= '<td columnName='.$columnNameId.' idCleEtrangere='.$cleEtrangere->id.'>'.$cleEtrangere->libelle.'</td>';
                    } else {
                        $retour .= '<td columnName='.$columnNameId.'></td>';
                    }
                } else {
                    $retour .= '<td columnName='.$columnName.'>'.$attribut.'</td>';
                }
            break;
        case 'boolean' :
            $retour .= '<td>';
            if($attribut != null && $attribut == 1) {
                $retour .= '<span class="checkbox checkbox_active" value="1" columnName='.$columnName.' '.$disabled.'></span></div>';
            } else {
                $retour .= '<span class="checkbox" value="0" columnName='.$columnName.' '.$disabled.'></span></td>';
            };
            break;
    }
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
//    echo generateEcranStatiqueEnTab($table);
}

function deleteTableStatique() {
    include_once('./lib/config.php');
    $ligne = Doctrine_Core::getTable($_POST['table'])->find($_POST['idLigne']);
    $ligne->delete();
//    echo generateEcranStatiqueEnTab($_POST['table']);
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
    echo generateContenuTableStatiqueEntab($table, $tableStatique, $search);
}
?>
