<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns ="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>ccas</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="./templates/navigationbar.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/ccas.css" class="switchable2" />
        <link rel="stylesheet" type="text/css" href="./templates/tipsy.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/glDatePicker.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/form.css" class="switchable" />
        <link rel="stylesheet" type="text/css" href="./templates/ui-lightness/jquery-ui-1.8.18.custom.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./templates/jquery.jqplot.min.css" media="screen" />
        
        <link rel="stylesheet" href="./templates/css/jquery.fileupload-ui.css" />
    </head>
    <body>
        <div id="navigationbar">
            <ul id="navigationlist">
                <li class="navigationligne">
                    <a id="" class="lien_navigation current" href="index.php" title="Ccas">
                        <span class="border_top"></span>
                        <span class="categorie">Ccas</span>
                    </a>
                </li>
            </ul>
            
            <div id="navigationright">
                <ul id="connexionlist">
                    <li class="navigationligne">
                        <a href="#" rel="./templates/form.css" rel2="./templates/ccas.css" class="css_switch cssform1" title="Thème classique"></a>
                    </li>
                    <li class="navigationligne">
                        <a href="#" rel="./templates/form2.css" rel2="./templates/ccas2.css" class="css_switch cssform2" title="Thème en couleur"></a>
                    </li>
                    <li class="navigationligne">
                        <span class="categorie"><a href="mailto:contact@mydevhouse.com" class="contact"></a></span>
                    </li>
                    <li class="navigationligne">
                        <a class="lien_navigation" href="index.php" title="Accueil">
                            <span class="border_top"></span>
                            <?php
                            include_once('./lib/config.php');
                            if(isset($_SESSION['userId'])) {
                                $user = Doctrine_Core::getTable('user')->find($_SESSION['userId']);
                                echo '<span class="categorie"><span class="home"></span>'.$user->nomcomplet.'</span>';
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
                                include_once('./pages/Droit.class.php');
                                if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_CONFIG)) {
                                    echo '<li><a clas="" href="index.php?p=config">Configuration</a></li>';
                                }
                                if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_ADMIN)) { 
                                    echo '<li><a class="" href="index.php?p=admin" >Administration</a></li>';
                                }
                                ?>
                                <li>
                                    <a class="deconnexion" href="index.php?p=deconnexion" >Deconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

