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
    default:
        login();
        break;
}

function home() {

    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche">
            <input id="search" type="text" placeholder="Search..."/><a href="#" class="add" original-title="Ajouter un foyer"></a>
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
                </div>';
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
                    <input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Se connecter" tabindex="100" />
                </p>
            </form>
        </div>';
        display($title, $contenu);
    } else {
        include_once('./lib/config.php');
        $user = Doctrine_Core::getTable('user')->findOneByLoginAndPassword($_POST['log'], md5($_POST['pwd']));
        if ($user != null) {
            $_SESSION['userId'] = $user->id;
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
    $retour = '';
    $foyer = Doctrine_Core::getTable('foyer')->find($_POST['idFoyer']);

    $i = 1;
    foreach ($foyer->individu as $individu) {
        if ($i % 2 == 0) {
            if ($individu->id == $_POST['idIndividu']) {
                $retour .= '<li class="pair individu current" id="' . $i . '">';
            } else {
                $retour .= '<li class="pair individu" id="' . $i . '">';
            }
        } else {
            if ($individu->id == $_POST['idIndividu']) {
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
    echo $retour;
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
