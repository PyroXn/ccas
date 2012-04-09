<?php

function action() {
    include_once('./lib/config.php');
    $actions = Doctrine_Core::getTable('action')->findByIdIndividu($_POST['idIndividu']);
    $types = Doctrine_Core::getTable('type')->findByCategorie(2); // Type Action
    $instructs = Doctrine_Core::getTable('instruct')->findByInterne(1); // Instruct interne
    $contenu = '<h2>Actions</h2>';
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_CREATION_ACTION)) {
        $contenu .= '
            <div id="createAction" class="bouton ajout">
                <i class="icon-add"></i>
                <span>Ajouter une action</span>
            </div>';
    }
    $contenu .= '<div><h3><span>Suivi des actions</span></h3>';
    $contenu .= '
        <div class="bubble tableau_classique_wrapper">
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                      <th>Date</th>
                      <th>Actions</th>
                      <th>Motif</th>
                      <th>Suite à donner</th>
                      <th>Suite donnee</th>
                      <th>Instructeur</th>
                      <th></th>
                    </tr>
                </thead>
                <tbody>';
    $i = 1;
    foreach($actions as $action) {
        $i % 2 ? $contenu .= '<tr>' : $contenu .= '<tr class="alt">';
        
        $contenu .= '<td>'.getDatebyTimestamp($action->date).'</td>
            <td>'.$action->typeaction->libelle.'</td>
            <td>'.$action->motif.'</td>
            <td>'.$action->suiteADonner.'</td>
            <td>'.$action->suitedonnee.'</td>
            <td>'.$action->instruct->nom.'</td>
            <td>';
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_MODIFICATION_ACTION)) {
            $contenu .= '<span class="edit_action" idAction="'.$action->id.'"></span>';
        }
        $contenu .= '</td>
        </tr>';
        $i++;
    }
    if($i == 1) {
        $contenu .=  '<tr>
                         <td colspan="7" align="center">< Aucune action n\'a été éffectuée > </td>
                     </tr>';
    }
    $contenu .= '</tbody></table></div>';
    
    
    $contenu .= '
        <div class="formulaire" action="creation_action">
            <h2>Actions</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input id="date" class="contour_field requis input_date" type="text" title="Date" placeholder="Date - jj/mm/aaaa">
                </div>
                <div class="select classique" role="select_motifaction">
                    <div id="typeaction" class="option requis">Type d\'action</div>
                    <div class="fleche_bas"> </div>
                </div>
                <div class="input_text">
                    <input id="motif" class="contour_field requis" type="text" title="Motif" placeholder="Motif">
                </div>
                <div class="input_text">
                    <input id="suiteadonner" class="contour_field" type="text" title="Suite à donner" placeholder="Suite à donner">
                </div>
                <div class="input_text">
                    <input id="suitedonnee" class="contour_field" type="text" title="Suite donnée" placeholder="Suite donnée">
                </div>
                <div class="select classique" role="select_instruct">
                    <div id="instruct" class="option requis">Instructeur</div>
                    <div class="fleche_bas"> </div>
                </div>
                <div class="sauvegarder_annuler">
                    <div value="save" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Enregistrer</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                    </div>
                </div>
            </div>
        </div>
   <div class="formulaire" action="edit_action">
            <h2>Actions</h2>
           <div class="colonne_droite">
                 <div class="input_text">
                    <input id="date_edit" class="contour_field" type="text" title="Date">
                </div>
                <div class="input_text">
                    <input id="typeaction_edit" class="contour_field" type="text" title="Type action" disabled/>
                </div>
                <div class="input_text">
                    <input id="motif_edit" class="contour_field" type="text" title="Motif">
                </div>
                <div class="input_text">
                    <input id="suiteadonner_edit" class="contour_field" type="text" title="Suite à donner">
                </div>
                <div class="input_text">
                    <input id="suitedonnee_edit" class="contour_field" type="text" title="Suite donnée">
                </div>
                <div class="input_text">
                    <input id="instruct_edit" class="contour_field" type="text" title="Instructeur" disabled/>
                </div>
                <div class="sauvegarder_annuler">
                    <div value="edit_action" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Enregistrer</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                    </div>
                </div>

           </div>
   </div>';
    // COMBO BOX
      $contenu .= '<ul class="select_instruct">';
    foreach($instructs as $instruct) {
        $contenu .= '<li>
                                    <div value="'.$instruct->id.'">'.$instruct->nom.'</div>
                                </li>';
    }
    $contenu .= '</ul>';
   $contenu .= '<ul class="select_motifaction">';
    foreach($types as $type) {
        $contenu .= '<li>
                                    <div value="'.$type->id.'">'.$type->libelle.'</div>
                                </li>';
    }
    $contenu .= '</ul>';
    return $contenu;

}

function createAction($date, $typeaction, $motif, $suiteadonner, $suitedonnee, $idInstruct, $idIndividu) {
    include_once('./lib/config.php');
    $action = new Action();
    if($date != 0) {
        $date1 = explode('/', $date);
        $action->date = mktime(0, 0, 0, $date1[1], $date1[0], $date1[2]);
    } else {
        $action->date = 0;
    }
    $action->idAction = $typeaction;
    $action->motif = $motif;
    $action->suiteADonner = $suiteadonner;
    $action->suitedonnee = $suitedonnee;
    $action->idInstruct = $idInstruct;
    $action->idIndividu = $idIndividu;
    $action->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Creation, 'action', $_SESSION['userId'], $idIndividu);
}

function getAction() {
    include_once('./lib/config.php');
    $action = Doctrine_Core::getTable('action')->find($_POST['id']);
    if($action->date != 0) {
        $date = date('d/m/Y', $action->date);
    } else {
        $date = 0;
    }
    $retour = array('date' => $date, 'action' => $action->typeaction->libelle, 'motif' => $action->motif, 'suiteadonner' => $action->suiteADonner, 'suitedonnee' => $action->suitedonnee, 'instruct' => $action->instruct->nom);
    echo json_encode($retour);
}

function updateAction() {
    include_once('./lib/config.php');
    $action = Doctrine_Core::getTable('action')->find($_POST['idAction']);
    $action->motif = $_POST['motif'];
    $action->suiteADonner = $_POST['suiteadonner'];
    $action->suitedonnee = $_POST['suitedonnee'];
    if($_POST['date'] != 0) {
        $date1 = explode('/', $_POST['date']);
        $action->date = mktime(0, 0, 0, $date1[1], $date1[0], $date1[2]);
    } else {
        $action->date = 0;
    }
    $action->save();
    
    include_once('./pages/historique.php');
    createHistorique(Historique::$Modification, 'action', $_SESSION['userId'], $action->idIndividu);
    
    echo action();
}
?>
