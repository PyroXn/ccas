<?php

include_once('./lib/config.php');
session_start();

switch (@$_GET['p']) {
    case 'login':
        login();
        break;
    case 'home':
        home();
        break;
    case 'search':
        search();
        break;
    case 'foyer':
        foyer();
        break;
    case 'scroll':
        scroll();
        break;
    case 'deconnexion':
        deconnexion();
        break;
    case 'form':
        include_once('./pages/form.php');
        form();
        break;
    case 'admin':
        include_once('./pages/admin.php');
        homeAdmin();
        break;
    case 'manageuser':
        include_once('./pages/admin.php');
        manageUser();
        break;
    case 'deconnexion':
        deconnexion();
        break;
    default:
        login();
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
            <a href="#">
                <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . '</span>
            </a>
        </li>';
        $i++;
    }
    $contenu .= '
                        </ul>
                    </div>
                </div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        <a href="#" class="page_header_link active">
                            <span class="label">Accueil</span>
                        </a>
                        <a href="#" class="page_header_link">
                            <span class="label">Loulilou</span>
                        </a>
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">
                        <a class="bouton_modif">Modifier</a>
                        <!--<div class="formulaire">
                            <h2>Sexe</h2>
                            <div class="colonne_droite">
                                <div class="sauvegarder_annuler">
                                    <div class="bouton modif">Enregistrer</div>
                                    <div class="bouton classique">Annuler</div>
                                </div>
                            </div>
                        </div>-->
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
                        </p>
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
                    <a href="#">
                        <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . '</span>
                    </a>
                </li>';
        $i++;
    }
    echo $retour;
}

function foyer() {
    $listeIndividu = creationListeByFoyer($_POST['idFoyer'], $_POST['idIndividu']);
    $menu = generationHeaderNavigation(1);
    $retour = array('listeIndividu' => $listeIndividu, 'menu' => $menu);
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
                    <a href="#">
                        <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . ' </span>
                    </a>
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
    $retour = '
        <a href="#" class="page_header_link active">
            <span class="label">Foyer</span>
        </a>
        <a href="#" class="page_header_link">
            <span class="label">G&#233;n&#233;ralit&#233;s</span>
        </a>
        <a href="#" class="page_header_link">
            <span class="label">Budget</span>
        </a>
        <a href="#" class="page_header_link">
            <span class="label">Aides</span>
        </a>
        <a href="#" class="page_header_link">
            <span class="label">Historique</span>
        </a>';
    return $retour;
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
                            <a href="#">
                                <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom . '</span>
                            </a>
                        </li>';
        $i++;
    }
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
