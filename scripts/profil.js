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

    // Disable all input fields by default
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

    // Enable all disabled fields before submitting the form
    document.querySelector('.change-profil').addEventListener('submit', (event) => {
        const disabledFields = document.querySelectorAll('input:disabled, select:disabled, textarea:disabled');
        disabledFields.forEach(field => field.disabled = false);
    });
});