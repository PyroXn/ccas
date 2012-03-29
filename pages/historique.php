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
        
        $contenu .= '<td>'.Historique::getStaticValue($historique->typeAction).'</td>
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
    $historiques = Doctrine_Core::getTable('historique')->findAll();
    $contenu = '<div><h3>Historique</h3>';
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
