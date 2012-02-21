<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Choix des items disponibles</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="script.js"></script>
    </head>
    <body>
        <?php
        $con = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass)
                or die('Connexion impossible : ' . pg_last_error());

        $qry = "select * from commandes_prod where etat = 0 and application in ( " . $_POST['metier'] . " ) order by application, ref_bug";

        $db = "";
        $result = pg_query($con, $qry) or die('échec de la requête de recherche des actions : ' . pg_last_error());
        ?>
        <table>
            <tr>
                <td>Utilisateur</td>
                <td>Bug</td>
                <td>Commentaire</td>
                <td>Type</td>
                <td>Application</td>
                <td>Base</td>
                <td>A inclure</td>
                <td>SQL</td>
            </tr>
            <?php
            while ($line = pg_fetch_array($result, null)) {
                echo "
                <tr>
                    <td>" . $line['utilisateur'] . "</td>
                    <td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['ref_bug'] . "'>" . $line['ref_bug'] . "</a></td>
                    <td>" . $line['commentaire'] . "</td>
                    <td>" . $line['type'] . "</td>
                    <td>" . $line['application'] . "</td>
                    <td>" . $line['db'] . "</td>
                    <td><input type='checkbox' name='patch[]' value='" . $line["id"] . "' checked/></td>
                    <td>" . $line['sql'] . "</td>
                </tr>";
            }
            ?>
        </table>
    </body>
</html>

