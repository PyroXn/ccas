<?php
//require_once 'lib/Doctrine.php';
//spl_autoload_register(array('Doctrine_Core', 'autoload'));

//include_once 'modeles/Bailleur.class.php';
//include_once 'modeles/BailleurTable.class.php';
//include_once 'modeles/Decideur.class.php';
//include_once 'modeles/DecideurTable.class.php';
//include_once 'modeles/Etude.class.php';
//include_once 'modeles/EtudeTable.class.php';
//include_once 'modeles/Foyer.class.php';
//include_once 'modeles/FoyerTable.class.php';
//include_once 'modeles/Individu.class.php';
//include_once 'modeles/IndividuTable.class.php';
//include_once 'modeles/Instruct.class.php';
//include_once 'modeles/InstructTable.class.php';
//include_once 'modeles/LienFamille.class.php';
//include_once 'modeles/LienFamilleTable.class.php';
//include_once 'modeles/Nationalite.class.php';
//include_once 'modeles/NationaliteTable.class.php';
//include_once 'modeles/Profession.class.php';
//include_once 'modeles/ProfessionTable.class.php';
//include_once 'modeles/Rue.class.php';
//include_once 'modeles/RueTable.class.php';
//include_once 'modeles/Secteur.class.php';
//include_once 'modeles/SecteurTable.class.php';
//include_once 'modeles/SituationMatri.class.php';
//include_once 'modeles/SituationMatriTable.class.php';
//include_once 'modeles/Type.class.php';
//include_once 'modeles/TypeTable.class.php';
//include_once 'modeles/User.class.php';
//include_once 'modeles/UserTable.class.php';
//include_once 'modeles/Ville.class.php';
//include_once 'modeles/VilleTable.class.php';
//
//$cfg='modeles';
//$dossier = opendir($cfg);
//while($fichier = readdir($dossier)){
//    if(is_file($cfg.'/'.$fichier) && $fichier !='/' && $fichier !='.' && $fichier != '..'){
//		include_once $cfg.'/'.$fichier;
//    }
//}
//$dsn = 'mysql://freeh_21900_38:Hc3p4LEn@db1.free-h.org/freeh_db_21900';
////$dsn = 'mysql://root:root@localhost/ccas';
//$connexion = Doctrine_Manager::connection($dsn);
//$connexion->setCollate('utf8_unicode_ci');
//$connexion->setCharset('utf8');

include 'lib/config.php';

// Si elle existe, supprimez la base existante.
// Attention, cela vide totalement la base de données !
Doctrine_Core::dropDatabases();

// Création de la base (uniquement si elle n'EXISTE PAS)
Doctrine_Core::createDatabases();
try {
	$table = Doctrine_Core::getTable('Bailleur'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Decideur'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Etude'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Foyer'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Individu'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Instruct'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('LienFamille'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Nationalite'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Profession'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Rue'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Secteur'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('SituationMatri'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Type'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('User'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Ville'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('AideExterne'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('AideInterne'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('ressource'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Dette'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Depense'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Credit'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Organisme'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('LibelleOrganisme'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Action'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('BonAide'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('historique'); // On récupère l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la crée.
        echo 'La table <b>'.$table->getTableName().'</b> a bien été créée</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lancée.
	echo $e->getMessage(); // On l'affiche.
}
?>
