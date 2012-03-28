<?php

function contenu() {
    $menu = $_POST['idMenu'];
    switch ($menu) {
        case 'foyer':
            echo foyerContenu($_POST['idFoyer']);
            break;
        case 'generalites':
            echo generalite();
            break;
        case 'budget':
            echo budget();
            break;
        case 'aides':
            include_once './pages/aide.php';
            echo aide();
            break;
        case 'historique':
            break;
        case 'documents':
            include_once './pages/document.php';
            echo getDocumentIndividu();
            break;
        case 'actions':
            include_once('./pages/action.php');
            echo action();
            break;
        case 'accueil':
            echo accueilContenu();
            break;
        case 'accueilAdmin':
            echo accueilAdmin();
            break;
        case 'manageuser' :
            echo manageUser();
            break;
        case 'document':
            include_once('./pages/document.php');
            echo getDocument();
            break;
        case 'accueilConfig':
            include_once('./pages/config.php');
            echo accueilConfig();
            break;
        case 'ecranTableStatique':
            include_once './pages/tableStatique.php';
            echo comboTableStatique();
            break;
    }
}

function foyerContenu($idFoyer) {
    $contenu = '';
    $contenu .= '<h2>Foyer</h2>';
    $foyer = Doctrine_Core::getTable('foyer')->find($idFoyer);

    function sortFoyer($a, $b) {
        if ($a->chefDeFamille == 1) {
            return -1;
        }
        if ($b->chefDeFamille == 1) {
            return 1;
        }
        return ($a->dateNaissance < $b->dateNaissance) ? -1 : 1;
        return 0;
    }

    $individus = $foyer->individu;
    $individus = $individus->getData(); // convert from Doctrine_Collection to array
    usort($individus, 'sortFoyer');
    
    $contenu .= '
        <h3>Membres du foyer</h3>
        <ul class="list_classique">';
    foreach ($individus as $individu) {
        $contenu .= generateLigneMembreFoyer($individu);
    }
    $lienFamilles = Doctrine_Core::getTable('lienFamille')->findAll();
    $contenu .= '
        </ul>
        <div id="newIndividu" class="bouton ajout" value="add">Ajouter un individu</div>
        <div class="bouton modif update" value="updateMembreFoyer">Enregistrer</div>
        <div class="formulaire" action="creation_individu">
            <h2>Individu</h2>
            <div class="colonne_droite">
                <div class="select classique" role="select_civilite">
                    <div id="form_1" class="option">Madame</div>
                    <div class="fleche_bas"> </div>
                </div>
                <div class="input_text">
                    <input id="form_2" class="contour_field" type="text" title="Nom" placeholder="Nom">
                </div>
                <div class="input_text">
                    <input id="form_3" class="contour_field" type="text" title="Pr&#233;nom" placeholder="Pr&#233;nom">
                </div>
                <div class="input_text">
                    <input id="form_4" class="contour_field date" type="text" title="Date de naissance" placeholder="Date de naissance">
                </div>
                <div class="select classique" role="select_lien_famille">
                    <div id="form_5" class="option">'. $lienFamilles[0]->lien .'</div>
                    <div class="fleche_bas"></div>
                </div>
                <div class="sauvegarder_annuler">
                    <div class="bouton modif" value="save">Enregistrer</div>
                    <div class="bouton classique" value="cancel">Annuler</div>
                </div>
            </div>
        </div>
        <ul class="select_lien_famille">';
    
        
        $i = 0;
        foreach ($lienFamilles as $lienFamille) {
            $contenu .= '<li>
                <div value="'.$lienFamille->id.'">'.$lienFamille->lien.'</div>
            </li>';
            $i++;
        }
        $contenu .= '</ul>';
        $contenu .= generateInfoFoyer($foyer);
    return $contenu;
}

