<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");

$con = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass)
		or die('Connexion impossible : ' . pg_last_error());

?>

<html>
	<head>
		<title>Génération du patch</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="includes/style.css"  />
	</head>
<body>

<h3>Génération du patch</h3>
<a href="index.html">retour</a>
<p/>
<?php
if (!isset($_GET['patch']) || $_GET['patch'] == "") {
    die("<span style='color:red'/>patch non d&eacute;fini</span><br/>");
}
if (!isset($_GET['out']) || $_GET['out'] == "") {
    die("<span style='color:red'/>out non d&eacute;fini</span><br/>");
}
$out = $_GET['out'];
/*
 * si le répertoire n'existe pas : erreur
 */
if(!is_dir($out)) {
     die("<span style='color:red'/>".$out." n'est pas un dossier</span><br/>");
}
/*
 * si le répertoire ne finit pas par /, on l'ajoute
 */
if (!endsWith($out, "/")) {
    $out .= "/";
}
/*
 * est-ce qu'on exécute et qu'on affiche
 */
$myExec = true;
$myEcho = true;

$version = "0";
$sql = 0;
$ear = false;
$java = false;

$ids = "";
$revisions = "";

$querynumPatch = "select cast ( max(CAST ((substring(num_patch from '[0-9]')) AS integer)) as varchar) || '.' || cast (max(CAST ((substring(num_patch from '[0-9]*$')) AS integer) + 1) as varchar) as patch from commandes where num_patch != ''";
$res = pg_query($con, $querynumPatch) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br/>");
$numPatch = pg_fetch_row($res);

$outPatch=$out."aaPROD";
if(!is_dir($outPatch)) {
    echo "<span style='color:red'/>".$outPatch." n'existe pas</span><br/>";
    mkdir($outPatch, 0777);
}
$outPatch=$out."aaPROD/prod".$numPatch[0];
if(!is_dir($outPatch)) {
    echo "<span style='color:red'/>".$outPatch." n'existe pas</span><br/>";
    mkdir($outPatch, 0777);
}

for ($i = 0; $i < count($_GET["patch"]); $i++) {
	$res = $_GET["patch"][$i];
	$qry = "select * from commandes where id = ".$res;
	$result = pg_query($con, $qry) or die('échec de la requête de recherche des actions : ' . pg_last_error());
	$line = pg_fetch_array($result, null);
	if ($line['type'] == "sql") {
		$file = $outPatch."/".$line['db']."-".$line['id']."-".$line['id_bug']."-".str_replace(" ", "_", $line['commentaire']).".sql";
		if ($myEcho) {
			echo "<span style='color:green'/> [FILE] >> ".$file."</span><br>\n";
		}
		if ($myExec) {
			$myfile = fopen($file, "w");
			fputs($myfile,"--bug:".$line['id_bug']." - tech : ".$line['utilisateur']." - Comment : ".$line['commentaire']."\n");
			fputs($myfile, $line['sql']."\n");
			fclose($myfile);
			chmod($file, 0777);
		}
		$sql++;
	} else if ($line['type'] == "java") {
        echo "<span style='color:green'/> [SCRIPT] >> ".$line['commentaire']."</span><br>\n";
		$java = true;
		$file = "&nbsp;";
	} else {
        $revisions .= $line['revision'].",";
        echo "<span style='color:green'/> [COMMIT] >> ".$line['revision'].": ".$line['commentaire']."</span><br>\n";
		$ear = true;
		$file = "&nbsp;";
	}
	if ($numPatch[0] > $version) {
		$version = $numPatch[0];
	}
	$ids .= $res.", ";
	
}
$ids = substr($ids, 0, -2);


$query = "update commandes set etat = 1, num_patch = ('" . $numPatch[0] . "') where id in ( " . $ids . ")";
if ($myEcho) {
    echo "<span style='color:green'/>[SQL] >> " . $query . "</span><br>\n";
}
if ($myExec) {
    pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error() . "</span><br/>");
}

$revisions = substr($revisions, 0, -2);
echo "<h3>Revisions</h3><p/>".$revisions."";

?>
<p/>
<?php
echo "<h2>Email</h2>";
$enteteMail = "";
$enteteMail .= "Bonjour
<br/><br/>
Le patch ".$version." est disponible sur le ftp
<br/><br/>
Cette version est composée de :<br/>";

