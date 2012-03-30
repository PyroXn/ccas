<?php

class User extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('login', 'string', 50, array('default' => ' '));
        $this->hasColumn('password', 'string', 80);
        $this->hasColumn('nomcomplet', 'string', 200, array('default' => ' '));
        $this->hasColumn('idInstruct', 'integer', 5);
        $this->hasColumn('actif', 'integer',1, array('default' => '1'));
        $this->hasColumn('idRole', 'integer', 5);
        $this->option('orderBy', 'nomcomplet ASC');
    }
    
    public function setUp() {
        $this->hasMany('historique as historique', array(
            'local' => 'id',
            'foreign' => 'idUser'
                )
        );
         $this->hasOne('role as role',
    		array(
    			'local' => 'idRole', 
    			'foreign' => 'id'
    		)
    	);
    }

}
?>
