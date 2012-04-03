<?php

function graphNewUsager() {
    include_once('./lib/config.php');
    $mois = array ('1' => 'Janvier', '2' => 'Fevrier', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août', '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Decembre');
    $foyers = Doctrine_Core::getTable('foyer')->findAll();
    $arrayCreation = array();
    $result = array();
    foreach($foyers as $foyer) {
        $arrayCreation[] = $foyer->dateInscription;
    }
    $result = getAnneeAndMois($arrayCreation);
    $retour = '<h3>Nombre de nouveaux usagers</h3>
        <div class="colonne">
            <ul>';

    for($i=0; $i < count($result['year']); $i++) {
        $retour .= '<li>Annee : '.$result['year'][$i].' : '.$result['total'][$result['year'][$i]].'</li>';
    }
        $retour .= '
            </ul>
        </div>';
        $retour .= '
            <div class="colonne">
                <ul>';
        for($u=0; $u < count($result['month']); $u++) {
            $retour .= '<li>Mois : '.$mois[$result['month'][$u]].' : '.$result['total'][$result['month'][$u]].'</li>';
        }
        $retour .= '
                </ul>
            </div>
            <div class="colonne">
                <table id="graphNewUsager" class="hide">
                    <caption>R&eacute;partition des nouveaux usagers en '.date('Y').'</caption>
                    <thead>
                        <tr>
                            <td></td>';
        for($u=0; $u < count($result['month']); $u++) {
            $retour .= '<th scope="col">'.$mois[$result['month'][$u]].'</th>';
        }
$retour .= '
                        </tr>
	</thead>
	<tbody>
                        <tr>
                            <th scope="row">Nombre de nouveaux usagers</th>';
 for($u=0; $u < count($result['month']); $u++) {
            $retour .= '<td>'.$result['total'][$result['month'][$u]].'</td>';
        }
$retour .= '</tr>		
	</tbody>
            </table>
        </div>
        ';
return $retour;
}

function graphTypeAction() {
    include_once('./lib/config.php');
    $retour = '';
    $tab = array();
    $actions = Doctrine_Core::getTable('action')->findAll();
    foreach($actions as $action) {
        if(!array_key_exists($action->typeaction->libelle, $tab)) {
            $tab[$action->typeaction->libelle] = 1;
        } else {
            $tab[$action->typeaction->libelle] += 1;
        }
    }
    $retour = '<h3>Type action</h3>
        <table id="graphTypeAction" class="hide">
                    <caption>Nombre et type d\'action</caption>
                    <thead>
                        <tr>
                            <td></td>';
    foreach($tab as $key => $value) {
        $retour .= '<th scope="col">'.$key.'</th>';
    }
    $retour .= '</tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nombre et typos action</th>';
    foreach($tab as $key => $value) {
        $retour .= '<td>'.$value.'</td>';
    }
    $retour .= '</tr>
                    </tbody>
                </table>';
    return $retour;
    
}

function graphTypeAide() {
    include_once('./lib/config.php');
    $retour = '';
    
    $aidesExternes = Doctrine_Core::getTable('aideexterne')->findAll();
    $aidesInternes = Doctrine_Core::getTable('aideinterne')->findAll();
    $retour = '<h3>Type d\'aide</h3>
        <table id="graphTypeAide" class="hide">
                    <caption>Type d\'aide</caption>
                    <thead>
                        <tr>
                            <td></td>
                                <th scope="col">Aides Internes</th>
                                <th scope="col">Aides Externes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Type d\'aide</th>';
    $retour .= '<td>'.count($aidesInternes).'</td>';
    $retour .= '<td>'.count($aidesExternes).'</td>';
    $retour .= '</tr>
                    </tbody>
                </table>';
    return $retour;
    
}
?>
