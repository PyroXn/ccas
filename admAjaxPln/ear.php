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
if ($action == "genererDev") {
	$titre = "Générer l'EAR de Dev";
} else if ($action == "genererProd") {
	$titre = "Générer l'EAR de Prod";
} else if ($action == "copier") {
	$titre = "Copier l'EAR vers un serveur";
} else if ($action == "copierFTP") {
	$titre = "Copier l'EAR sur le FTP";
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
<p/>
<?php
if ($action == "genererDev") {
	echo '<form action="action.php">';
	echo '<label for="ip">IP compilateur : </label><input type="text" name="ip" value="'.$ip_compilateur_dev.'" /><br />';
	echo '<label for="workspace">Workspace : </label><input type="text" name="workspace" value="'.$workspace_dev.'" /><br />';
	echo '<label for="out">Sortie de l\'EAR : </label><input type="text" name="out" value="'.$out_dev.'" size=50 /><br />';
	echo '<input type="hidden" name="action" value="ear" />';
	echo '<input type="submit"/></form>';
	
} else if ($action == "genererProd") {
	echo '<form action="action.php">';
	echo '<label for="ip">IP compilateur : </label><input type="text" name="ip" value="'.$ip_compilateur_prod.'" /><br />';
	echo '<label for="workspace">Workspace : </label><input type="text" name="workspace" value="'.$workspace_prod.'" /><br />';
	echo '<label for="out">Sortie de l\'EAR : </label><input type="text" name="out" value="'.$out_prod.'" size=50 /><br />';
	echo '<input type="hidden" name="action" value="ear" />';
	echo '<input type="submit"/></form>';
	
} else if ($action == "copier") {
	echo '<form action="action.php">';
	echo '<label for="in">Source : </label><input type="text" name="in" value="'.$out_prod.'" size=50 /><br />';
	echo '<label for="ip">IP jboss destination : </label><input type="text" name="ip" value="'.$proddev.'" /><br />';
	echo '<input type="hidden" name="action" value="copyEAR" />';
	echo '<input type="submit"/></form>';
	
} else if ($action == "copierFTP") {
	echo '<form action="action.php">';
	echo '<label for="ftp">Ftp : </label><input type="text" name="ftp" value="'.$ftp_ear.'" size=50 /><br />';
	echo '<label for="annee">Année : </label><input type="text" name="annee" value="2011" /><br />';
	echo '<label for="patch">Numéro du patch : </label><input type="text" name="patch" value="patch6.3" /><br />';
	echo '<label for="in">Emplacement EAR : </label><input type="text" name="in" value="'.$out_prod.'/iftgest.ear" size=50 /><br />';
	echo '<label for="out">Destination EAR : </label><input type="text" name="out" value="iftgest.ear" /><br />';
	
	echo '<input type="hidden" name="action" value="copyEARFTP" />';
	echo '<input type="submit"/></form>';
}
?>
</body>
</html>