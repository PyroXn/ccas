<?php

if (!isset($_GET['p'])) {
    $_GET['p'] = "home";
    home();
} elseif ($_GET['p'] == "home") {
    home();
}

function home() {
    include_once('./lib/config.php');
    $title = 'Accueil';
    $contenu = '<div id="menu_gauche">
            <input class="search" type="text" placeholder="Search..."/>
            <div id="side_foyer">
                <ul id="list_foyer">';
    $foyers = Doctrine_Core::getTable('foyer');
    $contenu .= '<div class="nb_foyer">' . $foyers->count() . '</div>';
    $i = 1;
    foreach ($foyers->searchByLimitOffset(100, 0)->execute() as $foyer) {
        if ($i % 2 == 0) {
            $contenu .= '<li class="pair foyer" id="' . $i . '">';
        } else {
            $contenu .= '<li class="impair foyer" id="' . $i . '">';
        }
        $contenu .= '
                            <a href="#">
                                <span class="label">' . $foyer->nom . ' ' . $foyer->prenom . ' ' . $foyer->id . '</span>
                            </a>
                        </li>';
        $i++;
    }
    $contenu .= '</ul>
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
                            </div>';
    display($title, $contenu);
}

function display($title, $contenu) {
    include('./templates/haut.php');
    echo $contenu;
    include('./templates/bas.php');
}
?>
