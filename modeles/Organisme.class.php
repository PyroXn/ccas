<?php

class Organisme extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('organisme');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('idTypeOrganisme', 'integer', 5);
        $this->hasColumn('appelation', 'string', 50);
        $this->hasColumn('adresse', 'string', 200);
        $this->hasColumn('cp', 'string', 10);
        $this->hasColumn('ville', 'string', 50);
        $this->hasColumn('telephone', 'string', 50);
        $this->hasColumn('fax', 'string', 50);
        $this->hasColumn('email', 'string', 50);
        $this->hasColumn('note', 'string', 200);
    }

}

?>
