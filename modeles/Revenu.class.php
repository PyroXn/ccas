<?php

class Revenu extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('revenu');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('salaire', 'float');
        $this->hasColumn('chomage', 'float'); 
        $this->hasColumn('revenuAlloc', 'float');
        $this->hasColumn('ass', 'float');
        $this->hasColumn('aah', 'float');
        $this->hasColumn('rsaSocle', 'float');
        $this->hasColumn('rsaActivite', 'float');
        $this->hasColumn('pensionAlim', 'float');
        $this->hasColumn('pensionRetraite', 'float');
        $this->hasColumn('retraitComp', 'float');
        $this->hasColumn('autreRevenu', 'float');
        $this->hasColumn('natureAutre', 'string', 150); // Nature autre revenu
        $this->hasColumn('idIndividu', 'integer', 10);
        $this->hasColumn('aideLogement', 'float');
        $this->hasColumn('dateCreation', 'integer', 20);
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
