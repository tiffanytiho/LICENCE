let currentStep = 1;
const totalSteps = 3;

function showStep(step) {
    const steps = document.querySelectorAll('.formbold-form-step');
    const stepMenus = document.querySelectorAll('.formbold-steps li');
    const submitButton = document.querySelector('.formbold-submit-btn');
    const nextButton = document.querySelector('.formbold-next-btn');

    steps.forEach((el, index) => {
        el.classList.toggle('active', index + 1 === step);
    });
    stepMenus.forEach((el, index) => {
        el.classList.toggle('active', index + 1 === step);
    });

    if (step === totalSteps) {
        submitButton.style.display = 'inline-block';  // Afficher le bouton Soumettre à la dernière étape
        nextButton.style.display = 'none';  // Masquer le bouton Suivant à la dernière étape
    } else {
        submitButton.style.display = 'none';  // Masquer le bouton Soumettre aux autres étapes
        nextButton.style.display = 'inline-block';  // Afficher le bouton Suivant sur les autres étapes
    }
}

function validateStep(step) {
    const inputs = document.querySelectorAll(`.formbold-form-step-${step} .formbold-form-input`);
    let valid = true;

    inputs.forEach(input => {
        if (input.type === 'file') {
            // Vérifie si un fichier est sélectionné
            if (input.files.length === 0) {
                alert('Veuillez télécharger tous les fichiers requis.');
                valid = false;
            }
        } else if (!input.value.trim()) {  // Vérifie les champs texte
            alert('Veuillez remplir tous les champs.');
            valid = false;
        }
    });

    return valid;
}

function updateDureeStage() {
    const typeStage = document.getElementById("idTypestage").value;
    const dureestageSelect = document.getElementById("dureestage");
    dureestageSelect.options.length = 0; // Supprimer toutes les options existantes

    if (typeStage === "1") { // Stage de validation de Diplôme
        dureestageSelect.add(new Option("3 mois", "3"));
        dureestageSelect.value = "3"; // Définir la valeur par défaut à 3 mois
    } else if (typeStage === "2") { // Stage de Perfectionnement
        dureestageSelect.add(new Option("6 mois", "6"));
        dureestageSelect.value = "6"; // Définir la valeur par défaut à 6 mois
    }

    // Optionnel : Calculer et afficher la date de fin de stage
    const debutStage = document.getElementById("debutstage").value;
    const duree = dureestageSelect.value;
    if (debutStage && duree) {
        const dateFinStage = new Date(debutStage);
        dateFinStage.setMonth(dateFinStage.getMonth() + parseInt(duree));
        document.getElementById("finstage").value = dateFinStage.toISOString().split('T')[0];
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

// Initialize the first step
showStep(currentStep);

// Update the duration field when the type of stage is selected
document.getElementById("idTypestage").addEventListener("change", updateDureeStage);

// Update the end date when the start date is changed
document.getElementById("debutstage").addEventListener("change", updateDureeStage);
