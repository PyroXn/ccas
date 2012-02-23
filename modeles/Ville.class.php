<?php

class Ville extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableDefinition('ville');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('cp', 'string', 10);
        $this->hasColumn('ville', 'string', 255);
    }
}
?>
