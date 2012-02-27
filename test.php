<?php

include_once('./lib/config.php');

//    $individu = Doctrine_Core::getTable('individu')->find(1);
//    echo $individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong>';

//    $individu = Doctrine_Core::getTable('individu')->findOneByPrenom('Pierre');
//    echo $individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong>';
//    $requete = Doctrine_Core::getTable('individu')->findAll();
//
    
//    $requete = Doctrine_Core::getTable('individu')->findByPrenom('%P%');
//foreach($requete as $individu)
//{
//    echo '<div>'.$individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong></div>';
//}
    
//    $famille = Doctrine_Core::getTable('individu');
//    foreach($famille->likeNom('pier')->execute() as $individu)
//    {
//        echo '<div>'.$individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong></div>';
//    }


// $requete = Doctrine_Core::getTable('foyer')->findAll();
//foreach($requete as $foyer)
//{
//    echo '<div>'.$foyer->id;
//}

    $foyer = Doctrine_Core::getTable('foyer')->find(1);
    echo $foyer->numRue ;
    foreach($foyer->individu as $individu) {
        echo '<div>'.$individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong></div>';
    }
    

?>
