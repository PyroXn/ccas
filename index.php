<?php

include_once('./lib/config.php');
session_start();
if (!isset($_SESSION['userId'])) {
    login();
    exit();
}
switch (@$_GET['p']) {
    case 'login':
        login();
        break;
    case 'home':
        home();
        break;
    case 'accueil':
        accueil();
        break;
    case 'search':
        search();
        break;
    case 'autoComplete':
        autoComplete();
        break;
    case 'foyer':
        foyer();
        break;
    case 'scroll':
        scroll();
        break;
    case 'form':
        include_once('./pages/form.php');
        form();
        break;
    case 'contenu':
        include_once('./pages/contenu.php');
        contenu();
        break;
    case 'admin':
        include_once('./pages/admin.php');
        homeAdmin();
        break;
    case 'deconnexion':
        deconnexion();
        break;
    case 'edituser':
        include_once('./pages/admin.php');
        editUser();
        break;
    case 'updateChefDeFamille':
        include_once('./pages/individu.php');
        updateChefDeFamille();
        break;
    case 'deleteIndividu':
        include_once('./pages/individu.php');
        deleteIndividu();
        break;
    case 'updateressource':
        include_once('./pages/individu.php');
        updateRessource();
        break;
    case 'updatedepense':
        include_once('./pages/individu.php');
        updateDepense();
        break;
    case 'updatedepensehabitation':
        include_once('./pages/individu.php');
        updateDepenseHabitation();
        break;
    case 'updatedette':
        include_once('./pages/individu.php');
        updateDette();
        break;
    case 'archiveressource':
        include_once('./pages/individu.php');
        archiveRessource();
        break;
    case 'archivedepense':
        include_once('./pages/individu.php');
        archiveDepense();
        break;
    case 'archivedette':
        include_once('./pages/individu.php');
        archiveDette();
        break;
    case 'deletecredit':
        include_once('./pages/individu.php');
        deleteCredit();
        break;
    case 'updatecontact':
        include_once('./pages/individu.php');
        updateContact();
        break;
    case 'updatecaf':
        include_once('./pages/individu.php');
        updateCaf();
        break;
    case 'updatemutuelle':
        include_once('./pages/individu.php');
        updateMutuelle();
        break;
    case 'updatecouverture':
        include_once('./pages/individu.php');
        updateCouvertureSociale();
        break;
    case 'updatesituationprofessionnelle':
        include_once('./pages/individu.php');
        updateSituationProfessionnelle();
        break;
    case 'updateFoyer':
        include_once('./pages/contenu.php');
        updateFoyer();
        break;
    case 'updateinfoperso':
        include_once('./pages/individu.php');
        updateInfoPerso();
        break;
    default:
        home();
        break;
}

function home() {

    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche">
            <input id="search" class="contour_field" type="text" placeholder="Search..."/><a id="newfoyer" href="#" class="add" original-title="Ajouter un foyer"></a>
            <div id="side_individu">
                <ul id="list_individu">';
    $individus = Doctrine_Core::getTable('individu');
    $contenu .= '<div class="nb_individu">' . $individus->count() . '</div>';
    $i = 1;
    foreach ($individus->searchByLimitOffset(100, 0)->execute() as $individu) {
        if ($i % 2 == 0) {
            $contenu .= '<li class="pair individu" id="' . $i . '">';
        } else {
            $contenu .= '<li class="impair individu" id="' . $i . '">';
        }
        $contenu .= '
                           <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . '</span>
                 </li>';
        $i++;
    }
    $contenu .= '
                        </ul>
                    </div>
                </div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        '.generationHeaderNavigation('accueil').'
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">
                        '.accueilContenu().'
                    </div>
                </div>
                ';
    display($title, $contenu);
}

function login() {
    if (!isset($_POST['wp-submit'])) {
        $title = '';
        $contenu = '<div class="login">
            <form name="loginform" id="loginform" action="index.php?p=login" method="post">
                <p>
                    <label for="user_login">Identifiant<br />
                        <input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10" /></label>
                </p>
                <p>
                    <label for="user_pass">Mot de passe<br />
                        <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" /></label>
                </p>
                <p class="submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="modif" value="Se connecter" tabindex="100" />
                </p>
            </form>
        </div>';
        display($title, $contenu);
    } else {
        include_once('./lib/config.php');
        $user = Doctrine_Core::getTable('user')->findOneByLoginAndPassword($_POST['log'], md5($_POST['pwd']));
        if ($user != null && $user->actif == 0) {
            $_SESSION['userId'] = $user->id;
            $_SESSION['level'] = $user->level;
            header('Location: index.php?p=home');
        } else {
            $title = '';
            $contenu = 'Non';
            display($title, $contenu);
        }
    }
}

function search() {
    $q = $_POST['searchword'];

    $retour = '';
    $tableIndividus = Doctrine_Core::getTable('individu');
    $nb = $tableIndividus->likeNom($q)->count();
    if ($nb != 0) {
        $retour .= '<div class="nb_individu">' . $nb . '</div>';
    } else {
        $retour .= '<div class="nb_individu">Aucun r&#233;sultat</div>';
    }

    $i = 1;
    foreach ($tableIndividus->searchLikeByLimitOffset($q, 100, 0)->execute() as $individu) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair individu" id="' . $i . '">';
        } else {
            $retour .= '<li class="impair individu" id="' . $i . '">';
        }
        $retour .= '
                         <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . '</span>
                 </li>';
        $i++;
    }
    echo $retour;
}

