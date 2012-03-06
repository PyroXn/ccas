<?php

function contenu() {
    $menu = $_POST['idMenu'];
    switch ($menu) {
        case 'foyer':
            echo foyerContenu($_POST['idFoyer']);
            break;
        case 'generalites':
            echo 'generalites';
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
        <h3>Membres du foyers</h3>
        <ul id="membre_foyer_list">';
    foreach ($individus as $individu) {
        $contenu .= generateLigneMembreFoyer($individu);
    }
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
                <div class="sauvegarder_annuler">
                    <div class="bouton modif" value="save">Enregistrer</div>
                    <div class="bouton classique" value="cancel">Annuler</div>
                </div>
            </div>
        </div>';
 
    return $contenu;
}

function generateLigneMembreFoyer($individu) {
    $retour = '
        <li class="membre_foyer" id_foyer='.$individu->idFoyer.' id_individu='.$individu->id.'>
            <div>
                <span class="label">' . $individu->nom . ' ' . $individu->prenom .'</span>
                <span class="date_naissance">'. date('d/m/Y', $individu->dateNaissance) .'</span>
                <span class="delete droite"></span>
                <span class="droite"> Chef de famille ';
                    if ($individu->chefDeFamille) {
                        $retour .= '<span class="checkbox checkbox_active"></span>';
                    } else {
                        $retour .= '<span class="checkbox"></span>';
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
    $user = Doctrine_Core::getTable('individu')->find($_POST['idIndividu']);
    $revenu = Doctrine_Core::getTable('revenu')->findOneByIdIndividu($_POST['idIndividu']);
    $depense = Doctrine_Core::getTable('depense')->findOneByIdIndividu($_POST['idIndividu']);
    $dette = Doctrine_Core::getTable('dette')->findOneByIdIndividu($_POST['idIndividu']);
    $credits = Doctrine_Core::getTable('credit')->findByIdIndividu($_POST['idIndividu']);
    $contenu = '<h2>Budget</h2>';
    $contenu .= '<div><h3>Ressources  <span class="edit"></span> <span class="timemaj">'.date('d/m/Y', $revenu->dateCreation).'</span></h3>';
    $contenu .= '<ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                    <div class="colonne">
                                        <span class="attribut">Salaire : </span>
                                        <span><input class="input_dyn" type="text" id="salaire" value="'.$revenu->salaire.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">All. Chômage : </span>
                                        <span><input class="input_dyn" type="text" id="chomage" value="'.$revenu->chomage.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">All. familiales : </span>
                                        <span><input type="text" id="revenuAlloc" value="'.$revenu->revenuAlloc.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">ASS : </span>
                                        <span><input type="text" id="ass" value="'.$revenu->ass.'" disabled/></span>
                                    </div>
                               </li>
                               <li class="membre_foyer">
                                    <div class="colonne">
                                        <span class="attribut">AAH : </span>
                                        <span><input type="text" id="aah" value="'.$revenu->aah.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">RSA Socle : </span>
                                        <span><input type="text" id="rsaSocle" value="'.$revenu->rsaSocle.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">RSA Activité : </span>
                                        <span><input type="text" id="rsaActivite" value="'.$revenu->rsaActivite.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">Retraite compl  : </span>
                                        <span><input type="text" id="retraitComp" value="'.$revenu->retraitComp.'" disabled/></span>
                                    </div>
                               </li>
                               <li class="membre_foyer">
                                    <div class="colonne">
                                        <span class="attribut">P. alimentaire : </span>
                                        <span><input type="text" id="pensionAlim" value="'.$revenu->pensionAlim.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">P. de retraite : </span>
                                        <span><input type="text" id="pensionRetraite" value="'.$revenu->pensionRetraite.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">Autres revenus  : </span>
                                        <span><input type="text" id="autreRevenu" value="'.$revenu->autreRevenu.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                        <span class="attribut">Nature : </span>
                                        <span><input type="text" id="natureRevenu" value="'.$revenu->natureAutre.'" disabled/></span>
                                    </div>
                               </li>
                            </ul>
                            
                            <div class="bouton modif update" value="updateRessource">Enregistrer</div>
                            </div>
                            <div>
                            <h3>Dépenses <span class="edit"></span> <span class="timemaj">'.date('d/m/Y', $depense->dateCreation).'</span></h3>
                            <ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                <div class="colonne">
                                    <span class="attribut">Impôts revenu : </span>
                                    <span><input type="text" id="impotRevenu" value="'.$depense->impotRevenu.'" disabled/></span>
                                 </div>
                                    <div class="colonne">
                                        <span class="attribut">Impôts locaux : </span>
                                        <span><input type="text" id="impotLocaux" value="'.$depense->impotLocaux.'" disabled/></span>
                                    </div>
                                    <div class="colonne">
                                    <span class="attribut">P. alimentaire :</span>
                                    <span><input type="text" id="pensionAlim" value="'.$depense->pensionAlim.'" disabled/></span>
                                     </div>
                                     <div class="colonne">
                                    <span class="attribut">Mutuelle : </span>
                                    <span><input type="text" id="mutuelle" value="'.$depense->mutuelle.'" disabled/></span>
                                    </div>
                               </li>
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Electricité : </span>
                                    <span><input type="text" id="electricite" value="'.$depense->electricite.'" disabled/></span>
                                 </div>
                                 <div class="colonne">
                                    <span class="attribut">Gaz : </span>
                                    <span><input type="text" id="gaz" value="'.$depense->gaz.'" disabled/></span>
                                 </div>
                                 <div class="colonne">
                                    <span class="attribut">Eau : </span>
                                    <span><input type="text" id="eau" value="'.$depense->eau.'" disabled/></span>
                                 </div>
                                 <div class="colonne">
                                    <span class="attribut">Chauffage :</span>
                                    <span><input type="text" id="chauffage" value="'.$depense->chauffage.'" disabled/></span>
                                </div>
                               </li>
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Téléphonie : </span>
                                    <span><input type="text" id="telephonie" value="'.$depense->telephonie.'" disabled/></span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Internet : </span>
                                    <span><input type="text" id="internet" value="'.$depense->internet.'" disabled/></span>
                              </div>
                              <div class="colonne">
                                    <span class="attribut">Télévision : </span>
                                    <span><input type="text" id="television" value="'.$depense->television.'" disabled/></span>
                               </div>
                               </li>
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Autres Dépenses : </span>
                                    <span><input type="text" id="autreDepense" value="'.$depense->autreDepense.'" disabled/></span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Détail : </span>
                                    <span><input type="text" id="natureDepense" value="'.$depense->natureDepense.'" disabled/></span>
                               </div>
                               </li>
                            </ul>
                            
                            <div class="bouton modif update" value="updateDepense">Enregistrer</div>
                            </div>
                            <div>
                            <h3>Dépenses habitation</h3>
                            <ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                <div class="colonne">
                                    <span class="attribut">Loyer : </span>
                                    <span>'.$depense->loyer.'</span>
                                </div>
                                <div class="colonne">
                                    <span class="attribut">AL ou APL : </span>
                                    <span>'.$revenu->aideLogement.'</span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Résiduel : </span>
                                    <span>'.($depense->loyer - $revenu->aideLogement).'</span>
                                </div>
                                </li>
                            </ul>
                            <h3>Dettes <span class="timemaj">'.date('d/m/Y', $dette->dateCreation).'</span></h3>
                                <ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                <div class="colonne">
                                    <span class="attribut">Arriéré locatif : </span>
                                    <span>'.$dette->arriereLocatif.'</span>
                                </div>
                                <div class="colonne">
                                    <span class="attribut">Frais huissier : </span>
                                    <span>'.$dette->fraisHuissier.'</span>
                                </div>
                                <div class="colonne">
                                    <span class="attribut">Autres dettes : </span>
                                    <span>'.$dette->autreDette.'</span>
                                </div>
                                <div class="colonne">
                                    <span class="attribut">Nature  :</span>
                                    <span></span>
                               </div>
                               </li>
                               <li class="membre_foyer">
                               <div class="colonne">
                                    <span class="attribut">Arriéré électricité : </span>
                                    <span>'.$dette->arriereElectricite.'</span>
                               </div>
                               <div class="colonne">
                                    <span class="attribut">Prestataire : </span>
                                    <span>'.$dette->idPrestaElec.'</span>
                               </div>
                               </li>
                              <li class="membre_foyer">
                              <div class="colonne">
                                    <span class="attribut">Arriéré gaz : </span>
                                    <span>'.$dette->arriereElectricite.'</span>
                              </div>
                              <div class="colonne">
                                    <span class="attribut">Prestataire : </span>
                                    <span>'.$dette->idPrestaElec.'</span>
                               </div>
                               </li>
                               </ul>
                               </div>
                               <div>
                            <h3>Crédits</h3>
                            <ul id="membre_foyer_list">';
                            foreach($credits as $credit) {
                                $contenu .= '<li class="membre_foyer">
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
                                                            </div>
                                                      </li>';
                            }

                               $contenu .= '</ul></div>';
    return utf8_encode($contenu);
}

?>
