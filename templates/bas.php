        
        <div class="formulaire" action="creation_foyer">
            <h2>Foyer</h2>
            <div class="colonne_droite">
<!--                <select name="civilite" placeholder="Civilite">
                    <option value="1">Madame</option>
                    <option value="2">Monsieur</option>
                </select>-->
                <div class="select classique" role="select_civilite">
                    <div id="form_1" class="option">Madame</div>
                    <div class="fleche_bas"> </div>
                </div>
                <div class="input_text">
                    <input id="form_2" class="contour_field" type="text" title="Nom" placeholder="Nom">
                </div>
                <div class="input_text">
                    <input id="form_3" class="contour_field" type="text" title="Pr&#233;nom" placeholder="Pr&#233;nom">
                </div>
                <div class="sauvegarder_annuler">
                    <div class="bouton modif" value="save">Enregistrer</div>
                    <div class="bouton classique" value="cancel">Annuler</div>
                </div>
            </div>
        </div>
        <ul class="select_civilite">
            <li value="0">
                <div>Madame</div>
            </li>
            <li value="1">
                <div>Monsieur</div>
            </li>
        </ul>
        <div id="ecran_gris"></div>
        <script type="text/javascript" src="./js/jquery.js"></script>
        <script type="text/javascript" src="./js/navigationbar.js"></script>
        <script type="text/javascript" src="./js/search.js"></script>
        <script type="text/javascript" src="./js/jquery.tipsy.js"></script>
        <script type="text/javascript" src="./js/form.js"></script>
    </body>
</html>