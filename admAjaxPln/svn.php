<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");
?>

<?php 

if (!isset($_GET['action']) || $_GET['action'] == "") {
	die("<span style='color:red'/>"."action non d&eacute;finie"."</span><br/>");
}
$action = $_GET['action'];
$titre = "";
if ($action == "modifier") {
	$titre = "Modifier un commit SVN";
} else if ($action == "lister") {
	$titre = "Liste des commit SVN";
} else if ($action == "ajouter") {
	$titre = "Ajouter un patch";
} else {
	die ("action ".$action." inconnue");
}
?>
<html>
	<head>
		<title><?php echo $titre; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="includes/style.css"  />
</head>

<body>
	<h3><?php echo $titre; ?></h3>
	<a href="index.html">retour</a>
	<?php if ($action == "modifier") { ?>
	<p/>
	<form name="formulaire" action="action.php" method="get" onSubmit="return checkCom();">
		<table id="rev" style="display: none">
			<tr>
				<td>Révision</td>
				<td><input type="text" value="" name="revision" id="revision" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>Application</td>
				<td><input type="text" value="" name="application" id="application" /></td>
			</tr>
			<tr>
				<td>Bug</td>
				<td><input type="text" value="" name="bug" id="bug" /></td>
			</tr>
			<tr>
				<td>Commentaire</td>
				<td><input type="text" value="" name="commentaire" id="commentaire" size="100"/></td>
			</tr>
		</table>
		<p/>
		<input type="hidden" name="action" value="revision" />
		<input id="bt" type="submit" value="ok" style="display: none"/>
	</form>
<p/>
<h4>Liste des commits</h4>
<?php } else if ($action == "ajouter") { ?>
<p/>
<form name="formulaire" action="action.php" method="get" onSubmit="return check();">

	<table>
		<tr><td>Utilisateur</td><td>

			<SELECT NAME="utilisateur">
			<?php	
				$conn = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass)
					or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>"); 
				$query = "SELECT nom FROM utilisateurs ORDER BY ordre";
				$result = pg_query($conn, $query) or die("<span style='color:red'/>".'échec de la requête : ' . pg_last_error()."</span><br/>");
				while($line = pg_fetch_array($result, null)) {
					echo "<option value=".$line["nom"].">".$line["nom"]."</option>";
				}
				pg_close($conn);
			?>
			</SELECT>
		</td></tr>
		<tr>
			<td>Type</td>
			<td><input type="text" value="java" name="type" id="type" readonly="readonly" /></td>
		</tr><tr>
			<td>Application</td>
			<td><SELECT NAME="application" id="application">
				<OPTION VALUE="IFTPERS">iftpers</option>
				<OPTION VALUE="IFTINSTR">iftinstr</option>
				<OPTION VALUE="IFTLOG">iftlog</option>
				<OPTION VALUE="COMMUN">commun</option>
			</SELECT></td>
		</tr><tr>
			<td>Bug</td>
			<td><input type="text" value="" name="bug" onKeyUp="javascript:couleur(this);" size="4"/></td>
		</tr><tr>
			<td>Commentaire</td>
			<td><input type="text" value="" name="commentaire" id="commentaire" onKeyUp="javascript:couleur(this);" size="100"/></td>
		</tr>
	</table>
	<p/>
	<input type="hidden" name="action" value="ajouterCommande" />
	<input type="submit" value="ok" />
</form>
<p/>
<h4>Liste des commits</h4>
<?php } ?>
<p/>
	<table class="liste">
		<tr>
				<td>Révision</td>
				<td>Utilisateur</td>
				<td>Bug</td>
				<td>Date</td>
				<td>Commentaire</td>
				<td>Application</td>
			</tr>
			<?php
			$con = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass)
					or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
			$qry = "select * from commandes where revision is not null and etat = 0 order by date";
			$result = pg_query($con, $qry) or die("<span style='color:red'/>".'échec de la requéte de recherche des actions : ' . pg_last_error()."</span><br/>");
			while ($line = pg_fetch_array($result, null)) {
				echo "<tr>";
					if ($action == "modifier") {
						echo "<td><a href='#' 
							onclick='javascript:selectRevision(\"" . $line['revision'] . "\", \"" . $line['application'] . "\", \"" . $line['id_bug'] . "\", \"" . $line['commentaire'] . "\")' >
							" . $line['revision'] . "</a></td>";
					} else {
						echo "<td>" . $line['revision'] . "</td>";
					}
					echo "<td>" . $line['utilisateur'] . "</td>
						<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>
						<td nowrap>" . date("d/m/y G:i", strtotime($line['date'])) . "</td>
						<td>" . $line['commentaire'] . "</td>
						<td>" . $line['application'] . "</td>
					</tr>";
			}
			pg_close($con);
			?>
	</table>
</body>
</html>