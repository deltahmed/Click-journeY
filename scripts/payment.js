document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault(); 

    const form = this; 
    const formData = new FormData(form);

    fetch('controllers/save_payment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            form.submit(); 
        } else {
            console.error('Erreur lors de la requête :', response.status);
        }
    })
    .catch(error => {
        console.error('Erreur réseau :', error);
    });
});