function generateInfoFoyer($foyer) {
    $secteurs = Doctrine_Core::getTable('secteur')->findAll();
    $types =  Doctrine_Core::getTable('type')->findAll();
    $bailleurs =  Doctrine_Core::getTable('bailleur')->findAll();
    $instructs =  Doctrine_Core::getTable('instruct')->findAll();
    $retour = '';
    $retour .= '
        <div><h3>Foyer<span class="edit"></span></h3>
            <ul class="list_classique">
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">N&deg; :</span>
                        <span><input type="text" class="contour_field input_num" id="numrue" value="'.$foyer->numRue.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Rue :</span>
                        <span><input type="text" class="contour_field input_char autoComplete" id="rue" table="rue" champ="rue" value="'.$foyer->rue->rue.'" valeur="'.$foyer->rue->id.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Secteur :</span>
                        <div class="select classique" role="select_secteur" disabled>';
    $retour .= $foyer->idSecteur == null ? '<div id="secteur" class="option">-----</div>':'<div id="secteur" class="option" value="'.$foyer->idSecteur.'">'.$foyer->secteur->secteur.'</div>';
    $retour .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Ville :</span>
                        <span><input type="text" class="contour_field input_char autoComplete" id="ville" table="ville" champ="libelle" value="'.$foyer->ville->libelle.'" valeur="'.$foyer->ville->id.'" disabled/></span>
                    </div>
               </li>
               <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Type :</span>
                        <div class="select classique" role="select_typelogement" disabled>';
$retour .= $foyer->typeLogement == null ? '<div id="typelogement" class="option">-----</div>':'<div id="typelogement" class="option" value="'.$foyer->typeLogement.'">'.$foyer->typelogement->libelle.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                </div>
                </div>
                   <div class="colonne">
                        <span class="attribut">Statut :</span>
                        <div class="select classique" role="select_statutlogement" disabled>';
$retour .= $foyer->typeAppartenance == null ? '<div id="statutlogement" class="option">-----</div>':'<div id="statutlogement" class="option" value="'.$foyer->typeAppartenance.'">'.$foyer->statutlogement->libelle.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                   </div>
                   <div class="colonne">
                        <span class="attribut">Surface :</span>
                        <span><input class="contour_field input_num" type="text" id="surface" value="'.$foyer->logSurface.'" disabled/></span>
                  </div>
                  <div class="colonne">
                        <span class="attribut">Date d\'entr&eacute;e :</span>
                        <span><input class="contour_field input_date" type="text" id="dateentree" size="10" value="'.getDatebyTimestamp($foyer->logDateArrive).'" disabled/></span>
                  </div>
               </li>
               <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Bailleur :</span>
                        <div class="select classique" role="select_bailleur" disabled>';
$retour .= $foyer->idBailleur == null ? '<div id="bailleur" class="option">-----</div>':'<div id="bailleur" class="option" value="'.$foyer->idBailleur.'">'.$foyer->bailleur->nomBailleur.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Instructeur :</span>
                        <div class="select classique" role="select_instruct" disabled>';
$retour .= $foyer->idInstruct == null ? '<div id="instruct" class="option">-----</div>':'<div id="instruct" class="option" value="'.$foyer->idInstruct.'">'.$foyer->instruct->nom.'</div>';
$retour .= '<div class="fleche_bas"> </div>
                    </div>
                    </div>
                    <div class="colonne_large">
                        <span class="attribut_for_large">Note :</span>
                        <span><input class="contour_field input_char_for_large" type="text" id="note" value="'.$foyer->notes.'" disabled/></span>
                    </div>
               </li>
            </ul>';
       
$retour .= '<div class="bouton modif update" value="updateFoyer">Enregistrer</div>
            <div class="clearboth"></div>
        </div>';
 $retour .= situationFinanciere($foyer->id);
 // COMBO BOX
 $retour .= '<ul class="select_instruct">';
    foreach($instructs as $instruct) {
        $retour .= '<li>
                                <div value="'.$instruct->id.'">'.$instruct->nom.'</div>
                           </li>';
    }
    $retour .= '</ul>';
 $retour .= '<ul class="select_bailleur">';
    foreach($bailleurs as $bailleur) {
        $retour .= '<li>
                                <div value="'.$bailleur->id.'">'.$bailleur->nomBailleur.'</div>
                           </li>';
    }
    $retour .= '</ul>';
 $retour .= '<ul class="select_statutlogement">';
 foreach($types as $t) {
     if($t->categorie == 3) {
     $retour .= '<li>
                            <div value="'.$t->id.'">'.$t->libelle.'</div>
                        </li>';
     }
 }
 $retour .= '</ul>';
 $retour .= '<ul class="select_typelogement">';
 foreach($types as $t) {
     if($t->categorie == 4) {
     $retour .= '<li>
                            <div value="'.$t->id.'">'.$t->libelle.'</div>
                        </li>';
     }
 }
 $retour .= '</ul>';
    $retour .= '<ul class="select_secteur">';
    foreach($secteurs as $secteur) {
        $retour .= '<li>
                                <div value="'.$secteur->id.'">'.$secteur->secteur.'</div>
                           </li>';
    }
    $retour .= '</ul>';
    return $retour;
}

function updateFoyer() {
    include_once('./lib/config.php');
//    $ville = Doctrine_Core::getTable('ville')->findOneByLibelle($_POST['ville']);
//    if($ville!=null) {
//        $ville = new Ville();
//        $ville->libelle = $_POST['ville'];
//    }
//    $rue = Doctrine_Core::getTable('rue')->findOneByRue($_POST['rue']);
//    if($rue!=null) {
//        $rue = new Rue();
//        $rue->rue = $_POST['rue'];
//    }
    $foyer = Doctrine_Core::getTable('foyer')->find($_POST['idFoyer']);
    $foyer->numRue = $_POST['numrue'];
    $foyer->idRue = $_POST['rue'];
    $foyer->idSecteur = $_POST['secteur'];
    $foyer->idVille = $_POST['ville'];
    $foyer->idBailleur = $_POST['bailleur'];
    $foyer->typeLogement = $_POST['type'];
    $foyer->typeAppartenance = $_POST['statut'];
    $foyer->logSurface = $_POST['surface'];
    $foyer->idInstruct = $_POST['instruct'];
    $foyer->notes = $_POST['notes'];
    if($_POST['dateentree'] != 0) {
        $date = explode('/', $_POST['dateentree']);
        $foyer->logDateArrive = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
    } else {
        $foyer->logDateArrive = 0;
    }
    $foyer->save();
}

