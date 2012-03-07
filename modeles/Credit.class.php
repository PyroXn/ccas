<?php

class Credit extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('credit');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
	$this->hasColumn('organisme', 'string',50, array('default' => ''));
        $this->hasColumn('mensualite', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('dureeMois', 'integer', 5, array('default' => '0')); 
        $this->hasColumn('totalRestant', 'float', null, array('type' => 'float', 'default' => 0));
        $this->hasColumn('idIndividu', 'integer', 5, array('default' => '0'));
        $this->hasColumn('dateAjout', 'integer', 20, array('default' => '0'));
    }

}

?>
