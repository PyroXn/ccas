<?php

class Role extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('role');
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('designation', 'string', 50, array('default' => ' '));
        $this->hasColumn('permissions', 'integer', 11, array('notnull' => true));
    }

    public function setUp() {
        $this->hasMany('user as user', array(
            'local' => 'id',
            'foreign' => 'idRole'
                )
        );
    }

}

?>
