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
                <table id="newusager" class="hide">
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
?>
