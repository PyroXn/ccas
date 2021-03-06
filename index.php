<?php
//error_reporting(E_ALL);
//ini_set('display_errors','On');

include_once('./lib/config.php');

if (!isset($_SESSION['userId'])) {
    login();
    exit();
}
switch (@$_GET['p']) {
    case 'login':
        login();
        break;
    case 'home':
        home();
        break;
    case 'accueil':
        accueil();
        break;
    case 'search':
        search();
        break;
    case 'autoComplete':
        autoComplete();
        break;
    case 'foyer':
        include_once('./pages/foyer.php');
        foyer();
        break;
    case 'scroll':
        scroll();
        break;
    case 'form':
        include_once('./pages/form.php');
        form();
        break;
    case 'contenu':
        include_once('./pages/contenu.php');
        contenu();
        break;
    case 'config':
        include_once('./pages/config.php');
        homeConfig();
        break;
    case 'admin':
        include_once('./pages/admin.php');
        homeAdmin();
        break;
    case 'gestionCompte':
        include_once('./pages/gestionCompte.php');
        gestionCompte();
        break;
    case 'updatePwdPersonnel':
        include_once('./pages/gestionCompte.php');
        echo editPassword();
        break;
    case 'deconnexion':
        deconnexion();
        break;
    case 'detailaideinterne':
        include_once('./pages/aideInterne.php');
        echo detailAideInterne();
        break;
    case 'detailaideexterne':
        include_once('./pages/aideExterne.php');
        echo detailAideExterne();
        break;
    case 'deleteUser':
        include_once('./pages/admin.php');
        deleteUser();
        break;
    case 'addPermission':
        include_once('./pages/admin.php');
        addPermission();
        break;
    case 'removePermission':
        include_once('./pages/admin.php');
        removePermission();
        break;
    case 'removeRole':
        include_once('./pages/admin.php');
        removeRole();
        break;
    case 'genererStat':
        include_once('./pages/statistiques.php');
        genererStat();
        break;
    case 'ecranTabCommission':
        include_once('./pages/tabCommission.php');
        ecranTabCommission();
        break;
    case 'genererTabCommission':
        include_once('./pages/tabCommission.php');
        genererTabCommission();
        break;
    case 'genererPeriode':
        include_once('./pages/statistiques.php');
        genererPeriode();
        break;
    case 'updateChefDeFamille':
        include_once('./pages/individu.php');
        updateChefDeFamille();
        break;
    case 'deleteIndividu':
        include_once('./pages/individu.php');
        deleteIndividu();
        break;
    case 'updateressource':
        include_once('./pages/budget.php');
        updateRessource();
        break;
    case 'updatedepense':
        include_once('./pages/budget.php');
        updateDepense();
        break;
    case 'updatedepensehabitation':
        include_once('./pages/budget.php');
        updateDepenseHabitation();
        break;
    case 'updatedette':
        include_once('./pages/budget.php');
        updateDette();
        break;
    case 'archiveressource':
        include_once('./pages/budget.php');
        archiveRessource();
        break;
    case 'archivedepense':
        include_once('./pages/budget.php');
        archiveDepense();
        break;
    case 'archivedette':
        include_once('./pages/budget.php');
        archiveDette();
        break;
    case 'deletecredit':
        include_once('./pages/budget.php');
        deleteCredit();
        break;
    case 'updatecontact':
        include_once('./pages/generalite.php');
        updateContact();
        break;
    case 'updatecaf':
        include_once('./pages/generalite.php');
        updateCaf();
        break;
    case 'updatemutuelle':
        include_once('./pages/generalite.php');
        updateMutuelle();
        break;
    case 'updatecouverture':
        include_once('./pages/generalite.php');
        updateCouvertureSociale();
        break;
    case 'updatesituationprofessionnelle':
        include_once('./pages/generalite.php');
        updateSituationProfessionnelle();
        break;
    case 'updateSituationScolaire':
        include_once('./pages/generalite.php');
        updateSituationScolaire();
        break;
    case 'updateFoyer':
        include_once('./pages/foyer.php');
        updateFoyer();
        break;
    case 'updateinfoperso':
        include_once('./pages/generalite.php');
        updateInfoPerso();
        break;
    case 'generateEcranStatique':
        include_once('./pages/tableStatique.php');
        echo generateEcranStatiqueEntab($_POST['table']);
        break;
    case 'saveTableStatique':
        include_once('./pages/tableStatique.php');
        updateTableStatique();
        break;
    case 'deleteTableStatique':
        include_once('./pages/tableStatique.php');
        deleteTableStatique();
        break;
    case 'searchTableStatique':
        include_once('./pages/tableStatique.php');
        searchTableStatique();
        break;
    case 'getaction':
        include_once('./pages/action.php');
        getAction();
        break;
    case 'updateaction':
        include_once('./pages/action.php');
        updateAction();
        break;
    case 'deleteaction':
        include_once('./pages/action.php');
        deleteAction();
        break;
    case 'updatedecisioninterne':
        include_once('./pages/aideInterne.php');
        updateDecisionInterne();
        break;
    case 'updatedecisionexterne':
        include_once('./pages/aideExterne.php');
        updateDecisionExterne();
        break;
    case 'createPDF':
        include_once('./pages/aideInterne.php');
        createPDF($_POST['idBon']);
        break;
    case 'afficherArchive':
        include_once('./pages/historique.php');
        affichageArchive();
        break;
    case 'searchTableHistorique':
        include_once('./pages/historique.php');
        searchHistorique();
        break;
    case 'graphinstruct':
        include_once('./pages/tableauBord.php');
        changeGraphInstruct();
        break;
    case 'createrapport':
        include_once('./pages/aideInterne.php');
        createPDFRapportSocial($_POST['idIndividu'], $_POST['motif'], $_POST['evaluation'], $_POST['idAide']);
        break;
    case 'rapportsocial':
        include_once('./pages/aideInterne.php');
        rapportSocial($_POST['idAide']);
        break;
    case 'deletedoc':
        include_once('./pages/document.php');
        destroyFile($_POST['file']);
        break;
    case 'cancelrapport':
        include_once('./pages/aideInterne.php');
        cancelRapport();
        break;
    case 'docremis':
        include_once('./pages/aideInterne.php');
        docRemis();
        break;
    case 'deleteaide':
        include_once('./pages/aideInterne.php');
        deleteAide();
        break;
    case 'updateDetailAideInterne':
        include_once('./pages/aideInterne.php');
        updateDetailAideInterne();
        break;
    case 'reloadRapport':
        include_once('./pages/document.php');
        reloadRapport();
        break;
    case 'updateDetailAideExterne':
        include_once('./pages/aideExterne.php');
        updateDetailAideExterne();
        break;
    case 'generateBeneficiaireAide':
        include_once('./pages/recapAides.php');
        echo generateBeneficiaireAide($_POST['idType']);
        break;
    case 'recapAides':
        include_once('./pages/recapAides.php');
        echo recapGlobal();
        break;
    default:
        home();
        break;
}

