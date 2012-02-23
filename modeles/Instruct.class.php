<?php

class Instruct extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('instruct');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('nom', 'string', 255);
        $this->hasColumn('adresse', 'string', 255);
        $this->hasColumn('telephone', 'string', 15);
        $this->hasColumn('interne', 'integer', 1); // Booléen : 0 : interne ; 1 : externe    
        }
}
?>
