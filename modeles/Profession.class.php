<?php

class Profession extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableDefinition('profession');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('profession', 'string', 100);
    }
}
?>
