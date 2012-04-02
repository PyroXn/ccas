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

function editUser() {
    if (isset($_POST['user'])) {
        $user = Doctrine_Core::getTable('user')->find($_POST['user']);
        $contenu = '<fieldset><legend>Modifier un utilisateur</legend>
                        <form method="POST" action="index.php?p=manageuser">
                            <div class="input_text">
                                <input type="hidden" name="idedit" value="' . $user->id . '" id="idedit">
                                <input class="contour_field" type="text" title="Login" placeholder="Login" name="login" id="loginedit"value="' . $user->login . '">
                            </div>
                            <div class="input_text">
                                <input class="contour_field" type="password" title="Password" placeholder="Nouveau password" name="pwdedit" id="pwdedit">
                            </div>
                            <div class="input_text">
                                <input class="contour_field" type="text" title="Nom complet" placeholder="Nom complet" name="nomcompletedit" value="' . $user->nomcomplet . '" id="nomcompletedit">
                            </div>
                            <div class="sauvegarder_annuler">
                                <input type="button" class="modif" name="submitedit" id="submitedit" value="Enregistrer"/>
                                <input type="reset" class="classique" name="reset" value="Annuler"/>
                            </div>
                        </form>
                        </fieldset>';
        echo $contenu;
    } elseif (isset($_POST['idedit'])) {
        $user = Doctrine_Core::getTable('user')->find($_POST['idedit']);
        $user->login = $_POST['loginedit'];
        $user->nomcomplet = $_POST['nomcompletedit'];
        if ($_POST['pwdedit'] != null) {
            $user->password = md5($_POST['pwd']);
        }
        $user->save();
    }
}

function manageUser() {
    include_once('./lib/config.php');
    $users = Doctrine_Core::getTable('user')->findByActif(1);
    $contenu = '
                    <fieldset><legend>Ajouter un utilisateur</legend>
                    <div id="newUser" class="bouton ajout" value="add">+</div>
        <div class="formulaire" action="creation_utilisateur">
            <h2>Utilisateur</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input class="contour_field" type="text" title="Login" placeholder="Login" name="login" id="newlogin">
                </div>
                <div class="input_text">
                    <input class="contour_field" type="password" title="Password" placeholder="Password" name="pwd" id="newpwd">
                </div>
                <div class="input_text">
                    <input class="contour_field" type="text" title="Nom complet" placeholder="Nom complet" name="nomcomplet" id="newnomcomplet">
                </div>
                <div class="sauvegarder_annuler">
                    <div class="bouton modif" value="save">Enregistrer</div>
                    <div class="bouton classique" value="cancel">Annuler</div>
                </div>
            </div>
        </div>
                    </fieldset>
                    <fieldset><legend>G&eacute;rer les permissions</legend>
                    <table id="manageuser" border="0">
                        <tr>
                            <td width="15%"></td>
                            <td width="5%"></td>
                            <td width="5%"></td>
                            <td width="20%">Utiliser le logiciel</td>
                            <td width="20%">Upload des documents</td>
                            <td width="20%">Configuration - Donn&eacute;es modulables</td>
                            <td width="20%">Administration</td>
                       </tr>';
    foreach ($users as $user) {
        $check0 = $user->level[3] == 1 ? "checked = checked" : "";
        $check1 = $user->level[2] == 1 ? "checked = checked" : "";
        $check2 = $user->level[1] == 1 ? "checked = checked" : "";
        $check3 = $user->level[0] == 1 ? "checked = checked" : "";

        $contenu .= '<tr>
                                    <td style="text-align: left;" width="15%">' . $user->nomcomplet . '</td>
                                    <td width="5%"><a id="test" href="#" class="delete" original-title="D&eacute;sactiver ' . $user->login . '" name="' . $user->login . '"><img src="./templates/img/delete.png"></img></a></td>
                                    <td width="5%"><a href="#" class="edituser" original-title="Modifier le compte" name="' . $user->id . '"><img src="./templates/img/edit.png"></img></a></td>
                                    <td width="20%"><input type="checkbox" name="use' . $user->id . '" ' . $check0 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="access' . $user->id . '" ' . $check1 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="config' . $user->id . '" ' . $check2 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="admin' . $user->id . '" ' . $check3 . ' value="1"></td>                                          
                                </tr>';
    }
    $contenu .= '</table>
            <input type="submit" name="submitpermission" id="submitpermission" class="modif" value="Enregistrer" />
            <input type="reset" name="reset" class="classique" value="Annuler" />
            </fieldset>
            <div id="useredit"></div>
            <div>
                </div>
                ';
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

?>
