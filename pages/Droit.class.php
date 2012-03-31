<?php
class Droit {
    
    /*
     * Pour ajouter un droit mettre � la suite et ajouter la valeur en hexa de la prochaine puissance de 2.
     * Il suffit de se souvenir de la progression 1 - 2 - 4 - 8, puis de recommencer en ajoutant un z�ro � droite.
     * Serait-il judicieux de cr�er une table ?
     */
    
    
    /*
     * PANNEAUX BARRE DE NAVIGATION
     */
    public static $ACCES_ADMIN = 0x01;                      //acc�s panneau d'administration
    public static $ACCES_CONFIG = 0x02;                     //acc�s panneau de configuration
    
    /*
     * DOCUMENT GENERAL
     */
    public static $ACCES_DOCUMENT = 0x04;                   //acc�s panneau document g�n�ral
    public static $DROIT_AJOUT_DOCUMENT = 0x08;             //droit ajout de document
    public static $DROIT_SUPPRESSION_DOCUMENT = 0x10;       //droit suppression de document
    public static $DROIT_TELECHARGEMENT_DOCUMENT = 0x20;    //droit de t�l�chargement de document
    
    /*
     * PANNEAUX BARRE DE MENU INDIVIDU
     */
    public static $ACCES_FOYER = 0x40;                      //acc�s panneau foyer
    public static $ACCES_GENERALITES = 0x80;                //acc�s panneau g�n�ralit�s
    public static $ACCES_BUDGET = 0x100;                    //acc�s panneau budget
    public static $ACCES_AIDES = 0x200;                     //acc�s panneau aides
    public static $ACCES_ACTIONS = 0x400;                   //acc�s panneau actions
    public static $ACCES_HISTORIQUE_INDIVIDU = 0x800;       //acc�s panneau historique de l'individu
    public static $ACCES_DOCUMENT_INDIVIDU = 0x1000;        //acc�s panneau document de l'individu
    
    
    public static $DROIT_CREATION_FOYER = 0x2000;           //droit cr�ation foyer
    public static $DROIT_CREATION_INDIVIDU = 0x4000;        //droit cr�ation individu
    
    public static $DROIT_MODIFICATION_FOYER = 0x8000;       //droit modification foyer
    public static $DROIT_MODIFICATION_INDIVIDU = 0x10000;   //droit modification individu
    
    public static $DROIT_MODIFICATION_GENERALITES = 0x20000;//droit modification g�n�ralit�s
    public static $DROIT_MODIFICATION_BUDGET = 0x40000;     //droit modification budget
    public static $DROIT_ARCHIVER_BUDGET = 0x80000;         //droit archiver budget
    
    /*
     * PARTIE AIDE
     */
    public static $DROIT_CREATION_AIDE_INTERNE = 0x100000;  //droit cr�ation aide interne
    public static $DROIT_CREATION_AIDE_EXTERNE = 0x200000;  //droit cr�ation aide externe
    public static $DROIT_AJOUT_DECISION = 0x400000;         //droit ajout d'une d�cision
    public static $DROIT_MODIFICATION_DECISION = 0x800000;  //droit de modification d'une d�cision
    public static $DROIT_CREATION_BON_INTERNE = 0x1000000;  //droit de cr�ation d'un bon interne
    
    public static $DROIT_CREATION_ACTION = 0x2000000;        //droit cr�ation action
    public static $DROIT_MODIFICATION_ACTION = 0x4000000;    //droit modification action
    
    public static function getStaticDesignation($i) {
        switch ($i) {
            case 0x01:
                return "Acc&eacute;s panneau d'administration";
                break;
            case 0x02:
                return 'Acc&eacute;s panneau de configuration';
                break;
            case 0x04:
                return 'Acc&eacute;s panneau document g&eacute;n&eacute;ral';
                break;
            case 0x08:
                return 'Droit ajout de document';
                break;
            case 0x10:
                return 'Droit suppression de document';
                break;
            case 0x20:
                return 'Droit de t&eacute;l&eacute;chargement de document';
                break;
            case 0x40:
                return 'Acc&eacute;s panneau foyer';
                break;
            case 0x80:
                return 'Acc&eacute;s panneau g&eacute;n&eacute;ralit&eacute;s';
                break;
            case 0x100:
                return 'Acc&eacute;s panneau budget';
                break;
            case 0x200:
                return 'Acc&eacute;s panneau aides';
                break;
            case 0x400:
                return 'Acc&eacute;s panneau actions';
                break;
            case 0x800:
                return "Acc&eacute;s panneau historique de l'individu";
                break;
            case 0x1000:
                return "Acc&eacute;s panneau document de l'individu";
                break;
            case 0x2000:
                return 'Droit cr&eacute;ation foyer';
                break;
            case 0x4000:
                return 'Droit cr&eacute;ation individu';
                break;
            case 0x8000:
                return 'Droit modification foyer';
                break;
            case 0x10000:
                return "Droit modification d'individu";
                break;
            case 0x20000:
                return 'Droit modification g&eacute;n&eacute;ralit&eacute;s';
                break;
            case 0x40000:
                return 'Droit modification budget';
                break;
            case 0x80000:
                return 'Droit archiver budget';
                break;
            case 0x100000:
                return 'Droit cr&eacute;ation aide interne';
                break;
            case 0x200000:
                return 'Droit cr&eacute;ation aide externe';
                break;
            case 0x400000:
                return "Droit ajout d'une d&eacute;cision";
                break;
            case 0x800000:
                return "Droit de modification d'une d&eacute;cision";
                break;
            case 0x1000000:
                return "Droit de cr&eacute;ation d'un bon interne";
                break;
            case 0x2000000:
                return "Droit de cr&eacute;ation d'une action";
                break;
            case 0x4000000:
                return "Droit de modification d'une action";
                break;
        }
    }
    
    /*
     * renvoie vrai si la permission pass�e en param contien le droit pass� en param
     */
    public static function isAcces($permissions, $droit) {
        if (((int)$permissions & $droit)) {
            return true;
        }
        return false;
    }
}
?>