function foyer() {
    include_once('./pages/contenu.php');
    $_SESSION['idIndividu'] = $_POST['idIndividu'];
    $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividu']);
    $menu = generationHeaderNavigation('foyer');
    $contenu = foyerContenu($_POST['idFoyer']);
    $retour = array('listeIndividu' => $listeIndividu, 'menu' => $menu, 'contenu' => $contenu);
    echo json_encode($retour);
}

function creationListeByFoyer($idFoyer, $idIndividu) {
    $retour = '';
    $foyer = Doctrine_Core::getTable('foyer')->find($idFoyer);

    $i = 1;
    foreach ($foyer->individu as $individu) {
        if ($i % 2 == 0) {
            if ($individu->id == $idIndividu) {
                $retour .= '<li class="pair individu current" id="' . $i . '">';
            } else {
                $retour .= '<li class="pair individu" id="' . $i . '">';
            }
        } else {
            if ($individu->id == $idIndividu) {
                $retour .= '<li class="impair individu current" id="' . $i . '">';
            } else {
                $retour .= '<li class="impair individu" id="' . $i . '">';
            }
        }
        $retour .= '
                        <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . ' </span>
                </li>';
        $i++;
    }
    return $retour;
}

/* genere la barre de navigation de la page selon le mode 
 * je pense à plusieurs mode de creation, si on doit générer le menu lorsqu'on click
 * sur un individu (cas le plus commun je pense), mais aussi générer le menu quand 
 * on est dans l'administration
 */

function generationHeaderNavigation($mode) {
    $retour = '';
    switch ($mode) {
        case 'accueil' :
            $retour = '
                <div id="accueil" class="page_header_link active">
                    <span class="label">Accueil</span>
                </div>';
            break;
        case 'foyer' :
            $retour = '
                <div id="foyer" class="page_header_link active">
                    <span class="label">Foyer</span>
                </div>
                <div id="generalites" class="page_header_link">
                    <span class="label">G&#233;n&#233;ralit&#233;s</span>
                </div>
                <div id="budget" class="page_header_link">
                    <span class="label">Budget</span>
                </div>
                <div id="aides" class="page_header_link">
                    <span class="label">Aides</span>
                </div>
                 <div id="actions" class="page_header_link">
                    <span class="label">Actions</span>
                </div>
                <div id="historique" class="page_header_link">
                    <span class="label">Historique</span>
                </div>';
            break;
        case 'admin' :
            $retour = '
                <div id="accueilAdmin" href="#" class="page_header_link active">
                    <span class="label">Administration - Accueil</span>
                </div>
                <div id="manageuser" href="#" class="page_header_link">
                    <span class="label">G&eacute;rer les utilisateurs</span>
                </div>';
            break;
    }
    return $retour;
}

function accueilContenu() {
    $retour = '
        <div class="input_text">
                    <input id="form_4" class="contour_field date" type="text" title="Date de naissance" placeholder="Date de naissance">
                </div>
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
        </p>';
    return $retour;
}

function accueil() {
    $menu = generationHeaderNavigation('accueil');
    $contenu = accueilContenu();
    $retour = array('menu' => $menu, 'contenu' => $contenu);
    echo json_encode($retour);
}

function scroll() {
    $retour = '';
    $individus = Doctrine_Core::getTable('individu');
    $i = $_POST['last'] + 1;
    $q = $_POST['searchword'];

    foreach ($individus->searchLikeByLimitOffset($q, 100, $_POST['last'])->execute() as $individu) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair individu" id="' . $i . '">';
        } else {
            $retour .= '<li class="impair individu" id="' . $i . '">';
        }
        $retour .= '
                    <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . '</span>
            </li>';
        $i++;
    }
    echo $retour;
}

function autoComplete() {
    $searchword = $_POST['searchword'];
    $table = $_POST['table'];
    $champ = $_POST['champ'];

    $retour = '';
    $t = Doctrine_Core::getTable($table);
    $likeNb = Doctrine_Query::create()
        ->from($table)
        ->where($champ + ' LIKE ?', array($searchword . '%'))
        ->orderBy($champ + ' ASC');
    $nb = $likeNb->count();
    
    $like = Doctrine_Query::create()
        ->from($table)
        ->where($champ .' LIKE ?', $searchword.'%')
        ->orderBy($champ .' ASC')
        ->limit(5);
    

    $retour = '<ul class="liste_suggestion" table="'.$table.'" champ="'.$champ.'">';
    
    foreach ($like->execute() as $tmp) {
        $retour .= '<li valeur="'.$tmp->id.'">'.$tmp->$champ.'</li>';
    }
    $retour .= '</ul>';
    echo $retour;
}

function deconnexion() {
    unset($_SESSION['userId']);
    header('Location: index.php');
}

function display($title, $contenu) {
    include('./templates/haut.php');
    echo $contenu;
    include('./templates/bas.php');
}

?>
