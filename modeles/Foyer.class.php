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

        $this->hasColumn('numRue', 'integer', 10);
        $this->hasColumn('idRue', 'integer', 10);
        $this->hasColumn('idSecteur', 'integer', 10);
        $this->hasColumn('idVille', 'integer', 10);
        $this->hasColumn('idSituationFamille', 'integer', 10);
        $this->hasColumn('idBailleur', 'integer', 10);
        $this->hasColumn('dateInscription', 'integer', 20); // timestamp
        $this->hasColumn('typeLogement', 'integer', 5);
        $this->hasColumn('typeAppartenance', 'integer', 5);
        $this->hasColumn('logDateArrive', 'integer', 20); // timestamp
        $this->hasColumn('logSurface', 'float');
        $this->hasColumn('idReferent', 'integer', 5);
        $this->hasColumn('notes', 'string', 255);
    }
    
    public function setUp() {
    	$this->hasMany(
                'individu as individu',
    		array(
    			'local' => 'id', 
    			'foreign' => 'idFoyer'
    		)
    	);
    }

}

?>