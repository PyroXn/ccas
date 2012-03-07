<?php

class Depense extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('depense');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('impotRevenu', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('impotLocaux', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('pensionAlim', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('mutuelle', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('electricite', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('gaz', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('eau', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('chauffage', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('telephonie', 'float',null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('internet', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('television', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('assurance', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('credit', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('autreDepense', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('natureDepense', 'string', 150, array('default' => ' '));
        $this->hasColumn('loyer', 'float', null, array('type' => 'float', 'default' => 0));
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
