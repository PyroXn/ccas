<?php

function homeAdmin() {

    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche"></div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        <a href="index.php?p=admin" class="page_header_link active">
                            <span class="label">Administration - Accueil</span>
                        </a>
                        <a href="index.php?p=manageuser" class="page_header_link">
                            <span class="label">G&eacute;rer les utilisateurs</span>
                        </a>
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget libero vel massa sagittis adipiscing sed vitae enim. Praesent non eros nec nunc vestibulum pharetra in in nisl. Nulla et luctus ante. Donec et consequat nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque laoreet facilisis egestas. Sed a ullamcorper risus.
                            In convallis turpis pharetra ante commodo convallis. In sit amet neque vitae libero luctus mollis. Morbi hendrerit, felis eu cursus ornare, arcu mi sodales mauris, non tincidunt justo odio a lacus. Maecenas vel sodales nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae velit ac est laoreet sollicitudin. Nullam suscipit porttitor pellentesque. Ut vehicula ligula at leo rhoncus tristique. Praesent scelerisque, orci at consectetur pretium, libero nisl mattis sapien, nec elementum tortor sem sed enim. Vestibulum vitae vulputate felis. Aliquam laoreet quam mollis velit gravida interdum lacinia orci sodales. Vivamus non placerat magna. Duis leo nunc, tincidunt vel pharetra sit amet, mollis id nunc. Etiam semper fermentum mauris nec sodales. Morbi tincidunt, nisi vitae pellentesque fringilla, ipsum turpis porta massa, at tincidunt mi tellus congue massa.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget libero vel massa sagittis adipiscing sed vitae enim. Praesent non eros nec nunc vestibulum pharetra in in nisl. Nulla et luctus ante. Donec et consequat nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque laoreet facilisis egestas. Sed a ullamcorper risus.
                            In convallis turpis pharetra ante commodo convallis. In sit amet neque vitae libero luctus mollis. Morbi hendrerit, felis eu cursus ornare, arcu mi sodales mauris, non tincidunt justo odio a lacus. Maecenas vel sodales nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae velit ac est laoreet sollicitudin. Nullam suscipit porttitor pellentesque. Ut vehicula ligula at leo rhoncus tristique. Praesent scelerisque, orci at consectetur pretium, libero nisl mattis sapien, nec elementum tortor sem sed enim. Vestibulum vitae vulputate felis. Aliquam laoreet quam mollis velit gravida interdum lacinia orci sodales. Vivamus non placerat magna. Duis leo nunc, tincidunt vel pharetra sit amet, mollis id nunc. Etiam semper fermentum mauris nec sodales. Morbi tincidunt, nisi vitae pellentesque fringilla, ipsum turpis porta massa, at tincidunt mi tellus congue massa.
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget libero vel massa sagittis adipiscing sed vitae enim. Praesent non eros nec nunc vestibulum pharetra in in nisl. Nulla et luctus ante. Donec et consequat nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque laoreet facilisis egestas. Sed a ullamcorper risus.
                            In convallis turpis pharetra ante commodo convallis. In sit amet neque vitae libero luctus mollis. Morbi hendrerit, felis eu cursus ornare, arcu mi sodales mauris, non tincidunt justo odio a lacus. Maecenas vel sodales nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae velit ac est laoreet sollicitudin. Nullam suscipit porttitor pellentesque. Ut vehicula ligula at leo rhoncus tristique. Praesent scelerisque, orci at consectetur pretium, libero nisl mattis sapien, nec elementum tortor sem sed enim. Vestibulum vitae vulputate felis. Aliquam laoreet quam mollis velit gravida interdum lacinia orci sodales. Vivamus non placerat magna. Duis leo nunc, tincidunt vel pharetra sit amet, mollis id nunc. Etiam semper fermentum mauris nec sodales. Morbi tincidunt, nisi vitae pellentesque fringilla, ipsum turpis porta massa, at tincidunt mi tellus congue massa.
                        </p>
                    <div>
                </div>
                ';
    display($title, $contenu);
}

