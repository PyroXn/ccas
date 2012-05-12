<?php

function getDocumentIndividu() {
    include_once('./lib/config.php');
    $idFoyer = $_POST['idFoyer'];
    $idIndividu = $_POST['idIndividu'];
    $dir_nom = './document/' . $_POST['idFoyer'] . '/' . $_POST['idIndividu'] . '/';

    //renvoie faux si le repertoire existe pas
    if (file_exists($dir_nom)) {
        $dir = opendir($dir_nom); // on ouvre le contenu du dossier courant
        $fichier = array(); // on déclare le tableau contenant le nom des fichiers
        $dossier = array();
        $arrayExtension = array();
        while ($element = readdir($dir)) {
            if ($element != '.' && $element != '..') {
                if (!is_dir($dir_nom . $element)) {
                    $name = basename($dir_nom . $element);
                    $debut = substr($name, 0, 3);
                    if ($debut == 'Rap') {
                        $fichier['rapport'][] = $element;
                        arsort($fichier['rapport']);
                    } elseif ($debut == 'bon') {
                        $fichier['bon'][] = $element; // N'est normalement jamais utilisé ici
                    } else {
                        $fichier['autre'][] = $element;
                    }
                } else {
                    $dossier[] = $element;
                }
            }
        }

        function sortDoc($a, $b) {
            global $idFoyer;
            global $idIndividu;
            $dir_nom = './document/' . $_POST['idFoyer'] . '/' . $_POST['idIndividu'] . '/';
            $sc = filemtime($dir_nom . $a);
            $sc2 = filemtime($dir_nom . $b);
            if ($sc > $sc2) {
                return -1;
            }
            return 1;
        }

        if (isset($fichier['autre'])) {
            usort($fichier['autre'], 'sortDoc');
        }
        while ($tab = current($dossier)) { // On parcourt les sous repertoires
            $sousDir = opendir($dir_nom . $tab);
            while ($dos = readdir($sousDir)) {
                if ($dos != '.' && $dos != '..') {
                    if (!is_dir($dir_nom . $tab . '/' . $dos)) {
                        $name = basename($dir_nom . $tab . '/' . $dos);
                        $debut = substr($name, 0, 3);
                        if ($debut == 'bon' || $debut == 'Man') {
                            $fichier['bon'][] = '/' . $tab . '/' . $dos;
                        }
                    }
                }
            }
            next($dossier);
        }
        closedir($dir);

        function sortBon($a, $b) {
            $sc = explode('_', $a);
            $sc2 = explode('_', $b);
            if ($sc[1] > $sc2[1]) {
                return -1;
            }
            return 1;
        }

        if (isset($fichier['bon'])) {
            usort($fichier['bon'], 'sortBon');
        }
        $contenu = '
            <h3>Rapport social</h3>
                <div class="bubble tableau_classique_wrapper">
                    <table class="tableau_classique" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="header">
                                <th>Nom document</th>
                                <th>Type fichier</th>
                                <th>Date derniére modification</th>
                                <th>Télécharger</th>
                            </tr>
                        </thead>
                        <tbody>';
        if (!empty($fichier['rapport'])) {
            foreach ($fichier['rapport'] as $file) {
                $extension = pathinfo($dir_nom . $file, PATHINFO_EXTENSION);

                $contenu .= '<tr name="' . $file . '">';
                $contenu .= '<td>' . $file . '</td>
                             <td>'.getNameExtension($extension).'</td>
                             <td> ' . getDatebyTimestamp(filemtime($dir_nom . $file)) . '</td>
                             <td>';
                if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_TELECHARGER_DOC_IND)) {
                    $contenu .= '<a href="' . $dir_nom . $file . '" target=_blank class="open_doc"></a>';
                }
                $contenu .= '</td>
                            </tr>';
            }
        } else {
            $contenu .= '<tr>
                             <td colspan=9 align=center>< Aucun rapport social n\'a été crée pour cet individu > </td>
                         </tr>';
        }

        $contenu .= '</tbody></table></div>';

        // BON AIDE
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_ACCES_DOC_REMIS)) {
            $contenu .= '
                <h3>Bon Alimentaire / Mandat</h3>
                    <div class="bubble tableau_classique_wrapper">
                        <table class="tableau_classique" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr class="header">
                                    <th>Nom document</th>
                                    <th>Type fichier</th>
                                    <th>Date derniére modification</th>
                                    <th>Télécharger</th>
                                </tr>
                            </thead>
                            <tbody>';
            if (!empty($fichier['bon'])) {
                foreach ($fichier['bon'] as $file) {
                    $extension = pathinfo($dir_nom . '/' . $file, PATHINFO_EXTENSION);

                    $contenu .= '<tr name="' . $file . '">';
                    $contenu .= '<td>' . basename($file) . '</td>
                                 <td>'.getNameExtension($extension).'</td>
                                 <td> ' . getDatebyTimestamp(filemtime($dir_nom . $file)) . '</td>
                                 <td>';
                    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_TELECHARGER_DOC_IND)) {
                        $contenu .= '<a href="' . $dir_nom . $file . '" target=_blank class="open_doc"></a>';
                    }
                    $contenu .= '</td>
                                        </tr>';
                }
            } else {
                $contenu .= '<tr>
                                 <td colspan=9 align=center>< Aucun bon d\'aide n\'a été crée pour cet individu > </td>
                             </tr>';
            }

            $contenu .= '</tbody></table></div>';
        }
        // AUTRES DOCS
        $contenu .= '
            <h3>Autre Document ';
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_AJOUT_DOC_IND)) {
            $contenu .= '<span class="addElem" role="ajout_doc"></span>';
        }
            $contenu .= '</h3>
                <div class="bubble tableau_classique_wrapper">
                    <table class="tableau_classique" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="header">
                                <th>Nom document</th>
                                <th>Type fichier</th>
                                <th>Date derniére modification</th>
                                <th>Télécharger</th>
                            </tr>
                        </thead>
                        <tbody>';
        if (!empty($fichier['autre'])) {
            foreach ($fichier['autre'] as $file) {
                $extension = pathinfo($dir_nom . $file, PATHINFO_EXTENSION);

                $contenu .= '<tr name="' . $file . '">';
                $contenu .= '<td>' . $file . '</td>
                             <td>'.getNameExtension($extension).'</td>
                             <td> ' . getDatebyTimestamp(filemtime($dir_nom . $file)) . '</td>
                             <td>';
                if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_TELECHARGER_DOC_IND)) {
                    $contenu .= '<a href="' . $dir_nom . $file . '" target=_blank class="open_doc"></a>';
                }
                    $contenu .= '</td>
                            </tr>';
            }
        } else {
            $contenu .= '<tr>
                             <td colspan=4 align=center>< Aucun autre document n\'a été crée pour cet individu > </td>
                         </tr>';
        }

        $contenu .= '</tbody></table>';
        $contenu .= '
        <div class="formulaire" action="ajout_doc">
        <form action="#" method="post">
            <h2>Ajouter un document</h2>
            <div class="colonne_droite">
                <div id="upload">
                    <label>Fichier : </label><input name="fichier" type="file" placeholder="test"><br>
                    <input type="hidden" name="chemin" value="' . $dir_nom . '">
                    <input type="hidden" name="idIndividu" value="' . $_POST['idIndividu'] . '">
                    <input type="hidden" name="idFoyer" value="' . $_POST['idFoyer'] . '">
                </div>
            </div>
            <div class="sauvegarder_annuler">
                <div value="ajout_doc_type" class="bouton modif">
                    <i class="icon-save"></i>
                    <span>Envoyer</span>
                </div>
                 <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                    </div>
        </form>
        </div>
        </div>';
        return $contenu;
    } else {
        $contenu = '
            <h3>Autre Document ';
        if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_AJOUT_DOC_IND)) {
            $contenu .= '<span class="addElem" role="ajout_doc"></span>';
        }
            $contenu .= '</h3>
                <div class="bubble tableau_classique_wrapper">
                    <table class="tableau_classique" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="header">
                                <th>Nom document</th>
                                <th>Type fichier</th>
                                <th>Date derniére modification</th>
                                <th>Télécharger</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>';
