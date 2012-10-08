<?php

class LienFamille extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('lienfamille');

        $this->hasColumn('id', 'integer', 8, array('primary' => true,
            'autoincrement' => true));
        $this->hasColumn('lien', 'string', 100, array('notnull' => true, 'default' => ''));
        $this->option('orderBy', 'lien ASC');
    }

    public static $Epouse = 3;
    public static $Compagne = 5;
    public static $Epoux = 12;
    public static $Compagnon = 16;
    public static $ChefLuiMeme = 2;
    
}

?>