if ($sql != 0) {
	$enteteMail .= "	* ".$sql."  patch".($sql > 1 ? "s" : "")." SQL<br/>";
}
if ($ear) {
	$enteteMail .= "	* Une archive java iftgest.ear<br/>";
}
if($java) {
	$enteteMail .= "	* 1 script java<br/>";
}
$enteteMail .= "<br/>
Veuillez trouver ci-dessous la liste des points corrigés dans ce patch :
<table border='1'>
<tr><td>Bug</td><td>Application</td><td>Commentaire</td><td>Type</td><td>Développeur</td></tr>";
$pers = false;
$instr = false;
$log = false;
$textMail = $enteteMail;
for ($i = 0; $i < count($_GET["patch"]); $i++) {
	$res = $_GET["patch"][$i];
	$qry = "select * from commandes where id = ".$res;
	$result = pg_query($con, $qry) or die('échec de la requête de recherche des actions : ' . pg_last_error());
	$line = pg_fetch_array($result, null);
	$textMail .= "<tr>";
    if ($line['id_bug'] == 0) {
		$textMail .= "<td>0000</td>";
	} else {
		$textMail .= "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
	}
    $textMail .= "<td>".$line['application']."</td><td>".$line['commentaire']."</td><td>".$line['type']."</td><td>".$line['utilisateur']."</td></tr>";
	
    switch ($line['application']) {
		case $line['application'] == "IFTPERS":
			if (!$pers)
			{
				$textMailPers = $enteteMail;
				$pers = true;
			}
			$textMailPers .= "<tr>";
            if ($line['id_bug'] == 0) {
                $textMailPers .= "<td>0000</td>";
            } else {
                $textMailPers .= "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
            }
            $textMailPers .= "<td>".$line['application']."</td><td>".$line['commentaire']."</td><td>".$line['type']."</td><td>".$line['utilisateur']."</td></tr>";
			break;
		case $line['application'] == "IFTINSTR":
			if (!$instr)
			{
				$textMailInstr = $enteteMail;
				$instr = true;
			}
			$textMailInstr .= "<tr>";
            if ($line['id_bug'] == 0) {
                $textMailInstr .= "<td>0000</td>";
            } else {
                $textMailInstr .= "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
            }
            $textMailInstr .= "<td>".$line['application']."</td><td>".$line['commentaire']."</td><td>".$line['type']."</td><td>".$line['utilisateur']."</td></tr>";
			break;
		case $line['application'] == "IFTLOG":
			if (!$log)
			{
				$textMailLog = $enteteMail;
				$log = true;
			}
			$textMailLog .= "<tr>";
            if ($line['id_bug'] == 0) {
                $textMailLog .= "<td>0000</td>";
            } else {
                $textMailLog .= "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
            }
            $textMailLog .= "<td>".$line['application']."</td><td>".$line['commentaire']."</td><td>".$line['type']."</td><td>".$line['utilisateur']."</td></tr>";
			break;
		
		default : 
			if (!$pers)
			{
				$textMailPers = $enteteMail;
				$pers = true;
			}
			$textMailPers .= "<tr>";
            if ($line['id_bug'] == 0) {
                $textMailPers .= "<td>0000</td>";
            } else {
                $textMailPers .= "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
            }
            $textMailPers .= "<td>".$line['application']."</td><td>".$line['commentaire']."</td><td>".$line['type']."</td><td>".$line['utilisateur']."</td></tr>";
			if (!$instr)
			{
				$textMailInstr = $enteteMail;
				$instr = true;
			}
			$textMailInstr .= "<tr>";
            if ($line['id_bug'] == 0) {
                $textMailInstr .= "<td>0000</td>";
            } else {
                $textMailInstr .= "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
            }
            $textMailInstr .= "<td>".$line['application']."</td><td>".$line['commentaire']."</td><td>".$line['type']."</td><td>".$line['utilisateur']."</td></tr>";
			if (!$log)
			{
				$textMailLog = $enteteMail;
				$log = true;
			}
			$textMailLog .= "<tr>";
            if ($line['id_bug'] == 0) {
                $textMailLog .= "<td>0000</td>";
            } else {
                $textMailLog .= "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
            }
            $textMailLog .= "<td>".$line['application']."</td><td>".$line['commentaire']."</td><td>".$line['type']."</td><td>".$line['utilisateur']."</td></tr>";
		break;
	}
}
$textMail .= "</table>";
if ($pers) {
	$textMailPers .= "</table>";
}
if ($instr) {
	$textMailInstr .= "</table>";
}
if ($log) {
	$textMailLog .= "</table>";
}
$textMailEchappe=str_replace("\"","\\\"", $textMail) ;
echo $textMailEchappe;
echo "<h2>Email Pers</h2>";
echo '<p/>';
echo str_replace("\"","\\\"", $textMailPers);
echo "<h2>Email Instr</h2>";
echo '<p/>';
echo str_replace("\"","\\\"", $textMailInstr);
echo "<h2>Email Log</h2>";
echo '<p/>';
echo str_replace("\"","\\\"", $textMailLog);
?>

<form action="envoieMail.php" method="post">
    <p/>
    <input type="submit" value="Envoyer le mail">
    <p/>
    <input type="hidden" name="textMail" value="<?php echo $textMailEchappe; ?>">
    <input type="hidden" name="Version" value="<?php echo $version; ?>">
    <input type="hidden" name="textMailPers" value="<?php echo $textMailPers; ?>">
    <input type="hidden" name="textMailInstr" value="<?php echo $textMailInstr; ?>">
    <input type="hidden" name="textMailLog" value="<?php echo $textMailLog; ?>">
    <input type="hidden" name="pers" value="<?php echo $pers; ?>">
    <input type="hidden" name="instr" value="<?php echo $instr; ?>">
    <input type="hidden" name="log" value="<?php echo $log; ?>">
</form>
</table>
</BODY>
</HTML>
