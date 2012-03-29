<?php

include_once('./lib/config.php');
//$q = Doctrine_Query::create()
//                ->from('depense')
//                ->where('datecreation < ?', 1333007766)
//                ->orderBy('datecreation DESC')
//                ->fetchOne();
//        
//        echo $q->id;

$credits = Doctrine_Core::getTable('credit')->findByIdIndividu(6332);

if(!isset($credits->id)) {
    echo "ok";
}
//    require('./lib/fpdf.php');
//    $pdf = new FPDF();
//    $pdf->AddPage();
//    $pdf->SetFont('times','B',12);
//    $pdf->Cell(500,10,'CENTRE COMMUNAL D\'ACTION SOCIALE DE HAYANGE', 0, 0);
//    $pdf->Output();
//$table = 'bailleur';
//$tableStatique = Doctrine_Core::getTable($table);
//$fla = $tableStatique->find(1);
//$test = $fla->getData();
//$arrayKey = array_keys($test);
//echo $tableStatique->getTypeOfColumn(strtolower($arrayKey[1]));
//$columnNames = $tableStatique->getColumnNames();
//foreach ($columnNames as $columnName) {
//    $type = $tableStatique->getTypeOfColumn($columnName);
//    echo $columnName .' '. $type .'</br>';
//}

//include_once('./pages/tableStatique.php');
//
//$retour = '';
//    $i = 0;
//    foreach ($search as $ligne) {
//        $ligneData = $ligne->getData();
//        $arrayKey = array_keys($ligneData);
//        $u = 0;
//        $retour .= '<li class="ligne_list_classique">';
//        foreach ($ligneData as $attribut) {
//            
//            $type = $tableStatique->getTypeOfColumn($arrayKey[$u]);
//            $retour.= 'NUMERO: '.$u.' '.$arrayKey[$u].' : '.$attribut.' type= '.$type.' ';
//            if ($arrayKey[$u] != 'id') {
//                $retour.= ' != id ';
//                $retour .= generateColonneByType($tableStatique, $arrayKey[$u], false, $attribut, true);
//            }
//            $u++;
//        }
//        $retour .= '<span class="delete_ligne droite" table="'.$table.'" idLigne="'.$ligne->id.'"></span><span class="edit_ligne droite" table="'.$table.'" idLigne="'.$ligne->id.'"></span></li>';
//        $i++;
//    }
//    echo $retour;

//$req = 'libelle LIKE ? and cp LIKE ? ';
//$array = array();
//
//$array[] = "%te%";
//$array[] = "%%";
//
//$test = '999999';
//$test2 = 'test';
//$villes = Doctrine_Core::getTable('ville')->findByDql($req, $array);
//
//foreach($villes as $ville) {
//    echo $ville->id.'</br>';
//}

//$actions = Doctrine_Core::getTable('action')->findByIdIndividu(1);
//foreach($actions as $action) {
//    echo $action->id;
//}
//$foyers = Doctrine_Core::getTable('foyer')->findAll();
//$arrayCreation = array();
//$result = array();
//foreach($foyers as $foyer) {
//    $arrayCreation[] = $foyer->dateInscription;
//}
////print_r($arrayCreation);
//$result = getAnneeAndMois($arrayCreation);
//print_r($result['year']);
//echo '<br />';
//print_r($result['month']);
//echo '<br />';
//print_r($result['total']);

//$mdp = 'florian';
//echo md5($mdp);


//echo generateEcranStatique('ville');
//
//function generateEcranStatique($table) {
//    $tableStatique = Doctrine_Core::getTable($table)->findAll();
//    $retour = '<h3>'.$table.'</h3>
//        <div id="newIndividu" class="bouton ajout" value="add">Ajouter un individu</div>
//        <div class="bouton modif update" value="updateMembreFoyer">Enregistrer</div>
//        <ul>';
//    
//    $i = 0;
//    foreach ($tableStatique as $ligne) {
//        $ligneData = $ligne->getData();
//        $retour .= '<li>';
//        foreach ($ligneData as $attribut) {
//            if (array_search($attribut, $ligneData) != 'id') {
//                $retour .= '
//                    <div class="colonne">
//                        <span class="attribut">'.array_search($attribut, $ligneData).' : </span>
//                        <span><input class="contour_field input_num" type="text" value="'.$attribut.'"/></span>
//                    </div>';
//            }
//        }
//        $retour .= '</li>';
//    }
//    $retour .= '</ul>';
//    return $retour;
//}


//$tableStatique = Doctrine_Core::getTable('ville')->findAll();
//$i = 0;
//foreach ($tableStatique as $ligne) {
//   $u = 0;
//   $test = $ligne->getData();
//   $array = array_keys($test);
//   echo 'ligne numero : '.$i ;
//   foreach ($test as $l) {
//       echo '<div>Cle :'.$array[$u].' | valeur : '.$l.'</div>';
//       $u++;
//   }
//   $i++;
//}


//$individu = Doctrine_Core::getTable('ville')->find(1);
//$table = Doctrine_Core::getTable('ville');
//$className = 'ville';
//$ville = new $className();
//$table->getTableName();
//foreach ($table->getColumnNames() as $columnName) {
//    echo $table->getTypeOfColumn($columnName).' ';
////    echo $colonne->get;
//}
//print_r($colonnes->type);

?>
