<?php
require_once 'lib/Doctrine.php';
spl_autoload_register(array('Doctrine_Core', 'autoload'));
require_once 'modeles/Foyer.class.php';
require_once 'modeles/Individu.class.php';

// Si l'utilisateur ne possède pas de mot de passe, il faut faire directement « utilisateur@serveur ».
$dsn = 'mysql://root:root@localhost/ccas';
$connexion = Doctrine_Manager::connection($dsn);

try {
	$table = Doctrine_Core::getTable('Foyer'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table a bien été créée';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}
try {
	$table = Doctrine_Core::getTable('Individu'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table a bien été créée';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

?>