function situationFinanciere($idFoyer) {
    include_once('./lib/config.php');
    $individus = Doctrine_Core::getTable('individu')->findByIdFoyer($idFoyer);
    
    $totalRessource = 0;
    $totalDepense = 0;
    $totalDette = 0;
    $totalCredit = 0;
    
    foreach($individus as $individu) {
        $revenu = Doctrine_Core::getTable('revenu')->getLastFicheRessource($individu->id);
        $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($individu->id);
        $dette = Doctrine_Core::getTable('dette')->getLastFicheDette($individu->id);
        $credits = Doctrine_Core::getTable('credit')->findByIdIndividu($individu->id);
        $arrayRevenu = array($revenu->salaire, $revenu->chomage, $revenu->revenuAlloc, $revenu->ass, $revenu->aah, $revenu->rsaSocle,
                                        $revenu->rsaActivite, $revenu->pensionAlim, $revenu->pensionRetraite, $revenu->retraitComp, $revenu->autreRevenu, $revenu->aideLogement);
        $arrayDepense = array($depense->impotRevenu, $depense->impotLocaux, $depense->pensionAlim, $depense->mutuelle, $depense->electricite, $depense->gaz,
                                        $depense->eau, $depense->chauffage, $depense->telephonie, $depense->internet, $depense->television, $depense->assurance, $depense->credit,
                                        $depense->autreDepense, $depense->loyer);
        $arrayDette = array($dette->arriereLocatif, $dette->fraisHuissier, $dette->arriereElectricite, $dette->arriereGaz, $dette->autreDette);
        foreach($credits as $credit) {
            $totalCredit = $totalCredit + $credit->mensualite;
        }
        $totalRessource =  $totalRessource + array_sum($arrayRevenu);
        $totalDepense = $totalDepense + array_sum($arrayDepense);
        $totalDette = $totalDette + array_sum($arrayDette);
        
    }
    $contenu = '<div><h3>Situation financi&egrave;re de la famille</h3>';
    $contenu .= '
        <ul class="list_classique">
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Total ressources :</span>
                        <span>'.$totalRessource.'</span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Total d&eacute;penses :</span>
                        <span>'.$totalDepense.'</span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Total dettes :</span>
                        <span>'.$totalRessource.'</span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Total credits :</span>
                        <span>'.$totalCredit.'</span>
                    </div>
                </li>
        </ul>
        </div>';
    return $contenu;
}

function generateLigneMembreFoyer($individu) {
    $retour = '
        <li class="ligne_list_classique" id_foyer='.$individu->idFoyer.' id_individu='.$individu->id.'>
            <div>
                <span class="label">' . $individu->nom . ' ' . $individu->prenom .'</span>
                <span class="date_naissance">'. date('d/m/Y', $individu->dateNaissance) .'</span>
                <span class="date_naissance">'. $individu->lienfamille->lien .'</span>
                <span class="delete_individu droite"></span>
                <span class="droite"> Chef de famille ';
                    if ($individu->chefDeFamille) {
                        $retour .= '<span class="checkboxChefFamille checkbox_active"></span>';
                    } else {
                        $retour .= '<span class="checkboxChefFamille"></span>';
                    }
    $retour .= '</span>
                
            </div>
        </li>';
    
    return $retour;
}

function accueilAdmin() {
    $contenu = '
         <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget libero vel massa sagittis adipiscing sed vitae enim. Praesent non eros nec nunc vestibulum pharetra in in nisl. Nulla et luctus ante. Donec et consequat nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque laoreet facilisis egestas. Sed a ullamcorper risus.
            In convallis turpis pharetra ante commodo convallis. In sit amet neque vitae libero luctus mollis. Morbi hendrerit, felis eu cursus ornare, arcu mi sodales mauris, non tincidunt justo odio a lacus. Maecenas vel sodales nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae velit ac est laoreet sollicitudin. Nullam suscipit porttitor pellentesque. Ut vehicula ligula at leo rhoncus tristique. Praesent scelerisque, orci at consectetur pretium, libero nisl mattis sapien, nec elementum tortor sem sed enim. Vestibulum vitae vulputate felis. Aliquam laoreet quam mollis velit gravida interdum lacinia orci sodales. Vivamus non placerat magna. Duis leo nunc, tincidunt vel pharetra sit amet, mollis id nunc. Etiam semper fermentum mauris nec sodales. Morbi tincidunt, nisi vitae pellentesque fringilla, ipsum turpis porta massa, at tincidunt mi tellus congue massa.
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget libero vel massa sagittis adipiscing sed vitae enim. Praesent non eros nec nunc vestibulum pharetra in in nisl. Nulla et luctus ante. Donec et consequat nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque laoreet facilisis egestas. Sed a ullamcorper risus.
            In convallis turpis pharetra ante commodo convallis. In sit amet neque vitae libero luctus mollis. Morbi hendrerit, felis eu cursus ornare, arcu mi sodales mauris, non tincidunt justo odio a lacus. Maecenas vel sodales nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae velit ac est laoreet sollicitudin. Nullam suscipit porttitor pellentesque. Ut vehicula ligula at leo rhoncus tristique. Praesent scelerisque, orci at consectetur pretium, libero nisl mattis sapien, nec elementum tortor sem sed enim. Vestibulum vitae vulputate felis. Aliquam laoreet quam mollis velit gravida interdum lacinia orci sodales. Vivamus non placerat magna. Duis leo nunc, tincidunt vel pharetra sit amet, mollis id nunc. Etiam semper fermentum mauris nec sodales. Morbi tincidunt, nisi vitae pellentesque fringilla, ipsum turpis porta massa, at tincidunt mi tellus congue massa.
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget libero vel massa sagittis adipiscing sed vitae enim. Praesent non eros nec nunc vestibulum pharetra in in nisl. Nulla et luctus ante. Donec et consequat nibh. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque laoreet facilisis egestas. Sed a ullamcorper risus.
            In convallis turpis pharetra ante commodo convallis. In sit amet neque vitae libero luctus mollis. Morbi hendrerit, felis eu cursus ornare, arcu mi sodales mauris, non tincidunt justo odio a lacus. Maecenas vel sodales nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vitae velit ac est laoreet sollicitudin. Nullam suscipit porttitor pellentesque. Ut vehicula ligula at leo rhoncus tristique. Praesent scelerisque, orci at consectetur pretium, libero nisl mattis sapien, nec elementum tortor sem sed enim. Vestibulum vitae vulputate felis. Aliquam laoreet quam mollis velit gravida interdum lacinia orci sodales. Vivamus non placerat magna. Duis leo nunc, tincidunt vel pharetra sit amet, mollis id nunc. Etiam semper fermentum mauris nec sodales. Morbi tincidunt, nisi vitae pellentesque fringilla, ipsum turpis porta massa, at tincidunt mi tellus congue massa.
        </p>
                ';
    return $contenu;
}

