<?php

require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine_Core', 'autoload'));
require_once '../modeles/Foyer.class.php';
require_once '../modeles/FoyerTable.class.php';
$dsn = 'mysql://root:root@localhost/ccas';
 
$connexion = Doctrine_Manager::connection($dsn);
$connexion->setCollate('utf8_unicode_ci');
$connexion->setCharset('utf8');
?>