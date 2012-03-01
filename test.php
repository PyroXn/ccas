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

//    $foyer = Doctrine_Core::getTable('foyer')->find(1);
//    echo $foyer->numRue ;
//    foreach($foyer->individu as $individu) {
//        echo '<div>'.$individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong></div>';
//    }



//$mdp = 'florian';
//echo md5($mdp);


//$user = Doctrine_Core::getTable('user')->findOneByLoginAndPassword('Florian', md5('lorian'));
//if ($user != null) {
//    echo '<div> '.$user->login.' ' . $user->id . ' ' . $user->password . '</div>';
//} else {
//    echo "opif";
//}

     $users = Doctrine_Query::create()
                ->from('individu')
                ->where('idFoyer= ?', 1)
                ->orderBy('datenaissance DESC')
                ->execute();
    foreach($users as $user) {
        echo $user->prenom;
    }
    

?>
