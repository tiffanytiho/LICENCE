let currentStep = 1;

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

            if (step === 3) {
                submitButton.style.display = 'inline-block';  // Afficher le bouton Soumettre à la troisième étape
                nextButton.style.display = 'none';  // Masquer le bouton suivant à la troisième étape
            } else {
                submitButton.style.display = 'none';  // Masquer le bouton Soumettre aux autres étapes
                nextButton.style.display = 'inline-block';  // Afficher le bouton suivant sur les autres étapes
            }
        }

        function validateStep(step) {
            const inputs = document.querySelectorAll(`.formbold-form-step-${step} .formbold-form-input`);
            for (let input of inputs) {
                if (input.type === 'file') {
                    // Vérifie si un fichier est sélectionné
                    if (input.files.length === 0) {
                        alert('Veuillez télécharger tous les fichiers requis.');
                        return false;
                    }
                } else if (!input.value.trim()) {  // Vérifie les champs texte
                    alert('Veuillez remplir tous les champs.');
                    return false;
                }
            }
            return true;
        }

        function updateDureeStage() {
            const libelstage = document.getElementById('libelstage').value;
            const dureestage = document.getElementById('dureestage');

            // Réinitialiser le champ de durée
            dureestage.disabled = false;  // Assurez-vous que le champ est activé au départ

            // Mettre à jour la durée en fonction du type de stage sélectionné
            if (libelstage === 'stage1') {
                dureestage.value = '3'; // 03 mois
                dureestage.disabled = true;  // Griser le champ après la sélection
            } else if (libelstage === 'stage2') {
                dureestage.value = '6'; // 06 mois
                dureestage.disabled = true;  // Griser le champ après la sélection
            }else{
              dureestage.value = '';  // Réinitialiser si aucun choix correspondant
              dureestage.disabled = false;  // Rendre le champ actif si le choix est supprimé
            }
        }

        const dureestage = document.getElementById('dureestage').value;
        console.log(dureestage); // Affiche la valeur sélectionnée comme "3" ou "6"

        function nextStep() {
            if(validateStep(currentStep)) {
                if (currentStep < 3) {
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