function home() {

    $title = 'Accueil';
    $contenu = '
        <div id="menu_gauche">
            <input id="search" class="contour_field" type="text" placeholder="Search..."/>';
            if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_CREATION_FOYER)) {
                $contenu .= '<a id="newfoyer" href="#" class="add" original-title="Ajouter un foyer"></a>';
            }
            $contenu .= '<div id="side_individu">
                <ul id="list_individu">';
    $individus = Doctrine_Core::getTable('individu');
    $contenu .= '<div class="nb_individu">' . $individus->count() . '</div>';
    $i = 1;
    foreach ($individus->searchByLimitOffset(100, 0)->execute() as $individu) {
        if ($i % 2 == 0) {
            $contenu .= '<li class="pair individu" id="' . $i . '">';
        } else {
            $contenu .= '<li class="impair individu" id="' . $i . '">';
        }
        $chefFamille = $individu->chefDeFamille ? ' <span class="chef_famille"></span>' : '';
        $contenu .= '
                           <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom .$chefFamille.'</span>
                 </li>';
        $i++;
    }
    $contenu .= '
                        </ul>
                    </div>
                </div>
                <div id="page_header">
                    <div id="page_header_navigation">
                        '.generationHeaderNavigation('accueil').'
                    </div>
                </div>
                <div id="contenu_wrapper">
                    <div id="contenu">
                       '.accueilContenu().'
                    </div>
                </div>
                ';
    display($title, $contenu);
}

