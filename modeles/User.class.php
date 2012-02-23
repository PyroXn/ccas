<?php

class User extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('login', 'string', 50);
        $this->hasColumn('password', 'string', 80);
        $this->hasColumn('nomComplet', 'string', 200);
        $this->hasColumn('level', 'integer', 2);
        
    }

}
?>
