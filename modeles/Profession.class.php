<?php

class Profession extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('profession');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('profession', 'string', 100);
    }
}
?>
