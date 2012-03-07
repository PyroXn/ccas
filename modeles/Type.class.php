<?php

class Type extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('type');
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('categorie', 'integer', 8,array('default' => '0'));
        $this->hasColumn('libelle', 'string', 50,array('default' => ' '));
        
    }

}

?>
