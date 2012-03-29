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
// Attention, cela vide totalement la base de donn�es !
Doctrine_Core::dropDatabases();

// Cr�ation de la base (uniquement si elle n'EXISTE PAS)
Doctrine_Core::createDatabases();
try {
	$table = Doctrine_Core::getTable('Bailleur'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Decideur'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Etude'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Foyer'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Individu'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Instruct'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('LienFamille'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Nationalite'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Profession'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Rue'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Secteur'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('SituationMatri'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Type'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('User'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Ville'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('AideExterne'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('AideInterne'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('ressource'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Dette'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Depense'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Credit'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Organisme'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('LibelleOrganisme'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('Action'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('BonAide'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}

try {
	$table = Doctrine_Core::getTable('historique'); // On r�cup�re l'objet de la table.
	$connexion->export->createTable($table->getTableName(), 
		                           $table->getColumns()); // Puis, on la cr�e.
        echo 'La table <b>'.$table->getTableName().'</b> a bien �t� cr��e</br>';
} catch(Doctrine_Connection_Exception $e) { // Si une exception est lanc�e.
	echo $e->getMessage(); // On l'affiche.
}
?>
