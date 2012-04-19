<?php

class BonAide extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('bonaide');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idAideInterne', 'integer', 20);
        $this->hasColumn('idInstruct', 'integer', 20);
        $this->hasColumn('dateRemisePrevue', 'integer', 20);
        $this->hasColumn('dateRemiseEffective', 'integer', 20);
        $this->hasColumn('montant', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('commentaire', 'string',250);
        $this->hasColumn('typeBon', 'integer');
    }
    
    public static $BonAide = 1;
    public static $MandatUrgent = 2;
    public static $AutreMandat = 3;
    
    public function setUp() {
        $this->hasOne('aideInterne as aideInterne', array(
            'local' => 'idAideInterne',
            'foreign' => 'id'
                )
        );
        $this->hasOne('instruct as instruct', array(
            'local' => 'idInstruct',
            'foreign' => 'id'
                )
        );
    }
}


?>
