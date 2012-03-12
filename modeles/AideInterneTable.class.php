<?php
// On inclut le modèle «News ».
require_once dirname(__FILE__).'/AideInterne.class.php';

class AideInterneTable extends Doctrine_Table
{
    public function getAllFicheAideInterne($idIndividu) {
        $q = Doctrine_Query::create()
                ->from('aideinterne')
                ->where('idIndividu = ?', $idIndividu)
                 ->orderBy('dateDemande DESC')
                 ->fetchOne();
        return $q;
    }
}
?>
