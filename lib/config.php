<?php

require_once './lib/Doctrine.php';
spl_autoload_register(array('Doctrine_Core', 'autoload'));
$cfg = 'modeles';
$dossier = opendir($cfg);
while ($fichier = readdir($dossier)) {
    if (is_file($cfg . '/' . $fichier) && $fichier != '/' && $fichier != '.' && $fichier != '..') {
        include_once $cfg . '/' . $fichier;
    }
}
$dsn = 'mysql://freeh_21900_38:Hc3p4LEn@db1.free-h.org/freeh_db_21900';
//$dsn = 'mysql://root:root@localhost/ccas';
$connexion = Doctrine_Manager::connection($dsn);
$connexion->setCollate('utf8_unicode_ci');
$connexion->setCharset('utf8');
?>