<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php
include_once("includes/variables.php");
include_once("includes/fonctions.php");
?>
    
<?php
if (!isset($_GET['action']) || $_GET['action'] == "") {
    die("<span style='color:red'/>" . "action non d&eacute;finie" . "</span><br/>");
}
$action = $_GET['action'];
$titre = "";
if ($action == "ajouter") {
    $titre = "Ajouter un patch SQL";
} else if ($action == "copier") {
    $titre = "Copier les patchs SQL sur le ftp";
} else if ($action == "appliquer") {
    $titre = "Appliquer des sql sur une base";
} else {
die("action " . $action . " inconnue");
}

$conn = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass)
or die("<span style='color:red'/>" . 'Connexion impossible : ' . pg_last_error() . "</span><br/>");
?>
<html>
    <head>
        <title><?php echo $titre; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
        <link rel="stylesheet" type="text/css" href="includes/style.css"  />
    </head>
        
    <body>     
        <h3><?php echo $titre; ?></h3>
        <a href="index.html">retour</a>
        <p/>
        <?php
        if ($action == "ajouter") {
            ?>
            <form name="formulaire" action="action.php" method="get" onSubmit="return check();">
                <table>
                    <tr><td>Utilisateur</td><td>
                        
                            <SELECT NAME="utilisateur">
                                <?php
                                $query = "SELECT nom FROM utilisateurs ORDER BY ordre";
                                $result = pg_query($conn, $query) or die("<span style='color:red'/>" . 'échec de la requête : ' . pg_last_error() . "</span><br/>");
                                while ($line = pg_fetch_array($result, null)) {
                                    echo "<option value=" . $line["nom"] . ">" . $line["nom"] . "</option>";
                                }
                                ?>
                            </SELECT>
                        </td></tr>
                            
                    <tr><td>Num BUG</td><td>
                            <input type="text" name="ref_bug" onKeyUp="javascript:couleur(this);" size="4"/>
                        </td></tr>
                            
                    <tr><td>Commentaire</td><td>
                            <input type="text" name="commentaire" onKeyUp="javascript:couleur(this);" size="100"/>
                        </td></tr>
                            
                    <tr><td>Application</td><td>
                            <SELECT NAME="application" id="application">
                                <OPTION VALUE="IFTPERS">iftpers</option>
                                <OPTION VALUE="IFTINSTR">iftinstr</option>
                                <OPTION VALUE="IFTLOG">iftlog</option>
                                <OPTION VALUE="COMMUN">commun</option>
                            </SELECT>
                        </td></tr>
                            
                    <tr><td>Base</td><td>
                        
                            <SELECT NAME="db">
                                <?php
                                $query = "SELECT nom FROM bases ORDER BY ordre";
                                $result = pg_query($conn, $query) or die("<span style='color:red'/>" . 'échec de la requête : ' . pg_last_error() . "</span><br/>");
                                while ($line = pg_fetch_array($result, null)) {
                                    echo "<option value=" . $line["nom"] . ">" . $line["nom"] . "</option>";
                                }
                                ?>
                            </SELECT>
                        </td></tr>
                            
                    <tr><td>Serveurs</td><td>
                        
                            <?php
                            $qry = "select * from serveur where order_commande_sql > 0 ORDER BY order_commande_sql ASC";
                            $result = pg_query($conn, $qry) or die("<span style='color:red'/>" . 'échec de la requête de recherche des actions : ' . pg_last_error() . "</span><br/>");
                            $i = 1;
                            while ($line = pg_fetch_array($result, null)) {
                                $err = testBase($conn, $line["nom"]);
                                $checked = True;
                                $enabled = True;
                                if ($err != "") {
                                    $checked = False;
                                    $enabled = False;
                                } else {
                                    $checked = $line["is_selected"] == "t";
                                }
                                echo '<input type="checkbox" name="mon_champ[]" value="' . $line["nom"] . '" ' . ($checked ? "checked" : "") . ' ' . ($enabled ? '' : 'disabled') . '>' . $err . 'Appliquer la modification sur ' . $line["nom"] . '<br/>';
                                $i = $i + 1;
                            }
                            ?>
                        </td></tr>
                    <tr><td colspan="2"><textarea name="sql" cols="100" rows="20"></textarea></td></tr>
                </table>
                <input type="hidden" name="action" value="ajouterOK" />
                <input type="submit" value="ok" />
            </form>
                
            <?php
        } else if ($action == "copier") {
            $patch = "6.3";
            echo '<form action="action.php"><table>';
            echo '<tr><td><label for="ftp">Ftp : </label></td><td><input type="text" name="ftp" value="' . $ftp_ear . '" size=50 /></td></tr>';
            echo '<tr><td><label for="annee">Année : </label></td><td><input type="text" name="annee" value="2011" /></td></tr>';
            echo '<tr><td><label for="patch">Numéro du patch : </label></td><td><input type="text" name="patch" value="patch' . $patch . '" /></td></tr>';
            echo '<tr><td><label for="in">Emplacement SQL : </label></td><td><input type="text" name="in" value="' . $out_prod . '/aaPROD/prod' . $patch . '" size=50 /></td></tr>';

            echo '</table><input type="hidden" name="action" value="copySQLFTP" />';
            echo '<input type="submit"/></form>';
        } else if ($action == "appliquer") {
            ?>
            <p/>
            <table>
                <tr>
                    <td>Application</td>
                    <td>
                        <?php
                        $con = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass) or die("<span style='color:red'/>" . 'Connexion impossible : ' . pg_last_error() . "</span><br/>");
                        $query = "select distinct(application) from commandes";
                        $result = pg_query($con, $query) or die("La requête SQL a échoué : " . pg_last_error());
                        while (list($tavariable) = pg_fetch_row($result)) {
                            echo "<input type='checkbox' name='appli' value='$tavariable' onclick='listerCorrectifs(\"&selection=ok\")'>$tavariable\n";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Etat</td>
                    <td>
                        <?php
                        $query = "select distinct(etat) from commandes order by etat";
                        $result = pg_query($con, $query) or die("La requête SQL a échoué :" . pg_last_error());
                        while ($line = pg_fetch_array($result, null)) {
                            if ($line["etat"] == 0) {
                                echo "<input type='checkbox' name='etat' value='" . $line["etat"] . "' onclick='listerCorrectifs(\"&selection=ok\")' checked>" . $line["etat"] . "\n";
                            } else {
                                echo "<input type='checkbox' name='etat' value='" . $line["etat"] . "' onclick='listerCorrectifs(\"&selection=ok\")' >" . $line["etat"] . "\n";
                            }
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Utilisateur</td>
                    <td>
                        <?php
                        $query = "select distinct(utilisateur) from commandes order by utilisateur";
                        $result = pg_query($con, $query) or die("La requête SQL a échoué : " . pg_last_error());
                        while ($line = pg_fetch_array($result, null)) {
                            echo "<input type='checkbox' name='nom' value='" . $line["utilisateur"] . "' onclick='listerCorrectifs(\"&selection=ok\")' checked>" . $line["utilisateur"] . "\n";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Version</td>
                    <td>
                        <?php
                        $query = "select distinct(num_patch) from commandes order by num_patch";
                        $result = pg_query($con, $query) or die("La requête SQL a échoué : " . pg_last_error());
                        while ($line = pg_fetch_array($result, null)) {
                            if ($line["num_patch"] == null) {
                                echo "<input type='checkbox' name='version' value='' onclick='listerCorrectifs(\"&selection=ok\")' checked>null\n";
                            } else {
                                echo "<input type='checkbox' name='version' value='" . $line["num_patch"] . "' onclick='listerCorrectifs(\"&selection=ok\")' >" . $line["num_patch"] . "\n";
                            }
                        }
                        pg_close($con);
                        ?>
                    </td>
                </tr>
                <tr><td>Type</td><td><input type='checkbox' name='type' value='sql' checked disabled>sql</td></tr>
            </table>
            <p/>
            <form name="formulaire" action="action.php" method="get" onSubmit="return check();">
                <table>
                    <tr>
                        <td>IP base destination<td/>
                        <td>
                            <?php
                            $query = "SELECT ip, nom FROM serveur";
                            $result = pg_query($conn, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error() . "</span><br>\n");
                            ?>
                            <select name="destination">
                                <?php
                                while ($line = pg_fetch_array($result, null)) {
                                    $err = testBase($conn, $line["nom"]);

                                    if ($err == "") {
                                        echo "<option value=" . $line["nom"] . " " . ($line["nom"] == $db_dev_base ? "selected" : "") . ">" . $line["nom"] . " (" . $line["ip"] . ")</option>";
                                    } else {
                                        echo "<option value=" . $line["nom"] . " " . ($line["nom"] == $db_dev_base ? "selected" : "") . ">" . $err . " " . $line["nom"] . " (" . $line["ip"] . ")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                </table>
                <input type="hidden" name="action" value="appliquerSQL" />
                <input type="submit"/>
                <p/>
                <div id="listeCorrectifs" />
            </form>
    <?php
    }
    pg_close($conn);
    ?>
    </body>
</html>
                
<script type="text/javascript">
    $(document).ready(listerCorrectifs("&selection=ok"));
</script>