$contenu .= '<div class="formulaire" action="ajout_doc">
        <form action="#" method="post">
            <h2>Ajouter un document</h2>
            <div class="colonne_droite">
                <div id="upload">
                    <label>Fichier : </label><input name="fichier" type="file" placeholder="test"><br>
                    <input type="hidden" name="chemin" value="' . $dir_nom . '">
                    <input type="hidden" name="idIndividu" value="' . $_POST['idIndividu'] . '">
                    <input type="hidden" name="idFoyer" value="' . $_POST['idFoyer'] . '">
                </div>
            </div>
            <div class="sauvegarder_annuler">
                <div value="ajout_doc_type" class="bouton modif">
                    <i class="icon-save"></i>
                    <span>Envoyer</span>
                </div>
                 <div value="cancel" class="bouton classique">
                        <i class="icon-cancel icon-black"></i>
                        <span>Annuler</span>
                    </div>
        </form>
        </div>';
            return $contenu;
    }
}

function getDocument() {
    include_once('./lib/config.php');
    $dir_nom = './document/';
    if (file_exists($dir_nom)) {
        $dir = opendir($dir_nom); // on ouvre le contenu du dossier courant
        $fichier = array(); // on déclare le tableau contenant le nom des fichiers
        $arrayExtension = array();
        while ($element = readdir($dir)) {
            if ($element != '.' && $element != '..') {
                if (!is_dir($dir_nom . '/' . $element)) {
                    $fichier[] = $element;
                }
            }
        }
    }

    function sortDoc($a, $b) {
        $sc = filemtime('./document/' . $a);
        $sc2 = filemtime('./document/' . $b);
        if ($sc > $sc2) {
            return -1;
        }
        return 1;
    }

    if (isset($fichier)) {
        usort($fichier, 'sortDoc');
    }
    $contenu = '';
    $contenu .= '
            <h3>Documents Types';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_AJOUT_DOCUMENT)) {
        $contenu .= '<span class="addElem" role="ajout_doc_type" original-title="Ajouter un document type"></span>';
    }
        $contenu .= '</h3>
                <div class="bubble tableau_classique_wrapper">
                    <table class="tableau_classique" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="header">
                                <th>Nom document</th>
                                <th>Type fichier</th>
                                <th>Date derniére modification</th>
                                <th>Télécharger/Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>';
    if (!empty($fichier)) {
        foreach ($fichier as $file) {
            $extension = pathinfo($dir_nom . '/' . $file, PATHINFO_EXTENSION);
            $contenu .= '<tr name="' . $file . '">';
            $contenu .= '<td>' . basename($file) . '</td>
                             <td>'.getNameExtension($extension).'</td>
                             <td> ' . getDatebyTimestamp(filemtime($dir_nom . '/' . $file)) . '</td>
                             <td>';
    if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_TELECHARGEMENT_DOCUMENT)) {
        $contenu .= '<a href="' . $dir_nom . $file . '" target=_blank class="open_doc"></a>';
    }
     if(Droit::isAcces($_SESSION['permissions'], Droit::$DROIT_SUPPRESSION_DOCUMENT)) {
        $contenu .= '<a name="' . $dir_nom . $file . '" target=_blank class="delete_doc"></a>';
    }
        $contenu .= '</td>
                            </tr>';
        }
    } else {
        $contenu .= '<tr>
                             <td colspan=9 align=center>< Aucun document type n\'a été publié > </td>
                         </tr>';
    }
    $contenu .= '</tbody></table>';
    $contenu .= '
        <div class="formulaire" action="ajout_doc_type">
        <form action="#" method="post">
            <div id="upload">
                <label>Fichier : </label><input name="fichier" type="file"><br>
                <input type="hidden" name="chemin" value="' . $dir_nom . '">
            </div>
            <div value="ajout_doc_type" class="bouton modif">
                <i class="icon-save"></i>
                <span>Enregistrer</span>
            </div>
        </form>
        </div>';
    echo $contenu;
}

