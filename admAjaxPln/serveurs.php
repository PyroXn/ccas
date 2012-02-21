<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>
<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");
?>
<html>
	<head>
		<title>Liste des serveurs et actions</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="includes/style.css"  />
	</head>
<body>

<h3>Serveurs</h3>
<a href="index.html">retour</a>
<p/>
<TABLE class="liste">
<TR><TH>Nom</TH><TH>IP</TH><TH>prefix</TH><TH>Version</TH><TH>Commentaires</TH><th>Dump/Restore</th><th>Patch</th><th>Postgres</th><th>JBoss</th><th>SQL Framework</th><th>SQL All</th></TR>

<?php
	$conn = pg_connect("host=".$db_admin_host." dbname=".$db_admin_name ." user=".$db_admin_user." password=".$db_admin_pass)
		or die("<span style='color:red'/>".'Connexion impossible : ' . pg_last_error()."</span><br/>");
	$query = "select * from serveur";
	$result = pg_query($conn, $query) or die("<span style='color:red'/>".'�chec de la requ�te : ' . pg_last_error()."</span><br/>");
	while($line = pg_fetch_array($result, null)) {
			$id = $line["id"];
	  		$ip = $line["ip"];
	  		$prefixe  = $line["prefixe"];
	  		$version = $line["version"];
	  		$nom = $line["nom"];
	  		$commentaires = $line["commentaires"];
			$can_dump = $line["can_dump"];
			$can_restore = $line["can_restore"];
			$can_patch = $line["can_patch"];
			$can_change_postgres = $line["can_change_postgres"];
			$can_change_jboss = $line["can_change_jboss"];
			?>
			<TR>
				<TD><?php echo "$nom"; ?></TD>
				<TD><?php echo "$ip"; ?></TD>
				<TD><?php echo "$prefixe&nbsp;"; ?></TD>
				<TD><?php echo "$version"; ?></TD>
                <TD nowrap><?php echo "$commentaires"; ?></TD>
				<td  bgcolor="#FF0000">
					<?php if($can_dump == 't') { ?>
					<a href="#" onclick="javascript:ahah('serveurs.php','sortie');">Dump</a>
					<?php } else { echo "&nbsp;"; } ?>
					<?php if($can_restore == 't') { ?>
					<a href="#" onclick="javascript:ahah('serveurs.php','sortie');">Restore</a>
					<?php } else { echo "&nbsp;"; } ?>
				</TD>
				<td  bgcolor="#FF0000" nowrap>
					<?php if($can_patch == 't') { ?>
					<INPUT TYPE="submit" VALUE="Patch" onclick="window.location='dbAction.php?action=patch&db=<?php echo $nom;?>';">
					<?php } else { echo "&nbsp;"; } ?>
				</td>
				<td nowrap>
					<?php if($can_change_postgres == 't') { ?>
					<a href="#" onclick="javascript:ahah('action.php?action=stopPG&ip=<?php echo $ip ?>','sortie');">Stop</a>
					<a href="#" onclick="javascript:ahah('action.php?action=startPG&ip=<?php echo $ip ?>','sortie');">Start</a>
					<?php } else { echo "&nbsp;"; } ?>
				</td>
				<td nowrap>
					<?php if($can_change_jboss == 't') { ?>
					<a href="#" onclick="javascript:ahah('action.php?action=stopJB&ip=<?php echo $ip ?>','sortie');">Stop</a>
					<a href="#" onclick="javascript:ahah('action.php?action=startJB&ip=<?php echo $ip ?>','sortie');">Start</a>
					<?php } else { echo "&nbsp;"; } ?>
				</td>
                <td>
                    <?php if ($line["sql_framework"] != "") { ?>
                        <a onclick="afficheMasqueObj('panel<?php echo $id; ?>');">Afficher</a>
                        <div id="panel<?php echo $id; ?>" style="display: none">
                            <pre>
                                <?php echo $line["sql_framework"]; ?>
                            </pre>
                        </div>
                    <?php } ?>
                </td>
                 <td>
                    <?php if ($line["sql_all"] != "") { ?>
                        <a onclick="afficheMasqueObj('panelAll<?php echo $id; ?>');">Afficher</a>
                            <div id="panelAll<?php echo $id; ?>" style="display: none">
                            <pre>
                                <?php echo $line["sql_all"]; ?>
                            </pre>
                        </a>
                    <?php } ?>
                </td>
				</tr>
		<?php
	}
?>
</TABLE>
<p/>
<div id="sortie"></div>
</P>
</BODY>
</HTML>