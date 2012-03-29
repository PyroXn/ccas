<?php

function createHistorique($typeAction, $objet, $idUser, $idIndividu) {
    include_once('./lib/config.php');
    $historique = new Historique();
    $historique->typeAction = $typeAction;
    $historique->objet = $objet;
    $historique->date = time();
    $historique->idUser = $idUser;
    $historique->idIndividu = $idIndividu;
    $historique->save();
}

function affichageHistoriqueByIndividu() {
    $historiques = Doctrine_Core::getTable('historique')->findByIdIndividu($_POST['idIndividu']);
    $contenu = '<div><h3>Historique</h3>';
    $contenu .= '
        <div class="bubble tableau_classique_wrapper">
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                      <th>Action</th>
                      <th>Objet</th>
                      <th>Utilisateur</th>
                      <th>Date</th>
                    </tr>
                </thead>
                <tbody>';
    
    foreach($historiques as $historique) {
        if ($historique->typeAction == Historique::$Archiver) {
            $q = Doctrine_Query::create()
                ->from($historique->objet)
                ->where('datecreation < ?', $historique->date)
                ->andWhere('idIndividu = ?', $historique->idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
            $contenu .= '<tr  class="afficherArchivage" idObjet='.$q->id.' table='.$historique->objet.'>';
        } else {
            $contenu .= '<tr>';
        }
        $contenu .= '<td>'.Historique::getStaticValue($historique->typeAction).'</td>';
        $contenu .= '
            <td>'.$historique->objet.'</td>
            <td>'.$historique->user->login.'</td>
            <td>'.getDatebyTimestamp($historique->date).'</td>
        </tr>';
    }
                                
    $contenu .= '</tbody></table></div>';
    return $contenu;
}

function affichageHistorique() {
    $contenu = '';
    $contenu .= '<h3>Recherche</h3>
        <ul class="list_classique">
            <li id="ligneRechercheTableHistorique" class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Individu : </span>
                    <span><input class="contour_field input_char rechercheHistorique" type="text" columnName="individu" value=""/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Action : </span>
                    <div class="select classique" role="select_historique_type_action">
                        <div id="form_1" class="option">--------</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">Objet : </span>
                    <span><input class="contour_field input_char rechercheHistorique" type="text" columnName="objet" value=""/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Utilisateur : </span>
                    <span><input class="contour_field input_char rechercheHistorique" type="text" columnName="utilisateur" value=""/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">date inf&eacute;rieur &agrave; : </span>
                    <span><input class="contour_field input_date rechercheHistorique" size="10" type="text" columnName="dateInf" value=""/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">date sup&eacute;rieur &agrave; : </span>
                    <span><input class="contour_field input_date rechercheHistorique" size="10" type="text" columnName="dateSup" value=""/></span>
                </div>
            </li>
        </ul>
        <ul class="select_historique_type_action">
            <li value='.Historique::$Creation.'>
                <div>'.Historique::getStaticValue(Historique::$Creation).'</div>
            </li>
            <li value='.Historique::$Modification.'>
                <div>'.Historique::getStaticValue(Historique::$Modification).'</div>
            </li>
            <li value='.Historique::$Suppression.'>
                <div>'.Historique::getStaticValue(Historique::$Suppression).'</div>
            </li>
            <li value='.Historique::$Archiver.'>
                <div>'.Historique::getStaticValue(Historique::$Archiver).'</div>
            </li>
        </ul>';
    $historiques = Doctrine_Core::getTable('historique')->findAll();
    $contenu .= '<div><h3>Historique</h3>';
    $contenu .= '
        <div class="bubble tableau_classique_wrapper">
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                      <th>Individu</th>
                      <th>Action</th>
                      <th>Objet</th>
                      <th>Utilisateur</th>
                      <th>Date</th>
                    </tr>
                </thead>
                <tbody id="contenu_table_historique">';     
    $contenu .= generateContenuTableHistorique($historiques).'</tbody></table></div>';
    return $contenu;
}

function generateContenuTableHistorique($historiques) {
    $retour = '';
    foreach($historiques as $historique) {
        if ($historique->typeAction == Historique::$Archiver) {
            $q = Doctrine_Query::create()
                ->from($historique->objet)
                ->where('datecreation < ?', $historique->date)
                ->andWhere('idIndividu = ?', $historique->idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
            $retour .= '<tr class="afficherArchivage isGlobal" idObjet='.$q->id.' table='.$historique->objet.'>';
        } else {
            $retour .= '<tr>';
        }
        
        $retour .= '
            <td>'.$historique->individu->nom.' '.$historique->individu->prenom.'</td>
            <td>'.Historique::getStaticValue($historique->typeAction).'</td>
            <td>'.$historique->objet.'</td>
            <td>'.$historique->user->login.'</td>
            <td>'.getDatebyTimestamp($historique->date).'</td>
        </tr>';
    }
    return $retour;
}

function searchHistorique() {
    include_once('./lib/config.php');
    $table = $_POST['table'];
    $tableHistorique = Doctrine_Core::getTable($table);
    $req = '';
    $param = array();
    $premierPassage = true;
    if (isset ($_POST['individu'])) {
        $tableIndividu = Doctrine_Core::getTable('individu')->likeNom($_POST['individu']);
        $tableIndividu->execute();
        $req .= $premierPassage ? 'idIndividu IN ? ' : 'and idIndividu IN ? ';
        $first = false;
        $paramIdIndividu = '';
        foreach($tableIndividu->execute() as $individu) {
            $first ? $paramIdIndividu .= '('.$individu->id : ','.$individu->id;
            
        }
        $paramIdIndividu .= ')';
        $param[] = $paramIdIndividu;
        $premierPassage = false;
    }
//    if (isset ($_POST['individu'])) {
//        $req .= $premierPassage ? $columnName.' like ? ' : 'and '.$columnName.' like ? ';
//        $premierPassage = false;
//    }
    if (isset ($_POST['objet'])) {
        $req .= $premierPassage ? 'objet like ? ' : 'and objet like ? ';
        $param[] = $_POST['objet'].'%';
        $premierPassage = false;
    }
//    if (isset ($_POST['individu'])) {
//        $req .= $premierPassage ? $columnName.' like ? ' : 'and '.$columnName.' like ? ';
//        $premierPassage = false;
//    }
    
//    foreach ($columnNames as $columnName) {
//        if ($columnName != 'id') {
//            $req .= $premierPassage ? $columnName.' like ? ' : 'and '.$columnName.' like ? ';
//            $param[] = $_POST[$columnName].'%';
//            $premierPassage = false;
//        }
//    }
    $search = $tableHistorique->findByDql($req, $param);
    echo generateContenuTableHistorique($search);
}

function affichageArchive() {
    $retour = '';
    if ($_POST['global'] == 'true') {
        $retour .= '<tr><td colspan=5>';
    } else {
        $retour .= '<tr><td colspan=4>';
    }
    $q = Doctrine_Core::getTable($_POST['table'])->find($_POST['idObjet']);
    switch($_POST['table']) {
        case 'ressource':
            $retour .= '
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Salaire : </h2>
                        <div class="aff">'.$q->salaire.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>AAH : </h2>
                        <div class="aff">'.$q->aah.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>P. alimentaire : </h2>
                        <div class="aff">'.$q->pensionAlim.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>All. Ch&ocirc;mage : </h2>
                        <div class="aff">'.$q->chomage.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>RSA Socle : </h2>
                        <div class="aff">'.$q->rsaSocle.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>P. de retraite : </h2>
                        <div class="aff">'.$q->pensionRetraite.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>All. familiales : </h2>
                        <div class="aff">'.$q->revenuAlloc.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>RSA Activit&eacute; : </h2>
                        <div class="aff">'.$q->rsaActivite.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Autres revenus : </h2>
                        <div class="aff">'.$q->autreRevenu.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>ASS : </h2>
                        <div class="aff">'.$q->ass.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Retraite compl : </h2>
                        <div class="aff">'.$q->retraitComp.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Nature : </h2>
                        <div class="aff">'.$q->natureAutre.'</div>
                    </div>
                </div></td></tr>';
            break;
        case 'depense':
            $retour .= '
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Imp&ocirc;ts revenu : </h2>
                        <div class="aff">'.$q->impotRevenu.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Electricit&eacute; : </h2>
                        <div class="aff">'.$q->electricite.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>T&eacute;l&eacute;phonie : </h2>
                        <div class="aff">'.$q->telephonie.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Autres D&eacute;penses : </h2>
                        <div class="aff">'.$q->autreDepense.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Imp&ocirc;ts locaux : </h2>
                        <div class="aff">'.$q->impotLocaux.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Gaz : </h2>
                        <div class="aff">'.$q->gaz.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Internet : </h2>
                        <div class="aff">'.$q->internet.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>D&eacute;tail : </h2>
                        <div class="aff">'.$q->natureDepense.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>P. alimentaire : </h2>
                        <div class="aff">'.$q->pensionAlim.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Eau : </h2>
                        <div class="aff">'.$q->eau.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>T&eacute;l&eacute;vision : </h2>
                        <div class="aff">'.$q->television.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Mutuelle : </h2>
                        <div class="aff">'.$q->mutuelle.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Chauffage : </h2>
                        <div class="aff">'.$q->chauffage.'</div>
                    </div>
                </div></td></tr>';
            break;
        case 'dette':
            $retour .= '
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Arri&eacute;r&eacute; locatif : </h2>
                        <div class="aff">'.$q->arriereLocatif.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Arri&eacute;r&eacute; &eacute;lectricit&eacute; : </h2>
                        <div class="aff">'.$q->arriereElectricite.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Arri&eacute;r&eacute; gaz : </h2>
                        <div class="aff">'.$q->arriereGaz.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Frais huissier : </h2>
                        <div class="aff">'.$q->fraisHuissier.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Prestataire : </h2>
                        <div class="aff">'.$q->prestaElec.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Prestataire : </h2>
                        <div class="aff">'.$q->prestaGaz.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Autres dettes : </h2>
                        <div class="aff">'.$q->autreDette.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Nature  :</h2>
                        <div class="aff">'.$q->natureDette.'</div>
                    </div>
                </div></td></tr>';
            break;
    }
    echo $retour;
}
?>
