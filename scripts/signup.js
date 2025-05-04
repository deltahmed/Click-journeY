document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("registration-form");

    form.addEventListener("input", (event) => {
        const target = event.target;
        validateField(target);
        if (target.id === "passwordid" || target.id === "confirm-password") {
            updateCharacterCounter(target);
        }
        if (target.id === "birth-date") {
            validateAge(target);
        }
        if (target.id === "email") {
            validateEmail(target);
        }
        if (target.id === "passwordid") {
            validatePassword(target);
        }
        if (target.id === "confirm-password") {
            validateConfirmPassword(target);
        }
        
    });

    form.addEventListener("submit", (event) => {
        event.preventDefault();
        if (isFormValid(form)) {
            form.submit();
        }
    });
});


function validateField(field) {
    const errorMessage = field.nextElementSibling;

    if (!errorMessage) {
        return;
    }

    if (field.validity.valueMissing) {
        errorMessage.innerHTML = "Ce champ est requis. <br>";
    } else if (field.validity.tooShort || field.validity.tooLong) {
        errorMessage.innerHTML = `La longueur doit être comprise entre ${field.minLength} et ${field.maxLength} caractères.<br>`;
    } else {
        errorMessage.innerHTML = "";
    }

}

// moins 18 ans
function validateAge(field) {
    const errorMessage = field.nextElementSibling;
    const birthDate = new Date(field.value);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    const dayDiff = today.getDate() - birthDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--;
    }

    if (age < 18) {
        errorMessage.innerHTML = "Vous devez avoir au moins 18 ans pour vous inscrire.<br>";
    } else {
        errorMessage.innerHTML = "";
    }
}

// email
function validateEmail(field) {
    const errorMessage = field.nextElementSibling;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(field.value)) {
        errorMessage.innerHTML = "Veuillez entrer une adresse email valide.<br>";
    } else {
        errorMessage.innerHTML = "";
    }
}

// mot de passe
function validatePassword(field) {
    const errorMessage = field.nextElementSibling;
    const password = field.value;
    const errors = [];

    if (password.length < 8) {
        errors.push("Le mot de passe doit contenir au moins 8 caractères.");
    }
    if (!/[A-Z]/.test(password)) {
        errors.push("Le mot de passe doit contenir au moins une lettre majuscule.");
    }
    if (!/[a-z]/.test(password)) {
        errors.push("Le mot de passe doit contenir au moins une lettre minuscule.");
    }
    if (!/[0-9]/.test(password)) {
        errors.push("Le mot de passe doit contenir au moins un chiffre.");
    }
    if (!/[\W_]/.test(password)) {
        errors.push("Le mot de passe doit contenir au moins un caractère spécial.");
    }

    if (errors.length > 0) {
        errorMessage.innerHTML = errors.join("<br>");
    } else {
        errorMessage.innerHTML = "";
    }
}

// confirmation du mot de passe
function validateConfirmPassword(field) {
    const errorMessage = field.nextElementSibling;
    const password = document.getElementById("passwordid").value;

    if (field.value !== password) {
        errorMessage.innerHTML = "Les mots de passe ne correspondent pas.<br>";
    } else {
        errorMessage.innerHTML = "";
    }
}

// Vérifier si le formulaire est valide
function isFormValid(form) {
    let isValid = true;
    Array.from(form.elements).forEach((field) => {
        if (!field.checkValidity()) {
            validateField(field);
            isValid = false;
        }
        if (field.id === "birth-date") {
            validateAge(field);
            if (field.nextElementSibling.innerHTML !== "") {
                isValid = false;
            }
        }
        if (field.id === "email") {
            validateEmail(field);
            if (field.nextElementSibling.innerHTML !== "") {
                isValid = false;
            }
        }
        if (field.id === "passwordid") {
            validatePassword(field);
            if (field.nextElementSibling.innerHTML !== "") {
                isValid = false;
            }
        }
        if (field.id === "confirm-password") {
            validateConfirmPassword(field);
            if (field.nextElementSibling.innerHTML !== "") {
                isValid = false;
            }
        }
    });
    return isValid;
}

// compteur de caractères
function updateCharacterCounter(field) {
    const counter = document.getElementById(`${field.id}-counter`);
    if (counter) {
        counter.textContent = `${field.value.length}`;
    }
}

// visibilité du mot de passe
function togglePasswordVisibility(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}