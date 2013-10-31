<?php

function gestionCompte() {
    if (isset($_SESSION['userId'])) {
        $title = 'Accueil';
        $contenu = '
            <div id="menu_gauche"></div>
            <div id="page_header">
                <div id="page_header_navigation">
                    ' . generationHeaderNavigation('gestionCompte') . '
                </div>
            </div>
            <div id="contenu_wrapper">
                <div id="contenu">'.gestionPass().'</div>
            </div>';
    } else {
        login();
        exit();
    }
    display($title, $contenu);
}

function gestionPass() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('user')->find($_SESSION['userId']);
    
    $retour = '<div id="tableStatique">';
    $retour .= '<h3>Modification du mot de passe</h3>
        <ul class="list_classique" id="updatePwdPerso">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Login :</span>
                    <span><input class="contour_field input_char" type="text" id="login" disabled iduser="'.$user->id.'" value="'.$user->login.'"/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Ancien mot de passe :</span>
                    <span><input class="contour_field input_char requis" type="password" id="oldPwd" value=""/></span>
                </div>
            </li>
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Nouveau mot de passe :</span>
                    <span><input class="contour_field input_char requis" type="password" id="newPwd" value=""/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Vérification mot de passe :</span>
                    <span><input class="contour_field input_char requis" type="password" id="newPwdVerif" value=""/></span>
                </div>
            </li>
        </ul>
        <div value="updatePwd" class="bouton modif">
            <i class="icon-save"></i>
            <span>Enregistrer</span>
        </div>
        <div class="clearboth"></div>';
    return $retour;
}

function editPassword() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('user')->find($_POST['iduser']);
    $retour = '';
    if ($user->password == md5($_POST['oldPwd'])) {
        if (md5($_POST['newPwd']) == md5($_POST['newPwdVerif'])) {
            $user->password = md5($_POST['newPwd']);
            $user->save();
            $retour .= 'Votre mot de passe à été modifié';
        } else {
            $retour .= 'Votre nouveau mot de passe et sa vérification ne sont pas identique';
        }
    } else {
        $retour .= 'Ancien mot de passe incorect';
    }
    return $retour;
}

?>
