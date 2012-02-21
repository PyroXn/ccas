/**
 * définition d'une fonction applicable sur les chaines de caractères
 * retourne une chaine formaté, qui contient length caractères avec des character devant pour remplir
 */
String.prototype.padLeft = function (length, character) { 
     return new Array(length - this.length + 1).join(character || '0') + this; 
}

/**
* fonction qui appelle action.php?action=log en boucle afin d'afficher dans la div 'log' le log de génlration de l'EAR
* paramètre d="ip=148.110.193.206&workspace=workspace&out=/mnt/extd/base.tgz/out"
*/
function lecture(d) {
	timer = setTimeout(function(){lecture(d);}, 2000);
	$.ajax({
				  async: "true", 
				  type: "GET",
				  url: "action.php",
				  data: "action=log&" + d,
				  error: function(errorData) {$("#log").html(errorData);},  //Si il y a une erreur on écrit quelque chose
				  success: function(data) {$("#log").html(data);$('html, body').animate({scrollTop: $('#log').height()}, 800);} //Si c'est bon
			});
}
/**
* fonction apellée au chargment de la page, elle apelle action.php?action=ear....&exe=0 afin de générer l'ear
* puis elle apelle la fonction lecture afin d'afficher le log
* paramètre d="ip=148.110.193.206&workspace=workspace&out=/mnt/extd/base.tgz/out"
*/
function principale(d) {
	$("#log").html("principale0 " + d);
	$.ajax({
				  async: "true",
				  type: "GET",
				  url: "action.php",
				  data: "action=ear&" + d + "&exe=0",
				  error: function(errorData) {$("#log").html(errorData);clearTimeout(timer);},  //Si il y a une erreur on écrit quelque chose
				  success: function(data) {$("#log").html(data);clearTimeout(timer);} //Si c'est bon
			});
	lecture(d);
}


function ahah(url,target) {
    document.getElementById(target).innerHTML = 'loading data...';
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = function() {ahahDone(target);};
        req.open("GET", url, true);
        req.send(null);
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
            req.onreadystatechange = function() {ahahDone(target);};
            req.open("GET", url, true);
            req.send();
        }
    }
} 

function ahahDone(target) {
   // only if req is "loaded"
   if (req.readyState == 4) {
       // only if "OK"
       if (req.status == 200 || req.status == 304) {
           results = req.responseText;
           document.getElementById(target).innerHTML = results;
       } else {
           document.getElementById(target).innerHTML="ahah error:\n" +
               req.statusText;
       }
   }
}

function couleur(obj) {
	obj.style.backgroundColor = "#FFFFFF";
}

