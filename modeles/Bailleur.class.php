<?php

class Bailleur extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableDefinition('bailleur');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('nomBailleur', 'string', 100);
        $this->hasColumn('adresse', 'string', 255);
        $this->hasColumn('idVille', 'integer', 10);
        $this->hasColumn('telephone', 'string', 30);
        $this->hasColumn('fax', 'string', 30);
        $this->hasColumn('email', 'string', 30);
    }
}
?>