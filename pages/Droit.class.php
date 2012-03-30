<?php
class Droit {
    
    /*
     * Pour ajouter un droit mettre à la suite et ajouter la valeur en hexa de la prochaine puissance de 2.
     * Il suffit de se souvenir de la progression 1 - 2 - 4 - 8, puis de recommencer en ajoutant un zéro à droite.
     * Serait-il judicieux de créer une table ?
     */
    
    
    /*
     * PANNEAUX BARRE DE NAVIGATION
     */
    public static $ACCES_ADMIN = 0x01;                      //accés panneau d'administration
    public static $ACCES_CONFIG = 0x02;                     //accés panneau de configuration
    
    /*
     * DOCUMENT GENERAL
     */
    public static $ACCES_DOCUMENT = 0x04;                   //accés panneau document général
    public static $DROIT_AJOUT_DOCUMENT = 0x08;             //droit ajout de document
    public static $DROIT_SUPPRESSION_DOCUMENT = 0x10;       //droit suppression de document
    public static $DROIT_TELECHARGEMENT_DOCUMENT = 0x20;    //droit de téléchargement de document
    
    /*
     * PANNEAUX BARRE DE MENU INDIVIDU
     */
    public static $ACCES_FOYER = 0x40;                      //accés panneau foyer
    public static $ACCES_GENERALITES = 0x80;                //accés panneau généralités
    public static $ACCES_BUDGET = 0x100;                    //accés panneau budget
    public static $ACCES_AIDES = 0x200;                     //accés panneau aides
    public static $ACCES_ACTIONS = 0x400;                   //accés panneau actions
    public static $ACCES_HISTORIQUE_INDIVIDU = 0x800;       //accés panneau historique de l'individu
    public static $ACCES_DOCUMENT_INDIVIDU = 0x1000;        //accés panneau document de l'individu
    
    
    public static $DROIT_CREATION_FOYER = 0x2000;           //droit création foyer
    public static $DROIT_CREATION_INDIVIDU = 0x4000;        //droit création individu
    
    public static $DROIT_MODIFICATION_FOYER = 0x8000;       //droit modification foyer
    public static $DROIT_MODIFICATION_INDIVIDU = 0x10000;   //droit modification individu
    
    public static $DROIT_MODIFICATION_GENERALITES = 0x20000;//droit modification généralités
    public static $DROIT_MODIFICATION_BUDGET = 0x40000;     //droit modification budget
    public static $DROIT_ARCHIVER_BUDGET = 0x80000;         //droit archiver budget
    
    /*
     * PARTIE AIDE
     */
    public static $DROIT_CREATION_AIDE_INTERNE = 0x100000;  //droit création aide interne
    public static $DROIT_CREATION_AIDE_EXTERNE = 0x200000;  //droit création aide externe
    public static $DROIT_AJOUT_DECISION = 0x400000;         //droit ajout d'une décision
    public static $DROIT_MODIFICATION_DECISION = 0x800000;  //droit de modification d'une décision
    public static $DROIT_CREATION_BON_INTERNE = 0x1000000;  //droit de création d'un bon interne
    
    public static $DROIT_CREATION_ACTION = 0x2000000;        //droit création action
    public static $DROIT_MODIFICATION_ACTION = 0x4000000;    //droit modification action
}
?>
