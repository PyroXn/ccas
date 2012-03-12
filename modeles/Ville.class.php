<?php

class Ville extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('ville');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('cp', 'string', 10, array('default' => ' '));
        $this->hasColumn('libelle', 'string', 255, array('default' => ' '));
    }
    
    public function setUp() {
        $this->hasMany(
                'ville as ville', array(
            'local' => 'id',
            'foreign' => 'idVille'
                )
        );
    }

}

?>
