<?php
class Individu extends Doctrine_Record
{
    public function setTableDefinition()
    {
        // On définit le nom de notre table : « Individu ».
        $this->setTableName('individu');
		
	//Puis, tous les champs
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
						   'autoincrement' => true));      
        $this->hasColumn('civilite', 'string', 50);
        $this->hasColumn('nom', 'string', 50);
        $this->hasColumn('prenom', 'string', 50);
        $this->hasColumn('nomMarital', 'string', 50,array('notnull' => true, 'default' => ''));
        $this->hasColumn('nomUsage', 'string', 50,array('notnull' => true, 'default' => ''));
        $this->hasColumn('chefDeFamille', 'boolean', 1, array('default' => '0'));
        $this->hasColumn('dateNaissance', 'integer', 50,array('default' => '0'));
        $this->hasColumn('sexe', 'string', 10,array('notnull' => true, 'default' => ''));
        $this->hasColumn('telephone', 'string', 50, array('notnull' => true, 'default' => ''));
        $this->hasColumn('portable', 'string', 50,array('notnull' => true, 'default' => ''));
        $this->hasColumn('email', 'string', 50,array('notnull' => true, 'default' => ''));
        $this->hasColumn('assure', 'boolean', 1,array('default' => '0'));
        $this->hasColumn('numSecu', 'integer', 20,array('default' => '0'));
        $this->hasColumn('clefSecu', 'integer', 10,array('default' => '0'));
        $this->hasColumn('regime', 'string', 50,array('notnull' => true, 'default' => ''));
        $this->hasColumn('cmu', 'boolean', 1,array('default' => '0'));
        $this->hasColumn('dateDebutCouvSecu', 'integer', 50,array('default' => '0'));
        $this->hasColumn('dateFinCouvSecu', 'integer', 50,array('default' => '0'));
        $this->hasColumn('numAdherentMut', 'string', 50, array('notnull' => true, 'default' => ''));
        $this->hasColumn('dateDebutCouvMut', 'integer', 50,array('default' => '0'));
        $this->hasColumn('dateFinCouvMut', 'integer', 50, array('default' => '0'));
        $this->hasColumn('CMUC', 'boolean', 1,array('default' => '0'));
        $this->hasColumn('employeur', 'string', 50,array('notnull' => true, 'default' => ''));
        $this->hasColumn('dateInscriptionPe', 'integer', 50,array('default' => '0'));
        $this->hasColumn('dateDebutDroitPe', 'integer', 50,array('default' => '0'));
        $this->hasColumn('dateFinDroitPe', 'integer', 50, array('default' => '0'));
        $this->hasColumn('numDossierPe', 'string', 20, array('notnull' => true, 'default' => ''));
        $this->hasColumn('numAllocataireCaf', 'string', 20, array('notnull' => true, 'default' => ''));
        $this->hasColumn('idLienFamille', 'integer', 5);               //cle etrangere
        $this->hasColumn('idCaisseCaf', 'integer', 5);            //cle etrangere ==> A FAIRE
        $this->hasColumn('idNiveauEtude', 'integer', 5, array('notnull' => true, 'default' => '0'));          //cle etrangere
        $this->hasColumn('idProfession', 'integer', 5);           //cle etrangere
        $this->hasColumn('idCaisseMut', 'integer', 5);            //cle etrangere ==> A FAIRE
        $this->hasColumn('idCaisseSecu', 'integer', 5);           //cle etrangere == A FAIRE
        $this->hasColumn('idSitMatri', 'integer', 5);               //cle etrangere
        $this->hasColumn('idNationalite', 'integer', 5);          //cle etrangere
        $this->hasColumn('idVilleNaissance', 'integer', 20);       //cle etrangere
        $this->hasColumn('idFoyer', 'integer', 8);       //cle etrangere
        $this->hasColumn('scolarise', 'boolean', 1,array('default' => '0'));        
        $this->hasColumn('etablissementScolaire', 'string', 50,array('notnull' => true, 'default' => ''));        
        
        $this->option('orderBy', 'nom ASC');
    }
    
    public function setUp() {
    	$this->hasOne('foyer as foyer',
    		array(
    			'local' => 'idFoyer', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('lienfamille as lienfamille',
    		array(
    			'local' => 'idLienFamille', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('etude as etude',
    		array(
    			'local' => 'idNiveauEtude', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('profession as profession',
    		array(
    			'local' => 'idProfession', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('situationmatri as situationmatri',
    		array(
    			'local' => 'idSitMatri', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('nationalite as nationalite',
    		array(
    			'local' => 'idNationalite', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('ville as ville',
    		array(
    			'local' => 'idVilleNaissance', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasMany('ressource as ressource',
    		array(
    			'local' => 'id', 
    			'foreign' => 'idIndividu'
    		)
    	);
        $this->hasOne('organisme as mutuelle',
    		array(
    			'local' => 'idCaisseMut', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('organisme as caf',
    		array(
    			'local' => 'idCaisseCaf', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasOne('organisme as secu',
    		array(
    			'local' => 'idCaisseSecu', 
    			'foreign' => 'id'
    		)
    	);
        $this->hasMany('aideinterne as aideinterne', array(
            'local' => 'id',
            'foreign' => 'idIndividu'
                )
        );
        $this->hasMany('aideexterne as aideexterne', array(
            'local' => 'id',
            'foreign' => 'idIndividu'
                )
        );
    }
}
?>