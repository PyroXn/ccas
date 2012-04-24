<?php

function homeAdmin() {
    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche"></div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        ' . generationHeaderNavigation('admin') . '
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">' . manageRole() . '</div>
                </div>
                ';
    display($title, $contenu);
}

function manageUser() {
    include_once('./lib/config.php');
    $users = Doctrine_Core::getTable('user')->findByActif(1);
    $roles = Doctrine_Core::getTable('role')->findAll();
    $contenu = '
        <div id="newUser" class="bouton ajout" value="add">
            <i class="icon-add"></i>
            <span>Ajouter un utilisateur</span>
        </div>
        <div class="formulaire" action="creation_utilisateur">
            <h2>Utilisateur</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input class="contour_field requis" type="text" title="Login" placeholder="Login" name="login" id="newlogin">
                </div>
                <div class="input_text">
                    <input class="contour_field requis" type="password" title="Password" placeholder="Password" name="pwd" id="newpwd">
                </div>
                <div class="input_text">
                    <input class="contour_field requis" type="text" title="Nom complet" placeholder="Nom complet" name="nomcomplet" id="newnomcomplet">
                </div>
                <div class="select classique" role="select_role">
                    <div class="option" id="newrole">Rôle</div>
                    <div class="fleche_bas"> </div>
                </div>
                <div class="sauvegarder_annuler">
                    <div value="save" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Enregistrer</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                    </div>
                </div>
            </div>
        </div>
        <ul class="select_role">';
            foreach ($roles as $role) {
                $contenu .= '
                    <li>
                        <div>'.$role->designation.'</div>
                    </li>';
            }
            $contenu .= '
        </ul>
        <table class="tableau_classique" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
                <thead>
                    <tr class="header">
                        <th>Nom complet</th>
                        <th>Login</th>
                        <th>Rôle</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($users as $user) {
        $contenu .= '
            <tr>
                <td nomcomplet>' . $user->nomcomplet . '</td>
                <td login>' . $user->login . '</td>
                <td role>' . $user->role->designation . '</td>
                <td  class="icon"><span class="edit_user" original-title="Modifier le compte" idUser="' . $user->id . '"></span></td>
                <td  class="icon"><span class="delete_user" original-title="Désactiver ' . $user->login . '" idUser="' . $user->id . '"></span></td>
                
            </tr>';
    }
    $contenu .= '</tbody></table>';
    return $contenu;
}

function manageRole() {
    $retour = '';
    $retour .= '
        <div id="newRole" class="bouton ajout" value="add">
            <i class="icon-add"></i>
            <span>Ajouter un rôle</span>
        </div>
        <div class="formulaire" action="creation_role">
            <h2>Role</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input id="designationRole" class="contour_field requis" type="text" title="Désignation" placeholder="Désignation">
                </div>
                <div class="sauvegarder_annuler">
                    <div value="save" class="bouton modif">
                        <i class="icon-save"></i>
                        <span>Enregistrer</span>
                    </div>
                    <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                    </div>
                </div>
            </div>
        </div>';
    $retour .= affichagePermissions();
    return $retour;
}

