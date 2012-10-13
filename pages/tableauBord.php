<?php
function tableauBord() {
    $retour = '';
    $retour .= graphNewUsager();
    $retour .= '<br /><br />';
    $retour .= graphTypeAction();
    $retour .= '<br /><br />';
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
    
    $retour = '<div id="graphNewUsager" style="height:250px;width:820px; "></div>';
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
    $limite = mktime(0, 0, 0, 1, 1, date('Y'));
    $actions = Doctrine_Core::getTable('action')->getActionAfter($limite)->execute();
    $retour = '';
    if(count($actions) > 0) {
        foreach ($actions as $action) {
            if (!array_key_exists($action->typeaction->libelle, $tab)) {
                $tab[$action->typeaction->libelle] = 1;
            } else {
                $tab[$action->typeaction->libelle] += 1;
            }
        }
        arsort($tab);
        $x = '[';
        $s1 = '[';
        $i = 0;
        foreach($tab as $key => $value) {
            $trouve = false;
            $u = 8; // On recherche un espace vide a partir du 8e caractere
            if($i < 12) { // On ressort les 12 dernieres qctions
                if (strlen($key) > 15) { // Si taille de la key > 12 caractere
                    while (!$trouve && $u < strlen($key)) {
                        if ($key[$u] != ' ') {
                            $u++;
                        } else {
                            $key = substr_replace($key, "<br />", $u, 0);
                            $trouve = true;
                        }
                    }
                }
                $x = $x.'"'.$key.'", ';
                $s1 = $s1.''.$value.', ';
                $i++;
            }
        }

        $x = substr($x, 0, strlen($x)-2);
        $s1 = substr($s1, 0, strlen($s1)-2);
        $x[strlen($x)] = ']';
        $s1[strlen($s1)] = ']';
        
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_ACCES_GRAPH_INSTRUCT)) {
            // On liste les instruct interne actif
            $instructs = Doctrine_Core::getTable('instruct')->findByInterne(1);
            $retour .= '
                <div class="select classique court" role="select_graph_instruct">
                    <div id="graphByInstruct" class="option" value=" ">-----</div>  
                    <div class="fleche_bas"> </div>
                </div>';
            $retour .= '<ul class="select_graph_instruct">';      
            foreach($instructs as $instruct) {
                $retour .= '<li>
                                        <div value="'.$instruct->id.'">'.$instruct->nom.'</div>
                                   </li>';
            }
            $retour .= '</ul>';
        }
        
        
        $retour .= '<div id="graphTypeAction" style="height:250px;width:820px; "></div>';
            $retour .= "
            <script type='text/javascript'>
                var s1 = ".$s1.";
            var ticks = ".$x.";

            plot2 = $.jqplot('graphTypeAction', [s1], {
                title: 'Répartition des actions par année',
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
    }
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
        $i = 10;
        if(strlen($t['libelle']) > 15) {
            while(!$trouve && $i < strlen($t['libelle'])) {
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
        $interne = $t['total'] - $t['externe'];
        $s1 = $s1.''.$interne.', ';
        $s2 = $s2.''.$t['externe'].', ';
    }
    

    $x = substr($x, 0, strlen($x)-2);
    $s1 = substr($s1, 0, strlen($s1)-2);
    $s2 = substr($s2, 0, strlen($s2)-2);
    $x[strlen($x)] = ']';
    $s1[strlen($s1)] = ']';
    $s2[strlen($s2)] = ']';
    $retour = '<div id="graphTypeAideInterne" style="height:250px;width:820px; "></div>';
    $retour .= "
     <script type='text/javascript'>
        var s1 = ".$s1.";
        var s2 = ".$s2.";
        var ticks = ".$x.";

    plot2 = $.jqplot('graphTypeAideInterne', [s1, s2], {
        title: 'Répartition des aides internes les plus demandés',
        seriesDefaults: {
            renderer:$.jqplot.BarRenderer,
            pointLabels: { show: true }
        },
        series:[
            {label:'Instructeur Interne'},
            {label:'Instructeur Externe'}
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
    return $retour;
}

function getDataGraphIntruct($idInstruct) {
    include_once('./lib/config.php');
    $tab = array();
    $instruct = Doctrine_Core::getTable('instruct')->find($idInstruct);
    $limite = mktime(0, 0, 0, 1, 1, date('Y'));
    $actions = Doctrine_Core::getTable('action')->getActionByInstructAfter($limite, $idInstruct)->execute();
    $retour = '';
    if(count($actions) > 0) {
        foreach ($actions as $action) {
            if (!array_key_exists($action->typeaction->libelle, $tab)) {
                $tab[$action->typeaction->libelle] = 1;
            } else {
                $tab[$action->typeaction->libelle] += 1;
            }
        }
        arsort($tab);
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
                title: 'Répartition des actions de <b>".$instruct->nom."</b> par année',
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
    }
   echo $retour;
}

function getDataGraphAideInterne() {
    include_once('./lib/config.php');
    $limite = mktime(0, 0, 0, 1, 1, date('Y'));
    $con = Doctrine_Manager::getInstance()->connection();
    $con->execute("CREATE TEMPORARY TABLE h(
					libelle VARCHAR(40) NOT NULL,
					total int(6) NOT NULL);

					INSERT INTO h 
					SELECT distinct(t.libelle), count(*) total
					FROM aideinterne ai
					INNER JOIN instruct i on i.id = ai.idinstruct
                                                                                          LEFT JOIN type t on t.id = ai.idaidedemandee
                                                                                          WHERE ai.datedemande > ".$limite."
					GROUP BY t.libelle;");

    $con->execute("CREATE TEMPORARY TABLE f(
                                    libelle VARCHAR(40) NOT NULL,
                                    externe int(6) NOT NULL);

                                    INSERT INTO f
                                    SELECT distinct(t.libelle), count(*) externe
                                    FROM aideinterne ai
                                    INNER JOIN type t on t.id = ai.idaidedemandee
                                    INNER JOIN instruct i on i.id = ai.idinstruct
                                    WHERE i.interne = 0
                                    AND ai.datedemande > ".$limite."
                                    GROUP BY t.libelle;");

	$st = $con->execute("SELECT h.libelle libelle, IF(h.total <> '', h.total, '0') total, IF(f.externe <> '', f.externe, '0') externe
						FROM h
						LEFT JOIN f on f.libelle = h.libelle
						ORDER BY h.total DESC
						LIMIT 6");
	
    $result = $st->fetchAll();
	
	//DELETE TEMP TABLE
	$con->execute("Drop Table h;");
	$con->execute("Drop Table f;");
	
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

/*
 * Function qui permet le switch de graph action par instruct
 */
function changeGraphInstruct() {
    $retour = getDataGraphIntruct($_POST['id']);
    echo $retour;
}
?>