//function getDocument() {
//    $contenu = '
//        
//        <div id="document"> 
//            <div class="container">
//    
//                <br>
//                <!-- The file upload form used as target for the file upload widget -->
//                <form id="fileupload" action="document/" method="POST" enctype="multipart/form-data">
//                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
//                    <div class="row fileupload-buttonbar">
//                        <div class="span7">
//                            <!-- The fileinput-button span is used to style the file input field as button -->
//                            <span class="btn btn-success fileinput-button">
//                                <i class="icon-plus icon-white"></i>
//                                <span>Ajouter un fichier</span>
//                                <input type="file" name="files[]" multiple>
//                            </span>
//                            <button type="submit" class="btn btn-primary start">
//                                <i class="icon-upload icon-white"></i>
//                                <span>Envoyer le fichier</span>
//                            </button>
//                            <button type="reset" class="btn btn-warning cancel">
//                                <i class="icon-ban-circle icon-white"></i>
//                                <span>Annuler l\'envois</span>
//                            </button>
//                            <button type="button" class="btn btn-danger delete">
//                                <i class="icon-trash icon-white"></i>
//                                <span>Supprimer</span>
//                            </button>
//                            <input type="checkbox" class="toggle">
//                        </div>
//                        <div class="span5">
//                            <!-- The global progress bar -->
//                            <div class="progress progress-success progress-striped active fade">
//                                <div class="bar" style="width:0%;"></div>
//                            </div>
//                        </div>
//                    </div>
//                    <!-- The loading indicator is shown during image processing -->
//                    <div class="fileupload-loading"></div>
//                    <br>
//                    <!-- The table listing the files available for upload/download -->
//                    <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
//                </form>
//                <br>
//    
//            </div>
//            
//            <!-- modal-gallery is the modal dialog used for the image gallery -->
//            <div id="modal-gallery" class="modal modal-gallery hide fade">
//                <div class="modal-header">
//                    <a class="close" data-dismiss="modal">&times;</a>
//                    <h4 class="modal-title"></h4>
//                </div>
//                <div class="modal-body"><div class="modal-image"></div></div>
//                <div class="modal-footer">
//                    <a class="btn modal-download" target="_blank">
//                        <i class="icon-download"></i>
//                        <span>Télécharger</span>
//                    </a>
//                    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
//                        <i class="icon-play icon-white"></i>
//                        <span>Slideshow</span>
//                    </a>
//                    <a class="btn btn-info modal-prev">
//                        <i class="icon-arrow-left icon-white"></i>
//                        <span>Previous</span>
//                    </a>
//                    <a class="btn btn-primary modal-next">
//                        <span>Next</span>
//                        <i class="icon-arrow-right icon-white"></i>
//                    </a>
//                </div>
//            </div>
//
//            <!-- The template to display files available for upload -->
//            <script id="template-upload" type="text/x-tmpl">
//            {% for (var i=0, file; file=o.files[i]; i++) { %}
//                <tr class="template-upload fade">
//                    <td class="preview"><span class="fade"></span></td>
//                    <td class="name"><span>{%=file.name%}</span></td>
//                    <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
//                    {% if (file.error) { %}
//                        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
//                    {% } else if (o.files.valid && !i) { %}
//                        <td>
//                            <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
//                        </td>
//                        <td class="start">{% if (!o.options.autoUpload) { %}
//                            <button class="btn btn-primary">
//                                <i class="icon-upload icon-white"></i>
//                                <span>{%=locale.fileupload.start%}</span>
//                            </button>
//                        {% } %}</td>
//                    {% } else { %}
//                        <td colspan="2"></td>
//                    {% } %}
//                    <td class="cancel">{% if (!i) { %}
//                        <button class="btn btn-warning">
//                            <i class="icon-ban-circle icon-white"></i>
//                            <span>{%=locale.fileupload.cancel%}</span>
//                        </button>
//                    {% } %}</td>
//                </tr>
//            {% } %}
//            </script>
//            
//            <!-- The template to display files available for download -->
//            <script id="template-download" type="text/x-tmpl">
//            {% for (var i=0, file; file=o.files[i]; i++) { %}
//                <tr class="template-download fade">
//                    {% if (file.error) { %}
//                        <td></td>
//                        <td class="name"><span>{%=file.name%}</span></td>
//                        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
//                        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
//                    {% } else { %}
//                        <td class="preview">{% if (file.thumbnail_url) { %}
//                            <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
//                        {% } %}</td>
//                        <td class="name">
//                            <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&"gallery"%}" download="{%=file.name%}">{%=file.name%}</a>
//                        </td>
//                        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
//                        <td colspan="2"></td>
//                    {% } %}
//                    <td class="delete">
//                        <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
//                            <i class="icon-trash icon-white"></i>
//                            <span>{%=locale.fileupload.destroy%}</span>
//                        </button>
//                        <input type="checkbox" name="delete" value="1">
//                    </td>
//                </tr>
//            {% } %}
//            </script>
//            <!-- The localization script -->
//            <script src="./js/jsUpload/locale.js"></script>
//            <!-- The main application script -->
//            <script src="./js/jsUpload/main.js"></script>
//        </div>';
//    echo $contenu;
//}
function getNameExtension($ext) {
    $contenu = '';
    switch ($ext) {
        case "doc":
        case "docx":
            $contenu = 'Microsoft word';
            break;
        case "xls":
        case "xlsx":
            $contenu = 'Microsoft excel';
            break;
        case "pdf":
            $contenu = 'Document PDF';
            break;
        case "jpeg":
        case "png":
        case "jpg":
        case "gif":
            $contenu = 'Image';
            break;
    }
    return $contenu;
}

function destroyFile($path) {
    if(file_exists($path)) {
        unlink($path);
    }
    $doc = getDocument();
    echo $doc;
}

?>
