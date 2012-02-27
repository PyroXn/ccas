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
        $this->hasColumn('nomMarital', 'string', 50);
        $this->hasColumn('nomUsage', 'string', 50);
        $this->hasColumn('chefDeFamille', 'boolean', 1);
        $this->hasColumn('dateNaissance', 'integer', 50);
        $this->hasColumn('sexe', 'string', 1);
        $this->hasColumn('telephone', 'string', 50);
        $this->hasColumn('portable', 'string', 50);
        $this->hasColumn('email', 'string', 50);
        $this->hasColumn('assure', 'boolean', 1);
        $this->hasColumn('numSecu', 'integer', 20);
        $this->hasColumn('clefSecu', 'integer', 10);
        $this->hasColumn('regime', 'integer', 5);
        $this->hasColumn('cmu', 'boolean', 1);
        $this->hasColumn('dateDebutCouvSecu', 'integer', 50);
        $this->hasColumn('dateFinCouvSecu', 'integer', 50);
        $this->hasColumn('numAdherentMut', 'string', 50);
        $this->hasColumn('dateDebutCouvMut', 'integer', 50);
        $this->hasColumn('dateFinCouvMut', 'integer', 50);
        $this->hasColumn('CMUC', 'boolean', 1);
        $this->hasColumn('employeur', 'string', 50);
        $this->hasColumn('dateInscriptionPe', 'integer', 50);
        $this->hasColumn('dateDebutDroitPe', 'integer', 50);
        $this->hasColumn('dateFinDroitPe', 'integer', 50);
        $this->hasColumn('numDossierPe', 'string', 20);
        $this->hasColumn('numAllocataireCaf', 'string', 20);
        $this->hasColumn('idLienFamille', 'integer', 5);               //cle etrangere
        $this->hasColumn('idCaisseCaf', 'integer', 5);            //cle etrangere
        $this->hasColumn('idNiveauEtude', 'integer', 5);          //cle etrangere
        $this->hasColumn('idProfession', 'integer', 5);           //cle etrangere
        $this->hasColumn('idCaisseMut', 'integer', 5);            //cle etrangere
        $this->hasColumn('idCaisseSecu', 'integer', 5);           //cle etrangere
        $this->hasColumn('idSitFam', 'integer', 5);               //cle etrangere
        $this->hasColumn('idNationalite', 'integer', 5);          //cle etrangere
        $this->hasColumn('idLieuNaissance', 'integer', 20);       //cle etrangere
        $this->hasColumn('idFoyer', 'integer', 8);       //cle etrangere
        
        
        
        $this->option('orderBy', 'nom ASC');
    }
    
    public function setUp() {
    	$this->hasOne('foyer as foyer',
    		array(
    			'local' => 'idFoyer', 
    			'foreign' => 'id'
    		)
    	);
    }
}
?>