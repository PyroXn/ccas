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
                          <td>'.$ligne["nom"].' '.$ligne["prenom"].'<br/>
                              '.$ligne["numrue"].' '.$ligne["rue"].'
                          </td>
                          <td>'.$ligne["aidedemandee"].'
                          </td>
                          <td  width="300">'.$ligne["proposition"].'
                          </td>';
                if ($withDecission == 1) {
                          $retour .= '<td width="300"><b>Avis:</b> '.$ligne["avis"].'<br/><b>Quantité:</b> '.$ligne["quantite"].'<br/><b>Montant total:</b> '.$ligne["montant_total"].' €
                              <br/><b>Commentaires:</b> '.$ligne["commentaire"].'
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