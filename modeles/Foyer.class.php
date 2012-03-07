<?php

class Foyer extends Doctrine_Record {

    public function setTableDefinition() {
        // On définit le nom de notre table : « news ».
        $this->setTableName('foyer');

        //Puis, tous les champs
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
//        $this->hasColumn('nom', 'string', 100);
//        $this->hasColumn('prenom', 'string', 100);

        $this->hasColumn('numRue', 'integer', 10, array('default' => '0'));
        $this->hasColumn('idRue', 'integer', 10);
        $this->hasColumn('idSecteur', 'integer', 10);
        $this->hasColumn('idVille', 'integer', 10);
        $this->hasColumn('idBailleur', 'integer', 10);
        $this->hasColumn('dateInscription', 'integer', 20, array('default' => '0')); // timestamp
        $this->hasColumn('typeLogement', 'integer', 5);
        $this->hasColumn('typeAppartenance', 'integer', 5);
        $this->hasColumn('logDateArrive', 'integer', 20, array('default' => '0')); // timestamp
        $this->hasColumn('logSurface', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('idInstruct', 'integer', 5);
        $this->hasColumn('notes', 'string', 255, array('default' => ''));
    }

    public function setUp() {
        $this->hasMany(
                'individu as individu', array(
            'local' => 'id',
            'foreign' => 'idFoyer'
                )
        );

        $this->hasOne(
                'rue as rue', array(
            'local' => 'id',
            'foreign' => 'idRue'
                )
        );
        $this->hasOne(
                'secteur as secteur', array(
            'local' => 'id',
            'foreign' => 'idSecteur'
                )
        );
        $this->hasOne(
                'ville as ville', array(
            'local' => 'id',
            'foreign' => 'idVille'
                )
        );
        $this->hasOne(
                'bailleur as bailleur', array(
            'local' => 'id',
            'foreign' => 'idBailleur'
                )
        );
        $this->hasOne(
                'instruct as instruct', array(
            'local' => 'id',
            'foreign' => 'idInstruct'
                )
        );
    }

}

?>