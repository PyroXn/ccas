<?php

class AideExterne extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('aideexterne');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idIndividu', 'integer', 20);
        $this->hasColumn('dateDemande', 'integer', 20, array('default' => '0'));
        $this->hasColumn('idOrganisme', 'integer', 5);
        $this->hasColumn('nature', 'string', 20);
        $this->hasColumn('aideUrgente', 'integer', 1, array('default' => '0'));
        $this->hasColumn('idAideDemandee', 'integer', 5);
        $this->hasColumn('idInstruct', 'integer', 5);
        $this->hasColumn('idDistrib', 'integer', 5);
        $this->hasColumn('etat', 'string', 20);
        $this->hasColumn('avis', 'string', 20);
        $this->hasColumn('dateDecision', 'integer', 20, array('default' => '0'));
        $this->hasColumn('montantDemande', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('montantPercu', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('commentaire', 'string',250);
        $this->hasColumn('dateRevision', 'integer', 20);

    }

    public function setUp() {
        $this->hasOne('type as type', array(
            'local' => 'idAideDemandee',
            'foreign' => 'id'
                )
        );
    }
}


?>
