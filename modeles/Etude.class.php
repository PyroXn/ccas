<?php

class Etude extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('etude');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('etude', 'string', 90, array('default' => ' '));
        $this->option('orderBy', 'etude ASC');
    }
}
?>
