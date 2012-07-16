<?php



function statistique() {

    $csp = Doctrine_Core::getTable('profession')->findAll();    
    
    $contenu ='<div class="colonne">
                   <div class="rounded_box" style="display: block; ">
                       <table cellpadding="0" cellspacing="0">
                           <thead>
                               <tr>
                                   <th class="role">Information souhaitée</th>
                               </tr>
                           </thead>
                           <tbody name="groupe1">
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbinscrit"> Nombre d\'inscrits</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbaide"> Nombre d\'aides demandées</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbaideurg"> Nombre d\'aides urgentes demandées</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbaideext"> Nombre d\'aides externes</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="montant"> Montants accordés</td>
                               </tr>

                           </tbody>
                       </table>
                   </div>
               </div>
               <div class="colonne">
                   <div class="rounded_box" style="display: block; ">
                       <table cellpadding="0" cellspacing="0">
                           <thead>
                               <tr>
                                   <th class="role">Par</th>
                               </tr>
                           </thead>
                           <tbody name="groupe2">
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="trancheage"> Tranche d\'&acirc;ge</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="csp"> Cat&eacute;gorie socioprofessionnelle</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="sexe"> Sexe</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="secteur"> Secteur</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="typefamille"> Type de famille</td>
                               </tr>
                          </tbody>
                       </table>
                   </div>
               </div>
               <div class="colonne">
                   <div class="rounded_box" style="display: block; ">
                       <table cellpadding="0" cellspacing="0">
                           <thead>
                               <tr>
                                   <th class="role">P&eacute;riode</th>
                               </tr>
                           </thead>
                           <tbody name="groupe3">
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="tout" checked> Tout</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="mois"> Mois</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="an"> Ann&eacute;e</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="periode"> P&eacute;riode donn&eacute;e</td>
                               </tr>
                           </tbody>
                       </table>
                   </div>
               </div>
               
               <div class="colonne">
                   <div id="periode_exacte">       
                   </div>
               </div>
               <div id="graph_stat">       
               </div>';
    
    return $contenu;
}

