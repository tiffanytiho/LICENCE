<!DOCTYPE html>
<html lang="fr">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de stage INP-HB</title>
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
                            <input type="text" name="nomDemandeur" id="nomDemandeur" class="formbold-form-input" required/>
                        </div>
                        <div>
                            <label for="prenomsDemandeur" class="formbold-form-label">Prénoms</label>
                            <input type="text" name="prenomsDemandeur" id="prenomsDemandeur" class="formbold-form-input" required/>
                        </div>
                    </div>
                    
                    <div class="formbold-input-flex">
                        <div>
                            <label for="genre" class="formbold-form-label">Genre</label>
                            <select name="genre" id="genre" class="formbold-form-input" required>
                              <option value="">Choisissez...</option>
                              <option value="F">Féminin</option>
                              <option value="M">Masculin</option>
                            </select>
                        </div>
                        <div>
                            <label for="emailDemandeur" class="formbold-form-label">Email</label>
                            <input type="email" name="emailDemandeur" id="emailDemandeur" class="formbold-form-input" required/>
                        </div>
                    </div>

                    <div class="formbold-input-flex">
                        <div>
                            <label for="dateNaissance" class="formbold-form-label">Date de Naissance</label>
                            <input type="date" name="dateNaissance" id="dateNaissance" class="formbold-form-input" required/>
                        </div>
                        <div>
                            <label for="lieuNaissance" class="formbold-form-label">Lieu de Naissance</label>
                            <input type="text" name="lieuNaissance" id="lieuNaissance" class="formbold-form-input" required />
                        </div>
                    </div>

                    <div class="formbold-input-flex">
                        <div>
                            <label for="nationaliteDemandeur" class="formbold-form-label">Nationalité</label>
                            <input type="text" name="nationaliteDemandeur" id="nationaliteDemandeur" class="formbold-form-input" required/>
                        </div>
                        <div>
                          <label for="numeropiece" class="formbold-form-label">Numéro de Pièce</label>
                          <input type="text" name="numeropiece" id="numeropiece" class="formbold-form-input" required/>
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step formbold-form-step-2">
                    <div class="formbold-input-flex">
                        <div>
                            <label for="idTypestage" class="formbold-form-label">Type de stage demandé</label>
                            <select name="idTypestage" id="idTypestage" class="formbold-form-input" onchange="updateDureeStage()" required>
                                <option value="">Choisissez...</option>
                                <option value="1">Stage de validation de Diplôme</option>
                                <option value="2">Stage de Perfectionnement</option>
                            </select>
                        </div>
                        <div>
                            <label for="dureestage" class="formbold-form-label">Durée du Stage</label>
                            <select name="dureestage" id="dureestage" class="formbold-form-input" required>
                                <option value="">Choisissez...</option>
                                <option value="3">03 mois</option>
                                <option value="6">06 mois</option>
                            </select>
                        </div>
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="debutstage" class="formbold-form-label">Date à partir de laquelle vous etes disponible </label>
                            <input type="date" name="debutstage" id="debutstage" class="formbold-form-input" required/>
                        </div>
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="telephone" class="formbold-form-label">Téléphone</label>
                            <input type="tel" name="telephone" id="telephone" class="formbold-form-input" 
                                pattern="\+225[0-9]{10}" 
                                placeholder="+2251234567890" 
                                title="Veuillez entrer un numéro de téléphone valide avec l'indicatif du pays (+225) suivi de 10 chiffres. Exemple : +2251234567890" 
                                required>
                        </div>
                        <div>
                            <label for="dateDemande" class="formbold-form-label">Date à laquelle vous demandez le stage</label>
                            <input type="date" name="dateDemande" id="dateDemande" class="formbold-form-input" required/>
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step formbold-form-step-3">
                    <div>
                        <label for="photo" class="formbold-form-label">Photo</label>
                        <input type="file" name="photo" id="photo" class="formbold-form-input" accept=".jpg, .jpeg, .png, .pdf" required/>
                    </div>
                    <div>
                        <label for="diplomeDemandeur" class="formbold-form-label">Diplôme</label>
                        <input type="file" name="diplomeDemandeur" id="diplomeDemandeur" class="formbold-form-input" accept=".jpg, .jpeg, .png, .pdf" required/>
                    </div>
                    <div>
                        <label for="cvDemandeur" class="formbold-form-label">CV</label>
                        <input type="file" name="cvDemandeur" id="cvDemandeur" class="formbold-form-input" accept=".jpg, .jpeg, .png, .pdf" required/>
                    </div>
                    <div>
                        <label for="cniDemandeur" class="formbold-form-label">CNI</label>
                        <input type="file" name="cniDemandeur" id="cniDemandeur" class="formbold-form-input" accept=".jpg, .jpeg, .png, .pdf" required/>
                    </div>
                    <div>
                        <label for="lettreDemandeur" class="formbold-form-label">Lettre de Demande</label>
                        <input type="file" name="lettreDemandeur" id="lettreDemandeur" class="formbold-form-input" accept=".jpg, .jpeg, .png, .pdf" required/>
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="idSpecialite" class="formbold-form-label">Spécialité</label>
                            <select name="idSpecialite" id="idSpecialite" class="formbold-form-input" required>
                                <option value="">Choisissez...</option>
                                <option value="1">Informatique</option>
                                <option value="2">Agronomie</option>
                                <option value="3">Economie & Commerce</option>
                                <option value="4">Mines et Géologie</option>
                                <option value="5">Travaux Publics</option>
                                <option value="6">Comptabilité</option>
                            </select>
                        </div>
                        <div>
                            <label for="idNiveau" class="formbold-form-label">Votre Niveau</label>
                            <select name="idNiveau" id="idNiveau" class="formbold-form-input">
                                <option value="">Choisissez...</option>
                                <option value="1">BTS</option>
                                <option value="2">LICENCE</option>
                                <option value="3">MASTER</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="idEcole" class="formbold-form-label">École d'origine</label>
                        <select name="idEcole" id="idEcole" class="formbold-form-input">
                            <option value="">Choisissez...</option>
                            <option value="1">INP-HB</option>
                            <option value="2">ESETEC</option>
                            <option value="3">PIGIER</option>
                        </select>
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

    <script >
        let currentStep = 1;
        const totalSteps = 3;

        function showStep(step) {
        const steps = document.querySelectorAll('.formbold-form-step');
        const stepMenus = document.querySelectorAll('.formbold-steps li');
        const submitButton = document.querySelector('.formbold-submit-btn');
        const nextButton = document.querySelector('.formbold-next-btn');
        const backButton = document.querySelector('.formbold-back-btn');

        steps.forEach((el, index) => {
            el.classList.toggle('active', index + 1 === step);
        });
        stepMenus.forEach((el, index) => {
            el.classList.toggle('active', index + 1 === step);
        });

        submitButton.style.display = step === totalSteps ? 'inline-block' : 'none';
        nextButton.style.display = step === totalSteps ? 'none' : 'inline-block';
        backButton.style.display = step === 1 ? 'none' : 'inline-block';
        }

        function validateStep(step) {
            const inputs = document.querySelectorAll(`.formbold-form-step-${step} .formbold-form-input`);
            let valid = true;

            inputs.forEach(input => {
                if (input.hasAttribute('required')) {
                    if (input.type === 'file') {
                        if (input.files.length === 0) {
                            alert('Veuillez télécharger tous les fichiers requis.');
                            valid = false;
                        }
                    } else if (!input.value.trim()) {
                        alert('Veuillez remplir tous les champs obligatoires.');
                        valid = false;
                    }
                }
            });

            return valid;
        }

        function updateDureeStage() {
            const typeStage = document.getElementById("idTypestage").value;
            const dureestageSelect = document.getElementById("dureestage");
            dureestageSelect.innerHTML = ''; // Vider les options existantes

            if (typeStage === "1") {
                dureestageSelect.add(new Option("3 mois", "3"));
                dureestageSelect.value = "3";
            } else if (typeStage === "2") {
                dureestageSelect.add(new Option("6 mois", "6"));
                dureestageSelect.value = "6";
            }
        }

        function nextStep() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
        }

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

// Initialiser la première étape
document.addEventListener('DOMContentLoaded', () => {
    showStep(currentStep);
    document.getElementById("idTypestage").addEventListener("change", updateDureeStage);
});
    </script>

</body>
</html>
