<?php

class Secteur extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('secteur');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('secteur', 'string', 255,array('default' => ''));
    }
}
?>