function affichagePermissions() {
    include_once('./lib/config.php');
    $roles = Doctrine_Core::getTable('role')->findAll();

    include_once('Droit.class.php');
    $retour = '';

    $retour .= '
        <div style="margin: 10px 0 0 0; clear: both; height: 30px;" class="tab_menu">
            <ul id="permissions_configurator_tabs">
                <li class="selected" id="configurator_tab_general"><a href="#">Permissions générales</a></li>
                <li id="configurator_tab_documents"><a href="#">Permissions sur les documents</a></li>
                <li id="configurator_tab_individu"><a href="#">Permissions sur les menus d\'individu</a></li>
                <li id="configurator_tab_modif_creation"><a href="#">Permissions de modification et de création</a></li>
                <li id="configurator_tab_aide"><a href="#">Permissions sur la partie aide</a></li>
                <li id="configurator_tab_tableaubord"><a href="#">Permissions sur les tableaux de bords</a></li>
            </ul>
        </div>';
    $retour .= '
        <div id="permissions_configurator_tabs_panes" class="permission_list">
            <div id="configurator_tab_general_pane" class="tab_pane">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_ADMIN) . '</span>' . listRole($roles, Droit::$ACCES_ADMIN) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_CONFIG) . '</span>' . listRole($roles, Droit::$ACCES_CONFIG) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_documents_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_DOCUMENT) . '</span>' . listRole($roles, Droit::$ACCES_DOCUMENT) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_AJOUT_DOCUMENT) . '</span>' . listRole($roles, Droit::$DROIT_AJOUT_DOCUMENT) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_TELECHARGEMENT_DOCUMENT) . '</span>' . listRole($roles, Droit::$DROIT_TELECHARGEMENT_DOCUMENT) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_SUPPRESSION_DOCUMENT) . '</span>' . listRole($roles, Droit::$DROIT_SUPPRESSION_DOCUMENT) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_AJOUT_DOC_IND) . '</span>' . listRole($roles, Droit::$DROIT_AJOUT_DOC_IND) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_TELECHARGER_DOC_IND) . '</span>' . listRole($roles, Droit::$DROIT_TELECHARGER_DOC_IND) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_individu_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_FOYER) . '</span>' . listRole($roles, Droit::$ACCES_FOYER) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_GENERALITES) . '</span>' . listRole($roles, Droit::$ACCES_GENERALITES) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_BUDGET) . '</span>' . listRole($roles, Droit::$ACCES_BUDGET) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_AIDES) . '</span>' . listRole($roles, Droit::$ACCES_AIDES) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_ACTIONS) . '</span>' . listRole($roles, Droit::$ACCES_ACTIONS) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_HISTORIQUE_INDIVIDU) . '</span>' . listRole($roles, Droit::$ACCES_HISTORIQUE_INDIVIDU) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$ACCES_DOCUMENT_INDIVIDU) . '</span>' . listRole($roles, Droit::$ACCES_DOCUMENT_INDIVIDU) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_modif_creation_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_FOYER) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_FOYER) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_INDIVIDU) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_INDIVIDU) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_FOYER) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_FOYER) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_INDIVIDU) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_INDIVIDU) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_GENERALITES) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_GENERALITES) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_BUDGET) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_BUDGET) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_ARCHIVER_BUDGET) . '</span>' . listRole($roles, Droit::$DROIT_ARCHIVER_BUDGET) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_ACTION) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_ACTION) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_MODIFICATION_ACTION) . '</span>' . listRole($roles, Droit::$DROIT_MODIFICATION_ACTION) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_aide_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_AIDE_INTERNE) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_AIDE_INTERNE) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_AIDE_EXTERNE) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_AIDE_EXTERNE) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_APPORTER_DECISION) . '</span>' . listRole($roles, Droit::$DROIT_APPORTER_DECISION) . '</li>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_CREATION_BON_INTERNE) . '</span>' . listRole($roles, Droit::$DROIT_CREATION_BON_INTERNE) . '</li>
                </ul>
            </div>
            <div id="configurator_tab_tableaubord_pane" class="tab_pane" style="display: none;">
                <ul>
                    <li><span class="permission">' . Droit::getStaticDesignation(Droit::$DROIT_ACCES_GRAPH_INSTRUCT) . '</span>' . listRole($roles, Droit::$DROIT_ACCES_GRAPH_INSTRUCT) . '</li>
                </ul>
            </div>
        </div>';
    $retour .= '
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                      <th>Désignation</th>
                      <th>Nombres d\'utilisateurs</th>
                      <th></th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($roles as $r) {
        $retour .= '
            <tr>
                <td>' . $r->designation . '</td>
                <td>' . count($r->user) . '</td>
                <td class="icon"><span idRole="'.$r->id.'" class="delete_role"></span></td>
            </tr>';
    }
    $retour .= '</tbody></table>';
    return $retour;
}

