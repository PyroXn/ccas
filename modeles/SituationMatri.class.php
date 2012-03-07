<?php

class SituationMatri extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('situationmatri');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('situation', 'string', 100,array('default' => ' '));
    }
}
?>
