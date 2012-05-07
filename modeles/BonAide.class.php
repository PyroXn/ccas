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
        $this->hasColumn('typeBon', 'integer', 1, array('notnull' => true, 'default' => '1'));
        $this->hasColumn('docRemis', 'integer', 1, array('notnull' => true, 'default' => '0'));
    }
    
    public static $BonAide = 1;
    public static $BonAideLibelle = 'BON ALIMENTAIRE COMISSION';
    public static $MandatSecoursUrgence = 2;
    public static $MandatSecoursUrgenceLibelle = 'SECOURS EN URGENCE';
    public static $AutreMandat = 3;
    public static $AutreMandatLibelle = 'AUTRES SECOURS';
    public static $MandatRSA = 4;
    public static $MandatRSALibelle = 'R.S.A.';
    public static $BonAideUrgence = 5;
    public static $BonAideUrgenceLibelle = 'BON ALIMENTAIRE URGENCE';
    
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