function login() {
    if (!isset($_POST['wp-submit'])) {
        $title = '';
        $contenu = '<div class="login">
            <form name="loginform" id="loginform" action="index.php?p=login" method="post">
                <p>
                    <label for="user_login">Identifiant<br />
                        <input type="text" name="log" id="user_login" class="input requis" value="" size="20" tabindex="10" /></label>
                </p>
                <p>
                    <label for="user_pass">Mot de passe<br />
                        <input type="password" name="pwd" id="user_pass" class="input requis" value="" size="20" tabindex="20" /></label>
                </p>
                <p class="submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="modif" value="Se connecter" tabindex="100" />
                </p>
            </form>
        </div>';
        display($title, $contenu);
    } else {
        include_once('./lib/config.php');
        $user = Doctrine_Core::getTable('user')->findOneByLoginAndPassword($_POST['log'], md5($_POST['pwd']));
        if ($user != null && $user->actif == 1) {
            $_SESSION['userId'] = $user->id;
            $_SESSION['permissions'] = $user->role->permissions;
            header('Location: index.php?p=home');
        } else {
            $title = '';
            $contenu = '<h3>Erreur</h3>
                                    <p>Login ou mot de passe incorrect</p>';
            display($title, $contenu);
        }
    }
}

function search() {
    $q = $_POST['searchword'];

    $retour = '';
    $tableIndividus = Doctrine_Core::getTable('individu');
    $nb = $tableIndividus->likeNom($q)->count();
    if ($nb != 0) {
        $retour .= '<div class="nb_individu">' . $nb . '</div>';
    } else {
        $retour .= '<div class="nb_individu">Aucun résultat</div>';
    }

    $i = 1;
    foreach ($tableIndividus->searchLikeByLimitOffset($q, 100, 0)->execute() as $individu) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair individu" id="' . $i . '">';
        } else {
            $retour .= '<li class="impair individu" id="' . $i . '">';
        }
        $chefFamille = $individu->chefDeFamille ? ' <span class="chef_famille"></span>' : '';
        $retour .= '
                         <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom .$chefFamille.'</span>
                 </li>';
        $i++;
    }
    echo $retour;
}

function creationListeByFoyer($idFoyer, $idIndividu) {
    $retour = '';
    $foyer = Doctrine_Core::getTable('foyer')->find($idFoyer);

    $i = 1;
    foreach ($foyer->individu as $individu) {
        if ($i % 2 == 0) {
            if ($individu->id == $idIndividu) {
                $retour .= '<li class="pair individu current" id="' . $i . '">';
            } else {
                $retour .= '<li class="pair individu" id="' . $i . '">';
            }
        } else {
            if ($individu->id == $idIndividu) {
                $retour .= '<li class="impair individu current" id="' . $i . '">';
            } else {
                $retour .= '<li class="impair individu" id="' . $i . '">';
            }
        }
        $chefFamille = $individu->chefDeFamille ? ' <span class="chef_famille"></span>' : '';
        $retour .= '
                        <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom .$chefFamille.'</span>
                </li>';
        $i++;
    }
    return $retour;
}

/* genere la barre de navigation de la page selon le mode 
 * je pense à plusieurs mode de creation, si on doit générer le menu lorsqu'on click
 * sur un individu (cas le plus commun je pense), mais aussi générer le menu quand 
 * on est dans l'administration
 */

