<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Demande de stage INP-HB </title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="formbold-main-wrapper">
        <div class="formbold-form-wrapper">
            <form action="process_form.php" method="POST" enctype="multipart/form-data">
                <div class="formbold-steps">
                    <ul>
                        <li class="formbold-step-menu1 active">
                            <span>1</span>
                            Informations Personnelles
                        </li>
                        <li class="formbold-step-menu2">
                            <span>2</span>
                            Informations sur le stage
                        </li>
                        <li class="formbold-step-menu3">
                            <span>3</span>
                            Documents
                        </li>
                    </ul>
                </div>

                <div class="formbold-form-step formbold-form-step-1 active">
                    <div class="formbold-input-flex">
                        <div>
                            <label for="nomDemandeur" class="formbold-form-label">Nom</label>
                            <input type="text" name="nomDemandeur" id="nomDemandeur" class="formbold-form-input" />
                        </div>
                        <div>
                            <label for="prenomsDemandeur" class="formbold-form-label">Prénoms</label>
                            <input type="text" name="prenomsDemandeur" id="prenomsDemandeur" class="formbold-form-input" />
                        </div>
                    </div>

                    <div class="formbold-input-flex">
                        <div>
                            <label for="genre" class="formbold-form-label">Genre</label>
                            <select name="genre" id="genre" class="formbold-form-input">
                              <option value="">  </option>
                              <option value="F"> Féminin </option>
                              <option value="M"> Masculin </option>
                            </select>
                        </div>
                        <div>
                            <label for="emailDemandeur" class="formbold-form-label">Email</label>
                            <input type="email" name="emailDemandeur" id="emailDemandeur" class="formbold-form-input" />
                        </div>
                    </div>

                    <div class="formbold-input-flex">
                        <div>
                            <label for="dateNaissance" class="formbold-form-label">Date de Naissance</label>
                            <input type="date" name="dateNaissance" id="dateNaissance" class="formbold-form-input"
                                placeholder="JJ-MM-AAAA" 
                                pattern="\d{2}-\d{2}-\d{4}" 
                                title="Veuillez entrer la date au format JJ-MM-AAAA. Exemple : 01-01-2024." />
                        </div>
                        <div>
                            <label for="lieuNaissance" class="formbold-form-label">Lieu de Naissance</label>
                            <input type="text" name="lieuNaissance" id="lieuNaissance" class="formbold-form-input" />
                        </div>
                    </div>

                    <div class="formbold-input-flex">
                        <div>
                            <label for="nationaliteDemandeur" class="formbold-form-label">Nationalité</label>
                            <input type="text" name="nationaliteDemandeur" id="nationaliteDemandeur" class="formbold-form-input" />
                        </div>
                        <div>
                          <label for="numeropiece" class="formbold-form-label">Numéro de Pièce</label>
                          <input type="text" name="numeropiece" id="numeropiece" class="formbold-form-input" />
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step formbold-form-step-2">
                  <div class="formbold-input-flex">
                          <div>
                              <label for="libelstage" class="formbold-form-label">Type de stage demandé</label>
                              <select name="libelstage" id="libelstage" class="formbold-form-input" onchange="updateDureeStage()">
                                <option value="">  </option>
                                <option value="stage1"> Stage de validation de Diplôme </option>
                                <option value="stage2"> Stage de Perfectionnement </option>
                              </select>
                          </div>
                          <div>
                              <label for="dureestage" class="formbold-form-label">Durée du Stage</label>
                              <select name="dureestage" id="dureestage" class="formbold-form-input">
                                <option value="">  </option>
                                <option name="dureestage" value="3">03 mois</option>
                                <option name="dureestage" value="6">06 mois</option>
                              </select>
                          </div>
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="debutstage" class="formbold-form-label">Début de Stage</label>
                            <input type="date" name="debutstage" id="debutstage" class="formbold-form-input" />
                        </div>
                        <div>
                            <label for="finstage" class="formbold-form-label">Fin de Stage</label>
                            <input type="date" name="finstage" id="finstage" class="formbold-form-input" 
                                placeholder="JJ-MM-AAAA" 
                                pattern="\d{2}-\d{2}-\d{4}" 
                                title="Veuillez entrer la date au format JJ-MM-AAAA. Exemple : 01-01-2024." />
                        </div>
                    </div>
                        <label for="telephone" class="formbold-form-label">Téléphone</label>
                        <input type="tel" name="telephone" id="telephone" class="formbold-form-input" 
                            pattern="\+225[0-9]{10}" 
                            placeholder="+2251234567890" 
                            title="Veuillez entrer un numéro de téléphone valide avec l'indicatif du pays (+225) suivi de 10 chiffres. Exemple : +2251234567890" 
                            required>
                    <div>
                        <label for="dateDemande" class="formbold-form-label">Date de Demande</label>
                        <input type="date" name="dateDemande" id="dateDemande" class="formbold-form-input" 
                            placeholder="JJ-MM-AAAA" 
                            pattern="\d{2}-\d{2}-\d{4}" 
                            title="Veuillez entrer la date au format JJ-MM-AAAA. Exemple : 01-01-2024." />
                    </div>
                </div>

                <div class="formbold-form-step formbold-form-step-3">
                    <div>
                        <label for="photo" class="formbold-form-label">Photo</label>
                        <input type="file" name="photo" id="photo" class="formbold-form-input" />
                    </div>
                    <div>
                        <label for="diplomeDemandeur" class="formbold-form-label">Diplôme</label>
                        <input type="file" name="diplomeDemandeur" id="diplomeDemandeur" class="formbold-form-input" />
                    </div>
                    <div>
                        <label for="cvDemandeur" class="formbold-form-label">CV</label>
                        <input type="file" name="cvDemandeur" id="cvDemandeur" class="formbold-form-input" />
                    </div>
                    <div>
                        <label for="cniDemandeur" class="formbold-form-label">CNI</label>
                        <input type="file" name="cniDemandeur" id="cniDemandeur" class="formbold-form-input" />
                    </div>
                    <div>
                        <label for="lettreDemandeur" class="formbold-form-label">Lettre de Demande</label>
                        <input type="file" name="lettreDemandeur" id="lettreDemandeur" class="formbold-form-input" />
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="idSpecialite" class="formbold-form-label">Spécialité</label>
                            <select name="idSpecialite" id="idSpecialite" class="formbold-form-input">
                              <option value="">  </option>
                              <option value="informatique"> Informatique </option>
                              <option value="agronomie"> Agronomie </option>
                              <option value="economie"> Economie & Commerce </option>
                              <option value="mine"> Mines et Géologie </option>
                              <option value="travaux-publics"> Travaux Publics </option>
                            </select>
                        </div>
                        <div>
                            <label for="idNiveau" class="formbold-form-label"> Votre Niveau</label>
                            <select name="idNiveau" id="idNiveau" class="formbold-form-input">
                              <option value="">  </option>
                              <option value="bts"> BTS </option>
                              <option value="licence"> LICENCE </option>
                              <option value="master"> MASTER </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="idEcole" class="formbold-form-label">École d'origine</label>
                        <input type="text" name="idEcole" id="idEcole" class="formbold-form-input" />
                    </div>
                </div>

                <div class="formbold-form-btn-wrapper">
                    <button type="button" class="formbold-back-btn" onclick="prevStep()">Retour</button>
                    <button type="button" class="formbold-btn formbold-next-btn" onclick="nextStep()">Étape Suivante</button>
                    <button type="submit" class="formbold-btn formbold-submit-btn" style="display: none;">Soumettre</button>
                </div>
            </form>
        </div>
    </div>

    <script src="index.js"> </script>

</body>
</html>
