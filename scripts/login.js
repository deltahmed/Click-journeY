document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("login-form");

    form.addEventListener("input", (event) => {
        const target = event.target;

        if (target.id === "password") {
            updateCharacterCounter(target);
        }

        validateField(target);
    });

    form.addEventListener("submit", (event) => {
        event.preventDefault(); 
        if (isFormValid(form)) {
            form.submit(); 
        }
    });
});

//valider champ
function validateField(field) {
    const errorMessage = field.nextElementSibling;

    if (field.validity.valueMissing) {
        errorMessage.innerHTML = "Ce champ est requis. <br>";
    } else if (field.validity.tooShort || field.validity.tooLong) {
        errorMessage.innerHTML = `La longueur doit être comprise entre ${field.minLength} et ${field.maxLength} caractères.<br>`;
    } else if (field.type === "email" && !field.validity.valid) {
        errorMessage.innerHTML = "Veuillez entrer une adresse email valide.<br>";
    } else {
        errorMessage.innerHTML = "";
    }
}

//le formulaire est valide
function isFormValid(form) {
    let isValid = true;
    Array.from(form.elements).forEach((field) => {
        if (!field.checkValidity()) {
            validateField(field);
            isValid = false;
        }
    });
    return isValid;
}

//le compteur de caractères
function updateCharacterCounter(field) {
    const counter = document.getElementById(`${field.id}-counter`);
    counter.textContent = `${field.value.length}`;
}

//les mots de passe
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}