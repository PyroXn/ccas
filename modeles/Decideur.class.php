<?php

class Decideur extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableDefinition('decideur');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('decideur', 'string', 255);
    }
}
?>
