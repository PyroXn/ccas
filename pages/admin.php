<?php

function homeAdmin() {
    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche"></div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        ' . generationHeaderNavigation('admin') . '
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">' . manageRole() . '</div>
                </div>
                ';
    display($title, $contenu);
}

function manageUser() {
    include_once('./lib/config.php');
    $users = Doctrine_Core::getTable('user')->findByActif(1);
    $roles = Doctrine_Core::getTable('role')->findAll();
    $contenu = '
        <div id="newUser" class="bouton ajout" value="add">
            <i class="icon-add"></i>
            <span>Ajouter un utilisateur</span>
        </div>
        <div class="formulaire" action="creation_utilisateur">
            <h2>Utilisateur</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input class="contour_field requis" type="text" title="Login" placeholder="Login" name="login" id="newlogin">
                </div>
                <div class="input_text">
                    <input class="contour_field requis" type="password" title="Password" placeholder="Password" name="pwd" id="newpwd">
                </div>
                <div class="input_text">
                    <input class="contour_field requis" type="text" title="Nom complet" placeholder="Nom complet" name="nomcomplet" id="newnomcomplet">
                </div>
                <div class="select classique" role="select_role">
                    <div class="option" id="newrole">Rôle</div>
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
        <ul class="select_role">';
            foreach ($roles as $role) {
                $contenu .= '
                    <li>
                        <div>'.$role->designation.'</div>
                    </li>';
            }
            $contenu .= '
        </ul>
        <table class="tableau_classique" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
                <thead>
                    <tr class="header">
                        <th>Nom complet</th>
                        <th>Login</th>
                        <th>Rôle</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($users as $user) {
        $contenu .= '
            <tr>
                <td nomcomplet>' . $user->nomcomplet . '</td>
                <td login>' . $user->login . '</td>
                <td role>' . $user->role->designation . '</td>
                <td  class="icon"><span class="edit_user" original-title="Modifier le compte" idUser="' . $user->id . '"></span></td>
                <td  class="icon"><span class="delete_user" original-title="Désactiver ' . $user->login . '" idUser="' . $user->id . '"></span></td>
                
            </tr>';
    }
    $contenu .= '</tbody></table>';
    return $contenu;
}

function manageRole() {
    $retour = '';
    $retour .= '
        <div id="newRole" class="bouton ajout" value="add">
            <i class="icon-add"></i>
            <span>Ajouter un rôle</span>
        </div>
        <div class="formulaire" action="creation_role">
            <h2>Role</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input id="designationRole" class="contour_field requis" type="text" title="Désignation" placeholder="Désignation">
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
        </div>';
    $retour .= affichagePermissions();
    return $retour;
}