function generationHeaderNavigation($mode) {
    $retour = '';
    switch ($mode) {
        case 'accueil' :
            $retour .= '
                <div id="accueil" class="page_header_link active">
                    <span class="label">Accueil</span>
                </div>';
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_DOCUMENT)) { 
                 $retour .= '
                 <div id="document" class="page_header_link">
                    <span class="label">Documents Types</span>
                </div>';
            }
                $retour .= '
                <div id="tableaubord" class="page_header_link">
                    <span class="label">Tableau de bord</span>
                </div>
                <div id="statistique" class="page_header_link">
                    <span class="label">Statistiques</span>
                </div>';
                if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_ACCES_TAB_COM)) { 
                    $retour .= '<div id="tabcommission" class="page_header_link">
                        <span class="label">Tableau de commission</span>
                    </div>';
                }
                $retour .= '<div id="recapAides" class="page_header_link">
                    <span class="label">Récapitulatif des aides</span>
                </div>';
                $retour .= '<div id="historiqueGlobal" class="page_header_link">
                    <span class="label">Historique</span>
                </div>';
            break;
        case 'foyer' :
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_FOYER)) { 
                $retour .= '
                    <div id="foyer" class="page_header_link active">
                        <span class="label">Logement</span>
                    </div>';
            }
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_GENERALITES)) { 
                $retour .= '
                    <div id="generalites" class="page_header_link">
                        <span class="label">Généralités</span>
                    </div>';
            }
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_BUDGET)) { 
                $retour .= '
                    <div id="budget" class="page_header_link">
                        <span class="label">Budget</span>
                    </div>';
            }
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_AIDES)) { 
                $retour .= '
                    <div id="aides" class="page_header_link">
                        <span class="label">Aides</span>
                    </div>';
            }
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_ACTIONS)) { 
                $retour .= '
                     <div id="actions" class="page_header_link">
                        <span class="label">Actions</span>
                    </div>';
            }
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_HISTORIQUE_INDIVIDU)) {
                $retour .= '
                    <div id="historique" class="page_header_link">
                        <span class="label">Historique</span>
                    </div>';
            }
            if(Droit::isAcces($_SESSION['permissions'], Droit::$ACCES_DOCUMENT_INDIVIDU)) {
                $retour .= '
                    <div id="documents" class="page_header_link">
                        <span class="label">Documents</span>
                    </div>';
            }
            break;
        case 'admin' :
            $retour .= '
                <div id="managerole" href="#" class="page_header_link active">
                    <span class="label">Gérer les rôles</span>
                </div>
                <div id="manageuser" href="#" class="page_header_link">
                    <span class="label">Gérer les utilisateurs</span>
                </div>';
            break;
        case 'config' :
            /*<div id="accueilConfig" href="#" class="page_header_link active">
                    <span class="label">Configuration - Accueil</span>
                </div>*/
            $retour .= '
                <div id="ecranTableStatique" href="#" class="page_header_link active">
                    <span class="label">Tables statique</span>
                </div>';
            break;
        case 'gestionCompte' :
            $retour .= '
                <div id="gestionPass" href="#" class="page_header_link active">
                    <span class="label">Gestion du mot de passe</span>
                </div>';
            break;
    }
    return $retour;
}

