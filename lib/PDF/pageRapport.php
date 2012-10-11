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
                &nbsp;<?php echo $aide->motifDemande; ?>
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
            <td><?php echo $salaireIndividu; ?></td>
            <td>Loyer (taux plein)</td>
            <td><?php echo $loyerFamille; ?></td>
        </tr>
        <tr>
            <td>Salaire du conjoint</td>
            <td><?php echo $salaireConjoint; ?></td>
            <td>Gaz</td>
            <td><?php echo $gazFamille; ?></td>
        </tr>
        <tr>
            <td>Salaire autres membres</td>
            <td><?php echo $salaireAutre; ?></td>
            <td>Electricité</td>
            <td><?php echo $elecFamille; ?></td>
        </tr>
        <tr>
            <td>IJSS</td>
            <td><?php echo $ijssFamille; ?></td>
            <td>EAU</td>
            <td><?php echo $eauFamille; ?></td>
        </tr>
        <tr>
            <td>RSA socle</td>
            <td><?php echo $rsaSocleFamille; ?></td>
            <td>Chauffage</td>
            <td><?php echo $chauffageFamille; ?></td>
        </tr>
        <tr>
            <td>RSA activité</td>
            <td><?php echo $rsaActiviteFamille; ?></td>
            <td>Téléphone</td>
            <td><?php echo $telFamille; ?></td>
        </tr>
        <tr>
            <td>AAH</td>
            <td><?php echo $aahFamille; ?></td>
            <td>Télévision</td>
            <td><?php echo $televisionFamille; ?></td>
        </tr>
        <tr>
            <td>ASS</td>
            <td><?php echo $assFamille; ?></td>
            <td>Internet</td>
            <td><?php echo $internetFamille; ?></td>
        </tr>
        <tr>
            <td>Chomage</td>
            <td><?php echo $chomageFamille; ?></td>
            <td>Assurance voiture</td>
            <td><?php echo $assuranceVoitureFamille; ?></td>
        </tr>
        <tr>
            <th colspan="2">Pensions</th>
            <td>Assurance habitation</td>
            <td><?php echo $assuranceHabitationFamille; ?></td>
        </tr>
        <tr>
            <td>Retraite</td>
            <td><?php echo $retraiteFamille; ?></td>
            <td>Mutuelle</td>
            <td><?php echo $mutuelleFamille; ?></td>
        </tr>
        <tr>
            <td>Complémentaires</td>
            <td><?php echo $complementaireFamille; ?></td>
            <td>Impôts sur le revenu</td>
            <td><?php echo $impotRevenuFamille; ?></td>
        </tr>
        <tr>
            <td>Invalidité</td>
            <td><?php echo $invaliditeFamille; ?></td>
            <td>Impôts locaux</td>
            <td><?php echo $impotLocauxFamille; ?></td>
        </tr>
        <tr>
            <td>Pension alimentaire</td>
            <td><?php echo $pensionAlimFamille; ?></td>
            <td>Pension alimentaire</td>
            <td><?php echo $pensionAlimChargeFamille; ?></td>
        </tr>
        <tr>
            <td>Autres ressources</td>
            <td><?php echo $autresRessourceFamille; ?></td>
            <td>Autres charges</td>
            <td><?php echo $autresChargeFamille; ?></td>
        </tr>
        <tr>
            <td><b>TOTAL RESSOURCES (A)</b></td>
            <td><b><?php echo $totalRessource; ?></b></td>
            <td><b>TOTAL CHARGES MENSUELLES (A)</b></td>
            <td><b><?php echo $totalCharges; ?></b></td>
        </tr>
        <tr>
            <td>Prestations familiales</td>
            <td><?php echo $prestationFamille; ?></td>
            <th colspan="2">Crédits</th>
        </tr>
        <tr>
            <td>AL ou APL</td>
            <td><?php echo $alFamille; ?></td>
            <td><b>TOTAL CREDITS MENSUELS (B)</b></td>
            <td><b><?php echo $creditMensuel; ?></b></td>
        </tr>
        <tr>
            <td><b>TOTAL PRESTATIONS (B)</b></td>
            <td><b><?php echo $totalPrestation; ?></b></td>
            <td>Total credits</td>
            <td><?php echo $totalCredit; ?></td>
        </tr>
        <tr>
            <td><b>TOTAL GENERAL (A) + (B)</b></td>
            <td><b><?php echo $totalG = array_sum(array($totalRessource, $totalPrestation)); ?></b></td>
            <td>Total dettes</td>
            <td><?php echo $totalDette; ?></td>
        </tr>
        <tr>
            <td><b>RESTE A VIVRE</b></td>
            <td><b><?php $totalCharge = array_sum(array($creditMensuel, $totalCharges)); echo $totalG - $totalCharge; ?></b></td>
            <td><b>TOTAL CHARGES (A) + (B)</b></td>
            <td><b><?php echo $totalCharge; ?></b></td>
       </tr>
    </table>
</page>
<page>
    <div id="titre" class="left"><u>Evalutation sociale :</u></div>
    <div class="verylarge largeur"><?php echo $aide->evaluationSociale; ?></div>
</page>
