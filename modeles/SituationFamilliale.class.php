<?php

class SituationFamilliale extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('situationfamilliale');
        
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('situation', 'string', 100,array('notnull' => true, 'default' => ''));
        $this->option('orderBy', 'situation ASC');
    }
}
?>