function affichagePermissions() {
    include_once('./lib/config.php');
    $roles = Doctrine_Core::getTable('role')->findAll();

    include_once('Droit.class.php');
    $retour = '';

    $retour .= '
        <div style="margin: 10px 0 0 0; clear: both; height: 30px;" class="tab_menu">
            <ul id="permissions_configurator_tabs">
                <li class="selected" id="configurator_tab_general"><a href="#">Permissions générales</a></li>
                <li id="configurator_tab_documents"><a href="#">Permissions sur les documents</a></li>
                <li id="configurator_tab_individu"><a href="#">Permissions sur les menus d\'individu</a></li>
                <li id="configurator_tab_modif_creation"><a href="#">Permissions de modification et de création</a></li>
                <li id="configurator_tab_aide"><a href="#">Permissions sur la partie aide</a></li>
                <li id="configurator_tab_tableaubord"><a href="#">Permissions sur les tableaux de bords</a></li>
            </ul>
        </div>';
    $retour .= '
        <div id="permissions_configurator_tabs_panes" class="permission_list">
            <div id="configurator_tab_general_pane" class="tab_pane">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_ADMIN) . '</span>' . listRole($roles, Droit::$ACCES_ADMIN) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_CONFIG) . '</span>' . listRole($roles, Droit::$ACCES_CONFIG) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_documents_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_DOCUMENT) . '</span>' . listRole($roles, Droit::$ACCES_DOCUMENT) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_AJOUT_DOCUMENT) . '</span>' . listRole($roles, Droit::$DROIT_AJOUT_DOCUMENT) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_SUPPRESSION_DOCUMENT) . '</span>' . listRole($roles, Droit::$DROIT_SUPPRESSION_DOCUMENT) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_TELECHARGEMENT_DOCUMENT) . '</span>' . listRole($roles, Droit::$DROIT_TELECHARGEMENT_DOCUMENT) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_individu_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_FOYER) . '</span>' . listRole($roles, Droit::$ACCES_FOYER) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_GENERALITES) . '</span>' . listRole($roles, Droit::$ACCES_GENERALITES) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_BUDGET) . '</span>' . listRole($roles, Droit::$ACCES_BUDGET) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_AIDES) . '</span>' . listRole($roles, Droit::$ACCES_AIDES) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_ACTIONS) . '</span>' . listRole($roles, Droit::$ACCES_ACTIONS) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_HISTORIQUE_INDIVIDU) . '</span>' . listRole($roles, Droit::$ACCES_HISTORIQUE_INDIVIDU) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_DOCUMENT_INDIVIDU) . '</span>' . listRole($roles, Droit::$ACCES_DOCUMENT_INDIVIDU) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_modif_creation_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_FOYER) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_FOYER) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_INDIVIDU) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_INDIVIDU) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_FOYER) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_FOYER) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_INDIVIDU) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_INDIVIDU) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_GENERALITES) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_GENERALITES) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_BUDGET) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_BUDGET) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_ARCHIVER_BUDGET) . '</span>' . listRole($roles, Droit::$DROIT_ARCHIVER_BUDGET) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_ACTION) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_ACTION) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_ACTION) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_ACTION) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_aide_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_AIDE_INTERNE) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_AIDE_INTERNE) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_AIDE_EXTERNE) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_AIDE_EXTERNE) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_APPORTER_DECISION) . '</span>' . listRole($roles, Droit::$DROIT_APPORTER_DECISION) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_BON_INTERNE) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_BON_INTERNE) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_tableaubord_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_ACCES_GRAPH_INSTRUCT) . '</span>' . listRole($roles, Droit::$DROIT_ACCES_GRAPH_INSTRUCT) . '</li>
                </ul>
            </div>
        </div>';
    $retour .= '
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                      <th>Désignation</th>
                      <th>Nombres d\'utilisateurs</th>
                      <th></th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($roles as $r) {
        $retour .= '
            <tr>
                <td>' . $r->designation . '</td>
                <td>' . count($r->user) . '</td>
                <td class="icon"><span idRole="'.$r->id.'" class="delete_role"></span></td>
            </tr>';
    }
    $retour .= '</tbody></table>';
    return $retour;
}

function listRole($roles, $droit) {
    $retour = '';
    $retour .= '
            <div class="rounded_box">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="role">Rôle</th>
                        <th class="acces">Accés</th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($roles as $role) {
        $retour .= '
            <tr>
                <td class="ligne">' . $role->designation . '</td>';
        if (Droit::isAcces($role->permissions, $droit)) {
            $retour .= '<td class="acces ligne"><span droit="' . $droit . '" idRole="' . $role->id . '" class="checkboxPermission checkbox_active"></span></td>';
        } else {
            $retour .= '<td class="acces ligne"><span droit="' . $droit . '" idRole="' . $role->id . '" class="checkboxPermission"></span></td>';
        }
        $retour .= '</tr>';
    }
    $retour .= '</tbody></table></div>';
    return $retour;
}

function creationRole($designation) {
    include_once('./lib/config.php');
    $role = new Role();
    $role->designation = $designation;
    $role->save();
}

function addPermission() {
    include_once('./lib/config.php');
    $role = Doctrine_Core::getTable('role')->find($_POST['idRole']);
    //putain de php qui transforme du int en string pour rien ...
    $role->permissions |= (int) $_POST['droit'];
    $role->save();
}

function removePermission() {
    include_once('./lib/config.php');
    $role = Doctrine_Core::getTable('role')->find($_POST['idRole']);
    //putain de php qui transforme du int en string pour rien ...
    $role->permissions &= ~((int) $_POST['droit']);
    $role->save();
}

function removeRole() {
    include_once('./lib/config.php');
    $role = Doctrine_Core::getTable('role')->find($_POST['idRole']);
    $role->delete();
    echo manageRole();
}

function createUser($login, $password, $nomcomplet, $role) {
    include_once('./lib/config.php');
    if (isset ($_POST['iduser'])) {
        $user = Doctrine_Core::getTable('user')->find($_POST['iduser']);
    } else {
        $user = new User();
    }
    $role = Doctrine_Core::getTable('role')->findOneByDesignation($role);
    $user->login = $login;
    $user->password = md5($password);
    $user->nomcomplet = $nomcomplet;
    $user->idRole = $role->id;
    $user->save();
}

