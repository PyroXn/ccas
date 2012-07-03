<?php

require_once dirname(__FILE__) . '/Action.class.php';

class ActionTable extends Doctrine_Table {

    public function getActionAfter($timestamp) {
        $q = Doctrine_Query::create()
                ->from('action')
                ->where('date > ?', $timestamp);
        return $q;
    }
    
    public function getActionByInstructAfter($timestamp, $idInstruct) {
        $q = Doctrine_Query::create()
                ->from('action')
                ->where('date > ? AND idinstruct = ?', array($timestamp, $idInstruct));
        return $q;
    }

}

?>
