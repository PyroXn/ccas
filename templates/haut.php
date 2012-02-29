<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns ="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>ccas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./templates/navigationbar.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/ccas.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/tipsy.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/form.css" media="screen" />
    </head>
    <body>
        <div id="navigationbar">
            <ul id="navigationlist">
                <li class="navigationligne">
                    <a id="" class="lien_navigation" href="#" title="Ccas">
                        <span class="border_top"></span>
                        <span class="categorie">Ccas</span>
                    </a>
                </li>
                <li class="navigationligne">
                    <a id="" class="lien_navigation current" href="#" title="Expulsion">
                        <span class="border_top"></span>
                        <span class="categorie">Expulsion</span>
                    </a>
                </li>
                <li class="navigationligne">
                    <a id="" class="lien_navigation" href="#" title="Opif">
                        <span class="border_top"></span>
                        <span class="categorie">Opif</span>
                    </a>
                </li>
            </ul>
            <div id="navigationright">
                <ul id="connexionlist">
                    <li class="navigationligne">
                        <a class="lien_navigation" href="#" title="Connexion">
                            <span class="border_top"></span>
                            <?php
                            include_once('./lib/config.php');
                            if(isset($_SESSION['userId'])) {
                                $user = Doctrine_Core::getTable('user')->find($_SESSION['userId']);
                                echo '<span class="categorie">'.$user->nomcomplet.'</span>';
                            } else {
                                echo  '<span class="categorie">No Connect</span>';
                            }
                            ?>
                        </a>
                    </li>
                    <li class="navigationligne">
                        <a id="lien_option" name="passive" class="lien_navigation actif" href="#" title="Options">
                            <span class="border_top"></span>
                            <span id="option" class="categorie"></span>
                        </a>
                        <div class="menu_option">
                            <ul class="liste_menu_option">
                                <?php
                                if(isAuthorized("0100")) {
                                    echo '<li><a clas="" href="#">Configuration</a></li>';
                                }
                                if(isAuthorized("1000")) { // On autorise à partir de l'user level 2 soit 0100
                                    echo '<li><a class="" href="index.php?p=admin" >Administration</a></li>';
                                }
                                ?>
                                <li>
                                    <a class="" href="index.php?p=deconnexion" >Deconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


