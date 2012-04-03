<?php

class Historique extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('historique');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('typeAction', 'integer', 3, array('default' => '0'));
        $this->hasColumn('objet', 'string', 255, array('default' => ' '));
        $this->hasColumn('date', 'integer', 50, array('default' => '0'));
        $this->hasColumn('idUser', 'integer', 5);
        $this->hasColumn('idIndividu', 'integer', 5);
        $this->option('orderBy', 'id DESC');
    }

    public static $Creation = 1;
    public static $Modification = 2;
    public static $Suppression = 3;
    public static $Archiver = 4;

    public static function getStaticValue($i) {
        switch ($i) {
            case 1:
                return 'Cr&eacute;ation';
                break;
            case 2:
                return 'Modification';
                break;
            case 3:
                return 'Suppression';
                break;
            case 4:
                return 'Archiver';
                break;
            case 'Création':
                return 1;
                break;
            case 'Modification':
                return 2;
                break;
            case 'Suppression':
                return 3;
                break;
            case 'Archiver':
                return 4;
                break;
        }
    }

    public function setUp() {
        $this->hasOne('user as user', array(
            'local' => 'idUser',
            'foreign' => 'id'
                )
        );
        $this->hasOne('individu as individu', array(
            'local' => 'idIndividu',
            'foreign' => 'id'
                )
        );
    }

}

?>
