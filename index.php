<?php
require_once 'lib/Doctrine.php';
spl_autoload_register(array('Doctrine_Core', 'autoload'));
require_once 'modeles/Individu.class.php';

$dsn = 'mysql://root:root@localhost/CCAS_NEW';
$connexion = Doctrine_Manager::connection($dsn);

try {
	$table = Doctrine_Core::getTable('Individu'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table a bien été créée';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}
?>