function accueilContenu() {
    include_once('./lib/config.php');
    $historique = Doctrine_Core::getTable('historique')->getHistoByUser($_SESSION['userId'])->execute();
    $retour = '<div class="acceuilpresentation">
                    <h2>CCAS MDH</h2>';
    $retour .= '<p>MDH CCAS est une solution souple et évolutive qui gère l’ensemble des aides et dispositifs traités par votre CCAS.</p>
    <p>Il est articulé autour d’un dossier unique pour tous les usagers du CCAS, commun à l’ensemble des modules, et véritable point d’entrée de tous les traitements.</p>';
    $retour .= '
        <ul id="methodologie">
            <li class="analyse">
                <span class="image_hover"></span>
                <span class="titre_liste">Editions</span>
                <span class="paragraphe_liste">Toutes les éditions réglementaires (imprimés, autres formulaires) sont livrées en standard dans le logiciel. Le contrat de maintenance vous garantit la mise à jour de ces éditions en cas de changement de réglementation.
                </span>
            </li>
            <li class="creation">
                <span class="image_hover"></span>
                <span class="titre_liste">Statistiques</span>
                <span class="paragraphe_liste">L’application dispose d’un module pour la génération des tableaux de bord et de statistiques sur l’activité du service. Ce module est livré avec une bibliothèque importante de requêtes et d’indicateurs.</span>
            </li>
            <li class="livraison">
                <span class="image_hover"></span>
                <span class="titre_liste">Sécurité</span>
                <span class="paragraphe_liste">L’accès aux données est sécurisé par un système d’habilitations qui permet de gérer les droits d’accès des utilisateurs en fonction de leur profil. Chaque fonctionnalité du logiciel est habilitée : accès à un module, onglet, zone spécifique d’un écran, droit total ou limité à la consultation, etc. </span>
            </li>
            <li class="suivi">
                <span class="image_hover"></span>
                <span class="titre_liste">Archivage</span>
                <span class="paragraphe_liste">Toutes les données saisies dans le logiciel sont historisées (parcours professionnel, éléments financiers, logement, changement de contexte familial, demandes d’aides, …). Le suivi des dossiers est ainsi facilité par une recherche rapide des informations, dès l’accueil d’un usager.</span>
            </li>
            </ul></div>';

    $retour .= '<div class="clearboth"></div>';
    $retour .= '
        <h3>Vos 10 dernières actions</h3>
         <div class="bubble tableau_classique_wrapper">
            <table class="tableau_classique" cellpadding="0" cellspacing="0">
                <thead>
                    <tr class="header">
                    <th>Individu</th>
                      <th>Action</th>
                      <th>Objet</th>
                      <th>Utilisateur</th>
                      <th>Date</th>
                    </tr>
                </thead>
                <tbody id="contenu_table_historique">';
  foreach($historique as $histo) {
        if ($histo->typeAction == Historique::$Archiver) {
            $q = Doctrine_Query::create()
                ->from($histo->objet)
                ->where('datecreation < ?', $histo->date)
                ->andWhere('idIndividu = ?', $histo->idIndividu)
                ->orderBy('datecreation DESC')
                ->fetchOne();
            $retour .= '<tr class="afficherArchivage" idObjet='.$q->id.' table='.$histo->objet.'>';
        } else {
            $retour .= '<tr>';
        }
        $retour .= '<td>'.$histo->individu->nom.' '.$histo->individu->prenom.'</td>';
        $retour .= '
            <td>'.Historique::getStaticValue($histo->typeAction).'</td>
            <td>'.$histo->objet.'</td>
            <td>'.$histo->user->login.'</td>
            <td>'.getDatebyTimestamp($histo->date).'</td>
        </tr>';
    }
    $retour .= '</tbody>
        </table>';
     return $retour;
}

function accueil() {
    $menu = generationHeaderNavigation('accueil');
    $contenu = accueilContenu();
    $retour = array('menu' => $menu, 'contenu' => $contenu);
    echo json_encode($retour);
}

function scroll() {
    $retour = '';
    $individus = Doctrine_Core::getTable('individu');
    $i = $_POST['last'] + 1;
    $q = $_POST['searchword'];

    foreach ($individus->searchLikeByLimitOffset($q, 100, $_POST['last'])->execute() as $individu) {
        if ($i % 2 == 0) {
            $retour .= '<li class="pair individu" id="' . $i . '">';
        } else {
            $retour .= '<li class="impair individu" id="' . $i . '">';
        }
        $chefFamille = $individu->chefDeFamille ? ' <span class="chef_famille"></span>' : '';
        $retour .= '
                    <span class="label" id_foyer="' . $individu->idFoyer . '" id_individu="' . $individu->id . '">' . $individu->nom . ' ' . $individu->prenom .$chefFamille.'</span>
            </li>';
        $i++;
    }
    echo $retour;
}

function autoComplete() {
    $searchword = $_POST['searchword'];
    $table = $_POST['table'];
    $champ = $_POST['champ'];

    $retour = '';
    $t = Doctrine_Core::getTable($table);
    $likeNb = Doctrine_Query::create()
        ->from($table)
        ->where($champ + ' LIKE ?', array($searchword . '%'))
        ->orderBy($champ + ' ASC');
    $nb = $likeNb->count();
    
    $like = Doctrine_Query::create()
        ->from($table)
        ->where($champ .' LIKE ?', $searchword.'%')
        ->orderBy($champ .' ASC')
        ->limit(5);
    

    $retour = '<ul class="liste_suggestion" table="'.$table.'" champ="'.$champ.'">';
    
    foreach ($like->execute() as $tmp) {
        $retour .= '<li valeur="'.$tmp->id.'">'.$tmp->$champ.'</li>';
    }
    $retour .= '</ul>';
    echo $retour;
}

function deconnexion() {
    unset($_SESSION['userId']);
    header('Location: index.php');
}

function display($title, $contenu) {
    include('./templates/haut.php');
    echo $contenu;
    include('./templates/bas.php');
}

?>
