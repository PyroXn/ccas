<?php

class Ville extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableDefinition('ville');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('situation', 'string', 100);
    }
}
?>
