<?php
require_once dirname(__FILE__).'/Dette.class.php';

class DetteTable extends Doctrine_Table
{
    public function getLastFicheDette($idIndividu) {
         $q = Doctrine_Query::create()
                ->from('dette')
                ->where('idIndividu = ?', $idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
        return $q;
    }
}
?>