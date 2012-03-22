<?php

class BonAide extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('bonaide');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idAideInterne', 'integer', 20);
        $this->hasColumn('idInstruct', 'integer', 20);
        $this->hasColumn('idTypeAide', 'integer', 20);
        $this->hasColumn('dateRemisePrevu', 'integer', 20);
        $this->hasColumn('dateRemiseEffective', 'integer', 20);
        $this->hasColumn('montant', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('commentaire', 'string',250);

    }

    public function setUp() {
        $this->hasOne('aideInterne as aideInterne', array(
            'local' => 'idAideInterne',
            'foreign' => 'id'
                )
        );
    }
}


?>
