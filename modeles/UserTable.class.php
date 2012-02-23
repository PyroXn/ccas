<?php

require_once dirname(__FILE__) . '/User.class.php';

class UserTable extends Doctrine_Table {

    public function isMember($login, $password) {
        $q = Doctrine_Query::create()
                ->from('user')
                ->where('login = ? AND password = ?', array($login , $password));
        return $q->count() == 1;
    }
    
    public function loadMember($login, $password) {
        $q = Doctrine_Query::create()
                ->from('user')
                ->where('login = ? AND password = ?', array($login , $password));
        return $q;
    }
    
    

}

?>
