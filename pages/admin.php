<?php

function homeAdmin() {
    include_once('./pages/contenu.php');
    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche"></div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        ' . generationHeaderNavigation('admin') . '
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">' . accueilAdmin() . '
                    <div>
                </div>
                ';
    display($title, $contenu);
}

function manageUser() {
    include_once('./lib/config.php');
    $users = Doctrine_Core::getTable('user')->findByActif(1);
    $roles = Doctrine_Core::getTable('role')->findAll();
    $contenu = '   
        <div id="newUser" class="bouton ajout" value="add">Ajouter un utilisateur</div>
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
                    <div class="option" id="newrole">R&ocirc;le</div>
                    <div class="fleche_bas"> </div>
                </div>
                <div class="sauvegarder_annuler">
                    <div class="bouton modif" value="save">Enregistrer</div>
                    <div class="bouton classique" value="cancel">Annuler</div>
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
                        <th>R&ocirc;le</th>
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
                <td  class="icon"><span class="delete_user" original-title="D&eacute;sactiver ' . $user->login . '" idUser="' . $user->id . '"></span></td>
                
            </tr>';
    }
    $contenu .= '</tbody></table>';
    return $contenu;
}

function manageRole() {
    $retour = '';
    $retour .= '
        <div id="newRole" class="bouton ajout" value="add">Ajouter un r&ocirc;le</div>
        <div class="formulaire" action="creation_role">
            <h2>Role</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input id="designationRole" class="contour_field requis" type="text" title="D&eacute;signation" placeholder="D&eacute;signation">
                </div>
                <div class="sauvegarder_annuler">
                    <div class="bouton modif" value="save">Enregistrer</div>
                    <div class="bouton classique" value="cancel">Annuler</div>
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
                <li class="selected" id="configurator_tab_general"><a href="#">Permissions g&eacute;n&eacute;rales</a></li>
                <li id="configurator_tab_documents"><a href="#">Permissions sur les documents</a></li>
                <li id="configurator_tab_individu"><a href="#">Permissions sur les menus d\'individu</a></li>
                <li id="configurator_tab_modif_creation"><a href="#">Permissions de modification et de cr&eacute;ation</a></li>
                <li id="configurator_tab_aide"><a href="#">Permissions sur la partie aide</a></li>
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
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_AJOUT_DECISION) . '</span>' . listRole($roles, Droit::$DROIT_AJOUT_DECISION) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_DECISION) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_DECISION) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_BON_INTERNE) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_BON_INTERNE) . '</li>
                </ul>
            </div>
        </div>';
    $retour .= '
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                      <th>D&eacute;signation</th>
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
                        <th class="role">R&ocirc;le</th>
                        <th class="acces">Acc&eacute;s</th>
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
?>
