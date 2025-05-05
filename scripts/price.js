document.addEventListener("DOMContentLoaded", function () {
    const totalPriceElement = document.getElementById("total-price");
    const totalPriceInput = document.getElementById("total_price"); 
    const roomsInput = document.getElementById("rooms");
    const travelersInput = document.getElementById("travelers");
    const selectElements = document.querySelectorAll("select");


    const basePricePerPerson = parseFloat(window.basePricePerPerson || 0);

    function calculateTotalPrice() {
        let cost = 0;


        cost += basePricePerPerson;


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
        totalPriceElement.textContent = formattedCost;


        totalPriceInput.value = formattedCost;
    }


    roomsInput.addEventListener("input", calculateTotalPrice);
    travelersInput.addEventListener("input", calculateTotalPrice);
    selectElements.forEach(select => {
        select.addEventListener("change", calculateTotalPrice);
    });


    calculateTotalPrice();
});