function genererStat() {
    include_once('./lib/config.php');
    $gp1 = $_POST['groupe1'];
    $gp2 = $_POST['groupe2'];
    $gp3 = $_POST['groupe3'];
    $dateDebut = explode('/', $_POST['datedebut']);
    $dateFin = explode('/', $_POST['datefin']);
    
    $select = 'SELECT';
    $from = ' FROM individu i';
    $join = '';
    $where = '';
    $wheresuite = '';
    $groupby = '';
    $orderby = ' ORDER BY';
    $titre = '';
    $finTitre = '';
    $nomColDate ='';
    $joinFoyer = false;
    

    
    
    
    SWITCH ($gp1) {
        case 'nbinscrit' : 
            $select .= ' count(distinct(i.id)) as nbindiv ';
            $orderby .= ' count(distinct(i.id))';
            $join .= ' INNER JOIN foyer f on f.id = i.idfoyer ';
            $joinFoyer = true;
            $nomColDate = 'dateinscription';
            $titre = 'Nombre d\'inscrit ';
            break;
        case 'nbaide' : 
            $select .= ' count(distinct(ai.id)) as nbaide';
            $join .= ' INNER JOIN aideinterne ai on ai.idindividu = i.id ';
            $orderby .= ' nbaide';
            $nomColDate = 'datedemande';
            $titre = 'Nombre d\'aide demandée ';
            break;
        case 'nbaideurg' : 
            $select .= ' count(distinct(ai.id)) as nbaide';
            $join .= ' INNER JOIN aideinterne ai on ai.idindividu = i.id ';
            $orderby .= ' nbaide';
            $nomColDate = 'datedemande';
            $titre = 'Nombre d\'aide demandée ';
            $wheresuite .= ' AND ai.aideurgente = 1 ';
            break;
        case 'nbaideext' : 
            $select .= ' count(distinct(ae.id)) as nbaide';
            $join .= ' INNER JOIN aideexterne ae on ae.idindividu = i.id ';
            $orderby .= ' nbaide';
            $nomColDate = 'datedemande';
            $titre = 'Nombre d\'aide demandée ';
            break;
        case 'montant' : 
            $select .= ' SUM(montant) as montant';
            $join .= ' INNER JOIN aideinterne ai on ai.idindividu = i.id 
                       INNER JOIN bonaide ba on ba.idaideinterne = ai.id ';
            $orderby .= ' montant';
            $nomColDate = 'dateremiseeffective';
            $titre = 'Montant total des aides accordées ';
            break;
    }
    
    SWITCH ($gp3) {
        case 'mois' : 
            $where .= ' WHERE '.$nomColDate.' > '.mktime(0,0,0, date("m"),1, date("Y")).'';
            $finTitre .= '<br/> sur le mois courant';
            break;
        case 'an' : 
            $where .= ' WHERE '.$nomColDate.' > '.mktime(0,0,0, 1,1, date("Y")).'';
            $finTitre .= '<br/> pour l\'année civile courante';
            break;
        case 'periode' :
            if ($dateDebut != '' && $dateFin != '') {
                $where .= ' WHERE '.$nomColDate.' BETWEEN '.mktime(0, 0, 0, $dateDebut[1], $dateDebut[0], $dateDebut[2]).' AND '.mktime(0, 0, 0, $dateFin[1], $dateFin[0], $dateFin[2]);
            }
            $finTitre .= '<br/> du '.$dateDebut[0].'/'.$dateDebut[1].'/'.$dateDebut[2].' au '.$dateFin[0].'/'.$dateFin[1].'/'.$dateFin[2];
            break;
    }

    SWITCH ($gp2) {
        case 'trancheage' :
            $temp = $select.', "moins de 18 ans"
                    FROM individu i 
                    '.$join.' 
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" )<18
                    '.$wheresuite.'
                    UNION
                    '.$select.', "18-25 ans"
                    FROM individu i
                    '.$join.'
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" ) between 18 and 25
                    '.$wheresuite.'
                    UNION
                    '.$select.', "25-59 ans"
                    FROM individu i
                    '.$join.'
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" ) between 26 and 59
                    '.$wheresuite.'
                    UNION
                    '.$select.', "plus de 60 ans"
                    FROM individu i
                    '.$join.'
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" ) >60
                    '.$wheresuite;
            $select = $temp;
            $from = '';
            $join = '';
            $where = '';
            $wheresuite = '';
            $orderby = '';
            $titre .= 'par tranche d\'âge';
            break;
        case 'csp' : 
            $select .= ', profession';
            $groupby .= ' GROUP BY profession';
            $join .= ' INNER JOIN profession p on p.id = i.idprofession';
            $titre .= 'par catégories socioprofessionnelles';
            break;
        case 'sexe' : 
            $select .= ', IF(sexe = "","Aucune information" ,sexe) ';
            $groupby .= ' GROUP BY sexe';
            $titre .= 'par sexe';
            break;
       case 'secteur' : 
            $select .= ', secteur';
            $groupby .= ' GROUP BY secteur';
            if (!$joinFoyer) {
                $join .= ' INNER JOIN foyer f on f.id = i.idfoyer ';
            }
            $join .= ' INNER JOIN secteur s on s.id = f.idsecteur';
            $titre .= 'par secteur';
            break;
       case 'typefamille' : 
            $select .= ', situation';
            $groupby .= ' GROUP BY situation';
            if (!$joinFoyer) {
                $join .= ' INNER JOIN foyer f on f.id = i.idfoyer ';
            }
            $join .= 'INNER JOIN situationfamiliale sf on sf.id = f.idsitfam';
            $titre .= 'par situation familiale';
            break;
    }
    
    
    $titre = $titre.$finTitre;
    

    $req = $select.$from.$join.$where.$wheresuite.$groupby.$orderby;
    
    echo 'TITRE   :   '.$titre.'<br/><br/>';
    echo $req;
    echo "<br/>";
    
    $con = Doctrine_Manager::getInstance()->connection();
    $st = $con->execute($req);
    // fetch query result
    $result = $st->fetchAll();

    genererGraph($result, $titre);
}

function genererGraph($tab, $titre) {
    include_once('./lib/config.php');
    $y = '[';
    $x = '[';
    foreach($tab as $tableau) {
           $x = $x.'"'.$tableau[1].'", ';
           $y = $y.''.$tableau[0].', ';
    }
    
    $x = substr($x, 0, strlen($x)-2);
    $y = substr($y, 0, strlen($y)-2);
    $x[strlen($x)] = ']';
    $y[strlen($y)] = ']';
    
//    echo "<br/>";
//    echo $x;
//    echo "<br/>";
//    echo $y;    
    
    $retour = '<div id="graphstat" "></div>';
        $retour .= "
         <script type='text/javascript'>
            var s1 = ".$y.";
        var ticks = ".$x.";
         
        plot2 = $.jqplot('graphstat', [s1], {
            title: '".addslashes($titre)."',
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
    echo $retour;
}

function genererPeriode() {
      echo '<div class="rounded_box" style="display: block; ">
               <table cellpadding="0" cellspacing="0">
                   <thead>
                       <tr>
                           <th class="role">Période exacte</th>
                       </tr>
                   </thead>
                   <tbody name="groupe3">
                       <tr>
                           <td class="ligne">                        
                               <span class="attribut">Date début :</span>
                               <span>
                                   <input class="contour_field input_date_graph" type="text" size="10" id="datedebut">
                               </span>
                           </td>
                       </tr>
                       <tr>
                           <td class="ligne">                        
                               <span class="attribut">Date fin :</span>
                               <span>
                                   <input class="input_date_graph" type="text" size="10" id="datefin">
                               </span>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>';
}
?>
