<?php

function getDocumentIndividu() {
    
    $dir_nom = './document/'.$_POST['idIndividu'];
    $dir = opendir($dir_nom) or die('Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
    $fichier= array(); // on déclare le tableau contenant le nom des fichiers
    $arrayExtension = array();
    while($element = readdir($dir)) {
            if($element != '.' && $element != '..') {
                    if (!is_dir($dir_nom.'/'.$element)) {$fichier[] = $element;}
            }
    }

    closedir($dir);
    
    
    $contenu = '
        <h3>Documents :</h3>
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
    if(!empty($fichier)) {
        $i = 1;
        foreach($fichier as $file) {
            $extension = pathinfo($dir_nom.'/'.$file, PATHINFO_EXTENSION);

            $i % 2 ? $contenu .= '<tr name="'.$file.'">' : $contenu .= '<tr class="alt" name="'.$file.'">';
            $contenu .= '<td>'.$file.'</td>
                         <td> ';
            switch ($extension) {
                case "doc":
                case "docx":
                    $contenu .= 'Microsoft word';
                    break;
                case "xls":
                case "xlsx":
                    $contenu .= 'Microsoft excel';
                    break;
                case "pdf":
                    echo "pdf";
                    break;
            }
         $contenu .=    '</td>
                         <td> '.getDatebyTimestamp(filemtime($dir_nom.'/'.$file)).'</td>
                         <td><span class="open_doc"></span></td>
                        </tr>';
            $i++;
        }
    } else {
        $contenu .= '<tr>
                         <td colspan=9 align=center>< Aucune document n\'a été attribué à cet individu > </td>
                     </tr>';
    }

    $contenu .= '</tbody></table>';

    return utf8_encode($contenu);
}


function getDocument() {
    $contenu = '
        
        <div id="document"> 
            <div class="container">
    
                <br>
                <!-- The file upload form used as target for the file upload widget -->
                <form id="fileupload" action="document/" method="POST" enctype="multipart/form-data">
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="row fileupload-buttonbar">
                        <div class="span7">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-success fileinput-button">
                                <i class="icon-plus icon-white"></i>
                                <span>Add files...</span>
                                <input type="file" name="files[]" multiple>
                            </span>
                            <button type="submit" class="btn btn-primary start">
                                <i class="icon-upload icon-white"></i>
                                <span>Start upload</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel">
                                <i class="icon-ban-circle icon-white"></i>
                                <span>Cancel upload</span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                                <i class="icon-trash icon-white"></i>
                                <span>Delete</span>
                            </button>
                            <input type="checkbox" class="toggle">
                        </div>
                        <div class="span5">
                            <!-- The global progress bar -->
                            <div class="progress progress-success progress-striped active fade">
                                <div class="bar" style="width:0%;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- The loading indicator is shown during image processing -->
                    <div class="fileupload-loading"></div>
                    <br>
                    <!-- The table listing the files available for upload/download -->
                    <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
                </form>
                <br>
    
            </div>
            
            <!-- modal-gallery is the modal dialog used for the image gallery -->
            <div id="modal-gallery" class="modal modal-gallery hide fade">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">&times;</a>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"><div class="modal-image"></div></div>
                <div class="modal-footer">
                    <a class="btn modal-download" target="_blank">
                        <i class="icon-download"></i>
                        <span>Download</span>
                    </a>
                    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
                        <i class="icon-play icon-white"></i>
                        <span>Slideshow</span>
                    </a>
                    <a class="btn btn-info modal-prev">
                        <i class="icon-arrow-left icon-white"></i>
                        <span>Previous</span>
                    </a>
                    <a class="btn btn-primary modal-next">
                        <span>Next</span>
                        <i class="icon-arrow-right icon-white"></i>
                    </a>
                </div>
            </div>

            <!-- The template to display files available for upload -->
            <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-upload fade">
                    <td class="preview"><span class="fade"></span></td>
                    <td class="name"><span>{%=file.name%}</span></td>
                    <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                    {% if (file.error) { %}
                        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
                    {% } else if (o.files.valid && !i) { %}
                        <td>
                            <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
                        </td>
                        <td class="start">{% if (!o.options.autoUpload) { %}
                            <button class="btn btn-primary">
                                <i class="icon-upload icon-white"></i>
                                <span>{%=locale.fileupload.start%}</span>
                            </button>
                        {% } %}</td>
                    {% } else { %}
                        <td colspan="2"></td>
                    {% } %}
                    <td class="cancel">{% if (!i) { %}
                        <button class="btn btn-warning">
                            <i class="icon-ban-circle icon-white"></i>
                            <span>{%=locale.fileupload.cancel%}</span>
                        </button>
                    {% } %}</td>
                </tr>
            {% } %}
            </script>
            
            <!-- The template to display files available for download -->
            <script id="template-download" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
                <tr class="template-download fade">
                    {% if (file.error) { %}
                        <td></td>
                        <td class="name"><span>{%=file.name%}</span></td>
                        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                        <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
                    {% } else { %}
                        <td class="preview">{% if (file.thumbnail_url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
                        {% } %}</td>
                        <td class="name">
                            <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&"gallery"%}" download="{%=file.name%}">{%=file.name%}</a>
                        </td>
                        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                        <td colspan="2"></td>
                    {% } %}
                    <td class="delete">
                        <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                            <i class="icon-trash icon-white"></i>
                            <span>{%=locale.fileupload.destroy%}</span>
                        </button>
                        <input type="checkbox" name="delete" value="1">
                    </td>
                </tr>
            {% } %}
            </script>
            <!-- The localization script -->
            <script src="./js/jsUpload/locale.js"></script>
            <!-- The main application script -->
            <script src="./js/jsUpload/main.js"></script>
        </div>';
    echo $contenu;
}
?>
