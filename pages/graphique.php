<?php
function tableauBord() {
    $retour = '<h2>Tableau de bord</h2>';
    $retour .= graphNewUsager();
    $retour .= graphTypeAction();
    $retour .= graphTypeAideInterne();
    return $retour;
}

function graphNewUsager() {
    include_once('./lib/config.php');
    $mois = array('1' => 'Janvier', '2' => 'Fevrier', '3' => 'Mars', '4' => 'Avril', '5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Ao&ucirc;t', '9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Decembre');
    $tab = getLastYear(); // On charge le tableau trié
    $s1 = '[';
    $x = '[';
        
   while($year = current($tab)) {
       while($month = current($year)) {
           $x = $x.'"'.$mois[key($year)].'", ';
           $s1 = $s1.''.$month.', ';
           next($year);
       }
       next($tab);
}
    $x = substr($x, 0, strlen($x)-2);
    $s1 = substr($s1, 0, strlen($s1)-2);
    $x[strlen($x)] = ']';
    $s1[strlen($s1)] = ']';
    
    $retour = '<div id="graphNewUsager" style="height:250px;width:800px; "></div>';
        $retour .= "
         <script type='text/javascript'>
            var s1 = ".$s1.";
        var ticks = ".$x.";
         
        plot2 = $.jqplot('graphNewUsager', [s1], {
            title: 'Répartition annuelle des nouveaux foyers',
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            }
        });
         </script>";
//    $retour = '<div class="colonne">
//            <ul>';
//
//    for($i=0; $i < count($result['year']); $i++) {
//        $retour .= '<li>'.$result['year'][$i].' : '.$result['total'][$result['year'][$i]].'</li>';
//    }
//        $retour .= '
//            </ul>';
//        $retour .= '
//                <ul>';
//        for($u=0; $u < count($result['month']); $u++) {
//            $retour .= '<li>'.$mois[$result['month'][$u]].' : '.$result['total'][$result['month'][$u]].'</li>';
//        }
//        $retour .= '
//                </ul>
//    $retour .= '
//            <div class="colonne">
//                <table id="graphNewUsager" class="hide">
//                    <caption>Répartition des nouveaux usagers en ' . date('Y') . '</caption>
//                    <thead>
//                        <tr>
//                            <td></td>';
//    for ($u = 0; $u < count($result['month']); $u++) {
//        $retour .= '<th scope="col">' . $mois[$result['month'][$u]] . '</th>';
//    }
//    $retour .= '
//                        </tr>
//	</thead>
//	<tbody>
//                        <tr>
//                            <th scope="row">Nombre de nouveaux usagers</th>';
//    for ($u = 0; $u < count($result['month']); $u++) {
//        $retour .= '<td>' . $result['total'][$result['month'][$u]] . '</td>';
//    }
//    $retour .= '</tr>		
//	</tbody>
//            </table>
//        </div>';
    return $retour;
}

function graphTypeAction() {
    include_once('./lib/config.php');
    $tab = array();
    $actions = Doctrine_Core::getTable('action')->findAll();
    foreach ($actions as $action) {
        if (!array_key_exists($action->typeaction->libelle, $tab)) {
            $tab[$action->typeaction->libelle] = 1;
        } else {
            $tab[$action->typeaction->libelle] += 1;
        }
    }
    $x = '[';
    $s1 = '[';
    $i = 0;
    foreach($tab as $key => $value) {
        if($i < 12) {
            $x = $x.'"'.$key.'", ';
            $s1 = $s1.''.$value.', ';
            $i++;
        }
    }

    $x = substr($x, 0, strlen($x)-2);
    $s1 = substr($s1, 0, strlen($s1)-2);
    $x[strlen($x)] = ']';
    $s1[strlen($s1)] = ']';

    $retour = '<div id="graphTypeAction" style="height:250px;width:800px; "></div>';
        $retour .= "
         <script type='text/javascript'>
            var s1 = ".$s1.";
        var ticks = ".$x.";
         
        plot2 = $.jqplot('graphTypeAction', [s1], {
            title: 'Répartition des actions les plus utilisés',
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            }
        });
         </script>";
//    $retour = '
//        <table id="graphTypeAction" class="hide">
//                    <caption>Nombre et type d\'action</caption>
//                    <thead>
//                        <tr>
//                            <td></td>';
//    foreach ($tab as $key => $value) {
//        $retour .= '<th scope="col">' . $key . '</th>';
//    }
//    $retour .= '</tr>
//                    </thead>
//                    <tbody>
//                        <tr>
//                            <th scope="row">Nombre et typos action</th>';
//    foreach ($tab as $key => $value) {
//        $retour .= '<td>' . $value . '</td>';
//    }
//    $retour .= '</tr>
//                    </tbody>
//                </table>';
    return $retour;
}