function check() {
	var msg = "";
	if (document.formulaire.ref_bug) {
		if (document.formulaire.ref_bug.value != "") {
			var regexp = /^[0-9]{4}$/ ;
			if (!document.formulaire.ref_bug.value.match(regexp)) {
				document.formulaire.ref_bug.style.backgroundColor = "#F3C200";
				msg += "Veuillez saisir votre numero de bug XXXX\n";
			}
		} else	{
			document.formulaire.ref_bug.style.backgroundColor = "#F3C200";
			msg += "Veuillez saisir votre numero de bug XXXX\n";
		}
	} else {
		if (document.formulaire.bug.value != "") {
			var regexp = /^[0-9]{4}$/ ;
			if (!document.formulaire.bug.value.match(regexp)) {
				document.formulaire.bug.style.backgroundColor = "#F3C200";
				msg += "Veuillez saisir votre numero de bug XXXX\n";
			}
		} else	{
			document.formulaire.bug.style.backgroundColor = "#F3C200";
			msg += "Veuillez saisir votre numero de bug XXXX\n";
		}
	}
		if (document.formulaire.commentaire.value == "") {
			document.formulaire.commentaire.style.backgroundColor = "#F3C200";
			msg += "Veuillez saisir votre commentaire\n";
		} else {
			var regexp = /^[^:'\/\\]+$/ ;
			if (!document.formulaire.commentaire.value.match(regexp)) {
				document.formulaire.commentaire.style.backgroundColor = "#F3C200";
				msg += "Veuillez saisir un commentaire sans ', sans :, sans /, sans \\ \n";
			}
		}

	if (msg == "") {
		return(true);
	} else	{
		alert(msg);
		return(false);
	}
}

/**
 * permet de tester si le commentaire est bien constitué de caractères normaux
 */
function checkCom() {
	var msg = "";
	var regexp = /^[a-zA-Z0-9 ]+$/ ;
	if (!document.formulaire.commentaire.value.match(regexp)) {
		document.formulaire.commentaire.style.backgroundColor = "#F3C200";
		msg += "Veuillez saisir un commentaire sans caracteres speciaux";
	}
	if (msg == "") {
		return(true);
	} else	{
		alert(msg);
		return(false);
	}
}
/**
 * fonction apellée au clic sur le numéro de revision
 * affiche les infos et les remplit
 */
function selectRevision(id, appli, bug, commentaire){
	document.getElementById('rev').style.display="block";
	document.getElementById('bt').style.display="block";
	document.getElementById('revision').value=id;
	document.getElementById('application').value=appli.toLowerCase();
	document.getElementById('bug').value=bug.padLeft(4, '0');
	document.getElementById('commentaire').value=commentaire;
}

/**
 * Affichage/masque un objet
 */
function afficheMasque(id, visible){
	if (visible) {
		document.getElementById(id).style.display="block";
	} else {
		document.getElementById(id).style.display="none";
	}
}

/**
 * Affichage/masque un objet
 */
function afficheMasqueObj(id){
	afficheMasque(id, document.getElementById(id).style.display == "none");
}

/**
 *
 */
function listerCorrectifs(selection) {
	var appli = "";
	var etat = "";
	var type = "";
	var nom = "";
	var version = "";
	
	var nb = document.getElementsByName('appli').length;
	for (i = 0; i < nb; i ++) {
		if (document.getElementsByName('appli')[i].checked) {
			if (appli == "") {
				appli = "'" + document.getElementsByName('appli')[i].value + "'";
			} else {
				appli += ",'" + document.getElementsByName('appli')[i].value + "'";
			}
		}
	}
	
	var nb = document.getElementsByName('etat').length;
	for (i = 0; i < nb; i ++) {
		if (document.getElementsByName('etat')[i].checked) {
			if (etat == "") {
				etat = "'" + document.getElementsByName('etat')[i].value + "'";
			} else {
				etat += ",'" + document.getElementsByName('etat')[i].value + "'";
			}
		}
	}
	
	var nb = document.getElementsByName('type').length;
	for (i = 0; i < nb; i ++) {
		if (document.getElementsByName('type')[i].checked) {
			if (type == "") {
				type = "'" + document.getElementsByName('type')[i].value + "'";
			} else {
				type += ",'" + document.getElementsByName('type')[i].value + "'";
			}
		}
	}
	
	var nb = document.getElementsByName('nom').length;
	for (i = 0; i < nb; i ++) {
		if (document.getElementsByName('nom')[i].checked) {
			if (nom == "") {
				nom = "'" + document.getElementsByName('nom')[i].value + "'";
			} else {
				nom += ",'" + document.getElementsByName('nom')[i].value + "'";
			}
		}
	}
	
	var nb = document.getElementsByName('version').length;
	for (i = 0; i < nb; i ++) {
		if (document.getElementsByName('version')[i].checked) {
			if (version == "") {
				version = "'" + document.getElementsByName('version')[i].value + "'";
			} else {
				version += ",'" + document.getElementsByName('version')[i].value + "'";
			}
		}
	}
	
	$.ajax({
		async: "true",
		type: "GET",
		url: "action.php",
		data: "action=listerCorrectifs&appli="+appli+"&etat="+etat+"&type="+type+"&nom="+nom+"&version="+version+selection,
		error: function(errorData) {$("#listeCorrectifs").html(errorData);},  //Si il y a une erreur on écrit quelque chose
		success: function(data) {$("#listeCorrectifs").html(data);} //Si c'est bon
	});
}

function toutSurligner(id, numero) {
    var nb0 = document.getElementsByTagName("td").length;
    for (i = 0; i < nb0; i ++) {
        document.getElementsByTagName("td")[i].style.backgroundColor="#f6f6f6";
    }
    if (numero != 0) {
        var checked = true;
        var nb1 = document.getElementsByName("patch[]").length;
        for (i = 0; i < nb1; i ++) {
            if (document.getElementsByName("patch[]")[i].value == id) {
                checked = document.getElementsByName("patch[]")[i].checked;
            }
        }
        var nb = document.getElementsByName(numero).length;
        for (i = 0; i < nb; i ++) {
            var row =  document.getElementsByName(numero)[i];
            row.getElementsByTagName("td")[2].style.backgroundColor="orange";
            var td = row.getElementsByTagName("td")[2];
            td.childNodes[0].checked=checked;
        }
    }
}

/**
 * coche tout les correctifs
 */
function toutCocher() {
    var nb0 = document.getElementsByTagName("td").length;
    for (i = 0; i < nb0; i ++) {
        document.getElementsByTagName("td")[i].style.backgroundColor="#f6f6f6";
    }
    var nb = document.getElementsByName("patch[]").length;
    for (i = 0; i < nb; i ++) {
		document.getElementsByName("patch[]")[i].checked=true;
	}
}

/**
 * decoche tout les correctifs
 */
function toutDecocher() {
    var nb0 = document.getElementsByTagName("td").length;
    for (i = 0; i < nb0; i ++) {
        document.getElementsByTagName("td")[i].style.backgroundColor="#f6f6f6";
    }
    var nb = document.getElementsByName("patch[]").length;
    for (i = 0; i < nb; i ++) {
		document.getElementsByName("patch[]")[i].checked=false;
	}
}

/**
 * inverse la sélection des correctifs
 */
function inverser() {
    var nb0 = document.getElementsByTagName("td").length;
    for (i = 0; i < nb0; i ++) {
        document.getElementsByTagName("td")[i].style.backgroundColor="#f6f6f6";
    }
    var nb = document.getElementsByName("patch[]").length;
    for (i = 0; i < nb; i ++) {
		document.getElementsByName("patch[]")[i].checked=!document.getElementsByName("patch[]")[i].checked;
	}
}

function confirm() 
{
	document.mail.submit();
}