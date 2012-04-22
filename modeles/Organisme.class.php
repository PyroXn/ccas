<?php

class Organisme extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('organisme');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idlibelleorganisme', 'integer', 5);
        $this->hasColumn('appelation', 'string', 50, array('notnull' => true, 'default' => ''));
        $this->hasColumn('adresse', 'string', 200, array('notnull' => true, 'default' => ''));
        $this->hasColumn('cp', 'string', 10, array('notnull' => true, 'default' => ''));
        $this->hasColumn('ville', 'string', 50, array('notnull' => true, 'default' => ''));
        $this->hasColumn('telephone', 'string', 50, array('notnull' => true, 'default' => ''));
        $this->hasColumn('fax', 'string', 50, array('notnull' => true, 'default' => ''));
        $this->hasColumn('email', 'string', 50, array('notnull' => true, 'default' => ''));
        $this->hasColumn('note', 'string', 200, array('notnull' => true, 'default' => ''));
    }

    public function setUp() {
        $this->hasOne('libelleorganisme as libelleorganisme', array(
            'local' => 'idLibelleOrganisme',
            'foreign' => 'id'
                )
        
        );
        $this->hasMany('individu as individu', array(
            'local' => 'id',
            'foreign' => 'idCaisseMut'
                )
        
        );
        $this->hasMany('aideinterne as aideinterne', array(
            'local' => 'id',
            'foreign' => 'idOrganisme'
                )
        
        );
    }
}

?>
