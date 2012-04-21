<?php
$filename = basename($_FILES['fichier']['name']);
if(file_exists($_POST['chemin'] . $filename)){
    $page = ""; //Si le fichier existe déjà on renvoie une erreur
}
//Si l'upload a réussi et que le fichier est correctement posé sur le serveur
else if (@move_uploaded_file($_FILES['fichier']['tmp_name'], $_POST['chemin'] . $filename)) {
    if(!isset($_POST['idIndividu'])) {
        include_once('./pages/document.php');
        $page = getDocument();
    } else {
        include_once('./pages/document.php');
        $page = getDocumentIndividu();
    }
}
//Si l'upload du fichier à échoué
else {
    $page = ''; //La valeur de retour sera à 0
}
echo $page; //on affiche finalement le résultat dans la page.
?>