function listRole($roles, $droit) {
    $retour = '';
    $retour .= '
            <div class="rounded_box">
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="role">Rôle</th>
                        <th class="acces">Accés</th>
                    </tr>
                </thead>
                <tbody>';
    foreach ($roles as $role) {
        $retour .= '
            <tr>
                <td class="ligne">' . $role->designation . '</td>';
        if (Droit::isAcces($role->permissions, $droit)) {
            $retour .= '<td class="acces ligne"><span droit="' . $droit . '" idRole="' . $role->id . '" class="checkboxPermission checkbox_active"></span></td>';
        } else {
            $retour .= '<td class="acces ligne"><span droit="' . $droit . '" idRole="' . $role->id . '" class="checkboxPermission"></span></td>';
        }
        $retour .= '</tr>';
    }
    $retour .= '</tbody></table></div>';
    return $retour;
}

function creationRole($designation) {
    include_once('./lib/config.php');
    $role = new Role();
    $role->designation = $designation;
    $role->save();
}

function addPermission() {
    include_once('./lib/config.php');
    $role = Doctrine_Core::getTable('role')->find($_POST['idRole']);
    //putain de php qui transforme du int en string pour rien ...
    $role->permissions |= (int) $_POST['droit'];
    $role->save();
}

function removePermission() {
    include_once('./lib/config.php');
    $role = Doctrine_Core::getTable('role')->find($_POST['idRole']);
    //putain de php qui transforme du int en string pour rien ...
    $role->permissions &= ~((int) $_POST['droit']);
    $role->save();
}

function removeRole() {
    include_once('./lib/config.php');
    $role = Doctrine_Core::getTable('role')->find($_POST['idRole']);
    $role->delete();
    echo manageRole();
}

function createUser($login, $password, $nomcomplet, $role) {
    include_once('./lib/config.php');
    if (isset ($_POST['iduser'])) {
        $user = Doctrine_Core::getTable('user')->find($_POST['iduser']);
    } else {
        $user = new User();
    }
    $role = Doctrine_Core::getTable('role')->findOneByDesignation($role);
    $user->login = $login;
    $user->password = md5($password);
    $user->nomcomplet = $nomcomplet;
    $user->idRole = $role->id;
    $user->save();
}

function deleteUser() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('user')->find($_POST['idUser']);
    $user->actif = false;
    $user->save();
    echo manageUser();
}


function statistique() {

    $csp = Doctrine_Core::getTable('profession')->findAll();    
    
    $contenu ='<div class="colonne">
                   <div class="rounded_box" style="display: block; ">
                       <table cellpadding="0" cellspacing="0">
                           <thead>
                               <tr>
                                   <th class="role">Information souhait&eacute;e</th>
                               </tr>
                           </thead>
                           <tbody name="groupe1">
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbinscrit"> Nombre d\'inscrit</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbaide"> Nombre d\'aide demandée</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbaideurg"> Nombre d\'aide urgente demandée</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="nbaideext"> Nombre d\'aide externe</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe1" value="montant"> Montants accord&eacute;s</td>
                               </tr>

                           </tbody>
                       </table>
                   </div>
               </div>
               <div class="colonne">
                   <div class="rounded_box" style="display: block; ">
                       <table cellpadding="0" cellspacing="0">
                           <thead>
                               <tr>
                                   <th class="role">Par</th>
                               </tr>
                           </thead>
                           <tbody name="groupe2">
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="trancheage"> Tranche d\'&acirc;ge</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="csp"> Cat&eacute;gorie socioprofessionnelle</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="sexe"> Sexe</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="secteur"> Secteur</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe2" value="typefamille"> Type de famille</td>
                               </tr>
                          </tbody>
                       </table>
                   </div>
               </div>
               <div class="colonne">
                   <div class="rounded_box" style="display: block; ">
                       <table cellpadding="0" cellspacing="0">
                           <thead>
                               <tr>
                                   <th class="role">P&eacute;riode</th>
                               </tr>
                           </thead>
                           <tbody name="groupe3">
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="tout" checked> Tout</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="mois"> Mois</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="an"> Ann&eacute;e</td>
                               </tr>
                               <tr>
                                   <td class="ligne"><input type="radio" class="radio_stat" name="groupe3" value="periode"> P&eacute;riode donn&eacute;e</td>
                               </tr>
                           </tbody>
                       </table>
                   </div>
               </div>
               
               <div class="colonne">
                   <div id="periode_exacte">       
                   </div>
               </div>
               <div id="graph_stat">       
               </div>';
    
    return $contenu;
}

