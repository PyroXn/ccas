<?php
/**
 * exécute la commande en shell
 */
function execPlusAffichage($cmd) {
	echo '[EXEC] '.$cmd.'<br/>';
	$out = array();
	echo exec($cmd, $out) ;
	echo print_r($out);
	echo '<br/>';
}

/**
 * teste si le serveur est acessible
 * con = connection courante à la base d'administration
 * model = nom du serveur à tester
 */
function testBase($con, $model) {
	$query = "SELECT * FROM serveur where nom='".$model."'";
	$result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	$ip= $line['ip'];
	$prefix=$line['prefixe'];
	$err = "";
	$dbconn = pg_connect("host=".$ip." user=postgres password=postgres") or $err = " [NON ACCESSIBLE] ";
	if ($err == "") pg_close($dbconn);
	return $err;
}

/*
 * fonction qui applique le sql à la base sélectionnée
 * con = connection courante à la base d'administration
 * model = nom du serveur où appliquer
 * db = nom de la database où appliquer
 * sql = commandes à appliquer
 */
function appliqueSql($con, $model, $db ,$sql) {
	$res = true;
	$query = "SELECT * FROM serveur where nom='".$model."'";
	$result = pg_query($con, $query) or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br>\n");
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	$ip= $line['ip'];
	$prefix=$line['prefixe'];
	$dbconn = pg_connect("host=".$ip." dbname=".$prefix.$db." user=postgres password=postgres")
		or die('Connexion impossible : ' . pg_last_error());
	begin();
	$res = pg_query($dbconn, $sql);
	if(!$res) {
		$err = "<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br/>\n";
		rollback();
		echo $err;
	} else {
		commit();
	}
	pg_close($dbconn);
	return $res;
}

function begin() {
	pg_query("BEGIN") or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br/>\n");
}

function commit() {
	pg_query("COMMIT") or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br/>\n");
}
	
function rollback() {
	pg_query("ROLLBACK") or die("<span style='color:red'/>échec de la requête : " . pg_last_error()."</span><br/>\n");
}

/**
 * endsWith
 * Tests whether a text ends with the given
 * string or not.
 *
 * @param     string
 * @param     string
 * @return    bool
 */
function endsWith($Haystack, $Needle){
    // Recommended version, using strpos
    return strrpos($Haystack, $Needle) === strlen($Haystack)-strlen($Needle);
}


?>