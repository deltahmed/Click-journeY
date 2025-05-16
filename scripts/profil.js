document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.mod-b');
    const saveButtons = document.querySelectorAll('.save-btn');
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.id = 'submit-changes';
    submitButton.textContent = 'Soumettre';
    submitButton.style.display = 'none';
    document.querySelector('.change-profil').appendChild(submitButton);

    let originalValues = {};

    const inputFields = document.querySelectorAll('input, select, textarea');
    inputFields.forEach(field => {
        field.disabled = true;
    });

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const inputField = document.getElementById(targetId);
            const saveButton = document.querySelector(`.save-btn[data-target="${targetId}"]`);
            const cancelButton = document.querySelector(`.cancel-btn[data-target="${targetId}"]`);

            originalValues[targetId] = inputField.value;

            inputField.disabled = false;
            button.style.display = 'none';
            saveButton.style.display = 'flex';
            cancelButton.style.display = 'flex';
        });
    });

    saveButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const inputField = document.getElementById(targetId);
            const editButton = document.querySelector(`.mod-b[data-target="${targetId}"]`);
            const cancelButton = document.querySelector(`.cancel-btn[data-target="${targetId}"]`);

            inputField.disabled = true;
            button.style.display = 'none';
            cancelButton.style.display = 'none';
            editButton.style.display = 'flex';

            submitButton.style.display = 'flex';
        });
    });

    cancelButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const inputField = document.getElementById(targetId);
            const editButton = document.querySelector(`.mod-b[data-target="${targetId}"]`);
            const saveButton = document.querySelector(`.save-btn[data-target="${targetId}"]`);

            inputField.value = originalValues[targetId];

            inputField.disabled = true;
            button.style.display = 'none';
            saveButton.style.display = 'none';
            editButton.style.display = 'flex';

            if (!Object.values(originalValues).some((value, id) => document.getElementById(id).value !== value)) {
                submitButton.style.display = 'none';
            }
        });
    });

    document.querySelector('.change-profil').addEventListener('submit', async (event) => {
        event.preventDefault();

        // Réactive tous les champs pour la soumission
        const disabledFields = document.querySelectorAll('input:disabled, select:disabled, textarea:disabled');
        disabledFields.forEach(field => field.disabled = false);

        const form = event.target;
        const formData = new FormData(form);

        // Affiche un message de chargement
        let msg = document.getElementById('profil-msg');
        if (!msg) {
            msg = document.createElement('div');
            msg.id = 'profil-msg';
            msg.style.margin = '10px 0';
            form.prepend(msg);
        }
        msg.textContent = "Mise à jour en cours...";

        try {
            const response = await fetch('controllers/update_profil.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                msg.style.color = 'green';
                msg.textContent = result.message;
                // Met à jour les valeurs originales
                inputFields.forEach(field => {
                    originalValues[field.id] = field.value;
                    field.disabled = true;
                });
                // Cache tous les boutons save/cancel, remet les boutons modifier
                saveButtons.forEach(btn => btn.style.display = 'none');
                cancelButtons.forEach(btn => btn.style.display = 'none');
                editButtons.forEach(btn => btn.style.display = 'flex');
                submitButton.style.display = 'none';
            } else {
                msg.style.color = 'red';
                msg.textContent = result.message;
                // Restaure les anciennes valeurs
                inputFields.forEach(field => {
                    if (originalValues[field.id] !== undefined) {
                        field.value = originalValues[field.id];
                    }
                    field.disabled = true;
                });
                saveButtons.forEach(btn => btn.style.display = 'none');
                cancelButtons.forEach(btn => btn.style.display = 'none');
                editButtons.forEach(btn => btn.style.display = 'flex');
                submitButton.style.display = 'none';
            }
        } catch (e) {
            msg.style.color = 'red';
            msg.textContent = "Erreur de communication avec le serveur.";
        }
    });



    inputFields.forEach(field => {
        field.disabled = true;
    });

});