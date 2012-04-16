<?php

class Foyer extends Doctrine_Record {

    public function setTableDefinition() {
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
        $this->hasColumn('idSitFam', 'integer', 5);        
        $this->hasColumn('notes', 'string', 255, array('notnull' => true, 'default' => ''));
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
            'local' => 'idRue',
            'foreign' => 'id'
                )
        );
        $this->hasOne(
                'secteur as secteur', array(
            'local' => 'idSecteur',
            'foreign' => 'id'
                )
        );
        $this->hasOne(
                'ville as ville', array(
            'local' => 'idVille',
            'foreign' => 'id'
                )
        );
        $this->hasOne(
                'bailleur as bailleur', array(
            'local' => 'idBailleur',
            'foreign' => 'id'
                )
        );
        $this->hasOne(
                'instruct as instruct', array(
            'local' => 'idInstruct',
            'foreign' => 'id'
                )
        );
        $this->hasOne(
                'type as typelogement', array(
            'local' => 'typeLogement',
            'foreign' => 'id'
                )
        );
        
        $this->hasOne(
                'type as statutlogement', array(
            'local' => 'typeAppartenance',
            'foreign' => 'id'
                )
        );
        
        $this->hasOne(
                'situationfamilliale as sitfam', array(
            'local' => 'idsitfam',
            'foreign' => 'id'
                )
        );
    }

}

?>