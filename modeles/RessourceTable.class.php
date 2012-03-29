<?php
// On inclut le modèle «News ».
require_once dirname(__FILE__).'/Ressource.class.php';

class RessourceTable extends Doctrine_Table
{
    public function getLastFicheRessource($idIndividu) {
         $q = Doctrine_Query::create()
                ->from('ressource')
                ->where('idIndividu = ?', $idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
        return $q;
    }
}
?>