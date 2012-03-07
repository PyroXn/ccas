<?php

class AideInterne extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('aideinterne');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idIndividu', 'integer', 20);
        $this->hasColumn('dateDemande', 'integer', 20, array('default' => '0'));
        $this->hasColumn('idOrigine', 'integer', 5);
        $this->hasColumn('idNature', 'integer', 5);
        $this->hasColumn('aideUrgente', 'integer', 1, array('default' => '0'));
        $this->hasColumn('idAideDemandee', 'integer', 5);
        $this->hasColumn('idInstruct', 'integer', 5);
        $this->hasColumn('idEtat', 'integer', 5);
        $this->hasColumn('proposition', 'string', 250, array('default' => ''));
        $this->hasColumn('idAvis', 'integer', 5);
        $this->hasColumn('idDecideur', 'integer', 5);
        $this->hasColumn('dateDecision', 'integer', 20, array('default' => '0'));
        $this->hasColumn('montant', 'float', array('default' => '0'));
        $this->hasColumn('quantite', 'integer', 5, array('default' => '0'));
        $this->hasColumn('montantTotal', 'float', array('default' => '0'));
        $this->hasColumn('vigilance', 'string',50, array('default' => ''));
        $this->hasColumn('idAideAccordee', 'integer', 5);
        $this->hasColumn('commentaire', 'string',250, array('default' => ''));
    }

}

?>
