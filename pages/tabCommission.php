<?php
function ecranTabCommission() {
    $requete = Doctrine_Query::create()
        ->select('dateDecision')
        ->from('aideinterne')
        ->distinct(true)
        ->orderBy('dateDecision DESC')
        ->groupBy('dateDecision')
        ->limit(6);
        $result = $requete->execute();
        $firstdate = '';
        $listedate = '';
    
    foreach ($result as $ligne) {
        if ($firstdate == '') {
            $firstdate = getDatebyTimestampInput($ligne->dateDecision);
        }
        $listedate .= '-  '.getDatebyTimestamp($ligne->dateDecision).'<br/>';
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
        $req = Doctrine_Query::create()
            ->from('aideinterne')
            ->where('avis <> ""')
            ->andWhere('dateDecision = '.mktime(0, 0, 0, $dateCommission[1], $dateCommission[0], $dateCommission[2]));
        $result = $req->execute();
        $titre = 'Demandes passées à la commission du '.$dateCommission[0].'/'.$dateCommission[1].'/'.$dateCommission[2];
    } else {
        $dateDebut = explode('/', $_POST['datedebut']);
        $dateFin = explode('/', $_POST['datefin']);
        $req = Doctrine_Query::create()
            ->from('aideinterne')
            ->where('avis = ""')
            ->andWhere('dateDemande BETWEEN '.mktime(0, 0, 0, $dateDebut[1], $dateDebut[0], $dateDebut[2]).' AND '.mktime(0, 0, 0, $dateFin[1], $dateFin[0], $dateFin[2]));
        $result = $req->execute();
        $titre = 'Demandes pour la période du '.$dateDebut[0].'/'.$dateDebut[1].'/'.$dateDebut[2].' au '.$dateFin[0].'/'.$dateFin[1].'/'.$dateFin[2];
    }
    include_once('./lib/PDF/generateTabCommission.php');
}
?>
