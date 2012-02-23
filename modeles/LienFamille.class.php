<?php

class LienFamille extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableDefinition('lienFamille');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('lien', 'string', 100);
    }
}
?>
