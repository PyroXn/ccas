<?php

class Depense extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('depense');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('impotRevenu', 'float');
        $this->hasColumn('impotLocaux', 'float'); 
        $this->hasColumn('pensionAlim', 'float');
        $this->hasColumn('mutuelle', 'float');
        $this->hasColumn('electricite', 'float');
        $this->hasColumn('gaz', 'float');
        $this->hasColumn('eau', 'float');
        $this->hasColumn('chauffage', 'float');
        $this->hasColumn('telephonie', 'float');
        $this->hasColumn('internet', 'float');
        $this->hasColumn('television', 'float');
        $this->hasColumn('assurance', 'float');
        $this->hasColumn('credit', 'float');
        $this->hasColumn('autreDepense', 'float');
        $this->hasColumn('natureDepense', 'string', 150);
        $this->hasColumn('loyer', 'float');
        $this->hasColumn('idIndividu', 'integer', 5);
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
