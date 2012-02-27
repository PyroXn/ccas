<?php

class Revenu extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('revenu');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('montantRevenu', 'float');
        $this->hasColumn('typeRevenu', 'integer', 5); // 1 : salaire ; 2 : chomage etc..
        $this->hasColumn('revenuAlloc', 'float');
        $this->hasColumn('rsaSocle', 'float');
        $this->hasColumn('rsaActivite', 'float');
        $this->hasColumn('pensionAlim', 'float');
        $this->hasColumn('pensionRetraite', 'float');
        $this->hasColumn('retraitComp', 'float');
        $this->hasColumn('autreRevenu', 'float');
        $this->hasColumn('natureAutre', 'string', 150); // Nature autre revenu
        $this->hasColumn('idIndividu', 'integer', 10);
    }

}

?>
