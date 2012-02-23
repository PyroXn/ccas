<?php

class LienFamille extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('lienfamille');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('lien', 'string', 100);
    }

}

?>
