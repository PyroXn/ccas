<?php

function homeAdmin() {
    include_once('./pages/contenu.php');
    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche"></div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        '.generationHeaderNavigation('admin').'
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">'.accueilAdmin().'
                    <div>
                </div>
                ';
    display($title, $contenu);
}

function editUser() {
    if(isset($_POST['user'])) {
        $user = Doctrine_Core::getTable('user')->find($_POST['user']);
        $contenu = '<fieldset><legend>Modifier un utilisateur</legend>
                        <form method="POST" action="index.php?p=manageuser">
                            <div class="input_text">
                                <input type="hidden" name="idedit" value="'.$user->id.'" id="idedit">
                                <input class="contour_field" type="text" title="Login" placeholder="Login" name="login" id="loginedit"value="'.$user->login.'">
                            </div>
                            <div class="input_text">
                                <input class="contour_field" type="password" title="Password" placeholder="Nouveau password" name="pwdedit" id="pwdedit">
                            </div>
                            <div class="input_text">
                                <input class="contour_field" type="text" title="Nom complet" placeholder="Nom complet" name="nomcompletedit" value="'.$user->nomcomplet.'" id="nomcompletedit">
                            </div>
                            <div class="sauvegarder_annuler">
                                <input type="button" class="modif" name="submitedit" id="submitedit" value="Enregistrer"/>
                                <input type="reset" class="classique" name="reset" value="Annuler"/>
                            </div>
                        </form>
                        </fieldset>';
        echo $contenu;
    } elseif(isset($_POST['idedit'])) {
        $user = Doctrine_Core::getTable('user')->find($_POST['idedit']);
        $user->login = $_POST['loginedit'];
        $user->nomcomplet = $_POST['nomcompletedit'];
        if($_POST['pwdedit'] != null) { $user->password = md5($_POST['pwd']); }
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
        <fieldset>
            <legend>Permissions g&eacute;n&eacute;rales</legend>
            <div class="permission">'.Droit::getStaticDesignation(Droit::$ACCES_ADMIN).'</div>'.listRole($roles, Droit::$ACCES_ADMIN).'
            <div class="permission">'.Droit::getStaticDesignation(Droit::$ACCES_CONFIG).'
        </fieldset>';
    
    return $retour;
}

function listRole($roles, $droit) {
    $retour = '';
    $retour .= '
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                        <th>R&ocirc;le</th>
                        <th>Acc&eacute;s</th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($roles as $role) {
        $retour .= '
            <tr>
                <td>'.$role->designation.'</td>';
                if (Droit::isAcces($role->permissions, $droit)) {
                    $retour .= '<td><span class="checkbox checkbox_active"></span></td>';
                } else {
                    $retour .= '<td><span class="checkbox"></span></td>';
                }
            $retour .= '</tr>';
    }
    $retour .= '</tbody></table>';
    return $retour;
}

function creationRole($designation) {
    include_once('./lib/config.php');
    $role = new Role();
    $role->designation = $designation;
    $role->save();
}

?>
