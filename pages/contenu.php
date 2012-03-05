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
        <div id="updateIndividu" class="bouton modif" value="updateMembreFoyer">Enregistrer</div>
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
                <spam class="date_naissance">'. date('d/m/Y', $individu->dateNaissance) .'</span>
                <span class="chef_famille"> Chef de famille ';
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
    $user = Doctrine_Core::getTable('individu')->find($_SESSION['idIndividu']);
    $revenu = Doctrine_Core::getTable('revenu')->findOneByIdIndividu($_SESSION['idIndividu']);
    $depense = Doctrine_Core::getTable('depense')->findOneByIdIndividu($_SESSION['idIndividu']);
    $dette = Doctrine_Core::getTable('dette')->findOneByIdIndividu($_SESSION['idIndividu']);
    $credits = Doctrine_Core::getTable('credit')->findByIdIndividu($_SESSION['idIndividu']);
    $contenu = '<h2>Budget</h2>';
    $contenu .= '<h3>Ressources de '.$user->civilite.' '.$user->nom.' '.$user->prenom.'</h3>';
    $contenu .= '<ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                    <span class="first_colonne">Salaire : '.$revenu->salaire.'</span>
                                    <span class="autre_colonne">All. Chômage : '.$revenu->chomage.'</span>
                                    <span class="autre_colonne">All. familiales : '.$revenu->revenuAlloc.'</span>
                                    <span class="autre_colonne">ASS : '.$revenu->ass.'</span>
                               </li>
                               <li class="membre_foyer">
                                    <span class="first_colonne">AAH : '.$revenu->aah.'</span>
                                    <span class="autre_colonne">RSA Socle : '.$revenu->rsaSocle.'</span>
                                    <span class="autre_colonne">RSA Activité : '.$revenu->rsaActivite.'</span>
                                    <span class="autre_colonne">Retraite compl  : '.$revenu->retraitComp.'</span>
                               </li>
                               <li class="membre_foyer">
                                    <span class="first_colonne">P. alimentaire : '.$revenu->pensionAlim.'</span>
                                    <span class="autre_colonne">P. de retraite : '.$revenu->pensionRetraite.'</span>
                                    <span class="autre_colonne">Autres revenus  : '.$revenu->autreRevenu.'</span>
                                    <span class="autre_colonne">Nature autres revenus  : </span>
                               </li>
                            </ul>
                            <h3>Dépenses</h3>
                            <ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                    <span class="first_colonne">Impôts revenu : '.$depense->impotRevenu.'</span>
                                    <span class="autre_colonne">Impôts locaux : '.$depense->impotLocaux.'</span>
                                    <span class="autre_colonne">P. alimentaire : '.$depense->pensionAlim.'</span>
                                    <span class="autre_colonne">Mutuelle : '.$depense->mutuelle.'</span>
                               </li>
                               <li class="membre_foyer">
                                    <span class="first_colonne">Electricité : '.$depense->electricite.'</span>
                                    <span class="autre_colonne">Gaz : '.$depense->gaz.'</span>
                                    <span class="autre_colonne">Eau : '.$depense->eau.'</span>
                                    <span class="autre_colonne">Chauffage : '.$depense->chauffage.'</span>
                               </li>
                               <li class="membre_foyer">
                                    <span class="first_colonne">Téléphonie : '.$depense->telephonie.'</span>
                                    <span class="autre_colonne">Internet : '.$depense->internet.'</span>
                                    <span class="autre_colonne">Télévision : '.$depense->television.'</span>
                               </li>
                               <li class="membre_foyer">
                                    <span class="first_colonne">Autres Dépenses : '.$depense->autreDepense.'</span>
                                    <span class="autre_colonne">Détail : </span>
                               </li>
                            </ul>
                            <h3>Dettes</h3>
                                <ul id="membre_foyer_list">
                                <li class="membre_foyer">
                                    <span class="first_colonne">Arriéré locatif : '.$dette->arriereLocatif.'</span>
                                    <span class="autre_colonne">Frais huissier : '.$dette->fraisHuissier.'</span>
                                    <span class="autre_colonne">Autres dettes : '.$dette->autreDette.'</span>
                                    <span class="autre_colonne">Nature autres dettes :</span>
                               </li>
                               <li class="membre_foyer">
                                    <span class="first_colonne">Arriéré électricité : '.$dette->arriereElectricite.'</span>
                                    <span class="autre_colonne">Prestataire : '.$dette->idPrestaElec.'</span>
                               </li>
                              <li class="membre_foyer">
                                    <span class="first_colonne">Arriéré gaz : '.$dette->arriereElectricite.'</span>
                                    <span class="autre_colonne">Prestataire : '.$dette->idPrestaElec.'</span>
                               </li>
                               </ul>
                            <h3>Crédits</h3>
                            <ul id="membre_foyer_list">';
                            foreach($credits as $credit) {
                                $contenu .= '<li class="membre_foyer">
                                                            <span class="first_colonne">Organisme : '.$credit->organisme.'</span>
                                                            <span class="autre_colonne">Mensualité : '.$credit->mensualite.'</span>
                                                            <span class="autre_colonne">Durée : '.$credit->dureeMois.'</span>
                                                            <span class="autre_colonne">Montant total restant : '.$credit->totalRestant.'</span>
                                                      </li>';
                            }

                               $contenu .= '</ul>';
    return utf8_encode($contenu);
}

?>
