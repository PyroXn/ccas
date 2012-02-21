<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Liste des correctifs disponibles</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <?php
        $con = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass)
                or die('Connexion impossible : ' . pg_last_error());
        $numero_patch = null;
        if (isset($_POST['numero_patch'])) {
            $numero_patch = $_POST['numero_patch'];
        }
        if (is_null($numero_patch)) {
            $qry = "select * from commandes_prod where etat = 0 and application in ( " . $_POST['metier'] . " ) order by application, date";
        } else {
            $qry = "select * from commandes_prod where num_patch = '" . $numero_patch . "' and etat = 0 and application in ( " . $_POST['metier'] . " ) order by application, date";
        }
        $db = "";
        $result = pg_query($con, $qry) or die('échec de la requéte de recherche des actions : ' . pg_last_error());
        ?>
        
        <table>
            <tr>
                <td>Num.</td>
                <td>Utilisateur</td>
                <td>Bug</td>
                <td>Date</td>
                <td>Commentaire</td>
                <td>Application</td>
                <td>Version</td>
            </tr>
            <?php
            $compteur = 0;
            while ($line = pg_fetch_array($result, null)) {
                $compteur = $compteur + 1;
                echo "
                <tr>
                    <td>$compteur</td>
                    <td>" . $line['utilisateur'] . "</td>
                    <td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['ref_bug'] . "'>" . $line['ref_bug'] . "</a></td>
                    <td>" . date("d/m/y G:i", strtotime($line['date'])) . "</td>
                    <td>" . $line['commentaire'] . "</td><td>" . $line['type'] . "</td>
                    <td>" . $line['application'] . "</td>
                    <td>" . $line['num_patch'] . "</td>
                </tr>";
            }
            ?>
        </table>
    </body>
</html>

