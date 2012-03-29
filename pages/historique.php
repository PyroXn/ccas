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
    $i = 1;
    foreach($historiques as $historique) {
        $i % 2 ? $contenu .= '<tr>' : $contenu .= '<tr class="alt">';
        if ($historique->typeAction == Historique::$Archiver) {
            $q = Doctrine_Query::create()
                ->from($historique->objet)
                ->where('datecreation < ?', $historique->date)
                ->andWhere('idIndividu = ?', $historique->idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
            
            $contenu .= '<td><span>'.$q->id.' '.Historique::getStaticValue($historique->typeAction).'</span></td>';
        } else {
            $contenu .= '<td>'.Historique::getStaticValue($historique->typeAction).'</td>';
        }
        $contenu .= '
            <td>'.$historique->objet.'</td>
            <td>'.$historique->user->login.'</td>
            <td>'.getDatebyTimestamp($historique->date).'</td>
        </tr>';
        $i++;
    }
                                
    $contenu .= '</tbody></table></div>';
    return $contenu;
}

function affichageHistorique() {
    $contenu = '';
//    $contenu .= '<h3>Recherche</h3>
//        <ul class="list_classique">
//            <li id="ligneRechercheTableStatique" class="ligne_list_classique" table="historique">
//                <div class="colonne">
//                    <span class="attribut">Individu : </span>
//                    <span><input class="contour_field input_char recherche" type="text" columnName="individu" value=""/></span>
//                </div>
//            </li>
//            <li id="ligneRechercheTableStatique" class="ligne_list_classique" table="historique">
//                <div class="colonne">
//                    <span class="attribut">Individu : </span>
//                    <span><input class="contour_field input_char recherche" type="text" columnName="individu" value=""/></span>
//                </div>
//            </li>
//            <li id="ligneRechercheTableStatique" class="ligne_list_classique" table="historique">
//                <div class="colonne">
//                    <span class="attribut">Objet : </span>
//                    <span><input class="contour_field input_char recherche" type="text" columnName="objet" value=""/></span>
//                </div>
//            </li>
//            <li id="ligneRechercheTableStatique" class="ligne_list_classique" table="historique">
//                <div class="colonne">
//                    <span class="attribut">Utilisateur : </span>
//                    <span><input class="contour_field input_char recherche" type="text" columnName="utilisateur" value=""/></span>
//                </div>
//            </li>
//        </ul>';
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
                <tbody>';
    $i = 1;
    foreach($historiques as $historique) {
        $i % 2 ? $contenu .= '<tr>' : $contenu .= '<tr class="alt">';
        
        $contenu .= '
            <td>'.$historique->individu->nom.' '.$historique->individu->prenom.'</td>
            <td>'.Historique::getStaticValue($historique->typeAction).'</td>
            <td>'.$historique->objet.'</td>
            <td>'.$historique->user->login.'</td>
            <td>'.getDatebyTimestamp($historique->date).'</td>
        </tr>';
        $i++;
    }
                                
    $contenu .= '</tbody></table></div>';
    return $contenu;
}
?>
