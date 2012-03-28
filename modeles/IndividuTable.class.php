<?php

// On inclut le modèle «News ».
require_once dirname(__FILE__) . '/Individu.class.php';

class IndividuTable extends Doctrine_Table {

    public function likeNom($nom) {
        $q = Doctrine_Query::create()
                ->from('individu')
                ->where('nom LIKE ? OR prenom LIKE ?', array($nom . '%', $nom . '%'))
                ->orderBy('nom ASC');
        return $q;
    }

    public function searchByLimitOffset($limit, $offset) {
        $q = Doctrine_Query::create()
                ->from('individu')
                ->orderBy('nom ASC')
                ->limit($limit)
                ->offset($offset);
        return $q;
    }

     public function searchLikeByLimitOffset($nom, $limit, $offset) {
        $q = Doctrine_Query::create()
                ->from('individu')
                ->where('nom LIKE ? OR prenom LIKE ?', array($nom . '%', $nom . '%'))
                ->orderBy('nom ASC')
                ->limit($limit)
                ->offset($offset);
        return $q;
    }
}

?>