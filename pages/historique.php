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
    $contenu = creationRecherche(false);
    //trop lent
//    $historiques = Doctrine_Core::getTable('historique')->findByIdIndividuAndD($_POST['idIndividu']);
//    $historiques = Doctrine_Query::create()
//        ->from('historique')
//        ->where('idIndividu = ?', $_POST['idIndividu'])
//        ->andWhere('date >= ?', mktime(0, 0, 0, date('m'), date('d'), date('Y')))
//        ->execute();
    $pager = new Doctrine_Pager(
            Doctrine_Query::create()->from('historique')
            ->where('idIndividu = ?', $_POST['idIndividu'])
            ->andWhere('date >= ?', mktime(0, 0, 0, date('m'), date('d'), date('Y'))),
            1, // Current page of request
            15 // (Optional) Number of results per page. Default is 25
        );
    $historiques = $pager->execute();
    $contenu .= '<div><h3>Historique'.generateNumeroPage($pager).'</h3>';
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
                <tbody id="contenu_table_historique">';
                                
    $contenu .= generateContenuTableHistorique($historiques, false).'</tbody></table>';
    $contenu .= generatePagination($pager).'</div>';
    return $contenu;
}

function affichageHistorique() {
    $contenu = creationRecherche(true);
    //trop lent
//    $historiques = Doctrine_Core::getTable('historique')->findAll();
//    $historiques = Doctrine_Query::create()
//        ->from('historique')
//        ->where('date >= ?', mktime(0, 0, 0, date('m'), date('d'), date('Y')))
//        ->execute();
    $pager = new Doctrine_Pager(
            Doctrine_Query::create()->from('historique')
            ->where('date >= ?', mktime(0, 0, 0, date('m'), date('d'), date('Y'))),
            1, // Current page of request
            15 // (Optional) Number of results per page. Default is 25
        );
    $historiques = $pager->execute();
    $contenu .= '<div><h3>Historique'.generateNumeroPage($pager).'</h3>';
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
    $contenu .= generateContenuTableHistorique($historiques, true).'</tbody></table>';
    $contenu .= generatePagination($pager).'</div>';
    return $contenu;
}

function generateContenuTableHistorique($historiques, $global) {
    $retour = '';
    foreach($historiques as $historique) {
        if ($historique->typeAction == Historique::$Archiver) {
            $q = Doctrine_Query::create()
                ->from($historique->objet)
                ->where('datecreation < ?', $historique->date)
                ->andWhere('idIndividu = ?', $historique->idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
            if ($global) {
                $retour .= '<tr class="afficherArchivage isGlobal" idObjet='.$q->id.' table='.$historique->objet.'>';
            } else {
                $retour .= '<tr class="afficherArchivage" idObjet='.$q->id.' table='.$historique->objet.'>';
            }
        } else {
            $retour .= '<tr>';
        }
        if ($global) {
            $retour .= '
            <td>'.$historique->individu->nom.' '.$historique->individu->prenom.'</td>';
        }
        $retour .= '
            <td>'.Historique::getStaticValue($historique->typeAction).'</td>
            <td>'.$historique->objet.'</td>
            <td>'.$historique->user->login.'</td>
            <td>'.getDatebyTimestamp($historique->date).'</td>
        </tr>';
    }
    return $retour;
}

function creationRecherche($global) {
    $retour = '<h3>Recherche</h3>
        <ul class="list_classique">';
            if ($global) {
                $retour .= '
                    <li id="ligneRechercheTableHistorique" class="ligne_list_classique isGlobal">
                    <div class="colonne">
                        <span class="attribut">Individu : </span>
                        <span><input class="contour_field input_char rechercheHistorique" type="text" columnName="individu" value=""/></span>
                    </div>';
            } else {
                $retour .= '
                    <li id="ligneRechercheTableHistorique" class="ligne_list_classique">';
            }
                $retour .= '<div class="colonne">
                    <span class="attribut">Action : </span>
                    <div class="select classique" role="select_historique_type_action">
                        <div class="option" columnName="action">--------</div>
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
                    <span class="attribut">date inférieur à : </span>
                    <span><input class="contour_field input_date rechercheHistorique" size="10" type="text" columnName="dateInf" value=""/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">date supérieur à : </span>
                    <span><input class="contour_field input_date rechercheHistorique" size="10" type="text" columnName="dateSup" '.getDatebyTimestampInput(time()).'/></span>
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
            <li value='.Historique::$Archiver.'>
                <div>--------</div>
            </li>
        </ul>';
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
        $tableIndividu = Doctrine_Core::getTable('individu');
        $req .= $premierPassage ? 'idIndividu IN ? ' : 'and idindividu IN ? ';
        $first = true;
        $paramIdIndividu = '';
        foreach($tableIndividu->likeNom($_POST['individu'])->execute() as $individu) {
            $paramIdIndividu .= $first ? $individu->id : ','.$individu->id;
            $first = false;
        }
        $param[] = $paramIdIndividu;
        $premierPassage = false;
    }
    if (isset ($_POST['idIndividu'])) {
        $req .= $premierPassage ? 'idIndividu = ? ' : 'and idIndividu = ? ';
        $param[] = $_POST['idIndividu'];
        $premierPassage = false;
    }
    if (isset ($_POST['objet'])) {
        $req .= $premierPassage ? 'objet like ? ' : 'and objet like ? ';
        $param[] = $_POST['objet'].'%';
        $premierPassage = false;
    }
    if (isset ($_POST['utilisateur'])) {
        $tableUser = Doctrine_Core::getTable('user');
        $req .= $premierPassage ? 'idUser IN ? ' : 'and idUser IN ? ';
        $first = true;
        $paramIdUser = '';
        foreach($tableUser->likeLogin($_POST['utilisateur'])->execute() as $user) {
            $paramIdUser .= $first ? $user->id : ','.$user->id;
            $first = false;
        }
        $param[] = $paramIdUser;
        $premierPassage = false;
    }
    if(isset ($_POST['dateInf'])) {
        if($_POST['dateInf'] != 0 && strlen($_POST['dateInf']) == 10) {
            $req .= $premierPassage ? 'date <=? ' : 'and date <= ? ';
            $date = explode('/', $_POST['dateInf']);
            $param[] = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
            $premierPassage = false;
        }
    }
    if(isset ($_POST['dateSup'])) {
        if($_POST['dateSup'] != 0 && strlen($_POST['dateSup']) == 10) {
            $req .= $premierPassage ? 'date >=? ' : 'and date >= ? ';
            $date = explode('/', $_POST['dateSup']);
            $param[] = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
            $premierPassage = false;
        }
    }
    if(isset ($_POST['action'])) {
        $req .= $premierPassage ? 'typeAction =? ' : 'and typeAction = ? ';
        $param[] = Historique::getStaticValue($_POST['action']);
        $premierPassage = false;
    }
    if ($req == '') {
        $pager = new Doctrine_Pager(
            Doctrine_Query::create()->from('historique'),
            isset ($_POST['page']) ? $_POST['page'] : 1, // Current page of request
            15 // (Optional) Number of results per page. Default is 25
        );
        $search = $pager->execute();
    } else {
        $pager = new Doctrine_Pager(
            Doctrine_Query::create()->from('historique')->where($req, $param),
            isset ($_POST['page']) ? $_POST['page'] : 1, // Current page of request
            15 // (Optional) Number of results per page. Default is 25
        );
        $search = $pager->execute();
    }
    if (isset ($_POST['global']) && $_POST['global'] == 'true') {
        $global = true;
    } else {
        $global = false;
    }
    
//    echo $pager->getQuery().'</br>';
    
    $contenuTableHistorique = generateContenuTableHistorique($search, $global, $pager);
    $pagination = generatePagination($pager);
    $numeroPage = generateNumeroPage($pager);
    $retour = array('contenu' => $contenuTableHistorique, 'pagination' => $pagination, 'numero_page' => $numeroPage);
    echo json_encode($retour);
}

