<?php

class Depense extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('depense');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('impotRevenu', 'float', array('default' => '0'));
        $this->hasColumn('impotLocaux', 'float', array('default' => '0')); 
        $this->hasColumn('pensionAlim', 'float', array('default' => '0'));
        $this->hasColumn('mutuelle', 'float', array('default' => '0'));
        $this->hasColumn('electricite', 'float', array('default' => '0'));
        $this->hasColumn('gaz', 'float', array('default' => '0'));
        $this->hasColumn('eau', 'float', array('default' => '0'));
        $this->hasColumn('chauffage', 'float', array('default' => '0'));
        $this->hasColumn('telephonie', 'float', array('default' => '0'));
        $this->hasColumn('internet', 'float', array('default' => '0'));
        $this->hasColumn('television', 'float', array('default' => '0'));
        $this->hasColumn('assurance', 'float', array('default' => '0'));
        $this->hasColumn('credit', 'float', array('default' => '0'));
        $this->hasColumn('autreDepense', 'float', array('default' => '0'));
        $this->hasColumn('natureDepense', 'string', 150, array('default' => ''));
        $this->hasColumn('loyer', 'float', array('default' => '0'));
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
