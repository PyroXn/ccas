<?php

class Dette extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('dette');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('arriereLocatif', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('fraisHuissier', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('arriereElectricite', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('arriereGaz', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('autreDette', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('natureDette', 'string', 255, array('notnull' => true, 'default' => ''));
        $this->hasColumn('prestaElec', 'string', 50);
        $this->hasColumn('prestaGaz', 'string', 50);
        $this->hasColumn('idIndividu', 'integer', 5);
        $this->hasColumn('dateCreation', 'integer', 20, array('default' => '0'));
    }
    public function setUp() {
        $this->hasOne('individu as individu', array(
            'local' => 'idIndidivu',
            'foreign' => 'id'
                )
        );
}
}

?>
