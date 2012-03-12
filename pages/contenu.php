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
            echo 'aides';
            break;
        case 'historique':
            echo 'historique';
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
        <ul id="membre_foyer_list">';
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
    $retour = '';
    $retour .= '
        <div><h3>Foyer<span class="edit"></span></h3>
            <ul id="membre_foyer_list">
                <li class="membre_foyer">
                    <div class="colonne">
                        <span class="attribut"> test</span>
                        <span>
                            <input class="contour_field input_num autoComplete" type="text" id="salaire" table="lol" champ="rue"/>
                            <input class="contour_field input_num autoComplete" type="text" id="salaire" table="rue" champ="rue"/>
                            <input class="contour_field input_num autoComplete" type="text" id="salaire" table="rue" champ="lol"/>
                        </span>
                    </div>
                </li>
                <li class="membre_foyer">
                    <div class="colonne">
                        <span class="attribut">N</span>
                        <span><input type="text" class="contour_field input_num" id="numrue" value="'.$foyer->numRue.'" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Rue</span>
                        <span><input type="text" class="contour_field input_char" id="rue" disabled/></span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Secteur</span>
                        <div class="select classique" role="select_secteur">';
    $retour .= $foyer->idSecteur == null ? '<div id="secteur" class="option">-----</div>':'<div id="secteur" class="option" value="'.$foyer->idSecteur.'">'.$foyer->secteur->secteur.'</div>';
    $retour .= '<div class="fleche_bas"> </div>
                        </div>
                    </div>
               </li>
            </ul>
            <div class="bouton modif update" value="updateDepense">Enregistrer</div>
        </div>';
    $retour .= '<ul class="select_secteur">';
    foreach($secteurs as $secteur) {
        $retour .= '<li>
                                <div value="'.$secteur->id.'">'.$secteur->secteur.'</div>
                           </li>';
    }
    $retour .= '</ul>';
    return $retour;
}

