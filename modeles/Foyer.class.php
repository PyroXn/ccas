<?php

class Foyer extends Doctrine_Record {

    public function setTableDefinition() {
        // On définit le nom de notre table : « news ».
        $this->setTableName('foyer');

        //Puis, tous les champs
        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('nom', 'string', 100);
        $this->hasColumn('prenom', 'string', 100);
    }

}

?>