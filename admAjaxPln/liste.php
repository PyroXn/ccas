<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");

if (!isset($_GET['action']) || $_GET['action'] == "") {
	die("<span style='color:red'/>"."action non d&eacute;finie"."</span><br/>");
}
$action = $_GET['action'];
$titre = "";
if ($action == "lister") {
	$titre = "Liste des correctifs";
} else if ($action == "selectionner") {
	$titre = "Sélection des correctifs";
} else {
	die ("action ".$action." inconnue");
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title><?php echo $titre; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="includes/style.css"  />
    </head>
	<body>
		<h3><?php echo $titre; ?></h3>
		<a href="index.html">retour</a>
		<p/>
		<table>
			<tr>
				<td>Application</td>
				<td>
				<?php
					$con = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass) or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
					$query = "select distinct(application) from commandes";
					$result = pg_query ($con, $query) or die ("La requête SQL a échoué : ". pg_last_error());
					while (list($tavariable) = pg_fetch_row($result)) {
						echo "<input type='checkbox' name='appli' value='$tavariable' onclick='listerCorrectifs(".($action == "selectionner" ? "\"&selection=ok\"" : "\"\"").")'>$tavariable\n"; 
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Etat</td>
				<td>
				<?php
					$query = "select distinct(etat) from commandes order by etat";
					$result = pg_query ($con, $query) or die ("La requête SQL a échoué :". pg_last_error());
					while ($line = pg_fetch_array($result, null)) {
						if ($line["etat"] == 0) {
							echo "<input type='checkbox' name='etat' value='".$line["etat"]."' onclick='listerCorrectifs(".($action == "selectionner" ? "\"&selection=ok\"" : "\"\"").")' checked>".$line["etat"]."\n"; 
						} else {
							echo "<input type='checkbox' name='etat' value='".$line["etat"]."' onclick='listerCorrectifs(".($action == "selectionner" ? "\"&selection=ok\"" : "\"\"").")' >".$line["etat"]."\n"; 
						}
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Type</td>
				<td>
				<?php
					$query = "select distinct(type) from commandes order by type";
					$result = pg_query ($con, $query) or die ("La requête SQL a échoué : ". pg_last_error());
					while ($line = pg_fetch_array($result, null)) {
						echo "<input type='checkbox' name='type' value='".$line["type"]."' onclick='listerCorrectifs(".($action == "selectionner" ? "\"&selection=ok\"" : "\"\"").")' checked>".$line["type"]."\n"; 
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Utilisateur</td>
				<td>
				<?php
					$query = "select distinct(utilisateur) from commandes order by utilisateur";
					$result = pg_query ($con, $query) or die ("La requête SQL a échoué : ". pg_last_error());
					while ($line = pg_fetch_array($result, null)) {
						echo "<input type='checkbox' name='nom' value='".$line["utilisateur"]."' onclick='listerCorrectifs(".($action == "selectionner" ? "\"&selection=ok\"" : "\"\"").")' checked>".$line["utilisateur"]."\n"; 
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Version</td>
				<td>
				<?php
					$query = "select distinct(num_patch) from commandes order by num_patch";
					$result = pg_query ($con, $query) or die ("La requête SQL a échoué : ". pg_last_error());
					while ($line = pg_fetch_array($result, null)) {
						if ($line["num_patch"] == null) {
							echo "<input type='checkbox' name='version' value='' onclick='listerCorrectifs(".($action == "selectionner" ? "\"&selection=ok\"" : "\"\"").")' checked>null\n"; 
						} else {
							echo "<input type='checkbox' name='version' value='".$line["num_patch"]."' onclick='listerCorrectifs(".($action == "selectionner" ? "\"&selection=ok\"" : "\"\"").")' >".$line["num_patch"]."\n"; 
						}
					}
					pg_close($con);
				?>
				</td>
			</tr>
		</table>
		<p/>
        <input type="button"  value="Tout cocher" onclick='toutCocher()' />
        <input type="button" value="Tout décocher" onclick='toutDecocher()' />
        <input type="button" value="Inverser" onclick='inverser()' />
        <form action="patch.php">
            <?php
            if ($action == "selectionner") {
                ?>
                <p/>
                <table>
                    <tr>
                        <td>Sortie des SQL</td>
                        <td><input type="text" name="out" value="<?php echo $out_prod; ?>" size=50 /></td>
                    </tr>
                </table>
                <input type="submit" value="Créer le patch"/>
                <?php
            }
            ?>
            <p/>
            <div id="listeCorrectifs" />
        </form>
    </body>
</html>

<script type="text/javascript">
	$(document).ready(listerCorrectifs(<?php if($action == "selectionner") echo "'&selection=ok'"; else echo "''"; ?>));
</script>