function manageUser() {
    include_once('./lib/config.php');
    $users = Doctrine_Core::getTable('user')->findByActif(0);
    $contenu = '
                    <fieldset><legend>Ajouter un utilisateur</legend>
                    <div id="newUser" class="bouton ajout" value="add">+</div>
        <div class="formulaire" action="creation_utilisateur">
            <h2>Utilisateur</h2>
            <div class="colonne_droite">
                <div class="input_text">
                    <input class="contour_field" type="text" title="Login" placeholder="Login" name="login" id="newlogin">
                </div>
                <div class="input_text">
                    <input class="contour_field" type="password" title="Password" placeholder="Password" name="pwd" id="newpwd">
                </div>
                <div class="input_text">
                    <input class="contour_field" type="text" title="Nom complet" placeholder="Nom complet" name="nomcomplet" id="newnomcomplet">
                </div>
                <div class="sauvegarder_annuler">
                    <div class="bouton modif" value="save">Enregistrer</div>
                    <div class="bouton classique" value="cancel">Annuler</div>
                </div>
            </div>
        </div>
                    </fieldset>
                    <fieldset><legend>G&eacute;rer les permissions</legend>
                    <table id="manageuser" border="0">
                        <tr>
                            <td width="15%"></td>
                            <td width="5%"></td>
                            <td width="5%"></td>
                            <td width="20%">Utiliser le logiciel</td>
                            <td width="20%">Upload des documents</td>
                            <td width="20%">Configuration - Donn&eacute;es modulables</td>
                            <td width="20%">Administration</td>
                       </tr>';
    foreach ($users as $user) {
        $check0 = $user->level[3] == 1 ? "checked = checked" : "";
        $check1 = $user->level[2] == 1 ? "checked = checked" : "";
        $check2 = $user->level[1] == 1 ? "checked = checked" : "";
        $check3 = $user->level[0] == 1 ? "checked = checked" : "";

        $contenu .= '<tr>
                                    <td style="text-align: left;" width="15%">' . $user->nomcomplet . '</td>
                                    <td width="5%"><a id="test" href="#" class="delete" original-title="D&eacute;sactiver ' . $user->login . '" name="' . $user->login . '"><img src="./templates/img/delete.png"></img></a></td>
                                    <td width="5%"><a href="#" class="edituser" original-title="Modifier le compte" name="' . $user->id . '"><img src="./templates/img/edit.png"></img></a></td>
                                    <td width="20%"><input type="checkbox" name="use' . $user->id . '" ' . $check0 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="access' . $user->id . '" ' . $check1 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="config' . $user->id . '" ' . $check2 . ' value="1"></td>
                                    <td width="20%"><input type="checkbox" name="admin' . $user->id . '" ' . $check3 . ' value="1"></td>                                          
                                </tr>';
    }
    $contenu .= '</table>
            <input type="submit" name="submitpermission" id="submitpermission" class="modif" value="Enregistrer" />
            <input type="reset" name="reset" class="classique" value="Annuler" />
            </fieldset>
            <div id="useredit"></div>
            <div>
                </div>
                ';
    return $contenu;
}

