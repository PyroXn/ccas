<?php

class AideInterne extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('aideinterne');
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idIndividu', 'integer', 20);
        $this->hasColumn('dateDemande', 'integer', 20, array('default' => '0'));
        $this->hasColumn('idOrganisme', 'integer', 5);
        $this->hasColumn('nature', 'integer', 1);
        $this->hasColumn('aideUrgente', 'integer', 1, array('default' => '0'));
        $this->hasColumn('idAideDemandee', 'integer', 5);
        $this->hasColumn('idInstruct', 'integer', 5);
        $this->hasColumn('etat', 'string', 20);
        $this->hasColumn('proposition', 'string', 250, array('notnull' => true, 'default' => ''));
        $this->hasColumn('avis', 'string', 20, array('notnull' => true, 'default' => ''));
        $this->hasColumn('idDecideur', 'integer', 5);
        $this->hasColumn('dateDecision', 'integer', 20, array('default' => '0'));
        $this->hasColumn('vigilance', 'integer',2, array('default' => '0'));
        $this->hasColumn('idAideAccordee', 'integer', 5);
        $this->hasColumn('commentaire', 'string',250, array('notnull' => true, 'default' => ''));
        $this->hasColumn('rapport', 'string', 250, array('default' => ''));
        $this->hasColumn('montant', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('montanttotal', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('quantite', 'integer', 10, array('default' => '0'));
        $this->hasColumn('motifDemande', 'text');
        $this->hasColumn('evaluationSociale', 'text');
        $this->option('orderBy', 'id DESC');
    }

    public function setUp() {
        $this->hasOne('type as typeAideDemandee', array(
            'local' => 'idAideDemandee',
            'foreign' => 'id'
                )
        );
        $this->hasOne('type as typeAideAccordee', array(
            'local' => 'idAideAccordee',
            'foreign' => 'id'
                )
        );
        $this->hasOne('individu as individu', array(
            'local' => 'idIndividu',
            'foreign' => 'id'
                )
        );
        $this->hasOne('organisme as organisme', array(
            'local' => 'idOrganisme',
            'foreign' => 'id'
                )
        );
        $this->hasOne('instruct as instruct', array(
            'local' => 'idInstruct',
            'foreign' => 'id'
                )
        );
        $this->hasOne('decideur as decideur', array(
            'local' => 'idDecideur',
            'foreign' => 'id'
                )
        );

        $this->hasOne('type as natureAide', array(
            'local' => 'nature',
            'foreign' => 'id'
                )
        );

        $this->hasMany('bonAide as bonAide',
    		array(
    			'local' => 'id', 
    			'foreign' => 'idAideInterne'
    		)
    	);
    }
}

?>
