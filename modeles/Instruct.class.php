<?php

class Instruct extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('instruct');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('nom', 'string', 255, array('default' => ' '));
        $this->hasColumn('adresse', 'string', 255, array('default' => ' '));
        $this->hasColumn('telephone', 'string', 15, array('default' => ' '));
        $this->hasColumn('interne', 'boolean', 1, array('default' => '0')); // Booléen : 1 : interne ; 0 : externe
        }
}
?>
