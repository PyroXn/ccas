<?php
session_start();
if (!isset($_GET['p'])) {
    $_GET['p'] = "login";
    login();
} elseif($_GET['p'] == "login") {
    login();
} elseif ($_GET['p'] == "home") {
    home();
}

function home() {
    include_once('./lib/config.php');
    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche">
            <input class="search" type="text" placeholder="Search..."/><a href="#" class="add" original-title="Ajouter un foyer"></a>
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
                <span class="label">' . $individu->nom . ' ' . $individu->prenom . '</span>
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
                            <span class="label">Opif</span>
                        </a>
                        <a href="#" class="page_header_link">
                            <span class="label">Loulilou</span>
                        </a>
                    </div>
                </div>';
    display($title, $contenu);
}

function login() {
    if(!isset($_POST['wp-submit'])) {
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
    display($title,$contenu);
    } else {
        include_once('./lib/config.php');
        $user = Doctrine_Core::getTable('user');
        if($user->isMember($_POST['log'], md5($_POST['pwd'])) == 1) {
            $_SESSION['user'] = serialize($user->loadMember($_POST['log'], md5($_POST['pwd'])));
            header('Location: index.php?p=home');
        } else {
            $title = '';
            $contenu = 'Non';
            display($title,$contenu);
        }
    }
}
function display($title, $contenu) {
    include('./templates/haut.php');
    echo $contenu;
    include('./templates/bas.php');
}

?>
