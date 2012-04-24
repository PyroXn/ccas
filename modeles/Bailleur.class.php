<?php

class Bailleur extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('bailleur');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('nombailleur', 'string', 100, array('notnull' => true, 'default' => ''));
        $this->hasColumn('adresse', 'string', 255, array('notnull' => true, 'default' => ''));
        $this->hasColumn('idville', 'integer', 10);
        $this->hasColumn('telephone', 'string', 30, array('notnull' => true, 'default' => ''));
        $this->hasColumn('fax', 'string', 30, array('notnull' => true, 'default' => ''));
        $this->hasColumn('email', 'string', 30, array('notnull' => true, 'default' => ''));
        $this->option('orderBy', 'nomBailleur ASC');
    }

    public function setUp() {
        $this->hasOne('ville as ville', array(
            'local' => 'idVille',
            'foreign' => 'id'
                )
        );
    }

}

?>
