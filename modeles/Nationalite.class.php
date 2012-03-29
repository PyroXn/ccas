<?php

class Nationalite extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('nationalite');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('nationalite', 'string', 90, array('default' => ' '));
        $this->option('orderBy', 'nationalite ASC');
    }
}
?>
