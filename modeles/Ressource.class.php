<?php

class Ressource extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('ressource');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('salaire', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('chomage', 'float', null, array('type' => 'float', 'default' => 0)); 
        $this->hasColumn('revenuAlloc', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('ass', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('aah', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('rsaSocle', 'float',null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('rsaActivite', 'float',null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('pensionAlim', 'float',null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('pensionRetraite', 'float',null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('retraitComp', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('autreRevenu', 'float',null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('natureAutre', 'string', 150,array('default' => '')); // Nature autre revenu
        $this->hasColumn('idIndividu', 'integer', 10,array('default' => '0'));
        $this->hasColumn('aideLogement', 'float',null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('dateCreation', 'integer', 20,array('default' => '0'));
        $this->hasColumn('ijss', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('pensionInvalide', 'float', null, array('type' => 'float', 'default' => 0));
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
