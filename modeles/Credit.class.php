<?php

class Credit extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('credit');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
	$this->hasColumn('organisme', 'string',50);
        $this->hasColumn('mensualite', 'float');
        $this->hasColumn('dureeMois', 'integer', 5); 
        $this->hasColumn('totalRestant', 'float');
        $this->hasColumn('idIndividu', 'integer', 5);
        $this->hasColumn('dateAjout', 'integer', 20);
    }

}

?>
