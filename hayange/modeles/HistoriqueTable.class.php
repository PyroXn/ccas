<?php

require_once dirname(__FILE__).'/Historique.class.php';

class HistoriqueTable extends Doctrine_Table
{
    public function getHistoByUser($idUser) {
        $q = Doctrine_Query::create()
                ->from('historique')
                ->where('iduser = ?',$idUser)
                ->orderBy('id DESC')
                ->limit('10');
        return $q;
    }
}
?>