function graphTypeAideInterne() {
    include_once('./lib/config.php');
    $tab = getDataGraphAideInterne();
    $s1 = '[';
    $s2 = '[';
    $x = '[';
    foreach($tab as $t) {
        $trouve = false;
        $i = 12;
        if(strlen($t['libelle']) > 15) {
            while(!$trouve) {
                if($t['libelle'][$i] != ' ') {
                    $i++;
                } else {
//                    $t['libelle'][$i] = '<br />';
                    $t['libelle'] = substr_replace($t['libelle'], "<br />", $i, 0);
                    $trouve = true;
                }
            }
        }
        $x = $x.'"'.$t['libelle'].'", ';
        $s1 = $s1.''.$t['homme'].', ';
        $s2 = $s2.''.$t['femme'].', ';
    }
    
    $x = substr($x, 0, strlen($x)-2);
    $s1 = substr($s1, 0, strlen($s1)-2);
    $s2 = substr($s2, 0, strlen($s2)-2);
    $x[strlen($x)] = ']';
    $s1[strlen($s1)] = ']';
    $s2[strlen($s2)] = ']';
    
    $retour = '<div id="graphTypeAideInterne" style="height:250px;width:800px; "></div>';
    $retour .= "
     <script type='text/javascript'>
        var s1 = ".$s1.";
        var s2 = ".$s2.";
        var ticks = ".$x.";

    plot2 = $.jqplot('graphTypeAideInterne', [s1, s2], {
        title: 'Répartition des aides les plus demandés, par sexe',
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true }
        },
        series:[
            {label:'Homme'},
            {label:'Femme'}
        ],
        legend: {
            show: true,
            placement: 'inside'
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            }
        },
    });
     </script>";
//    $retour = '';
//    $retour = '<div class="colonne">
//        <table id="graphTypeAide" class="hide">
//                    <caption>Type d\'aide</caption>
//                    <thead>
//                        <tr>
//                            <td></td>';
//    $i = 0;
//    foreach ($result as $key => $value) {
//        if ($i < 10) {
//            $retour .= '<th scope="col">' . $key . '</th>';
//            $i++;
//        }
//    }
//    $retour .= '
//                        </tr>
//                    </thead>
//                    <tbody>
//                        <tr>
//                            <th scope="row">Type d\'aide</th>';
//    $i = 0;
//    foreach ($result as $key => $value) {
//        if ($i < 10) {
//            $retour .= '<td>' . $value . '</td>';
//            $i++;
//        }
//    }
//    $retour .= '</tr>
//                    </tbody>
//                </table></div>';
    return $retour;
}

function getDataGraphAideInterne() {
    include_once('./lib/config.php');
    $tab = array();
//    $nbAide = Doctrine_Core::getTable('aideinterne')->findByIdAideDemandee($aide->id);
    $con = Doctrine_Manager::getInstance()->connection();
    $st = $con->execute("SELECT distinct(t.libelle), (SELECT count(*) FROM individu INNER JOIN aideinterne ai on ai.idindividu = individu.id INNER JOIN type ty on ty.id = ai.idaidedemandee WHERE sexe = 'Homme' AND ty.libelle = t.libelle) as homme, (SELECT count(*) FROM individu INNER JOIN aideinterne ai on ai.idindividu = individu.id INNER JOIN type ty on ty.id = ai.idaidedemandee WHERE sexe = 'Femme' AND ty.libelle = t.libelle) as femme
FROM aideinterne ai
INNER JOIN type t on t.id = ai.idaidedemandee
INNER JOIN individu i on i.id = ai.idindividu
ORDER BY homme+femme DESC
LIMIT 6");
    $result = $st->fetchAll();
//    $typeAides = Doctrine_Core::getTable('type')->findByCategorie(1); // Libellé aide interne
//    foreach ($typeAides as $aide) {
//        $nbAide = Doctrine_Core::getTable('aideinterne')->findByIdAideDemandee($aide->id);
//        $con = Doctrine_Manager::getInstance()->connection();
//        $st = $con->execute("SELECT count(*) as nbHomme FROM aideinterne ai INNER JOIN individu i on i.id=ai.idindividu WHERE i.sexe='Masculin'");
//        $result = $st->fetchAll();
//        if (count($nbAide) != 0) {
//            foreach($nbAide as $aide) {
//                if(!array_key_exists($typeAides->libelle, $tab)) {
//                    $tab[$typeAides->libelle]['Homme'] = 0;
//                    $tab[$typeAides->libelle]['Femme'] = 0;
//                }
//                if($aide->individu->sexe == 'Homme') {
//                    $tab[$typeAides->libelle]['Homme'] += 1;
//                } else {
//                    $tab[$typeAides->libelle]['Femme'] += 1;
//                }
//            }
//            
//        }
//    }
//        print_r($result[1]);
//    exit();
//    arsort($tab);
    return $result;
}

function getLastYear() {
    $tab = array();
    $now = time();
    $dateMax = $now - 31536000; // = 12 mois
    $con = Doctrine_Manager::getInstance()->connection();
    $st = $con->execute("SELECT * FROM foyer WHERE dateinscription > ".$dateMax);
    $result = $st->fetchAll();
    foreach($result as $foyer) {
        $date = explode('/', date('d/n/Y', $foyer['dateinscription']));
        if(!array_key_exists($date[2], $tab)) {
            $tab[$date[2]][$date[1]] = 1;
//            $tab[$date[2]][$date[1]] = 1; // J'intialise mon tableau ex : $tab[2012][4] = 1
//            arsort($tab);
        } elseif(!array_key_exists($date[1], $tab[$date[2]])) {
            $tab[$date[2]][$date[1]] = 1;
//            ksort($tab[$date[2]]);
        } else {
            $tab[$date[2]][$date[1]] += 1;
        }
    }
    return $tab;
    
}

function getLastYear2() {
    $now = time() - 36720000;
    $con = Doctrine_Manager::getInstance()->connection();
    $st = $con->execute("SELECT DATE_FORMAT(DATE_ADD('1970-01-01', INTERVAL dateinscription SECOND),  '%M' ) as month, count(dateinscription) as nb FROM foyer
WHERE dateinscription > ".$now." GROUP BY month");
    $result = $st->fetchAll();
    return $result;
}

?>
