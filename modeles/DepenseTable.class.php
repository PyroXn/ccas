<?php
// On inclut le modèle «News ».
require_once dirname(__FILE__).'/Depense.class.php';

class DepenseTable extends Doctrine_Table
{
    public function getLastFicheDepense($idIndividu) {
         $q = Doctrine_Query::create()
                ->from('depense')
                ->where('idIndividu = ?', $idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
        return $q;
    }
}
?>