function manageUser() {
    if (!isset($_POST['submitpermission']) && !isset($_POST['submituser'])) {
        include_once('./lib/config.php');
        $users = Doctrine_Core::getTable('user')->findAll();
        $title = 'Accueil';
        $contenu = '
        <div id="menu_gauche"></div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        <a href="index.php?p=admin" class="page_header_link">
                            <span class="label">Administration - Accueil</span>
                        </a>
                        <a href="index.php?p=manageuser" class="page_header_link active">
                            <span class="label">G&eacute;rer les utilisateurs</span>
                        </a>
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">
                    <fieldset><legend>Ajouter un utilisateur</legend>
                    <form method="POST">
                        <div class="input_text">
                            <input class="contour_field" type="text" title="Login" placeholder="Login" name="login">
                        </div>
                        <div class="input_text">
                            <input class="contour_field" type="text" title="Password" placeholder="Password" name="pwd">
                        </div>
                        <div class="input_text">
                            <input class="contour_field" type="text" title="Nom complet" placeholder="Nom complet" name="nomcomplet">
                        </div>
                        <div class="sauvegarder_annuler">
                            <input type="submit" class="modif" name="submituser" value="Ajouter"/>
                            <input type="reset" class="classique" name="reset" value="Annuler"/>
                        </div>
                    </form>
                    </fieldset>
                    <fieldset><legend>G&eacute;rer les permissions</legend>
                    <form method="POST">
                    <table border="0">
                        <tr>
                            <td width="20%"></td>
                            <td width="20%">Utiliser le logiciel</td>
                            <td width="20%">Acc&eacute;der aux documents vierges</td>
                            <td width="20%">Configuration</td>
                            <td width="20%">Administration</td>
                       </tr>';
        foreach ($users as $user) {
            $check0 = $user->level[3] == 1 ? "checked = checked" : "";
            $check1 = $user->level[2] == 1 ? "checked = checked" : "";
            $check2 = $user->level[1] == 1 ? "checked = checked" : "";
            $check3 = $user->level[0] == 1 ? "checked = checked" : "";

            $contenu .= '<tr>
                                    <td width="20%">' . $user->nomcomplet . '</td>
                                    <td width="20%"><input type="checkbox" name="use' . $user->id . '" ' . $check0 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="access' . $user->id . '" ' . $check1 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="config' . $user->id . '" ' . $check2 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="admin' . $user->id . '" ' . $check3 . ' value="1"></td>                                          
                                </tr>';
        }
        $contenu .= '</table>
            <input type="submit" name="submitpermission" class="modif" value="Enregistrer" />
            <input type="reset" name="reset" class="classique" value="Annuler" />
            </form></fieldset>
            <div>
                </div>
                ';
        display($title, $contenu);
    } elseif (isset($_POST['submitpermission'])) {
        include_once('./lib/config.php');
        $users = Doctrine_Core::getTable('user')->findAll();
        $chaine = array();
        foreach ($users as $user) {
            $check0 = (isset($_POST['use' . $user->id])) ? $_POST['use' . $user->id] : "0";
            $check1 = (isset($_POST['access' . $user->id])) ? $_POST['access' . $user->id] : "0";
            $check2 = (isset($_POST['config' . $user->id])) ? $_POST['config' . $user->id] : "0";
            $check3 = (isset($_POST['admin' . $user->id])) ? $_POST['admin' . $user->id] : "0";
            $chaine = $check3 . $check2 . $check1 . $check0;

            // On met à jour
            $userUpdate = Doctrine_Core::getTable('user')->find($user->id);
            $userUpdate->level = $chaine;
            $userUpdate->save();
        }
        header("Location: index.php?p=manageuser");
    } elseif (isset($_POST['submituser'])) {
        $user = new User();
        $user->login = $_POST['login'];
        $user->password = md5($_POST['pwd']);
        $user->nomcomplet = $_POST['nomcomplet'];
        $user->save();
        header("Location: index.php?p=manageuser");
    }
}

?>
