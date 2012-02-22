<?php

    require_once 'lib/Doctrine.php';
    spl_autoload_register(array('Doctrine_Core', 'autoload'));
    require_once 'modeles/Foyer.class.php';
    require_once 'modeles/FoyerTable.class.php';
    // Si l'utilisateur ne possède pas de mot de passe, il faut faire directement « utilisateur@serveur ».
    $dsn = 'mysql://root:root@localhost/ccas';
    $connexion = Doctrine_Manager::connection($dsn);

//    $foyer = Doctrine_Core::getTable('Foyer')->find(1);
//    echo $foyer->nom . ', prenom: <strong>' . $foyer->prenom . '</strong>';

    $foyer = Doctrine_Core::getTable('Foyer')->findOneByPrenom('Pierre');
    echo $foyer->nom . ', prenom: <strong>' . $foyer->prenom . '</strong>';
//    $requete = Doctrine_Core::getTable('Foyer')->findAll();
//
    
//    $requete = Doctrine_Core::getTable('Foyer')->findByPrenom('%P%');
//foreach($requete as $foyer)
//{
//    echo '<div>'.$foyer->nom . ', prenom: <strong>' . $foyer->prenom . '</strong></div>';
//}
    
    $famille = Doctrine_Core::getTable('Foyer');
    foreach($famille->likeNom('pier')->execute() as $foyer)
    {
        echo '<div>'.$foyer->nom . ', prenom: <strong>' . $foyer->prenom . '</strong></div>';
    }

?>
