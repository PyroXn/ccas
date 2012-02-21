<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");
include_once("includes/dbSystem.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
		<link rel="stylesheet" type="text/css" href="includes/style.css"  />
	</head>

	<body>
	<?php
	if (!isset($_GET['action']) || $_GET['action'] == "") {
		die("<span style='color:red'/>"."action non d&eacute;finie"."</span><br/>");
	}
	$action = $_GET['action'];

	/////////////////////////////////
	/////////////////////////////////	
	if ($action == "copieTGZ") {
        ?>
        <h3>Copie des TGZ de prod</h3>
		<a href="index.html">retour</a>
        <p/>
        <?php
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];
		if (!isset($_GET['path']) || $_GET['path'] == "") {
			die("<span style='color:red'/>"."path non d&eacute;finie"."</span><br/>");
		}
		$path = $_GET['path'];
		if (!isset($_GET['login']) || $_GET['login'] == "") {
			die("<span style='color:red'/>"."login non d&eacute;finie"."</span><br/>");
		}
		$login = $_GET['login'];
		if (!isset($_GET['mdp']) || $_GET['mdp'] == "") {
			die("<span style='color:red'/>"."mdp non d&eacute;finie"."</span><br/>");
		}
		$mdp = $_GET['mdp'];
		if (!isset($_GET['out']) || $_GET['out'] == "") {
			die("<span style='color:red'/>"."out non d&eacute;finie"."</span><br/>");
		}
		$out = $_GET['out'];
		execPlusAffichage('sudo ./scripts/recupererTgzSmb.sh '.$ip.' '.$path.' '.$login.' '.$mdp.' *.tgz '.$out.' ');
        
        
	/////////////////////////////////
	// GENERE DB_PROD A PARTIR DES TGZ
	/////////////////////////////////
	} else if ($action == "importeTGZ") {
        ?>
        <h3>Importation des TGZ de prod</h3>
		<a href="index.html">retour</a>
        <p/>
        <?php
		if (!isset($_GET['in']) || $_GET['in'] == "") {
			die("<span style='color:red'/>"."in non d&eacute;finie"."</span><br/>");
		}
		$in = $_GET['in'];
		$con = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass);
		$system = new dbSystem($con, "db_prod");
		$system->importTGZ($con, $in);
        pg_close($con);
        
        
	/////////////////////////////////
	// REPLICATION DE LA BASE
	/////////////////////////////////
	} else if ($action == "repliquerBase") {
        ?>
        <h3>Réplication de la base</h3>
		<a href="index.html">retour</a>
        <p/>
        <?php
        if (!isset($_GET['source']) || $_GET['source'] == "") {
			die("<span style='color:red'/>source non d&eacute;finie"."</span><br/>");
		}
		$source = $_GET['source'];
        if (!isset($_GET['destination']) || $_GET['destination'] == "") {
			die("<span style='color:red'/>destination non d&eacute;finie"."</span><br/>");
		}
		$destination = $_GET['destination'];
        
		$con = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass);
		$dbOut = new dbSystem($con, $destination);
		$dbIn = new dbSystem($con, $source);
		if ($destination == "db_model") {
			$dbOut->copie($con, $dbIn, $dest_tgz);	
		} else {
			$dbOut->copie($con, $dbIn, $dest_tgz_tmp);
		}
		
		pg_close($con);
        

	
	/////////////////////////////////
	// STOP JBOSS
	/////////////////////////////////
	} else if ($action == "stopJB") {
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];

		execPlusAffichage('sudo ./scripts/stopJBoss.sh '.$ip) ;

	/////////////////////////////////
	// START JBOSS
	/////////////////////////////////
	} else if ($action == "startJB") {
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];

		execPlusAffichage('sudo ./scripts/startJBoss.sh '.$ip);
		
	/////////////////////////////////
	// STOP Postgre
	/////////////////////////////////
	} else if ($action == "stopPG") {
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];

		execPlusAffichage('sudo ./scripts/stopPG.sh '.$ip) ;

	/////////////////////////////////
	// START Postgre
	/////////////////////////////////
	} else if ($action == "startPG") {
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];

		execPlusAffichage('sudo ./scripts/startPG.sh '.$ip);
		
	/////////////////////////////////
	// EAR
	/////////////////////////////////
	} else if ($action == "ear") {
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];
		if (!isset($_GET['workspace']) || $_GET['workspace'] == "") {
			die("<span style='color:red'/>"."workspace non d&eacute;fini"."</span><br/>");
		}
		$workspace = $_GET['workspace'];
		if (!isset($_GET['out']) || $_GET['out'] == "") {
			die("<span style='color:red'/>"."out non d&eacute;fini"."</span><br/>");
		}
		$out = $_GET['out'];
		if (isset($_GET['exe'])) {
			execPlusAffichage('sudo ./scripts/genererEAR.sh '.$ip.' '.$workspace.' '.$out);
		} else {
			?>
			<h3>Génération de l'EAR</h3>
			<a href="index.html">retour</a>
			<p id="log" />
			<script type="text/javascript">
			$(document).ready(principale("ip=<?php echo $ip; ?>&workspace=<?php echo $workspace; ?>&out=<?php echo $out ?>"));
			</script>
			<?php
		}
		
	/////////////////////////////////
	// log de génération EAR
	/////////////////////////////////
	} else if ($action == "log") {
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];
		if (!isset($_GET['workspace']) || $_GET['workspace'] == "") {
			die("<span style='color:red'/>"."workspace non d&eacute;fini"."</span><br/>");
		}
		$workspace = $_GET['workspace'];
		echo "<pre>".shell_exec('sudo ./scripts/logEAR.sh '.$ip.' '.$workspace)."</pre>";

        
	/////////////////////////////////
	// copie de l'EAR
	/////////////////////////////////
	} else if ($action == "copyEAR") {
		if (!isset($_GET['ip']) || $_GET['ip'] == "") {
			die("<span style='color:red'/>"."ip non d&eacute;finie"."</span><br/>");
		}
		$ip = $_GET['ip'];
		if (!isset($_GET['in']) || $_GET['in'] == "") {
			die("<span style='color:red'/>"."in non d&eacute;fini"."</span><br/>");
		}
		$in = $_GET['in'];
		?>
		<h3>Copie de l'EAR sur le serveur <?php echo $ip; ?></h3>
		<a href="index.html">retour</a>
		<p/>
		<?php
		execPlusAffichage('sudo ./scripts/copierEAR.sh '.$ip.' '.$in);
		
        
	/////////////////////////////////
	// copie de l'EAR sur le FTP
	/////////////////////////////////
	} else if ($action == "copyEARFTP") {
		if (!isset($_GET['ftp']) || $_GET['ftp'] == "") {
			die("<span style='color:red'/>"."ftp non d&eacute;finie"."</span><br/>");
		}
		$ftp = $_GET['ftp'];
		if (!isset($_GET['annee']) || $_GET['annee'] == "") {
			die("<span style='color:red'/>"."annee non d&eacute;finie"."</span><br/>");
		}
		$annee = $_GET['annee'];
		if (!isset($_GET['patch']) || $_GET['patch'] == "") {
			die("<span style='color:red'/>"."patch non d&eacute;finie"."</span><br/>");
		}
		$patch = $_GET['patch'];
		if (!isset($_GET['in']) || $_GET['in'] == "") {
			die("<span style='color:red'/>"."in non d&eacute;fini"."</span><br/>");
		}
		$in = $_GET['in'];
		if (!isset($_GET['out']) || $_GET['out'] == "") {
			die("<span style='color:red'/>"."out non d&eacute;finie"."</span><br/>");
		}
		$out = $_GET['out'];
		?>
		<h3>Copie de l'EAR sur le ftp</h3>
		<a href="index.html">retour</a>
		<p/>
		<?php
		execPlusAffichage('sudo ./scripts/copierEARftp.sh '.$ftp.' '.$annee.' '.$patch.' '.$in.' '.$out);
		
        
	/////////////////////////////////
	// copie des SQL sur le FTP
	/////////////////////////////////
	} else if ($action == "copySQLFTP") {
		if (!isset($_GET['ftp']) || $_GET['ftp'] == "") {
			die("<span style='color:red'/>"."ftp non d&eacute;finie"."</span><br/>");
		}
		$ftp = $_GET['ftp'];
		if (!isset($_GET['annee']) || $_GET['annee'] == "") {
			die("<span style='color:red'/>"."annee non d&eacute;finie"."</span><br/>");
		}
		$annee = $_GET['annee'];
		if (!isset($_GET['patch']) || $_GET['patch'] == "") {
			die("<span style='color:red'/>"."patch non d&eacute;finie"."</span><br/>");
		}
		$patch = $_GET['patch'];
		if (!isset($_GET['in']) || $_GET['in'] == "") {
			die("<span style='color:red'/>"."in non d&eacute;fini"."</span><br/>");
		}
		$in = $_GET['in'];
		?>
		<h3>Copie des SQL sur le ftp</h3>
		<a href="index.html">retour</a>
		<p/>
		<?php
		
		$dir = opendir($in) or die("<span style='color:red'/>".'Erreur de listage : le répertoire '.$in.' n\'existe pas'."</span><br/>");
		while($element = readdir($dir)) {
			
			if($element != '.' && $element != '..') {
				if (!is_dir($in.'/'.$element)) {
					$inSQL=$in.'/'.$element;
					$outSQL = $element;
					$cmd = 'sudo ./scripts/copierEARftp.sh '.$ftp.' '.$annee.' '.$patch.' '.$inSQL.' '.$outSQL;
					execPlusAffichage($cmd);
				}
			}
		}
		closedir($dir);
		
        
        
	/////////////////////////////////
	// application des SQL
	/////////////////////////////////
	} else if ($action == "appliquerSQL") {
		if (!isset($_GET['destination']) || $_GET['destination'] == "") {
			die("<span style='color:red'/>destination non d&eacute;finie</span><br/>");
		}
		$destination = $_GET['destination'];
        $con = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass)
					or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
		for ($i = 0; $i < count($_GET["patch"]); $i++) {
            $qry = "select * from commandes where id = ".$_GET["patch"][$i];
            $result = pg_query($con, $qry) or die("<span style='color:red'/>échec de la requête de recherche des actions : " . pg_last_error()."</span><br/>");
            $line = pg_fetch_array($result, null);
            if ($line['type'] == "sql") {
                echo $line['sql']."<br/>";
                pg_query($con, "begin;");
                
                echo "applique sur ".$destination." ". $line['db']."<br/>";
                echo $line['sql']."<br/>";
                appliqueSql($con, $destination, $line['db'] , $line['sql']);
                
            } else {
                die("<span style='color:red'/>ne sélectionner que des sql</span><br/>");
            }
        }
        pg_close($con);
        
		
	/////////////////////////////////
	// ajout d'un sql
	/////////////////////////////////
	} else if ($action == "ajouterOK") {
		if (!isset($_GET['utilisateur']) || $_GET['utilisateur'] == "") {
			die("<span style='color:red'/>"."utilisateur non d&eacute;finie"."</span><br/>");
		}
		$utilisateur = $_GET['utilisateur'];
		if (!isset($_GET['ref_bug']) || $_GET['ref_bug'] == "") {
			die("<span style='color:red'/>"."ref_bug non d&eacute;finie"."</span><br/>");
		}
		$ref_bug = $_GET['ref_bug'];
		if (!isset($_GET['commentaire']) || $_GET['commentaire'] == "") {
			die("<span style='color:red'/>"."commentaire non d&eacute;finie"."</span><br/>");
		}
		$commentaire = addslashes($_GET['commentaire']);
		if (!isset($_GET['application']) || $_GET['application'] == "") {
			die("<span style='color:red'/>"."application non d&eacute;finie"."</span><br/>");
		}
		$application = $_GET['application'];
		if (!isset($_GET['db']) || $_GET['db'] == "") {
			die("<span style='color:red'/>"."db non d&eacute;finie"."</span><br/>");
		}
		$db = $_GET['db'];
		if (!isset($_GET['sql']) || $_GET['sql'] == "") {
			die("<span style='color:red'/>"."sql non d&eacute;finie"."</span><br/>");
		}
		$sql = $_GET['sql'];
		if (!isset($_GET['mon_champ']) || $_GET['mon_champ'] == "") {
			die("<span style='color:red'/>"."Serveurs non d&eacute;finie"."</span><br/>");
		}
		echo '<h3>Application des SQL</h3><p/>';
		$con = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass)
		or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
        echo "<pre>".$sql."</pre>";
		pg_query($con, "begin;");
		$ok = true;
		for ($i = 0; $i < count($_GET["mon_champ"]); $i++) {
			$res = $_GET["mon_champ"][$i];
			if ($ok) {
				echo "Applique sql sur ".$res."<br/>";
				$ok = appliqueSql($con, $res, $db ,$sql);
			}
		}
		if (!$ok) {
			die("<span style='color:red'/>IMPOSSIBLE D'EXECUTER LA REQUETE</span><br/>");
		}
		echo '<h3>Ajout à la table des SQL</h3><p/>';
		$query = 'insert into commandes (sql, db, date, utilisateur, commentaire, id_bug, type, application) values (\''.addslashes($sql).'\',\''.$db.'\',now(),\''.$utilisateur.'\',\''.$commentaire.'\',\''.$ref_bug.'\',\'sql\',\''.$application.'\')';
		$ok = $ok && pg_query($con, $query) or die("<span style='color:red'/>".'échec de la requête : ' . pg_last_error()."</span><br/>");
		if ($ok) {
			pg_query($con, "commit;");
			echo "<h4>tout est ok</h4>";
		} else {
			pg_query($con, "rollback;");
			echo "<h4>erreur : rollback</h4>";
		}
		pg_close($con);
		
		
	/////////////////////////////////
	// modification d'un commentaire SVN
	/////////////////////////////////
	} else if ($action == "revision") {
		if (!isset($_GET['revision']) || $_GET['revision'] == "") {
			die("<span style='color:red'/>"."revision non d&eacute;finie"."</span><br/>");
		}
		$revision = $_GET['revision'];
		if (!isset($_GET['application']) || $_GET['application'] == "") {
			die("<span style='color:red'/>"."application non d&eacute;fini"."</span><br/>");
		}
		$application = strtoupper($_GET['application']);
		if (!isset($_GET['bug']) || $_GET['bug'] == "") {
			die("<span style='color:red'/>"."bug non d&eacute;fini"."</span><br/>");
		}
		$bug = $_GET['bug'];
		if (!isset($_GET['commentaire']) || $_GET['commentaire'] == "") {
			die("<span style='color:red'/>"."commentaire non d&eacute;fini"."</span><br/>");
		}
		$commentaire = $_GET['commentaire'];
		?>
		<h3>Modification du commentaire de la révision <?php echo $revision ?></h3>
		<a href="index.html">retour</a>
		<p/>
		<?php
		$cmd = 'sudo ./scripts/changerComSVN.sh '.$revision.' "'.$application.' : '.$bug.' : '.$commentaire.'"';
		execPlusAffichage($cmd);
		$con = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass)
			or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
		$query = "update commandes set application='".$application."', commentaire='".$commentaire."',id_bug=".$bug." where revision=".$revision;
		pg_query($con, $query) or die("<span style='color:red'/>".'échec de la requête : ' . pg_last_error()."</span><br/>");
		pg_close($con);
		
        
	/////////////////////////////////
	// ajout d'une commande
	/////////////////////////////////
	} else if ($action == "ajouterCommande") {
		if (!isset($_GET['bug']) || $_GET['bug'] == "") {
			die("<span style='color:red'/>"."bug non d&eacute;finie"."</span><br/>");
		}
		$bug = $_GET['bug'];
		
		if (!isset($_GET['utilisateur']) || $_GET['utilisateur'] == "") {
			die("<span style='color:red'/>"."utilisateur non d&eacute;finie"."</span><br/>");
		}
		$utilisateur = $_GET['utilisateur'];
		
		if (!isset($_GET['commentaire']) || $_GET['commentaire'] == "") {
			die("<span style='color:red'/>"."commentaire non d&eacute;finie"."</span><br/>");
		}
		$commentaire = $_GET['commentaire'];
		
		if (!isset($_GET['revision']) || $_GET['revision'] == "") {
			$revision = "NULL";
		} else {
			$revision = $_GET['revision'];
		}
		if (!isset($_GET['application']) || $_GET['application'] == "") {
			die("<span style='color:red'/>"."application non d&eacute;finie"."</span><br/>");
		}
		$application = strtoupper($_GET['application']);
		
		if (!isset($_GET['type']) || $_GET['type'] == "") {
			$type = 'code';
		} else {
			$type = $_GET['type'];
		}
		
		$con = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass)
						or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
		$query = "insert into commandes (application, id_bug, commentaire, date, utilisateur, type, revision) values ('".$application."', ".$bug.", '".$commentaire."',now(),'".$utilisateur."', '".$type."', ".$revision.")";
		pg_query($con, $query) or die("<span style='color:red'/>".'échec de la requête : ' . pg_last_error()."</span><br/>");
		pg_close($con);
		die ("ok");
		
        
	/////////////////////////////////
	// liste des correctifs
	/////////////////////////////////
	} else if ($action == "listerCorrectifs") {
		$selection = false;
		if (isset($_GET['selection'])) {
			$selection = true;
		}
		?>
		<table class="liste">
			<tr>
				<td>Num.</td>
				<td>Bug</td>
				<?php if ($selection) { ?>
				<td>Sélection</td>
				<?php } ?>
				<td>Utilisateur</td>
				<td>Révision</td>
				<td>Date</td>
				<td>Commentaire</td>
				<td>Application</td>
				<td>Type</td>
				<td>Version</td>
				<td>Etat</td>
				
			</tr>
			<?php
				
				
				$con = pg_connect("host=" . $db_admin_host . " dbname=" . $db_admin_name . " user=" . $db_admin_user . " password=" . $db_admin_pass)
					or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
				$query = "select * from commandes ";
				$where = false;
				if ($_GET['appli'] != "") {
					$query .= ($where ? "and" : "where")." application in (" . $_GET['appli'] . " ) ";
					$where = true;
				}
				if ($_GET['etat'] != "") {
					$query .= ($where ? "and" : "where")." etat in (" . $_GET['etat'] . " ) ";
					$where = true;
				}
				if ($_GET['type'] != "") {
					$query .= ($where ? "and" : "where")." type in (" . $_GET['type'] . " ) ";
					$where = true;
				}
				if ($_GET['nom'] != "") {
					$query .= ($where ? "and" : "where")." utilisateur in (" . $_GET['nom'] . " ) ";
					$where = true;
				}
				if ($_GET['version'] != "") {
					$query .= ($where ? "and" : "where")." num_patch in (" . $_GET['version'] . " ) ";
					$where = true;
				}
				$query .= "order by id_bug, date";
				//echo $query;
				$result = pg_query($con, $query) or die("<span style='color:red'/>".'échec de la requète : ' . pg_last_error()."</span><br/>");
				$compteur = 0;
				while ($line = pg_fetch_array($result, null)) {
					$compteur = $compteur + 1;
					echo "<tr name='".$line['id_bug']."'>";
						echo "<td>".$compteur."</td>";
						if ($line['id_bug'] == 0) {
							echo "<td>0000</td>";
						} else {
							echo "<td><a href='http://148.110.193.202/bugs/view_bug.php?bug_id=" . $line['id_bug'] . "'>" . $line['id_bug'] . "</a></td>";
						}
						if ($selection) {
							echo "<td>";
								echo "<input type='checkbox' name='patch[]' value='" . $line["id"] . "' checked  onclick='toutSurligner(".$line["id"].", ".$line["id_bug"].")' />";
							echo "</td>";
						}
						echo "<td>".$line['utilisateur']."</td>";
						echo "<td>".$line['revision']."</td>";
						echo "<td nowrap>" . date("d/m/y G:i", strtotime($line['date'])) . "</td>";
						echo "<td>".utf8_encode($line['commentaire'])."</td>";
						echo "<td>".$line['application']."</td>";
						echo "<td>".$line['type']."</td>";
						echo "<td>".$line['num_patch']."</td>";
						echo "<td>".$line['etat']."</td>";
						
					echo "</tr>";
				}
				pg_close($con);
			echo "</table>";
		
		
	} else {
		die ("action ".$action." inconnue");
	}
	?>

	</body>
</html>