function genererStat() {
    include_once('./lib/config.php');
    $gp1 = $_POST['groupe1'];
    $gp2 = $_POST['groupe2'];
    $gp3 = $_POST['groupe3'];
    $dateDebut = explode('/', $_POST['datedebut']);
    $dateFin = explode('/', $_POST['datefin']);
    
    $select = 'SELECT';
    $from = ' FROM individu i';
    $join = '';
    $where = '';
    $wheresuite = '';
    $groupby = '';
    $orderby = ' ORDER BY';
    $titre = '';
    $finTitre = '';
    $nomColDate ='';
    $joinFoyer = false;
    

    
    
    
    SWITCH ($gp1) {
        case 'nbinscrit' : 
            $select .= ' count(distinct(i.id)) as nbindiv ';
            $orderby .= ' count(distinct(i.id))';
            $join .= ' INNER JOIN foyer f on f.id = i.idfoyer ';
            $joinFoyer = true;
            $nomColDate = 'dateinscription';
            $titre = 'Nombre d\'inscrit ';
            break;
        case 'nbaide' : 
            $select .= ' count(distinct(ai.id)) as nbaide';
            $join .= ' INNER JOIN aideinterne ai on ai.idindividu = i.id ';
            $orderby .= ' nbaide';
            $nomColDate = 'datedemande';
            $titre = 'Nombre d\'aide demandée ';
            break;
        case 'nbaideurg' : 
            $select .= ' count(distinct(ai.id)) as nbaide';
            $join .= ' INNER JOIN aideinterne ai on ai.idindividu = i.id ';
            $orderby .= ' nbaide';
            $nomColDate = 'datedemande';
            $titre = 'Nombre d\'aide demandée ';
            $wheresuite .= ' AND ai.aideurgente = 1 ';
            break;
        case 'nbaideext' : 
            $select .= ' count(distinct(ae.id)) as nbaide';
            $join .= ' INNER JOIN aideexterne ae on ae.idindividu = i.id ';
            $orderby .= ' nbaide';
            $nomColDate = 'datedemande';
            $titre = 'Nombre d\'aide demandée ';
            break;
        case 'montant' : 
            $select .= ' SUM(montant) as montant';
            $join .= ' INNER JOIN aideinterne ai on ai.idindividu = i.id 
                       INNER JOIN bonaide ba on ba.idaideinterne = ai.id ';
            $orderby .= ' montant';
            $nomColDate = 'dateremiseeffective';
            $titre = 'Montant total des aides accordées ';
            break;
    }
    
    SWITCH ($gp3) {
        case 'mois' : 
            $where .= ' WHERE '.$nomColDate.' > '.mktime(0,0,0, date("m"),1, date("Y")).'';
            $finTitre .= '<br/> sur le mois courant';
            break;
        case 'an' : 
            $where .= ' WHERE '.$nomColDate.' > '.mktime(0,0,0, 1,1, date("Y")).'';
            $finTitre .= '<br/> pour l\'année civile courante';
            break;
        case 'periode' :
            if ($dateDebut != '' && $dateFin != '') {
                $where .= ' WHERE '.$nomColDate.' BETWEEN '.mktime(0, 0, 0, $dateDebut[1], $dateDebut[0], $dateDebut[2]).' AND '.mktime(0, 0, 0, $dateFin[1], $dateFin[0], $dateFin[2]);
            }
            $finTitre .= '<br/> du '.$dateDebut[0].'/'.$dateDebut[1].'/'.$dateDebut[2].' au '.$dateFin[0].'/'.$dateFin[1].'/'.$dateFin[2];
            break;
    }

    SWITCH ($gp2) {
        case 'trancheage' :
            $temp = $select.', "moins de 18 ans"
                    FROM individu i 
                    '.$join.' 
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" )<18
                    '.$wheresuite.'
                    UNION
                    '.$select.', "18-25 ans"
                    FROM individu i
                    '.$join.'
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" ) between 18 and 25
                    '.$wheresuite.'
                    UNION
                    '.$select.', "25-59 ans"
                    FROM individu i
                    '.$join.'
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" ) between 26 and 59
                    '.$wheresuite.'
                    UNION
                    '.$select.', "plus de 60 ans"
                    FROM individu i
                    '.$join.'
                    '.$where.' AND YEAR(CURDATE()) - DATE_FORMAT( DATE_ADD(  "1970-01-01", INTERVAL datenaissance SECOND ) ,  "%Y" ) >60
                    '.$wheresuite;
            $select = $temp;
            $from = '';
            $join = '';
            $where = '';
            $wheresuite = '';
            $orderby = '';
            $titre .= 'par tranche d\'âge';
            break;
        case 'csp' : 
            $select .= ', profession';
            $groupby .= ' GROUP BY profession';
            $join .= ' INNER JOIN profession p on p.id = i.idprofession';
            $titre .= 'par catégories socioprofessionnelles';
            break;
        case 'sexe' : 
            $select .= ', IF(sexe = "","Aucune information" ,sexe) ';
            $groupby .= ' GROUP BY sexe';
            $titre .= 'par sexe';
            break;
       case 'secteur' : 
            $select .= ', secteur';
            $groupby .= ' GROUP BY secteur';
            if (!$joinFoyer) {
                $join .= ' INNER JOIN foyer f on f.id = i.idfoyer ';
            }
            $join .= ' INNER JOIN secteur s on s.id = f.idsecteur';
            $titre .= 'par secteur';
            break;
       case 'typefamille' : 
            $select .= ', situation';
            $groupby .= ' GROUP BY situation';
            if (!$joinFoyer) {
                $join .= ' INNER JOIN foyer f on f.id = i.idfoyer ';
            }
            $join .= 'INNER JOIN situationfamiliale sf on sf.id = f.idsitfam';
            $titre .= 'par situation familiale';
            break;
    }
    
    
    $titre = $titre.$finTitre;
    

    $req = $select.$from.$join.$where.$wheresuite.$groupby.$orderby;
    
//    echo 'TITRE   :   '.$titre.'<br/><br/>';
//    echo $req;
//    echo "<br/>";
    
    $con = Doctrine_Manager::getInstance()->connection();
    $st = $con->execute($req);
    // fetch query result
    $result = $st->fetchAll();

    genererGraph($result, $titre);
}

