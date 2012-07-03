<?php

class Action extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('action');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('date', 'integer', 20, array('default' => '0'));
        $this->hasColumn('idAction', 'integer', 5, array('default' => '0'));
        $this->hasColumn('motif', 'string', 150, array('notnull' => true, 'default' => ''));
        $this->hasColumn('suiteADonner', 'string', 150, array('notnull' => true, 'default' => ''));
        $this->hasColumn('suitedonnee', 'string', 150, array('notnull' => true, 'default' => ''));
        $this->hasColumn('idInstruct', 'integer', 5, array('default' => '0'));
        $this->hasColumn('idIndividu', 'integer', 5, array('default' => '0'));
        $this->option('orderBy', 'id DESC');

    }
    
      public function setUp() {
        $this->hasOne(
                'type as typeaction', array(
            'local' => 'idAction',
            'foreign' => 'id'
                )
        );
        
         $this->hasOne(
                'instruct as instruct', array(
            'local' => 'idInstruct',
            'foreign' => 'id'
                )
        );
      }

}


?>

