<?php
// On inclut le modèle «News ».
require_once dirname(__FILE__).'/AideExterne.class.php';

class AideExterneTable extends Doctrine_Table
{
    public function getAllFicheAideExterne($idIndividu) {
        $q = Doctrine_Query::create()
                ->from('aideexterne')
                ->where('idindividu = ?', $idIndividu)
                 ->orderBy('dateDemande DESC');
        return $q;
    }
}
?>