function budget() {
    include_once('./lib/config.php');
    $revenu = Doctrine_Core::getTable('revenu')->getLastFicheRessource($_POST['idIndividu']);
    $depense = Doctrine_Core::getTable('depense')->getLastFicheDepense($_POST['idIndividu']);
    $dette = Doctrine_Core::getTable('dette')->getLastFicheDette($_POST['idIndividu']);
    $credits = Doctrine_Core::getTable('credit')->findByIdIndividu($_POST['idIndividu']);
    $contenu = '<h2>Budget</h2>';
    $contenu .= '<div><h3 role="ressource"><span>Ressources</span>  <span class="edit"></span><span class="archive"></span> <span class="timemaj">'.getDatebyTimestamp($revenu->dateCreation).'</span></h3>';
    $contenu .= '<ul class="list_classique">
                                <li class="ligne_list_classique">
                                    <div class="colonne">
                                        <span class="attribut">Salaire : </span>
                                        <span><input class="contour_field input_num" type="text" id="salaire" value="'.$revenu->salaire.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">All. Ch&ocirc;mage : </span>
                                        <span><input class="contour_field input_num" type="text" id="chomage" value="'.$revenu->chomage.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">All. familiales : </span>
                                        <span><input class="contour_field input_num" type="text" id="revenuAlloc" value="'.$revenu->revenuAlloc.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">ASS : </span>
                                        <span><input class="contour_field input_num" type="text" id="ass" value="'.$revenu->ass.'" disabled/></span>
                                    </div>
                               </li>
                               <li class="ligne_list_classique">
                                    <div class="colonne">
                                        <span class="attribut">AAH : </span>
                                        <span><input class="contour_field input_num" type="text" id="aah" value="'.$revenu->aah.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">RSA Socle : </span>
                                        <span><input class="contour_field input_num" type="text" id="rsaSocle" value="'.$revenu->rsaSocle.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">RSA Activit&eacute; : </span>
                                        <span><input class="contour_field input_num" type="text" id="rsaActivite" value="'.$revenu->rsaActivite.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">Retraite compl  : </span>
                                        <span><input class="contour_field input_num" type="text" id="retraitComp" value="'.$revenu->retraitComp.'" disabled/></span>
                                    </div>
                               </li>
                               <li class="ligne_list_classique">
                                    <div class="colonne">
                                        <span class="attribut">P. alimentaire : </span>
                                        <span><input class="contour_field input_num" type="text" id="pensionAlim" value="'.$revenu->pensionAlim.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">P. de retraite : </span>
                                        <span><input class="contour_field input_num" type="text" id="pensionRetraite" value="'.$revenu->pensionRetraite.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">Autres revenus  : </span>
                                        <span><input class="contour_field input_num" type="text" id="autreRevenu" value="'.$revenu->autreRevenu.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">Nature : </span>
                                        <span><input class="contour_field input_char" type="text" id="natureRevenu" value="'.$revenu->natureAutre.'" disabled/></span>
                                    </div>
                               </li>
                            </ul>
                            <div class="bouton modif update" value="updateRessource">Enregistrer</div>
                            <div class="clearboth"></div>
                            </div>
                            
                            <div>
                            <h3 role="depense">D&eacute;penses <span class="edit"></span><span class="archive"></span> <span class="timemaj">'.getDatebyTimestamp($depense->dateCreation).'</span></h3>
                            <ul class="list_classique">
                                <li class="ligne_list_classique">
                                <div class="colonne">
                                    <span class="attribut">Imp&ocirc;ts revenu : </span>
                                    <span><input class="contour_field input_num" type="text" id="impotRevenu" value="'.$depense->impotRevenu.'" disabled/></span>
                                 </div>
                                    <div class="colonne">
                                        <span class="attribut">Imp&ocirc;ts locaux : </span>
                                        <span><input class="contour_field input_num" type="text" id="impotLocaux" value="'.$depense->impotLocaux.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                    <span class="attribut">P. alimentaire :</span>
                                    <span><input class="contour_field input_num" type="text" id="pensionAlim" value="'.$depense->pensionAlim.'" disabled/></span>
                                     </div>
                                     <div class="colonne">
                                    <span class="attribut">Mutuelle : </span>
                                    <span><input class="contour_field input_num" type="text" id="mutuelle" value="'.$depense->mutuelle.'" disabled/></span>
                                    </div>
                               </li>
                               <li class="ligne_list_classique">
                               <div class="colonne">
                                    <span class="attribut">Electricit&eacute; : </span>
                                    <span><input class="contour_field input_num" type="text" id="electricite" value="'.$depense->electricite.'" disabled/></span>
                                 </div>
                                 <div class="colonne">
                                    <span class="attribut">Gaz : </span>
                                    <span><input class="contour_field input_num" type="text" id="gaz" value="'.$depense->gaz.'" disabled/></span>
                                 </div>
                                 <div class="colonne">
                                    <span class="attribut">Eau : </span>
                                    <span><input class="contour_field input_num" type="text" id="eau" value="'.$depense->eau.'" disabled/></span>
                                 </div>
                                 <div class="colonne">
                                    <span class="attribut">Chauffage :</span>
                                    <span><input class="contour_field input_num" type="text" id="chauffage" value="'.$depense->chauffage.'" disabled/></span>
                                </div>
                               </li>
                               <li class="ligne_list_classique">
                               <div class="colonne">
                                    <span class="attribut">T&eacute;l&eacute;phonie : </span>
                                    <span><input class="contour_field input_num" type="text" id="telephonie" value="'.$depense->telephonie.'" disabled/></span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Internet : </span>
                                    <span><input class="contour_field input_num" type="text" id="internet" value="'.$depense->internet.'" disabled/></span>
                              </div>
                              <div class="colonne">
                                    <span class="attribut">T&eacute;l&eacute;vision : </span>
                                    <span><input class="contour_field input_num" type="text" id="television" value="'.$depense->television.'" disabled/></span>
                               </div>
                               </li>
                               <li class="ligne_list_classique">
                               <div class="colonne">
                                    <span class="attribut">Autres D&eacute;penses : </span>
                                    <span><input class="contour_field input_num" type="text" id="autreDepense" value="'.$depense->autreDepense.'" disabled/></span>
                               </div>
                               <div class="colonne_large">
                                    <span class="attribut_for_large">D&eacute;tail : </span>
                                    <span><input class="contour_field  input_char_for_large" type="text" id="natureDepense" value="'.$depense->natureDepense.'" disabled/></span>
                               </div>
                               </li>
                            </ul>
                            <div class="bouton modif update" value="updateDepense">Enregistrer</div>
                            <div class="clearboth"></div>
                            </div>
                            
                            <div>
                                <h3>D&eacute;penses habitation <span class="edit"></span></h3>
                                <ul class="list_classique">
                                    <li class="ligne_list_classique">
                                    <div class="colonne">
                                        <span class="attribut">Loyer : </span>
                                        <span><input class="contour_field input_num" type="text" id="loyer" value="'.$depense->loyer.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">AL ou APL : </span>
                                        <span><input class="contour_field input_num" type="text" id="apl" value="'.$revenu->aideLogement.'" disabled/></span>
                                   </div>
                                   <div class="colonne">
                                        <span class="attribut">R&eacute;siduel : </span>
                                        <span>'.($depense->loyer - $revenu->aideLogement).'</span>
                                    </div>
                                    </li>
                                </ul>
                                <div class="bouton modif update" value="updateDepenseHabitation">Enregistrer</div>
                                <div class="clearboth"></div>
                            </div>
                            
                            <div>
                            <h3 role="dette">Dettes <span class="edit"></span><span class="archive" original-title="Archiver les dettes"></span><span class="timemaj">'.getDatebyTimestamp($dette->dateCreation).'</span></h3>
                                <ul class="list_classique">
                                <li class="ligne_list_classique">
                                <div class="colonne">
                                    <span class="attribut">Arri&eacute;r&eacute; locatif : </span>
                                    <span><input class="contour_field input_num" type="text" id="arriereLocatif" value="'.$dette->arriereLocatif.'" disabled/></span>
                                </div>
                                <div class="colonne">
                                    <span class="attribut">Frais huissier : </span>
                                    <span><input class="contour_field input_num" type="text" id="fraisHuissier" value="'.$dette->fraisHuissier.'" disabled/></span>
                                </div>
                                <div class="colonne">
                                    <span class="attribut">Autres dettes : </span>
                                    <span><input class="contour_field input_num" type="text" id="autreDette" value="'.$dette->autreDette.'" disabled/></span>
                                </div>
                                <div class="colonne">
                                    <span class="attribut">Nature  :</span>
                                    <span><input class="contour_field input_char" type="text" id="natureDette" value="'.$dette->natureDette.'" disabled/></span>
                               </div>
                               </li>
                               <li class="ligne_list_classique">
                               <div class="colonne">
                                    <span class="attribut">Arri&eacute;r&eacute; &eacute;lectricit&eacute; : </span>
                                    <span><input class="contour_field input_num" type="text" id="arriereElec" value="'.$dette->arriereElectricite.'" disabled/></span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Prestataire : </span>
                                    <span><input class="contour_field input_char" type="text" id="prestaElec" value="'.$dette->prestaElec.'" disabled/></span>
                               </div>
                               </li>
                              <li class="ligne_list_classique">
                              <div class="colonne">
                                    <span class="attribut">Arri&eacute;r&eacute; gaz : </span>
                                    <span><input class="contour_field input_num" type="text" id="arriereGaz" value="'.$dette->arriereGaz.'" disabled/></span>
                              </div>
                              <div class="colonne">
                                    <span class="attribut">Prestataire : </span>
                                    <span><input class="contour_field input_char" type="text" id="prestaGaz" value="'.$dette->prestaGaz.'" disabled/></span>
                               </div>
                               </li>
                               </ul>
                               <div class="bouton modif update" value="updateDette">Enregistrer</div>
                               <div class="clearboth"></div>
                               </div>
                               
                               <div>';
                       $contenu .= '<div class="colonne_large">
                                        <h3>Cr&eacute;dits <span class="addElem"  id="createCredit"></span></h3>
                                            <div class="bubble tableau_classique_wrapper">
                                                <table class="tableau_classique" cellpadding="0" cellspacing="0">
                                                    <thead>
                                                        <tr class="header">
                                                            <th>Organisme</th>
                                                            <th>Mensualit&eacute;</th>
                                                            <th>Dur&eacute;e</th>
                                                            <th>Montant restant</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                    $i = 1;
                                    if (sizeof($credits) != null) {
                                        foreach($credits as $credit) {
                                            $i % 2 ? $contenu .= '<tr name="'.$credit->id.'">' : $contenu .= '<tr class="alt" name="'.$credit->id.'">';
                                            $contenu .= '<td>'.$credit->organisme.'</td>
                                                                    <td> '.$credit->mensualite.'</td>
                                                                    <td> '.$credit->dureeMois.'</td>
                                                                    <td> '.$credit->totalRestant.'</td>
                                                                    <td><span class="delete_credit"></span></td>
                                                        </tr>';
                                            $i++;
                                        }
                                    } else {
                                        $contenu .= '<tr>
                                                         <td colspan=9 align=center>< Aucun cr&eacute;dit n\'est enregistr&eacute; pour cet individu > </td>
                                                     </tr>';
                                    }

                               $contenu .= '</tbody></table></div>
                                   </div>
                                   <div class="formulaire" action="creation_credit">
                                   <div class="colonne_droite">
                                         <div class="input_text">
                                            <input id="organisme" class="contour_field" type="text" title="Organisme" placeholder="Organisme">
                                        </div>
                                        <div class="input_text">
                                            <input id="mensualite" class="contour_field" type="text" title="Mensualite" placeholder="Mensualite">
                                        </div>
                                        <div class="input_text">
                                            <input id="duree" class="contour_field" type="text" title="Dur&eacute;e" placeholder="Dur&eacute;e">
                                        </div>
                                        <div class="input_text">
                                            <input id="total" class="contour_field" type="text" title="Total Restant" placeholder="Total Restant">
                                        </div>
                                        <div class="sauvegarder_annuler">
                                            <div class="bouton modif" value="save">Enregistrer</div>
                                            <div class="bouton classique" value="cancel">Annuler</div>
                                        </div>
                                        
                                   </div>
                                   </div>';
    return $contenu;
}