function generatePagination($pager) {
    $retour = '<div class="pagination">';
    $current = $pager->getPage();
    $maxPerPage = $pager->getMaxPerPage();
    $numResult = $pager->getNumResults();
    $numPage = ceil($numResult / $maxPerPage);
    
    if ($pager->haveToPaginate()) {
        $retour .= '<span class="page gradient paginationHistorique" value="1"><<</span>
            <span class="page gradient paginationHistorique" value="'.$pager->getPreviousPage().'"><</span>';
        if ($numPage > 5) {
            if ($numPage - 2 < $current) {
                $retour .= numeroPagination($numPage - 4, $numPage, $current);
            } else if ($current < 3) {
                $retour .= numeroPagination(1, 5, $current);
            } else {
                $retour .= numeroPagination($current - 2, $current + 2, $current);
            }
        } else {
            $retour .= numeroPagination(1, $numPage, $current);      
        }
        $retour .= '<span class="page gradient paginationHistorique" value="'.$pager->getNextPage().'">></span>
            <span class="page gradient paginationHistorique" value="'.$numPage.'">>></span></div>';
    }
    return $retour;
}

function numeroPagination($debutCompteur, $finCompteur, $current) {
    $retour = '';
    for ($i = $debutCompteur; $i <= $finCompteur; $i++) {
        if ($i == $current) {
            $retour .= '<span class="page active">'.$current.'</span>';
        }   else {
            $retour .= '<span class="page gradient paginationHistorique" value="'.$i.'">'.$i.'</span>';
        }
    }
    return $retour;
}

function generateNumeroPage($pager) {
    $retour = '<span class="numero_page">';
    $current = $pager->getPage();
    $maxPerPage = $pager->getMaxPerPage();
    $numResult = $pager->getNumResults();
    if ($numResult!=0) {
        $retour .= min(($current*$maxPerPage-$maxPerPage+1),$numResult).'-'.min(($current*$maxPerPage),$numResult).' sur '.$numResult;
    }
    $retour .= '</span>';
    return $retour;
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
                        <h2>All. Chômage : </h2>
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
                        <h2>RSA Activité : </h2>
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
                        <h2>Impôts revenu : </h2>
                        <div class="aff">'.$q->impotRevenu.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Electricité : </h2>
                        <div class="aff">'.$q->electricite.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Téléphonie : </h2>
                        <div class="aff">'.$q->telephonie.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Autres Dépenses : </h2>
                        <div class="aff">'.$q->autreDepense.'</div>
                    </div>
                </div>
                <div class="colonne_classique">
                    <div class="affichage_classique">
                        <h2>Impôts locaux : </h2>
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
                        <h2>Détail : </h2>
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
                        <h2>Télévision : </h2>
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
                        <h2>Arriéré locatif : </h2>
                        <div class="aff">'.$q->arriereLocatif.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Arriéré électricité : </h2>
                        <div class="aff">'.$q->arriereElectricite.'</div>
                    </div>
                    <div class="affichage_classique">
                        <h2>Arriéré gaz : </h2>
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
