<?php
// On inclut le modèle «News ».
require_once dirname(__FILE__).'/Revenu.class.php';

class RevenuTable extends Doctrine_Table
{
    public function getLastFicheRessource($idIndividu) {
         $q = Doctrine_Query::create()
                ->from('revenu')
                ->where('idIndividu = ?', $idIndividu)
                 ->orderBy('datecreation DESC')
                 ->fetchOne();
        return $q;
    }
}
?>