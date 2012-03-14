<?php

function action() {
    include_once('./lib/config.php');
    $actions = Doctrine_Core::getTable('action')->findByIdIndividu($_POST['idIndividu']);
    $types = Doctrine_Core::getTable('type')->findByCategorie(4); // Type Action
    $instructs = Doctrine_Core::getTable('instruct')->findByInterne(1); // Instruct interne
    $contenu = '<h2>Budget</h2>';
    $contenu .= '<div><h3><span>Suivi des actions</span></h3>';
    $contenu .= '<table border="0">
                                <tr>
                                    <td>Date</td>
                                    <td>Actions</td>
                                    <td>Motif</td>
                                    <td>Suite à donner</td>
                                    <td>Suite donnee</td>
                                    <td>Instructeur</td>
                                </tr>';
    foreach($actions as $action) {
        $contenu .= '<tr>
                                    <td>'.getDatebyTimestamp($action->date).'</td>
                                    <td>'.utf8_decode($action->typeaction->libelle).'</td>
                                    <td>'.$action->motif.'</td>
                                    <td>'.utf8_decode($action->suiteADonner).'</td>
                                    <td>'.utf8_decode($action->suitedonnee).'</td>
                                    <td>'.utf8_decode($action->instruct->nom).'</td>
                                </tr>';
    }
                                
    $contenu .= '</table>
                            <div class="bouton modif" id="createAction">Ajouter une action</div>
                            <div class="formulaire" action="creation_action">
                                   <div class="colonne_droite">
                                         <div class="input_text">
                                            <input id="date" class="contour_field" type="text" title="Date" placeholder="Date - jj/mm/aaaa">
                                        </div>
                                        <div class="select classique" role="select_motifaction">
                                            <div id="typeaction" class="option">--------</div>
                                            <div class="fleche_bas"> </div>
                                        </div>
                                        <div class="input_text">
                                            <input id="motif" class="contour_field" type="text" title="Motif" placeholder="Motif">
                                        </div>
                                        <div class="input_text">
                                            <input id="suiteadonner" class="contour_field" type="text" title="Suite à donner" placeholder="Suite à donner">
                                        </div>
                                        <div class="input_text">
                                            <input id="suitedonnee" class="contour_field" type="text" title="Suite donnée" placeholder="Suite donnée">
                                        </div>
                                        <div class="select classique" role="select_instruct">
                                            <div id="instruct" class="option">--------</div>
                                            <div class="fleche_bas"> </div>
                                        </div>
                                        <div class="sauvegarder_annuler">
                                            <div class="bouton modif" value="save">Enregistrer</div>
                                            <div class="bouton classique" value="cancel">Annuler</div>
                                        </div>
                                        
                                   </div>
                           </div>';
    // COMBO BOX
      $contenu .= '<ul class="select_instruct">';
    foreach($instructs as $instruct) {
        $contenu .= '<li>
                                    <div value="'.$instruct->id.'">'.utf8_decode($instruct->nom).'</div>
                                </li>';
    }
    $contenu .= '</ul>';
   $contenu .= '<ul class="select_motifaction">';
    foreach($types as $type) {
        $contenu .= '<li>
                                    <div value="'.$type->id.'">'.utf8_decode($type->libelle).'</div>
                                </li>';
    }
    $contenu .= '</ul>';
    return utf8_encode($contenu);

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
}
?>
