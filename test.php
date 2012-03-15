<?php

include_once('./lib/config.php');
$actions = Doctrine_Core::getTable('action')->findByIdIndividu(1);
foreach($actions as $action) {
    echo $action->id;
}
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
//        <ul id="membre_foyer_list">';
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