function genererGraph($tab, $titre) {
    include_once('./lib/config.php');
    $y = '[';
    $x = '[';
    foreach($tab as $tableau) {
           $x = $x.'"'.$tableau[1].'", ';
           $y = $y.''.$tableau[0].', ';
    }
    
    $x = substr($x, 0, strlen($x)-2);
    $y = substr($y, 0, strlen($y)-2);
    $x[strlen($x)] = ']';
    $y[strlen($y)] = ']';
    
//    echo "<br/>";
//    echo $x;
//    echo "<br/>";
//    echo $y;    
    
    $retour = '<div id="graphstat" style="height:250px;width:1000px; "></div>';
        $retour .= "
         <script type='text/javascript'>
            var s1 = ".$y.";
        var ticks = ".$x.";
         
        plot2 = $.jqplot('graphstat', [s1], {
            title: '".addslashes($titre)."',
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            }
        });
         </script>";
    echo $retour;
}

function genererPeriode() {
      echo '<div class="rounded_box" style="display: block; ">
               <table cellpadding="0" cellspacing="0">
                   <thead>
                       <tr>
                           <th class="role">P&eacute;riode exacte</th>
                       </tr>
                   </thead>
                   <tbody name="groupe3">
                       <tr>
                           <td class="ligne">                        
                               <span class="attribut">Date début :</span>
                               <span>
                                   <input class="contour_field input_date_graph" type="text" size="10" id="datedebut">
                               </span>
                           </td>
                       </tr>
                       <tr>
                           <td class="ligne">                        
                               <span class="attribut">Date fin :</span>
                               <span>
                                   <input class="input_date_graph" type="text" size="10" id="datefin">
                               </span>
                           </td>
                       </tr>
                   </tbody>
               </table>
           </div>';
}


?>
