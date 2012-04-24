<?php

class LibelleType extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('libelletype');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('libelle', 'string',50,array('notnull' => true, 'default' => ''));
    }
    public function setUp() {
        $this->hasMany('type as type', array(
            'local' => 'id',
            'foreign' => 'idlibelletype'
                )
        );
    }
}

?>