function generateLigneMembreFoyer($individu) {
    $retour = '
        <li class="membre_foyer" id_foyer='.$individu->idFoyer.' id_individu='.$individu->id.'>
            <div>
                <span class="label">' . $individu->nom . ' ' . $individu->prenom .'</span>
                <span class="date_naissance">'. date('d/m/Y', $individu->dateNaissance) .'</span>
                <span class="date_naissance">'. $individu->lienfamille->lien .'</span>
                <span class="delete droite"></span>
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
    $contenu .= '<ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                    <div class="colonne">
                                        <span class="attribut">Salaire : </span>
                                        <span><input class="contour_field input_num" type="text" id="salaire" value="'.$revenu->salaire.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">All. Chômage : </span>
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
                               <li class="membre_foyer">
                                    <div class="colonne">
                                        <span class="attribut">AAH : </span>
                                        <span><input class="contour_field input_num" type="text" id="aah" value="'.$revenu->aah.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">RSA Socle : </span>
                                        <span><input class="contour_field input_num" type="text" id="rsaSocle" value="'.$revenu->rsaSocle.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">RSA Activité : </span>
                                        <span><input class="contour_field input_num" type="text" id="rsaActivite" value="'.$revenu->rsaActivite.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">Retraite compl  : </span>
                                        <span><input class="contour_field input_num" type="text" id="retraitComp" value="'.$revenu->retraitComp.'" disabled/></span>
                                    </div>
                               </li>
                               <li class="membre_foyer">
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
                            <h3 role="depense">Dépenses <span class="edit"></span><span class="archive"></span> <span class="timemaj">'.getDatebyTimestamp($depense->dateCreation).'</span></h3>
                            <ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                <div class="colonne">
                                    <span class="attribut">Impôts revenu : </span>
                                    <span><input class="contour_field input_num" type="text" id="impotRevenu" value="'.$depense->impotRevenu.'" disabled/></span>
                                 </div>
                                    <div class="colonne">
                                        <span class="attribut">Impôts locaux : </span>
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
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Electricité : </span>
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
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Téléphonie : </span>
                                    <span><input class="contour_field input_num" type="text" id="telephonie" value="'.$depense->telephonie.'" disabled/></span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Internet : </span>
                                    <span><input class="contour_field input_num" type="text" id="internet" value="'.$depense->internet.'" disabled/></span>
                              </div>
                              <div class="colonne">
                                    <span class="attribut">Télévision : </span>
                                    <span><input class="contour_field input_num" type="text" id="television" value="'.$depense->television.'" disabled/></span>
                               </div>
                               </li>
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Autres Dépenses : </span>
                                    <span><input class="contour_field input_num" type="text" id="autreDepense" value="'.$depense->autreDepense.'" disabled/></span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Détail : </span>
                                    <span><input class="contour_field input_char" type="text" id="natureDepense" value="'.$depense->natureDepense.'" disabled/></span>
                               </div>
                               </li>
                            </ul>
                            <div class="bouton modif update" value="updateDepense">Enregistrer</div>
                            <div class="clearboth"></div>
                            </div>
                            
                            <div>
                                <h3>Dépenses habitation <span class="edit"></span></h3>
                                <ul id="membre_foyer_list">
                                    <li class="membre_foyer">
                                    <div class="colonne">
                                        <span class="attribut">Loyer : </span>
                                        <span><input class="contour_field input_num" type="text" id="loyer" value="'.$depense->loyer.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">AL ou APL : </span>
                                        <span><input class="contour_field input_num" type="text" id="apl" value="'.$revenu->aideLogement.'" disabled/></span>
                                   </div>
                                   <div class="colonne">
                                        <span class="attribut">Résiduel : </span>
                                        <span>'.($depense->loyer - $revenu->aideLogement).'</span>
                                    </div>
                                    </li>
                                </ul>
                                <div class="bouton modif update" value="updateDepenseHabitation">Enregistrer</div>
                                <div class="clearboth"></div>
                            </div>
                            
                            <div>
                            <h3 role="dette">Dettes <span class="edit"></span><span class="archive" original-title="Archiver les dettes"></span><span class="timemaj">'.getDatebyTimestamp($dette->dateCreation).'</span></h3>
                                <ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                <div class="colonne">
                                    <span class="attribut">Arriéré locatif : </span>
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
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Arriéré électricité : </span>
                                    <span><input class="contour_field input_num" type="text" id="arriereElec" value="'.$dette->arriereElectricite.'" disabled/></span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Prestataire : </span>
                                    <span><input class="contour_field input_char" type="text" id="prestaElec" value="'.$dette->prestaElec.'" disabled/></span>
                               </div>
                               </li>
                              <li class="membre_foyer">
                              <div class="colonne">
                                    <span class="attribut">Arriéré gaz : </span>
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
                               
                               <div>
                            <h3>Crédits</h3>
                            <ul id="membre_foyer_list">';
                            foreach($credits as $credit) {
                                $contenu .= '<li name="'.$credit->id.'" class="membre_foyer">
                                                            <div class="colonne">
                                                                <span class="attribut">Organisme : </span>
                                                                <span>'.$credit->organisme.'</span>
                                                            </div>
                                                            <div class="colonne">
                                                                <span class="attribut">Mensualité : </span>
                                                                <span>'.$credit->mensualite.'</span>
                                                            </div>
                                                            <div class="colonne">
                                                                <span class="attribut">Durée : </span>
                                                                <span>'.$credit->dureeMois.'</span>
                                                            </div>
                                                            <div class="colonne">
                                                                <span class="attribut">Montant restant : </span>
                                                                <span>'.$credit->totalRestant.'</span>
                                                                <span class="timemaj">'.getDatebyTimestamp($credit->dateAjout).'</span>
                                                            </div>
                                                            <span class="delete_credit"></span>
                                                      </li>';
                            }

                               $contenu .= '</ul>
                                   <div class="bouton modif" id="createCredit">Ajouter un crédit</div></div>
                                   <div class="formulaire" action="creation_credit">
                                   <div class="colonne_droite">
                                         <div class="input_text">
                                            <input id="organisme" class="contour_field" type="text" title="Organisme" placeholder="Organisme">
                                        </div>
                                        <div class="input_text">
                                            <input id="mensualite" class="contour_field" type="text" title="Mensualite" placeholder="Mensualite">
                                        </div>
                                        <div class="input_text">
                                            <input id="duree" class="contour_field" type="text" title="Durée" placeholder="Durée">
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
    return utf8_encode($contenu);
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
    
    $contenu = '<h2>Généralités</h2>';
    $contenu .= '
    <div>
        <h3><span>Informations personnelles</span><span class="edit"></span></h3>
            <ul id="membre_foyer_list">
                <li class="membre_foyer">
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
                        <div class="select classique" role="select_situation">
                            <div id="situation" class="option" value=" ">-----</div>
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Nationalité :</span>
                        <div class="select classique" role="select_natio">
                        <div id="nationalite" class="option" value=" ">-----</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </li>
                <li class="membre_foyer">
                    <div class="colonne">
                        <span class="attribut">Date de naissance :</span>
                        <span>
                            <input class="contour_field input_char" type="text" id="datenaissance" value="'.getDatebyTimestamp($user->dateNaissance).'" disabled/>
                        </span>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Lieu de naissance :</span>
                        <div class="select classique" role="select_ville">
                            <div id="lieu" class="option">YUTZ</div>
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Sexe :</span>
                        <div class="select classique" role="select_sexe">
                            <div id="sexe" class="option" value=" ">-----</div>
                            <div class="fleche_bas"> </div>
                        </div>
                    </div>
                    <div class="colonne">
                        <span class="attribut">Statut :</span>
                        <div class="select classique" role="select_statut">
                            <div id="statut" class="option" value=" ">-----</div>
                            <div class="fleche_bas"> </div>
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
        <h3><span>Télèphone / Email</span><span class="edit"></span></h3>
        <ul id="membre_foyer_list">
            <li class="membre_foyer">
                <div class="colonne">
                    <span class="attribut">Télèphone :</span>
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
    <div>
        <h3><span>Situation professionnelle</span>  <span class="edit"></span></h3>
        <ul id="membre_foyer_list">
            <li class="membre_foyer">
                <div class="colonne">
                    <span class="attribut">Niveau étude :</span>
                    <div class="select classique" role="select_etude">
                        <div id="etude" class="option" value=" ">-----</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">Profession :</span>
                    <div class="select classique" role="select_profession">
                        <div id="profession" class="option" value=" ">-----</div>
                        <div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">Employeur :</span>
                    <span><input class="contour_field input_char" type="text" id="employeur" value="'.$user->employeur.'" disabled/></span>
                </div> 
            </li>
            <li class="membre_foyer">
                <div class="colonne">
                    <span class="attribut">Inscription P.E :</span>
                    <span><input class="contour_field input_char" type="text" id="dateinscriptionpe" value="'.getDatebyTimestamp($user->dateInscriptionPe).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">N° dossier P.E :</span>
                    <span><input class="contour_field input_char" type="text" id="numdossierpe" value="'.$user->numDossierPe.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Début droits P.E :</span>
                    <span><input class="contour_field input_char" type="text" id="datedebutdroitpe" value="'.getDatebyTimestamp($user->dateDebutDroitPe).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Fin droits P.E :</span>
                    <span><input class="contour_field input_char" type="text" id="datefindroitpe" value="'.getDatebyTimestamp($user->dateFinDroitPe).'" disabled/></span>
                </div> 
            </li>
        </ul>
        <div class="bouton modif update" value="updateSituationProfessionnelle">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
    
// COUVERTURE SOCIALE
    $contenu .= '
    <div>
        <h3><span>Couverture sociale</span><span class="edit"></span></h3>
        <ul id="membre_foyer_list">
            <li class="membre_foyer">
                <div class="colonne">
                    <span class="attribut">Assuré : </span>';
    if($user->assure == 1) {
        $contenu .= '<span id="assure" class="checkbox checkbox_active" value="1"></span>';
    } else {
        $contenu .= '<span id="assure" class="checkbox" value="0"></span>';
    }
                    
    $contenu .= '</div>
                <div class="colonne">
                    <span class="attribut">N° :</span>
                    <span><input maxlength="13" class="contour_field input_numsecu" type="text" id="numsecu" value="'.$user->numSecu.'" size="13" disabled/></span>
                    <span><input maxlength="2" class="contour_field input_cle" type="text" id="clefsecu" value="'.$user->clefSecu.'" size="2" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Régime :</span>
                    <div class="select classique" role="select_regime">';
$contenu .= $user->regime == ' ' ? '<div id="regime" class="option" value=" ">-----</div>' : '<div id="regime" class="option" value="'.$user->regime.'">'.utf8_decode($user->regime).'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
            </li>
            <li class="membre_foyer">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_couv">';
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
                    <span class="attribut">Date début droit :</span>
                    <span><input class="contour_field input_char" type="text" id="datedebutcouvsecu" value="'.getDatebyTimestamp($user->dateDebutCouvSecu).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin de droits :</span>
                    <span><input class="contour_field input_char" type="text" id="datefincouvsecu" value="'.getDatebyTimestamp($user->dateFinCouvSecu).'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateCouvertureSocial">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';
    
// MUTUELLE
$contenu .= '
    <div>
        <h3><span>Mutuelle</span><span class="edit"></span></h3>
        <ul id="membre_foyer_list">
            <li class="membre_foyer">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_mut">';
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
                    <span class="attribut">N° adhérent :</span>
                    <span><input class="contour_field input_char" type="text" id="numadherentmut" value="'.$user->numAdherentMut.'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date début :</span>
                    <span><input class="contour_field input_char" type="text" id="datedebutcouvmut" value="'.getDatebyTimestamp($user->dateDebutCouvMut).'" disabled/></span>
                </div>
                <div class="colonne">
                    <span class="attribut">Date fin :</span>
                    <span><input class="contour_field input_char" type="text" id="datefincouvmut" value="'.getDatebyTimestamp($user->dateFinCouvMut).'" disabled/></span>
                </div>
            </li>
        </ul>
        <div class="bouton modif update" value="updateMutuelle">Enregistrer</div>
        <div class="clearboth"></div>
    </div>';

// CAF
$contenu .= '
    <div>
        <h3><span>CAF</span><span class="edit"></span></h3>
        <ul id="membre_foyer_list">
            <li class="membre_foyer">
                <div class="colonne">
                    <span class="attribut">Caisse :</span>
                    <div class="select classique" role="select_caf">';
$contenu .= $user->idCaisseCaf == null ? '<div id="caf" class="option" value="">-----</div>' : '<div id="caf" class="option" value="'.$user->idCaisseCaf.'">'.$user->caf->appelation.'</div>';                   
$contenu .= '<div class="fleche_bas"> </div>
                    </div>
                </div>
                <div class="colonne">
                    <span class="attribut">N° allocataire :</span>
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
                        <div value="'.$organisme->id.'">'.utf8_decode($organisme->appelation).'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
$contenu .= '<ul class="select_mut">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Mutuelle') {
            $contenu .= '
                    <li>
                        <div value="'.$organisme->id.'">'.utf8_decode($organisme->appelation).'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
    $contenu .= '<ul class="select_couv">';
    foreach($organismes as $organisme) {
        if($organisme->libelleorganisme->libelle == 'Caisse SECU') {
            $contenu .= '
                    <li>
                        <div  value="'.$organisme->id.'">'.utf8_decode($organisme->appelation).'</div>
                    </li>';
        }
    }
    $contenu .= '</ul>';
    
    
    $contenu .= ' <ul class="select_regime">';
     $contenu .= '<li>
                                    <div value="Local">Local</div>
                            </li>
                            <li>
                                <div value="Général">Général</div>
                            </li>
                            </ul>';
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_profession">';
    foreach($professions as $profession) {
        $contenu .= '<li value="'.$profession->id.'">
                                    <div>'.utf8_decode($profession->profession).'</div>
                               </li>';
    }
    $contenu .= '</ul>';
   $contenu .= ' <ul class="select_etude">';
    foreach($etudes as $etude) {
        $contenu .= '<li value="'.$etude->id.'">
                                    <div>'.utf8_decode($etude->etude).'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_statut">';
    foreach($liens as $lien) {
        $contenu .= '<li value="'.$lien->id.'">
                                    <div>'.utf8_decode($lien->lien).'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_ville">';
    foreach($villes as $ville) {
        $contenu .= '<li value="'.$ville->id.'">
                                    <div>'.utf8_decode($ville->libelle).'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_natio">';
    foreach($nationalite as $nat) {
        $contenu .= '<li value="'.$nat->id.'">
                                    <div>'.utf8_decode($nat->nationalite).'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_situation">';
    foreach($situations as $sit) {
        $contenu .= '<li value="'.$sit->id.'">
                                    <div>'.utf8_decode($sit->situation).'</div>
                               </li>';
    }
    $contenu .= '</ul>';
    $contenu .= ' <ul class="select_sexe">
                                <li value="Homme">
                                    <div>Homme</div>
                                </li>
                                <li value="Femme">
                                    <div>Femme</div>
                                </li>
                            </ul>';
    return utf8_encode($contenu);
}

?>
