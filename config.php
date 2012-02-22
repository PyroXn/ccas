<?php

require_once 'lib/Doctrine.php';
spl_autoload_register(array('Doctrine_Core', 'autoload'));
require_once 'modeles/Foyer.class.php';
require_once 'modeles/FoyerTable.class.php';
// Si l'utilisateur ne possède pas de mot de passe, il faut faire directement « utilisateur@serveur ».
$dsn = 'mysql://root:root@localhost/ccas';
$connexion = Doctrine_Manager::connection($dsn);
?>