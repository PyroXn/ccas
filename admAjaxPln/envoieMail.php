<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js" ></script>
<script type="text/javascript" src="includes/script.js" ></script>

<?php 
include_once("includes/variables.php");
include_once("includes/fonctions.php");
?>

<html>
    <head>
        <title>Envoi des mails</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="includes/style.css"  />
    </head>
    <body>       
        <h3>Envoi des mails</h3>
        <a href="index.html">retour</a>
        <p/>
        <?php
        $Sujet = "Patch " . $_POST['Version'];
        $to = "iftmun2@ema.etat.lu, iftmun3@ema.etat.lu,iftmun4@ema.etat.lu,iftmun8@ema.etat.lu";

        $From = "From:iftmun2@ema.etat.lu\n";
        $From .= "MIME-version: 1.0\n";
        $From .= "Content-type: text/html; charset= utf-8\n";

        $Message = "<h1>A ENVOYER A MM. THILL ET SCHOLTES</h1>" . $_POST['textMail'];
        mail($to, $Sujet, $Message, $From) or die("<span style='color:red'/>impossible d'envoyer le mail général</span><br/>");
        echo "<span style='color:green'/>le mail général est envoyé</span><br/>";

        if ($_POST['pers']) {
            $Message = "<h1>A ENVOYER A LtCol KOHNEN et Maj SCHILTZ</h1>" . $_POST['textMailPers'];
            mail($to, $Sujet . " partie PERS", $Message, $From) or die("<span style='color:red'/>impossible d'envoyer le mail pers</span><br/>");
            echo "<span style='color:green'/>le mail pers est envoyé</span><br/>";
        }
        if ($_POST['instr']) {
            $Message = "<h1>A ENVOYER Au LtCol SCHILTZ</h1>" . $_POST['textMailInstr'];
            mail($to, $Sujet . " partie INSTR", $Message, $From) or die("<span style='color:red'/>impossible d'envoyer le mail instr</span><br/>");
            echo "<span style='color:green'/>le mail instr est envoyé</span><br/>";
        }
        if ($_POST['log']) {
            $Message = "<h1>A ENVOYER Aux LtCol BALLINGER et ROBINET</h1>" . $_POST['textMailLog'];
            mail($to, $Sujet . " partie LOG", $Message, $From) or die("<span style='color:red'/>impossible d'envoyer le mail log</span><br/>");
            echo "<span style='color:green'/>le mail log est envoyé</span><br/>";
        }
        ?>
    </body>
</html>