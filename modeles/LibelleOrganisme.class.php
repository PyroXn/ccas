<?php

class LibelleOrganisme extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('libelleorganisme');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('libelle', 'string',50,array('default' => ' '));
    }
    public function setUp() {
        $this->hasMany('organisme as organisme', array(
            'local' => 'id',
            'foreign' => 'idLibelleOrganisme'
                )
        );
    }
}

?>
