<?php

class Revenu extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('revenu');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('salaire', 'float', array('default' => '0'));
        $this->hasColumn('chomage', 'float', array('default' => '0')); 
        $this->hasColumn('revenuAlloc', 'float', array('default' => '0'));
        $this->hasColumn('ass', 'float', array('default' => '0'));
        $this->hasColumn('aah', 'float', array('default' => '0'));
        $this->hasColumn('rsaSocle', 'float',array('default' => '0'));
        $this->hasColumn('rsaActivite', 'float',array('default' => '0'));
        $this->hasColumn('pensionAlim', 'float',array('default' => '0'));
        $this->hasColumn('pensionRetraite', 'float',array('default' => '0'));
        $this->hasColumn('retraitComp', 'float', array('default' => '0'));
        $this->hasColumn('autreRevenu', 'float',array('default' => '0'));
        $this->hasColumn('natureAutre', 'string', 150,array('default' => '')); // Nature autre revenu
        $this->hasColumn('idIndividu', 'integer', 10,array('default' => '0'));
        $this->hasColumn('aideLogement', 'float',0);
        $this->hasColumn('dateCreation', 'integer', 20,array('default' => '0'));
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
