<link type="text/css" href="./lib/PDF/styleBon.css" rel="stylesheet" >
<page>
    <div id="nomCentre">
        <b>CENTRE COMMUNAL D'ACTION SOCIALE DE HAYANGE</b>
    </div>
    <div id="telephone">
        <b>Téléphone : 03 82 82 49 00</b>
    </div>
    <div class="espace"></div>
    <table>
        <tr>
            <th colspan="2" width="285">
                Numéro de l'enregistrement
            </th>
            <th rowspan="2" width="150">
                Date du bon
            </th>
            <th colspan="2" width="300">
                Imputation budgétaire
            </th>
        </tr>
        <tr>
            <th>Exercice</th>
            <th>N° de bon</th>
            <th>Article</th>
            <th>Fonction</th>
        </tr>
        <tr>
            <td></td>
            <td><span class="numBon"><?php echo $numBon; ?></span></td>
            <td><?php echo date('d/m/Y'); ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <div class="espace"></div>
    Emis par : <div class="underline" width="470"></div> pour le C.C.A.S. <br />
    M. <div class="underline" width="720"></div>
    est invité à fournir les prestations suivantes :
    <div class="espace"></div>
    <table>
        <tr>
            <th width="350">Denrées alimentaires (<b>boissons alcoolisées exclues</b>)
            et produits de 1ère nécessité</th>
            <th width="125"></th>
            <td class="noBorder" rowspan="2">(case correspondate à cocher)</td>
        </tr>
        <tr>
            <th height="30">Autres : (préciser)</th>
            <th></th>
        </tr>
    </table>
    <div class="espace"></div>
    <div class="underline" width="735"></div>
    <div class="underline" width="735"></div>
    <div class="underline" width="735"></div>
    <div class="underline" width="735"></div>
    <div class="underline" width="735"></div>
    <div class="underline" width="735"></div>
    <div class="espace"></div>
    Pour un montant maximum de : <div class="underline" width="100"><?php echo $bon->montant; ?></div> euros : Soit en toutes lettres : <div class="underline" width="238"><?php echo $lettres; ?> euros</div>
    <div class="underline" width="735"></div>   
    <div class="espace"></div>
    Bénéficiaire : <div class="underline" width="655"><?php echo $beneficaire; ?></div>
    Rue : <div class="underline" width="333"><?php echo $rue; ?></div> N° <div class="underline" width="333"><?php echo $num; ?></div>
    <div class="espace"></div>
    Signature du bénéficiaire :
    <div class="espace"></div>
    <div class="espace"></div>
    <table>
        <tr>
            <td class="signature" width="240" height="90">
                La directrice du C.C.A.S. :<br />
                Le : <div class="underline" width="50"></div> 201<div class="underline" width="20"></div>
            </td>
            <td class="signature" width="240">
                Le Vice-Président du C.C.A.S :<br />
                <span class="test">Le : <div class="underline" width="50"></div> 201<div class="underline" width="20"></div></span>
            </td>
            <td class="signature" width="240">
                Le Président du C.C.A.S. :<br />
                Le : <div class="underline" width="50"></div> 201<div class="underline" width="20"></div>
            </td>
        </tr>
    </table>
    <div id="espace"></div>
    <div id="espace"></div>
    <div id="footer">
        La facture datée, arrêtée en toutes lettres doit être présentée en DEUX exemplaires, au plus tard dans le mois qui suit l'exécution de la
        commande. Le volet de couleur vert sera obligatoirement joint à la facture, <b>accompagné d'un relevé d'identité bancaire</b>, adressés en mairie, à
        Monsieur le Président du C.C.A.S., Place de la Résistance et de la Déportation 57701 HAYANGE CEDEX.
    </div>
</page>
