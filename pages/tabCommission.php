<?php
function ecranTabCommission() {
    $req = 'SELECT distinct(datedecision)
            FROM aideinterne ai
            ORDER BY datedecision DESC
            LIMIT 6';
    $con = Doctrine_Manager::getInstance()->connection();
    $st = $con->execute($req);
    $result = $st->fetchAll();
    $firstdate = '';
    $listedate = '';
    
    foreach ($result as $ligne) {
        if ($firstdate == '') {
            $firstdate = getDatebyTimestampInput($ligne["datedecision"]);
        }
        $listedate .= '-  '.getDatebyTimestamp($ligne["datedecision"]).'<br/>';
    }
    
    
    
    $retour = '<div class="colonne_large">
                   <h3>Demandes pour la periode du :</h3>
                   <ul class="list_classique" id="demande_commission">
                       <li class="ligne_list_classique">
                           <div class="colonne_large">
                               <span class="attribut">Date début :</span>
                               <span>
                                   <input class="contour_field input_date requis" type="text" size="10" id="datedebut" '.getDatebyTimestampInput(time()).'>
                               </span>
                           </div>
                           <div class="colonne_large">
                               <span class="attribut">Date fin :</span>
                               <span>
                                   <input class="contour_field input_date requis" type="text" size="10" id="datefin" '.getDatebyTimestampInput(time() + 604800).'>
                               </span>
                           </div>
                       </li>
                       <li class="ligne_list_classique">
                            <div value="create_tab_demande_commission" class="bouton modif">
                                <span>Créer le tableau de demandes</span>
                            </div>
                       </li>
                   </ul>
               </div>
               <div class="colonne_large">
               </div>
               <div class="colonne_large">
                   <h3>Demandes passées a la commission du :</h3>
                   <ul class="list_classique" id="decision_commission">
                       <li class="ligne_list_classique">
                           <div class="colonne_large">
                               <span class="attribut">Date de la commission :</span>
                               <span>
                                   <input class="contour_field input_date requis" type="text" size="10" id="datecommission" '.$firstdate.'>
                               </span>
                           </div>
                           <div class="colonne_large">
                               <span class="attribut">Date des dernières commission :</span>';
                               $retour .= $listedate;
               $retour .=  '</div>
                       </li>
                       <li class="ligne_list_classique">
                            <div value="create_tab_decision_commission" class="bouton modif">
                                <span>Créer le tableau de décision de commission</span>
                            </div>
                       </li>
                   </ul>
               </div>
               <div id="dialogTab">
               </div>';
    return $retour;
}

function genererTabCommission() {
    $withDecission = $_POST['withDecission'];
    
        echo '<div id="dialogTab">
              <iframe id="iPDF" width="100%" height="500" src="./PDFTabCommission2.pdf"></iframe>
              </div>';
            
    if($withDecission == "1") {
        $dateCommission = explode('/', $_POST['datecommission']);
        $req = 'SELECT i.id, i.nom, i.prenom, f.numrue, r.rue, t.libelle aidedemandee, ai.proposition, ai.avis, SUM(ba.montant) montant_total, count(ba.id) quantite, ai.commentaire
                FROM individu i
                INNER JOIN foyer f on f.id = i.idfoyer
                INNER JOIN rue r on r.id = f.idrue
                INNER JOIN aideinterne ai on ai.idindividu = i.id
                INNER JOIN type t on t.id = ai.idaidedemandee
                LEFT JOIN bonaide ba on ba.idaideinterne = ai.id
                WHERE ai.avis <> ""
                AND datedecision = '.mktime(0, 0, 0, $dateCommission[1], $dateCommission[0], $dateCommission[2]).'
                GROUP BY ai.id';
        $con = Doctrine_Manager::getInstance()->connection();
        $st = $con->execute($req);
        $result = $st->fetchAll();
        $titre = 'Demandes passées à la commission du '.$dateCommission[0].'/'.$dateCommission[1].'/'.$dateCommission[2];
    } else {
        $dateDebut = explode('/', $_POST['datedebut']);
        $dateFin = explode('/', $_POST['datefin']);
        $req = 'SELECT i.id, i.nom, i.prenom, f.numrue, r.rue, t.libelle aidedemandee, ai.proposition, ai.avis, ai.commentaire
                FROM individu i
                INNER JOIN foyer f on f.id = i.idfoyer
                INNER JOIN rue r on r.id = f.idrue
                INNER JOIN aideinterne ai on ai.idindividu = i.id
                INNER JOIN type t on t.id = ai.idaidedemandee
                WHERE ai.avis = ""
                AND datedemande BETWEEN '.mktime(0, 0, 0, $dateDebut[1], $dateDebut[0], $dateDebut[2]).' AND '.mktime(0, 0, 0, $dateFin[1], $dateFin[0], $dateFin[2]).' 
                GROUP BY i.id';
        $con = Doctrine_Manager::getInstance()->connection();
        $st = $con->execute($req);
        $result = $st->fetchAll();
        $titre = 'Demandes pour la période du '.$dateDebut[0].'/'.$dateDebut[1].'/'.$dateDebut[2].' au '.$dateFin[0].'/'.$dateFin[1].'/'.$dateFin[2];
    }
//    echo $req;
    include_once('./lib/PDF/generateTabCommission.php');
}
?>
