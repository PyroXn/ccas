<?php

class Rue extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('rue');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('rue', 'string', 255);
    }
}
?>
