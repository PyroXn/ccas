<?php

class Aide extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('aide');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idIndividu', 'integer', 20);
        $this->hasColumn('idInstruct', 'integer', 5);
        $this->hasColumn('typeAide', 'integer', 5);
        $this->hasColumn('dateRemise', 'integer', 50); //timestamp
        $this->hasColumn('montant', 'float');
        $this->hasColumn('notes', 'string',100);
    }

}

?>
