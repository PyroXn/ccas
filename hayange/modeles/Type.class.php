<?php

class Type extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('type');
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idlibelletype', 'integer', 8,array('default' => '0'));
        $this->hasColumn('libelle', 'string', 50,array('notnull' => true, 'default' => ''));
        $this->option('orderBy', 'libelle ASC');
        
    }

    public function setUp() {
        $this->hasMany('aideexterne as aideexterne', array(
            'local' => 'id',
            'foreign' => 'idAideDemandee'
                )
        );
        $this->hasMany('aideinterne as aideinterne', array(
            'local' => 'id',
            'foreign' => 'idAideDemandee'
                )
        );
        $this->hasOne('libelletype as libelletype', array(
            'local' => 'idLibelletype',
            'foreign' => 'id'
                )
        
        );
    }
}

?>
