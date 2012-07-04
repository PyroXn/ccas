<link type="text/css" href="./lib/PDF/styleMandat.css" rel="stylesheet" >
<page>
    <div id="titre">
        ORDRE DE PAIEMENT
    </div>
    <table border="1">
        <tr>
            <th class="center" width="200" rowspan="2">
                Département de la Moselle<br />
                Centre Communal d'Action<br />
                Sociale<br />
                de la Ville de Hayange<br />
                057 - 022
            </th>
            <th width="200">&nbsp;Exercice</th>
            <th width="200">&nbsp;Imputation au budget</th>
            <th width="130">&nbsp;Compte n°</th>
        </tr>
        <tr>
            <td></td>
            <td class="center">article <?php echo $article; ?> - fonction <?php echo $fonction; ?></td>
            <td>&nbsp;pièce n°</td>
        </tr>
        <tr>
            <td>&nbsp;Comptable payeur :<br />
            &nbsp;Trésorerie principale de Hayange<br />
            &nbsp;C.C.P. - Nancy<br />
            &nbsp;n°5003 29 N</td>
            <td colspan="3">
            &nbsp;<u>Objet de la dépense</u><br />
            &nbsp;<?php echo $objet; ?>
            </td>
        </tr>
        <tr>
            <td rowspan="2">
                &nbsp;créancier<br />
                &nbsp;Nom : <?php echo $nom; ?><br />
                &nbsp;Prénom : <?php echo $prenom; ?><br />
                &nbsp;Adresse : <?php echo $num.' '.$rue; ?><br />
                                                <?php echo $ville; ?><br />
            </td>
            <td>
                &nbsp;Montant attribué : <?php echo $bon->montant; ?>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>&nbsp;&agrave; précompter</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>&nbsp;Vu, bon &agrave; payer ou &agrave; virer<br />&nbsp;pour la somme de :</td>
            <td>&nbsp;Somme nette &agrave; payer ou &agrave;<br />&nbsp;virer :</td>
            <td colspan="2"><?php echo $bon->montant; ?></td>
        </tr>
        <tr>
            <td>&nbsp;Pour acquit de la somme<br />
            &nbsp;indiquée ci-dessus<br /><br /><br />
            &nbsp;Hayange, le
            <br /><br /><br /></td>
            <td class="noBorder">
                &nbsp;Arrêté le présent ordre de<br /><br />
                <div width="200" class="separateur"><?php echo $lettres.' euros'; ?></div>
                <br /><br /><br />
                &nbsp;Hayange, le
                <br /><br /><br /><br /></td>
            <td class="noBorder" colspan="2"><br />
                &nbsp;paiement &agrave; la somme de :<br /><br /><br />
                <div width="330" class="separateur"></div><br />
                &nbsp;Le Président du C.C.A.S.<br />
                &nbsp;Par délégation, la Vice-Présidente<br />
                &nbsp;le Directeur
                <br /><br /><br /><br />
            </td>
        </tr>
    </table>
    <br /><br /><br />
    <div width="745" class="separateur"></div>
    <br /><br />
    <div id="titre">
        ORDRE DE PAIEMENT
    </div>
    <table border="1">
        <tr>
            <th class="center" width="200" rowspan="2">
                Département de la Moselle<br />
                Centre Communal d'Action<br />
                Sociale<br />
                de la Ville de Hayange<br />
                057 - 022
            </th>
            <th width="200">&nbsp;Exercice</th>
            <th width="200">&nbsp;Imputation au budget</th>
            <th width="130">&nbsp;Compte n°</th>
        </tr>
        <tr>
            <td></td>
            <td class="center">article <?php echo $article; ?> - fonction <?php echo $fonction; ?></td>
            <td>&nbsp;pièce n°</td>
        </tr>
        <tr>
            <td>&nbsp;Comptable payeur :<br />
            &nbsp;Trésorerie principale de Hayange<br />
            &nbsp;C.C.P. - Nancy<br />
            &nbsp;n°5003 29 N</td>
            <td colspan="3">
            &nbsp;<u>Objet de la dépense</u><br />
            &nbsp;<?php echo $objet; ?>
            </td>
        </tr>
        <tr>
            <td rowspan="2">
                &nbsp;créancier<br />
                &nbsp;Nom : <?php echo $nom; ?><br />
                &nbsp;Prénom : <?php echo $prenom; ?><br />
                &nbsp;Adresse : <?php echo $num.' '.$rue; ?><br />
                                                <?php echo $ville; ?><br />
            </td>
            <td>
                &nbsp;Montant attribué : <?php echo $bon->montant; ?>
            </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>&nbsp;&agrave; précompter</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td>&nbsp;Vu, bon &agrave; payer ou &agrave; virer<br />&nbsp;pour la somme de :</td>
            <td>&nbsp;Somme nette &agrave; payer ou &agrave;<br />&nbsp;virer :</td>
            <td colspan="2"><?php echo $bon->montant; ?></td>
        </tr>
        <tr>
            <td>&nbsp;Pour acquit de la somme<br />
            &nbsp;indiquée ci-dessus<br /><br /><br />
            &nbsp;Hayange, le
            <br /><br /><br /></td>
            <td class="noBorder">
                &nbsp;Arrêté le présent ordre de<br /><br />
                <div width="200" class="separateur"><?php echo $lettres.' euros'; ?></div>
                <br /><br /><br />
                &nbsp;Hayange, le
                <br /><br /><br /><br /></td>
            <td class="noBorder" colspan="2"><br />
                &nbsp;paiement &agrave; la somme de :<br /><br /><br />
                <div width="330" class="separateur"></div><br />
                &nbsp;Le Président du C.C.A.S.<br />
                &nbsp;Par délégation, la Vice-Présidente<br />
                &nbsp;le Directeur
                <br /><br /><br /><br />
            </td>
        </tr>
    </table>
</page>