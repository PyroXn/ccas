<link type="text/css" href="./lib/PDF/styleRapport.css" rel="stylesheet" >
<page>
    <div id="titre">
        RAPPORT D'EVALUATION SOCIALE
    </div>
    <div id="date">
        Date : <?php echo date('d/m/Y'); ?>
    </div>
    <div id="espace"></div>
    <table>
        <tr>
            <th colspan="2" width="745"><b>Renseignements Administratifs</b></th>
        </tr>
        <tr>
            <td colspan="2" class="left">
                Nom & Prénom du demandeur : <?php echo $nomComplet; ?>
            </td>
        </tr>
        <tr>
            <td width="350" class="left">
                Né le : <?php echo getDatebyTimestamp($individu->dateNaissance); ?>
            </td>
            <td width="350" class="left">
                A <?php echo $individu->ville->libelle; ?>
            </td>
        </tr>
        <tr>
            <td width="350" class="left">
                Adresse : <?php echo $individu->foyer->numRue . ' ' . $individu->foyer->rue->rue . ' ' . $individu->foyer->ville->libelle; ?>
            </td>
            <td width="350" class="left">
                Téléphone : <?php echo $individu->telephone; ?>
            </td>
        </tr>
        <tr>
            <td width="350" class="left">
                Situation Matrimoniale : <?php echo $individu->situationmatri->situation; ?>
            </td>
            <td width="350" class="left">
                Nb d'enfants : <?php echo $nbEnfant; ?>
            </td>
        </tr>
        <tr>
            <td width="350" class="left">
                Situation professionnelle : <?php echo $individu->profession->profession; ?>
            </td>
            <td width="350" class="left">
                N° CAF : <?php echo $individu->numSecu; ?>
            </td>
        </tr>
    </table>
    <div class="espace"></div>
    <table>
        <tr>
            <th class="left top" width="745" height="70">
                <b>Motif de la demande</b>
            </th>
        </tr>
    </table>
    <div class="espace"></div>
    <table>
        <tr>
            <th colspan="4" width="745">
                <b>Composition de la famille</b>
            </th>
        </tr>
        <tr>
            <td width="250">
                Nom & Prenom
            </td>
            <td width="150">
                Parenté avec le demandeur
            </td>
            <td width="100">
                Date de naissance
            </td>
            <td width="200">
                Profession - Employeur - Ecoles
            </td>
        </tr>
        <?php
        foreach ($famille as $fam) {
            ?>
            <tr>
                <td><?php echo $fam->nom .' '. $fam->prenom; ?></td>
                <td><?php echo $fam->lienfamille->lien; ?></td>
                <td><?php echo getDatebyTimestamp($fam->dateNaissance); ?></td>
                <td><?php echo $fam->profession->profession.' '. $fam->employeur.' '.$fam->etablissementScolaire; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</page>
<page>
    <div id="titre" class="left">
        RESSOURCES ET CHARGES MENSUELLES : PARTIE 1
    </div>
    <div id="titre" class="EnteteGauche">Mois de : Septembre</div>
    <div class="espace"></div>
    <table>
        <tr>
            <th width="250">Nature des ressources</th>
            <th width="112">MONTANTS</th>
            <th width="250">Nature des charges</th>
            <th width="112">MONTANTS</th>
        </tr>
        <tr>
            <td>Salaire du demandeur</td>
            <td><?php echo $ressource->salaire; ?></td>
            <td>Loyer (taux plein)</td>
            <td><?php echo $depense->loyer; ?></td>
        </tr>
        <tr>
            <td>Salaire du conjoint</td>
            <td><?php echo $salaireConjoint; ?></td>
            <td>Loyer (résiduel)</td>
            <td><?php echo $depense->loyer-$ressource->aideLogement; ?></td>
        </tr>
        <tr>
            <td>Indemnité de stage</td>
            <td></td>
            <td>Gaz</td>
            <td><?php echo $depense->gaz; ?></td>
        </tr>
        <tr>
            <td>Salaire des enfants</td>
            <td><?php echo $salaireEnfant; ?></td>
            <td>Electricité</td>
            <td><?php echo $depense->electricite; ?></td>
        </tr>
        <tr>
            <td>Complément aux indemnités</td>
            <td></td>
            <td>EAU</td>
            <td><?php echo $depense->eau; ?></td>
        </tr>
        <tr>
            <td>IJSS</td>
            <td></td>
            <td>Téléphone</td>
            <td><?php echo $depense->telephonie; ?></td>
        </tr>
        <tr>
            <td>RSA socle</td>
            <td><?php echo $ressource->rsaSocle; ?></td>
            <td>Assurance voiture</td>
            <td></td>
        </tr>
        <tr>
            <td>RSA activité</td>
            <td><?php echo $ressource->rsaActivite; ?></td>
            <td>Assurance habitation</td>
            <td></td>
        </tr>
        <tr>
            <td>AAH</td>
            <td><?php echo $ressource->aah; ?></td>
            <td>Mutuelle</td>
            <td><?php echo $depense->mutuelle; ?></td>
        </tr>
        <tr>
            <td>Chomage</td>
            <td><?php echo $ressource->chomage; ?></td>
            <td>Impots sur le revenu</td>
            <td><?php echo $depense->impotRevenu; ?></td>
        </tr>
        <tr>
            <th colspan="2">Pensions</th>
            <td>Taxe d'habitation</td>
            <td></td>
        </tr>
        <tr>
            <td class="large">Retraite</td>
            <td class="large"><?php echo $ressource->pensionRetraite; ?></td>
            <td class="large">Autres</td>
            <td class="large"><?php echo $depense->autreDepense; ?></td>
        </tr>
        <tr>
            <td class="large">Complémentaires</td>
            <td class="large"><?php echo $ressource->retraitComp; ?></td>
            <td class="large"><b>TOTAL CHARGES MENSUELLES (A)</b></td>
            <td class="large"><?php echo array_sum(array($depense->loyer-$ressource->aideLogement, $depense->gaz, $depense->electricite, $depense->eau, $depense->mutuelle, $depense->impotRevenu, $depense->autreDepense)); ?></td>
        </tr>
        <tr>
            <td>Rente A.T</td>
            <td></td>
            <th colspan="2">Crédits</th>
        </tr>
        <tr>
            <td>Invalidité</td>
            <td></td>
            <td class="top left" rowspan="4">Total des crédits :</td>
            <td rowspan="4"><?php echo $totalCredit; ?></td>
        </tr>
        <tr>
            <td>Aide sociale à l'enfance</td>
            <td></td>
        </tr>
        <tr>
            <td>ACTP</td>
            <td></td>
        </tr>
        <tr>
            <td>PSD</td>
            <td></td>
        </tr>
        <tr>
            <td>ATA</td>
            <td></td>
            <td><b>TOTAL CREDITS (B)</b></td>
            <td><?php echo $totalCredit; ?></td>
        </tr>
        <tr>
            <td>Pension alimentaire</td>
            <td><?php echo $ressource->pensionAlim; ?></td>
            <td class="top left" rowspan="3">Factures ponctuelles :</td>
            <td rowspan="3"></td>
        </tr>
        <tr>
            <td>Divers</td>
            <td></td>
        </tr>
        <tr>
            <td><b>TOTAL RESSOURCES (A)</b></td>
            <td></td>
        </tr>
        <tr>
            <td>Allocations familiales</td>
            <td></td>
            <td><b>TOTAL FACTURES PONCTUELLES (C)</b></td>
            <td></td>
        </tr>
    </table>
</page>
<page>
    <div id="titre" class="left">
        RESSOURCES ET CHARGES MENSUELLES : PARTIE 2
    </div>
    <div class="espace"></div>
    <table>
        <tr>
            <th width="250">Nature des ressources</th>
            <th width="112">MONTANTS</th>
            <th width="250">Nature des charges</th>
            <th width="112">MONTANTS</th>
        </tr>
        <tr>
            <td>RSA Majoré</td>
            <td></td>
            <th colspan="2">Dettes</th>
        </tr>
        <tr>
            <td>ASF</td>
            <td></td>
            <td rowspan="3" class="top left">Nature & créanciers :</td>
            <td rowspan="3"></td>
        </tr>
        <tr>
            <td>AL ou APL</td>
            <td></td>
        </tr>
        <tr>
            <td><b>TOTAL PRESTATIONS (B)</b></td>
            <td></td>
        </tr>
        <tr>
            <td class="noborder"></td>
            <td class="noborder"></td>
            <td class="noborder"></td>
            <td class="noborder"></td>
        </tr>
        <tr>
            <td><b>TOTAL GENERAL (A) + (B)</b></td>
            <td></td>
            <td><b>TOTAL DETTES</b></td>
            <td></td>
        </tr>
        <tr>
            <td><b>RESTE A VIVRE</b></td>
            <td></td>
            <td><b>TOTAL CHARGES (A) + (B) + (C)</b></td>
            <td></td>
        </tr>
    </table>
</page>
<page>
    <div id="titre" class="left"><u>Evalutation sociale :</u></div>
    <div class="verylarge largeur"></div>
    <table>
        <tr>
            <th width="100">DATE</th>
            <th width="340">AIDES ET ORGANISMES SOLLICITES</th>
            <th width="300">DECISIONS ET MONTANTS</th>
        </tr>
        <tr>
            <td class="verylarge"></td>
            <td class="verylarge"></td>
            <td class="verylarge"></td>
        </tr>
    </table>
</page>
