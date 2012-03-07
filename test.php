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

//$foyer = Doctrine_Core::getTable('foyer')->find(1);
//
//function sortFoyer($a, $b) {
//    if ($a->chefDeFamille == 1) {
//        return -1;
//    }
//    if ($b->chefDeFamille == 1) {
//        return 1;
//    }    
//    return ($a->dateNaissance < $b->dateNaissance) ? -1 : 1;
//    return 0;
//}
//
//$individus = $foyer->individu;
//
//$individus = $individus->getData(); // convert from Doctrine_Collection to array
//
//echo '<h1>Pas triée</h1>';
//foreach($foyer->individu as $individu) {
//        echo '<div>'.$individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong>, chef de famille = '.$individu->chefDeFamille.' date de naissance = '.$individu->dateNaissance.'</div>';
//}
//
//usort($individus, "sortFoyer");
//echo '<h1>Triée</h1>';
//foreach($individus as $individu) {
//        echo '<div>'.$individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong>, chef de famille = '.$individu->chefDeFamille.' date de naissance = '.$individu->dateNaissance.'</div>';
//}

//$individu = new Individu();
//    $individu->civilite = 'Monsieur';
//    $individu->nom = 'Opif';
//    $individu->prenom = 'prenom';
//    
//    $individu->save();
//    
//    echo $individu->dateNaissance;


//$individu = Doctrine_Core::getTable('individu')->findOneByIdFoyerAndChefDeFamille(1, 0);
//$individu->chefDeFamille = true;
//$individu->save();
//echo '<div>'.$individu->nom . ', prenom: <strong>' . $individu->prenom . '</strong>, chef de famille = '.$individu->chefDeFamille.' date de naissance = '.$individu->dateNaissance.'</div>';
$individu = Doctrine_Core::getTable('dette')->getLastFicheDette(1);
echo '<div>'.$individu->arriereLocatif . ', prenom: <strong>' . $individu->fraisHuissier . '</strong></div>';
?>
