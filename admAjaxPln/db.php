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
if ($action == "copie") {
	$titre = "Copier les tgz de prod";
} else if ($action == "importer") {
	$titre = "Importer les données de prod";
} else if ($action == "repliquerProd") {
	$titre = "Répliquer prod";
} else if ($action == "repliquerModel") {
	$titre = "Répliquer model";
} else {
	die ("action ".$action." inconnue");
}
$con = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass)
	or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>"); 
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
		<form action="action.php">
			<p/>
			<?php
			if ($action == "copie") {
			?>
				<table>
					<tr>
						<td>IP réseau</td>
						<td><input type="text" name="ip" value="<?php echo $ip_tgz; ?>" /></td>
					</tr>
					<tr>
						<td>Path</td>
						<td><input type="text" name="path" value="<?php echo $path_tgz; ?>" /></td>
					</tr>
					<tr>
						<td>Login</td>
						<td><input type="text" name="login" value="<?php echo $login_tgz; ?>" /></td>
					</tr>
					<tr>
						<td>Mdp</td>
						<td><input type="text" name="mdp" value="<?php echo $mdp_tgz; ?>" /></td>
					</tr>
					<tr>
						<td>Destination</td>
						<td><input type="text" name="out" value="<?php echo $dest_tgz; ?>" size=50 /></td>
					</tr>
				</table>
				<p/>
				<input type="hidden" name="action" value="copieTGZ" />
				<input type="submit"/>
			<?php	
			} else if ($action == "importer") {
				?>
				<table>
					<tr>
						<td>Source</td>
						<td><input type="text" name="in" value="<?php echo $dest_tgz; ?>" size=50 /></td>
					</tr>
				</table>
				<p/>
				<input type="hidden" name="action" value="importeTGZ" />
				<input type="submit"/>
				<?php
			} else if ($action == "repliquerProd") {
				?>
				<table>
					<tr>
						<td>DB source</td>
                        <td>
                            <select name="source">
                                <?php
                                $query = "SELECT ip, nom FROM serveur";
                                $result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");

                                while($line = pg_fetch_array($result, null)) {
                                    $err = testBase($con, $line["nom"]);

                                    if ( $err == "") {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_prod_base ? "selected" : "").">".$line["nom"]." (".$line["ip"].")</option>";
                                    } else {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_prod_base ? "selected" : "").">".$err." ".$line["nom"]." (".$line["ip"].")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
					</tr>
					<tr>
						<td>DB destination</td>
						<td>
                            <select name="destination">
                                <?php
                                $query = "SELECT ip, nom FROM serveur";
                                $result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");

                                while($line = pg_fetch_array($result, null)) {
                                    $err = testBase($con, $line["nom"]);

                                    if ( $err == "") {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_model_base ? "selected" : "").">".$line["nom"]." (".$line["ip"].")</option>";
                                    } else {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_model_base ? "selected" : "").">".$err." ".$line["nom"]." (".$line["ip"].")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
					</tr>
				</table>
				<p/>
				<input type="hidden" name="action" value="repliquerBase" />
				<input type="submit"/>
				<?php
			} else if ($action == "repliquerModel") {
				?>
				<table>
					<tr>
						<td>DB source</td>
                        <td>
                            <select name="source">
                                <?php
                                $query = "SELECT ip, nom FROM serveur";
                                $result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");

                                while($line = pg_fetch_array($result, null)) {
                                    $err = testBase($con, $line["nom"]);

                                    if ( $err == "") {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_model_base ? "selected" : "").">".$line["nom"]." (".$line["ip"].")</option>";
                                    } else {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_model_base ? "selected" : "").">".$err." ".$line["nom"]." (".$line["ip"].")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
					</tr>
					<tr>
						<td>DB destination</td>
						<td>
                            <select name="destination">
                                <?php
                                $query = "SELECT ip, nom FROM serveur";
                                $result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");

                                while($line = pg_fetch_array($result, null)) {
                                    $err = testBase($con, $line["nom"]);

                                    if ( $err == "") {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_dev_base ? "selected" : "").">".$line["nom"]." (".$line["ip"].")</option>";
                                    } else {
                                        echo "<option value=".$line["nom"]." ".($line["nom"] == $db_dev_base ? "selected" : "").">".$err." ".$line["nom"]." (".$line["ip"].")</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
					</tr>
				</table>
				<p/>
				<input type="hidden" name="action" value="repliquerBase" />
				<input type="submit"/>
				<?php
			}
			?>
		</form>
	</body>
</html>

<?php
    pg_close($con);
?>