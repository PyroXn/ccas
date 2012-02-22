<?php

// On inclut le mod�le �Foyer �.
require_once dirname(__FILE__) . './Foyer.class.php';

class FoyerTable extends Doctrine_Table {

    public function likeNom($nom) {
        $q = Doctrine_Query::create()
                ->from('foyer')
                ->where('nom LIKE ? OR prenom LIKE ?', array($nom . '%', $nom . '%'))
                ->orderBy('nom ASC');
        return $q;
    }

}

?>