<link type="text/css" href="./lib/PDF/styleTabCommission.css" rel="stylesheet" >
<page orientation="paysage">
    <div id="adresse_ccas">
        CENTRE COMMUNAL D'ACTION SOCIALE DE HAYANGE
        <br/>
        57700  HAYANGE
    </div>
    <div id="date_impression">
        imprimé le: <?php echo date('d/m/Y'); ?>
    </div>
    
    <div class="espace"></div>

    <div id="titre">
        <b><?php echo $titre; ?></b>
    </div>
    
    <div class="espace"></div>
    
    <table>
        <tr>
            <th width="200">
                Famille
            </th>
            <th width="160">
                Demande
            </th>
            <th width="300">
                Propositions
            </th>
            <th width="300">
                Décision de la commission
            </th>
        </tr>
        
        <?php 
            foreach ($result as $ligne) {
                $retour = '<tr>
                          <td height="100">'.$ligne->individu->nom.' '.$ligne->individu->prenom.'<br/>
                              '.$ligne->individu->foyer->numRue.' '.$ligne->individu->foyer->rue->rue.'
                          </td>
                          <td>'.$ligne->typeAideDemandee->libelle.'
                          </td>
                          <td  width="300">'.str_replace('à', '&agrave;', $ligne->proposition).'
                          </td>';
                if ($withDecission == 1) {
                          $retour .= '<td width="300"><b>Avis:</b> '.$ligne->avis.'<br/><b>Quantité:</b> '.$ligne->quantite.'<br/><b>Montant total:</b> '.$ligne->montanttotal.' €
                              <br/><b>Commentaires:</b> '.str_replace('à', '&agrave;', $ligne->commentaire).'
                          </td>';
                } else {
                    $retour .= '<td></td>';
                }
                $retour .= '</tr>';
                echo $retour;
            };
        ?>
    </table>
</page>