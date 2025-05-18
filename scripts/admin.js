function simulateAction(button, actionName, userId) {
    button.disabled = true;
    const originalText = button.innerHTML;
    button.innerHTML = "<img class=\"icon\"> ...";

    setTimeout(() => {
        fetch('controllers/admin_act.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `action=${encodeURIComponent(actionName)}&id=${encodeURIComponent(userId)}`
        })
        .then(res => {
            if (!res.ok) throw new Error('Erreur serveur');
            return res.text();
        })
        .then(() => {
            // Mise à jour du DOM en live
            const row = document.querySelector(`tr[data-id="${userId}"]`);
            const roleCell = document.getElementById(`role-${userId}`);
            if (actionName === "promote") {
                roleCell.textContent = "vip";
                button.outerHTML = `<button class="ban-b" data-id="${userId}"><img class="icon">Rétrograder</button>`;
                addBanListener(userId);
            } else if (actionName === "demote") {
                roleCell.textContent = "user";
                button.outerHTML = `<button class="add-b" data-id="${userId}"><img class="icon">Promouvoir</button>`;
                addPromoteListener(userId);
            } else if (actionName === "delete") {
                row.remove();
            }
        })
        .catch(() => {
            button.innerHTML = "Erreur";
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        });
    }, 2000); // Attend 2 secondes avant d'exécuter la modification
}
// Pour ré-attacher les listeners sur les nouveaux boutons
function addPromoteListener(userId) {
    const btn = document.querySelector(`button.add-b[data-id="${userId}"]`);
    if (btn) {
        btn.addEventListener("click", () => {
            simulateAction(btn, "promote", userId);
        });
    }
}
function addBanListener(userId) {
    const btn = document.querySelector(`button.ban-b[data-id="${userId}"]`);
    if (btn) {
        btn.addEventListener("click", () => {
            simulateAction(btn, "demote", userId);
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".add-b").forEach(button => {
        button.addEventListener("click", () => {
            simulateAction(button, "promote", button.dataset.id);
        });
    });

    document.querySelectorAll(".ban-b").forEach(button => {
        button.addEventListener("click", () => {
            simulateAction(button, "demote", button.dataset.id);
        });
    });

    document.querySelectorAll(".del-b").forEach(button => {
        button.addEventListener("click", () => {
            if (confirm("Supprimer cet utilisateur ?")) {
                simulateAction(button, "delete", button.dataset.id);
            }
        });
    });
});