document.addEventListener('DOMContentLoaded', function () {
    const stages = JSON.parse(document.getElementById('stages-data').textContent);
    const types = [
        {type: 'home', label: '🏠 Logement'},
        {type: 'transport', label: '🚗 Transport'},
        {type: 'food', label: '🍽️ Nourriture'},
        {type: 'activity', label: '🏞️ Activité'},
        {type: 'other', label: '🔧 Autre'}
    ];

    // Récupérer les options sélectionnées depuis la session
    let selectedOptions = {};
    const selectedOptionsScript = document.getElementById('selected-options-data');
    if (selectedOptionsScript) {
        selectedOptions = JSON.parse(selectedOptionsScript.textContent);
    }

    // Prix total
    const totalPriceElement = document.getElementById("total-price");
    const totalPriceInput = document.getElementById("total_price"); 
    const roomsInput = document.getElementById("rooms");
    const travelersInput = document.getElementById("travelers");
    const basePricePerPerson = parseFloat(window.basePricePerPerson || 0);

    function calculateTotalPrice() {
        let cost = 0;
        cost += basePricePerPerson;

        // Sélectionner tous les selects à chaque appel (pour inclure les nouveaux)
        const selectElements = document.querySelectorAll("select");
        selectElements.forEach(select => {
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption) {
                const priceText = selectedOption.textContent.match(/: ([\d.]+)€/);
                if (priceText) {
                    cost += parseFloat(priceText[1]);
                }
            }
        });

        const rooms = parseInt(roomsInput.value) || 1;
        cost += 50 * (rooms - 1);

        const travelers = parseInt(travelersInput.value) || 1;
        cost *= travelers;

        const formattedCost = cost.toFixed(2);
        if (totalPriceElement) totalPriceElement.textContent = formattedCost;
        if (totalPriceInput) totalPriceInput.value = formattedCost;
    }

    // Listeners sur inputs fixes
    if (roomsInput) roomsInput.addEventListener("input", calculateTotalPrice);
    if (travelersInput) travelersInput.addEventListener("input", calculateTotalPrice);

    // Génération dynamique des selects
    stages.forEach(stage => {
        types.forEach(opt => {
            fetch(`controllers/options.php?stage_id=${stage.id}&type=${opt.type}`)
                .then(res => res.json())
                .then(options => {
                    const container = document.getElementById(`options_${opt.type}_${stage.id}`);
                    if (!container) return;
                    if (options.length === 0) {
                        container.innerHTML = '';
                        return;
                    }
                    let selectName = `${opt.type}_${stage.id}`;
                    let select = `<h4>${opt.label} :</h4><select name="${selectName}">`;
                    options.forEach(option => {
                        // Cherche si cette option était sélectionnée
                        let selected = "";
                        let optionValue = `${stage.trip_id}option_${option.id}`;
                        // Clé de session
                        let sessionKey = `${stage.trip_id}option_${option.id}`;
                        // Si la valeur correspond à celle en session, on sélectionne
                        for (const key in selectedOptions) {
                            if (selectedOptions[key] == option.id) {
                                if (key === optionValue) {
                                    selected = "selected";
                                    break;
                                }
                            }
                        }
                        select += `<option value="${optionValue}" ${selected}>${option.title} : ${option.price}€</option>`;
                    });
                    select += '</select>';
                    container.innerHTML = select;

                    // Ajouter le listener sur le nouveau select
                    const newSelect = container.querySelector('select');
                    if (newSelect) {
                        newSelect.addEventListener("change", calculateTotalPrice);
                    }

                    // Recalculer le prix après ajout du select
                    calculateTotalPrice();
                });
        });
    });

    // Calcul initial
    calculateTotalPrice();
});