function deleteUser() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('user')->find($_POST['idUser']);
    $user->actif = false;
    $user->save();
    echo manageUser();
}


function statistique() {

    $csp = Doctrine_Core::getTable('profession')->findAll();    
    
    $contenu ='<div class="rounded_box" style="display: block; ">
                   <table cellpadding="0" cellspacing="0">
                       <thead>
                           <tr>
                               <th class="role">Information souhait&eacute;e</th>
                           </tr>
                       </thead>
                       <tbody name="groupe1">
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group1" value="nbinscrit"> Nombre d\'inscrit</td>
                           </tr>
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group1" value="nbaide"> Nombre d\'aide</td>
                           </tr>
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group1" value="montant"> Montants accord&eacute;s</td>
                           </tr>
                           
                       </tbody>
                   </table>
               </div>
               <div class="rounded_box" style="display: block; ">
                   <table cellpadding="0" cellspacing="0">
                       <thead>
                           <tr>
                               <th class="role">Par</th>
                           </tr>
                       </thead>
                       <tbody name="groupe2">
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group2" value="trancheage"> Tranche d\'&acirc;ge</td>
                           </tr>
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group2" value="csp"> Cat&eacute;gorie socioprofessionnelle</td>
                           </tr>
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group2" value="sexe"> Sexe</td>
                           </tr>
                       </tbody>
                   </table>
               </div>
               <div class="rounded_box" style="display: block; ">
                   <table cellpadding="0" cellspacing="0">
                       <thead>
                           <tr>
                               <th class="role">P&eacute;riode</th>
                           </tr>
                       </thead>
                       <tbody name="groupe3">
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group3" value="mois"> Mois</td>
                           </tr>
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group3" value="trimestre"> Trimestre</td>
                           </tr>
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group3" value="an"> Ann&eacute;e</td>
                           </tr>
                           <tr>
                               <td class="ligne"><input type="radio" class="radio_stat" name="group3" value="periode"> P&eacute;riode donn&eacute;e</td>
                           </tr>
                       </tbody>
                   </table>
               </div>
               <div class="admin_stat">
               </div>';

    $con = Doctrine_Manager::getInstance()->connection();
    $st = $con->execute("SELECT ae.id as idaide, i.id as idindividu ,ae.datedemande, t.libelle as libelleaide, ae.avis, ROUND(montantpercu, 2) as montant, '0' as interne
                         FROM aideexterne ae
                         INNER JOIN  individu i on i.id = ae.idindividu
                         LEFT JOIN type t on ae.idaidedemandee = t.id

                         UNION

                         SELECT ai.id as idaide, i.id as idindividu,ai.datedemande, t.libelle as libelleaide, ai.avis, 
                             ROUND((SELECT IF(SUM(montant)<>'', SUM(montant), 0)  
                             FROM bonaide ba
                             WHERE ba.idaideinterne = ai.id), 2) as montant, '1' as interne
                         FROM aideinterne ai
                         INNER JOIN  individu i on i.id = ai.idindividu
                         INNER JOIN type t on t.id = ai.idaidedemandee");
    // fetch query result
    $result = $st->fetchAll();

    $tabTemp = $result;


    return $contenu;
}

function genererStat() {
    include_once('./lib/config.php');
    $gp1 = $_POST['groupe1'];
    $gp2 = $_POST['groupe2'];
    $gp3 = $_POST['groupe3'];
    
    $x = "";
    $y = "";

    SWITCH ($groupe2) {
        case 'trancheage' :
            $x = array('moins de 18 ans', '18-25 ans', '16-40 ans', '41-60 ans', 'plus de 60 ans');
            break;
        case 'csp' :
                foreach($professions as $profession) {
                    array_push($x, $profession->profession);
                }
            break;            
        case 'sexe' :
            $x = array('Homme', 'Femme');
            break;
        }
    
    SWITCH ($groupe1) {
        //Nombre d\'inscritNombre d\'aideMontants accord&eacute;s
        case 'nbinscrit' :
            
            break;
        case 'nbaide' :
            break;
        case 'montant' :
            break;  
    }
    
    
    echo "ahahahahahahah";
}
?>