function generalite() {
    include_once('./lib/config.php');
    $user = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $situations = Doctrine_Core::getTable('situationmatri')->findAll();
    $nationalite = Doctrine_Core::getTable('nationalite')->findAll();
    $villes = Doctrine_Core::getTable('ville')->findAll();
    $liens = Doctrine_Core::getTable('lienfamille')->findAll();
    $etudes = Doctrine_Core::getTable('etude')->findAll();
    $professions = Doctrine_Core::getTable('profession')->findAll();
    $organismes = Doctrine_Core::getTable('organisme')->findAll();
    
    $contenu = '<h2>G&eacute;n&eacute;ralit&eacute;s</h2>';
    $contenu .= '
    <div>
        <h3><span>Informations personnelles</span>  <span class="edit"></span></h3>
            <ul class="list_classique">
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Nom :</span>
                        <span><input class="contour_field input_char" type="text" id="nom" value="'.$user->nom.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Prenom :</span>
                        <span><input class="contour_field input_char" type="text" id="prenom" value="'.$user->prenom.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Situation Familiale :</span>
                        <div class="select classique" role="select_situation" disabled>';
$contenu .= $user->idSitMatri == null ? '<div id="situation" class="option" value=" ">-----</div>' : '<div id="situation" class="option" value="'.$user->idSitMatri.'">'.$user->situationmatri->situation.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Nationalit&eacute; :</span>
                        <div class="select classique" role="select_natio" disabled>';
$contenu .= $user->idNationalite == null ? '<div id="nationalite" class="option" value=" ">-----</div>' : '<div id="nationalite" class="option" value="'.$user->idNationalite.'">'.$user->nationalite->nationalite.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne">
                        <span class="attribut">Date de naissance :</span>
                        <span>
                            <input class="contour_field input_date" type="text" size="10" id="datenaissance" value="'.getDatebyTimestamp($user->dateNaissance).'" disabled/>
                        </span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Lieu de naissance :</span>
                        <span><input type="text" class="contour_field input_char autoComplete" id="lieu" table="ville" champ="libelle" value="'.$user->ville->libelle.'" valeur="'.$user->ville->id.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Sexe :</span>
                        <div class="select classique" role="select_sexe" disabled>';
$contenu .= $user->sexe == ' ' ? '<div id="sexe" class="option" value=" ">-----</div>' : '<div id="sexe" class="option" value="'.$user->sexe.'">'.$user->sexe.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Statut :</span>
                        <div class="select classique" role="select_statut" disabled>';
$contenu .= $user->idLienFamille == null ? '<div id="statut" class="option" value=" ">-----</div>' : '<div id="statut" class="option" value="'.$user->idLienFamille.'">'.$user->lienfamille->lien.'</div>';  
$contenu .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="bouton modif update" value="updateInfoPerso">Enregistrer</div>
            <div class="clearboth"></div>
        </div>';
    
// CONTACT
    $contenu .= '
    <div>
        <h3><span>T&eacute;l&agrave;phone / Email</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">T&eacute;l&agrave;phone :</span>
                    <span><input class="contour_field input_char" type="text" id="telephone" value="'.$user->telephone.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Portable :</span>
                    <span><input class="contour_field input_char" type="text" id="portable" value="'.$user->portable.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Email :</span>
                    <span><input class="contour_field input_char" type="text" id="email" value="'.$user->email.'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateContact">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
    
// SITUATION PROFESSIONNELLE
    $contenu .= '
    <div class="colonne50">
        <h3><span>Situation professionnelle</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">';
$contenu .=      '<div class="colonne_large">
                    <span class="attribut">Profession :</span>
                    <div class="select classique" role="select_profession" disabled>';
$contenu .= $user->idNiveauEtude == null ? '<div id="profession" class="option" value=" ">-----</div>' : '<div id="profession" class="option" value="'.$user->idProfession.'">'.$user->profession->profession.'</div>';  
$contenu .= '
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne_large">
                    <span class="attribut">Employeur :</span>
                    <span><input class="contour_field input_char" type="text" id="employeur" value="'.$user->employeur.'" disabled/></span>
                </div> 
            </li>
            <li class="ligne_list_classique">
                <div class="colonne_large">
                    <span class="attribut">Inscription P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="dateinscriptionpe" value="'.getDatebyTimestamp($user->dateInscriptionPe).'" disabled/></span>
                </div>
                <div class="colonne_large">
                    <span class="attribut">N&deg; dossier P.E :</span>
                    <span><input class="contour_field input_char" type="text" id="numdossierpe" value="'.$user->numDossierPe.'" disabled/></span>
                </div>
            </li>    
            <li class="ligne_list_classique">
                <div class="colonne_large">
                    <span class="attribut">D&eacute;but droits P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutdroitpe" value="'.getDatebyTimestamp($user->dateDebutDroitPe).'" disabled/></span>
                </div>
                <div class="colonne_large">
                    <span class="attribut">Fin droits P.E :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefindroitpe" value="'.getDatebyTimestamp($user->dateFinDroitPe).'" disabled/></span>
                </div> 
            </li>
        </ul>
        <div class="bouton modif update" value="updateSituationProfessionnelle">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';

// SITUATION SCOLAIRE
    $contenu .= '
    <div class="colonne50">
        <h3><span>Situation scolaire</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique" >
                <div class="colonne_large">
                    <span class="attribut">actuellement scolaris&eacute; :</span>';
                        if($user->scolarise == 1) {
                            $contenu .= '<span id="checkboxScolarise" class="checkbox checkbox_active" value="1"></span>';
                        } else {
                            $contenu .= '<span id="checkboxScolarise" class="checkbox"></span>';
                        }
     $contenu .='</div>
            </li>';
            if($user->scolarise == 1) {
                $contenu .= '<div class="scolarise">';
            } else {
                $contenu .= '<div class="scolarise" style="display:none">';
            }
    $contenu .='<li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">&Eacute;tablissement :</span>
                        <span><input class="contour_field input_char" type="text" id="etablissementscolaire" value="'.$user->etablissementScolaire.'" disabled/></span>
                    </div>
                </li>
                <li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">Classe :</span>
                        <div class="select classique" role="select_etude" disabled>';
    $contenu .= $user->idNiveauEtude == null ? '<div id="etude" class="option" value=" ">-----</div>' : '<div id="etude" class="option" value="'.$user->idNiveauEtude.'">'.$user->etude->etude.'</div>';  
    $contenu .= '
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </div>';
            if($user->scolarise == 1) {
                $contenu .= '<div class="nonscolarise" style="display:none">';
            } else {
                $contenu .= '<div class="nonscolarise">';
            }
    $contenu .='<li class="ligne_list_classique">
                    <div class="colonne_large">
                        <span class="attribut">Niveau &eacute;tude :</span>
                        <div class="select classique" role="select_etude" disabled>';
    $contenu .= $user->idNiveauEtude == null ? '<div id="etude" class="option" value=" ">-----</div>' : '<div id="etude" class="option" value="'.$user->idNiveauEtude.'">'.$user->etude->etude.'</div>';  
    $contenu .= '
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                </li>
            </div>
        </ul>
        <div class="bouton modif update" value="updateSituationScolaire">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
    
// COUVERTURE SOCIALE
    $contenu .= '
    <div>
        <h3><span>Couverture sociale</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Assur&eacute; : </span>';
    if($user->assure == 1) {
        $contenu .= '<span id="assure" class="checkbox checkbox_active" value="1"></span>';
    } else {
        $contenu .= '<span id="assure" class="checkbox" value="0"></span>';
    }
                    
    $contenu .= '</div>
                <div class="colonne">
                    <span class="attribut">N&deg; :</span>
                    <span><input maxlength="13" class="contour_field input_numsecu" type="text" id="numsecu" value="'.$user->numSecu.'" size="13" disabled/></span>
                    <span><input maxlength="2" class="contour_field input_cle" type="text" id="clefsecu" value="'.$user->clefSecu.'" size="2" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">R&eacute;gime :</span>
                    <div class="select classique" role="select_regime" disabled>';
$contenu .= $user->regime == ' ' ? '<div id="regime" class="option" value=" ">-----</div>' : '<div id="regime" class="option" value="'.$user->regime.'">'.$user->regime.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
            </li>
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_couv" disabled>';
$contenu .= $user->idCaisseSecu == null ? '<div id="caisseCouv" class="option" value=" ">-----</div>' : '<div id="caisseCouv" class="option" value="'.$user->idCaisseSecu.'">'.$user->secu->appelation.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">CMU : </span>';
    if($user->cmu == 1) {
        $contenu .= '<span id="cmu" class="checkbox checkbox_active" value="1"></span>';
    } else {
        $contenu .= '<span id="cmu" class="checkbox" value="0"></span>';
    }
    $contenu .= '
                </div>
                <div class="colonne">
                    <span class="attribut">Date d&eacute;but droit :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutcouvsecu" value="'.getDatebyTimestamp($user->dateDebutCouvSecu).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin de droits :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefincouvsecu" value="'.getDatebyTimestamp($user->dateFinCouvSecu).'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateCouvertureSocial">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
    
// MUTUELLE
$contenu .= '
    <div>
        <h3><span>Mutuelle</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_mut" disabled>';
$contenu .= $user->idCaisseMut == null ? '<div id="mutuelle" class="option" value="">-----</div>' : '<div id="mutuelle" class="option" value="'.$user->idCaisseMut.'">'.$user->mutuelle->appelation.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                    <span class="attribut">CMUC : </span>';
if($user->CMUC == 1) {
    $contenu .= '<span id="cmuc" class="checkbox checkbox_active"></span>';
} else {
    $contenu .= '<span id="cmuc" class="checkbox"></span>';
}
$contenu .= '
                </div>
                <div class="colonne">
                    <span class="attribut">N&deg; adh&eacute;rent :</span>
                    <span><input class="contour_field input_char" type="text" id="numadherentmut" value="'.$user->numAdherentMut.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date d&eacute;but :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datedebutcouvmut" value="'.getDatebyTimestamp($user->dateDebutCouvMut).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin :</span>
                    <span><input class="contour_field input_date" size="10" type="text" id="datefincouvmut" value="'.getDatebyTimestamp($user->dateFinCouvMut).'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateMutuelle">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';

// CAF
$contenu .= '
    <div>
        <h3><span>CAF</span>  <span class="edit"></span></h3>
        <ul class="list_classique">
            <li class="ligne_list_classique">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_caf" disabled>';
$contenu .= $user->idCaisseCaf == null ? '<div id="caf" class="option" value="">-----</div>' : '<div id="caf" class="option" value="'.$user->idCaisseCaf.'">'.$user->caf->appelation.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">N&deg; allocataire :</span>
                    <span><input class="contour_field input_char" type="text" id="numallocatairecaf" value="'.$user->numAllocataireCaf.'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateCaf">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';

// COMBO BOX
$contenu .= '<ul class="select_caf">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Caisse CAF') {
            $contenu .= '
                    <li>
                        <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
$contenu .= '<ul class="select_mut">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Mutuelle') {
            $contenu .= '
                    <li>
                        <div value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_couv">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Caisse SECU') {
            $contenu .= '
                    <li>
                        <div  value="'.$organisme->id.'">'.$organisme->appelation.'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
    
    
    $contenu .= ' <ul class="select_regime">';
     $contenu .= '<li>
                                    <div value="Local">Local</div>
                            </li>
                            <li>
                                <div value="G&eacute;n&eacute;ral">G&eacute;n&eacute;ral</div>
                            </li>
                            </ul>';
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_profession">';
    foreach($professions as $profession) {
        $contenu .= '<li>
                                    <div value="'.$profession->id.'">'.$profession->profession.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
   $contenu .= ' <ul class="select_etude">';
    foreach($etudes as $etude) {
        $contenu .= '<li>
                                    <div value="'.$etude->id.'">'.$etude->etude.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_statut">';
    foreach($liens as $lien) {
        $contenu .= '<li>
                                    <div value="'.$lien->id.'">'.$lien->lien.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_ville">';
    foreach($villes as $ville) {
        $contenu .= '<li>
                                    <div value="'.$ville->id.'">'.$ville->libelle.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_natio">';
    foreach($nationalite as $nat) {
        $contenu .= '<li>
                                    <div value="'.$nat->id.'">'.$nat->nationalite.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_situation">';
    foreach($situations as $sit) {
        $contenu .= '<li>
                                    <div value="'.$sit->id.'">'.$sit->situation.'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_sexe">
                                <li>
                                    <div value="Homme">Homme</div>
                                </li>
                                <li value="Femme">
                                    <div value="Femme">Femme</div>
                                </li>
                            </ul>';
    return $contenu;
}

?>
