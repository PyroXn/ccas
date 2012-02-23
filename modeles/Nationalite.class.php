<?php

class Nationalite extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableDefinition('nationalite');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('nationalite', 'string', 90);
    }
}
?>
