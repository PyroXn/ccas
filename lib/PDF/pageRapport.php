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
                &nbsp;<b>Motif de la demande</b><br />
                &nbsp;<?php echo $motif; ?>
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
        RESSOURCES ET CHARGES MENSUELLES
    </div>
    <div id="titre" class="EnteteGauche">Mois de : <?php echo $mois; ?></div>
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
            <td>IJSS</td>
            <td><?php echo $ressource->ijss; ?></td>
            <td>EAU</td>
            <td><?php echo $depense->eau; ?></td>
        </tr>
        <tr>
            <td>RSA socle</td>
            <td><?php echo $ressource->rsaSocle; ?></td>
            <td>Téléphone</td>
            <td><?php echo $depense->telephonie; ?></td>
        </tr>
        <tr>
           <td>RSA activité</td>
            <td><?php echo $ressource->rsaActivite; ?></td>
            <td>Assurance voiture</td>
            <td><?php echo $depense->assuranceVoiture; ?></td>
        </tr>
        <tr>
            <td>AAH</td>
            <td><?php echo $ressource->aah; ?></td>
            <td>Assurance habitation</td>
            <td><?php echo $depense->assuranceHabitation; ?></td>
        </tr>
        <tr>
             <td>Chomage</td>
            <td><?php echo $ressource->chomage; ?></td>
            <td>Mutuelle</td>
            <td><?php echo $depense->mutuelle; ?></td>
        </tr>
        <tr>
            <th colspan="2">Pensions</th>
            <td>Impôts sur le revenu</td>
            <td><?php echo $depense->impotRevenu; ?></td>
        </tr>
        <tr>
            <td class="large">Retraite</td>
            <td class="large"><?php echo $ressource->pensionRetraite; ?></td>
            <td>Impôts locaux</td>
            <td><?php echo $depense->impotLocaux; ?></td>
        </tr>
        <tr>
            <td class="large">Complémentaires</td>
            <td class="large"><?php echo $ressource->retraitComp; ?></td>
            <td class="large">Autres</td>
            <td class="large"><?php echo $depense->autreDepense; ?></td>
        </tr>
        <tr>
            <td>Invalidité</td>
            <td><?php echo $ressource->pensionInvalide; ?></td>
            <td class="large"><b>TOTAL CHARGES MENSUELLES (A)</b></td>
            <td class="large"><b><?php echo array_sum(array($depense->loyer, $depense->gaz, $depense->electricite, $depense->eau, $depense->mutuelle, $depense->impotRevenu, $depense->impotLocaux, $depense->pensionAlim, $depense->telephonie, $depense->assuranceVoiture, $depense->assuranceHabitation, $depense->autreDepense)); ?></b></td>
        </tr>
        <tr>
            <td>Pension alimentaire</td>
            <td><?php echo $ressource->pensionAlim; ?></td>
            <th colspan="2">Crédits</th>
        </tr>
        <tr>
            <td>Autres ressources</td>
            <td><?php echo $ressource->autreRevenu; ?></td>
            <td class="top left" rowspan="2">Total des crédits :</td>
            <td rowspan="2"><?php echo $totalCredit; ?></td>
        </tr>
        <tr>
            <td><b>TOTAL RESSOURCES (A)</b></td>
            <td><b><?php echo array_sum(array($ressource->salaire, $salaireConjoint, $salaireEnfant, $ressource->ijss, $ressource->rsaSocle, $ressource->rsaActivite, $ressource->aah, $ressource->chomage, $ressource->pensionRetraite, $ressource->retraitComp, $ressource->pensionInvalide, $ressource->pensionAlim, $ressource->autreRevenu)); ?></b></td>
        </tr>
        <tr>
            <td>Prestations familiales</td>
            <td><?php echo $ressource->revenuAlloc; ?></td>
            <td><b>TOTAL CREDITS (B)</b></td>
            <td><b><?php echo $totalCredit; ?></b></td>
        </tr>
        <tr>
            <td>AL ou APL</td>
            <td><?php echo $ressource->aideLogement; ?></td>
            <td><b>TOTAL DETTES (C)</b></td>
            <td><b><?php echo $totalDette; ?></b></td>
        </tr>
        <tr>
            <td><b>TOTAL PRESTATIONS (B)</b></td>
            <td><b><?php echo $ressource->revenuAlloc+$ressource->aideLogement; ?></b></td>
            <td><b>TOTAL CHARGES (A) + (B) + (C)</b></td>
            <td><b><?php echo $totalCharge = array_sum(array($totalCredit, $totalDette, $depense->loyer, $depense->gaz, $depense->electricite, $depense->eau, $depense->mutuelle, $depense->impotRevenu, $depense->autreDepense, $depense->impotLocaux, $depense->pensionAlim, $depense->telephonie, $depense->assuranceVoiture, $depense->assuranceHabitation, $depense->autreDepense)); ?></b></td>
        </tr>
        <tr>
            <td><b>TOTAL GENERAL (A) + (B)</b></td>
            <td><b><?php echo $totalG = array_sum(array($ressource->revenuAlloc, $ressource->aideLogement, $ressource->salaire, $salaireConjoint, $salaireEnfant, $ressource->ijss, $ressource->rsaSocle, $ressource->rsaActivite, $ressource->aah, $ressource->chomage, $ressource->pensionRetraite, $ressource->retraitComp, $ressource->pensionInvalide, $ressource->pensionAlim, $ressource->autreRevenu)); ?></b></td>
        </tr>
        <tr>
            <td><b>RESTE A VIVRE</b></td>
            <td><b><?php echo $totalG - $totalCharge; ?></b></td>
       </tr>
    </table>
</page>
<page>
    <div id="titre" class="left"><u>Evalutation sociale :</u></div>
    <div class="verylarge largeur"><?php echo $evaluation; ?></div>
</page>
