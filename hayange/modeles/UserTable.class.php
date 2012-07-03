<?php

require_once dirname(__FILE__) . '/User.class.php';

class UserTable extends Doctrine_Table {
    public function likeLogin($login) {
        $q = Doctrine_Query::create()
                ->from('user')
                ->where('login LIKE ?', array($login . '%'))
                ->orderBy('login ASC');
        return $q;
    }
    

}

?>
