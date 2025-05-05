function simulateAction(button, actionName) {
    button.disabled = true; 
    const originalText = button.innerHTML ; 
    button.innerHTML = "<img class=\"icon\"> ..."; 

    
    setTimeout(() => {
        button.disabled = false; 
        button.innerHTML = originalText; 
    }, 2000); // 2000ms = 2 secondes
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".add-b").forEach(button => {
        button.addEventListener("click", () => simulateAction(button, ""));
    });

    document.querySelectorAll(".reset-b").forEach(button => {
        button.addEventListener("click", () => simulateAction(button, ""));
    });

    document.querySelectorAll(".ban-b").forEach(button => {
        button.addEventListener("click", () => simulateAction(button, ""));
    });

    document.querySelectorAll(".del-b").forEach(button => {
        button.addEventListener("click", () => simulateAction(button, ""));
    });
});