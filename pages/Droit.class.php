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
}
?>
