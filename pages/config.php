<?php

function homeConfig() {
    include_once('./pages/contenu.php');
    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche"></div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        '.generationHeaderNavigation('config').'
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">'.accueilConfig().'
                    <div>
                </div>
                ';
    display($title, $contenu);
}

function accueilConfig() {
    
}
?>
