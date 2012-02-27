<?php

class Dette extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('dette');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('arriereLocatif', 'float');
        $this->hasColumn('fraisHuissier', 'float'); 
        $this->hasColumn('arriereElectricite', 'float');
        $this->hasColumn('arriereGaz', 'float');
        $this->hasColumn('autreDette', 'float');
        $this->hasColumn('noteAutreDette', 'string', 255);
        $this->hasColumn('idPrestaElec', 'integer', 5);
        $this->hasColumn('idPrestaGaz', 'integer', 5);
        $this->hasColumn('idIndidivu', 'integer', 5);
        $this->hasColumn('dateCreation', 'integer', 20);
    }

}

?>
