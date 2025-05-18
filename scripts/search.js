const resultsContainer = document.getElementById('search-results');

let currentPage = 1;
const resultsPerPage = 5;

function displayPagination(totalResults) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    const totalPages = Math.ceil(totalResults / resultsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.classList.add('button_page'); 
        if (i === currentPage) {
            button.classList.add('active');
        }
        button.addEventListener('click', () => {
            currentPage = i;
            filterTrips(false);
        });
        paginationContainer.appendChild(button);
    }
}


function displayResults(filteredTrips) {
    resultsContainer.innerHTML = ''; 

    if (filteredTrips.length === 0) {
        resultsContainer.innerHTML = `
            <div class="notfound-content">
                <h1>Aucun résultat trouvé</h1>
                <a class="small-link" href="search.php">Cliquer ici pour vider le champs de recherche</a>
                <br> <br> <br> <br>
                <h1>Voyages qui pourrais vous intéresser : </h1>
            </div>
        `;
        filteredTrips = allTrips; 
    }

    const startIndex = (currentPage - 1) * resultsPerPage;
    const endIndex = startIndex + resultsPerPage;
    const paginatedTrips = filteredTrips.slice(startIndex, endIndex);

    paginatedTrips.forEach(trip => {
        const tripElement = document.createElement('div');
        tripElement.id = "results";
        tripElement.classList.add('results-container');
        tripElement.innerHTML = `
            <a class="result" href="trip.php?trip=${trip.id}">
                <h1>🌍 ${trip.title}</h1>
                <div>
                    <p>📅 ${trip.departure_date} - ${trip.return_date}</p>
                    <p>👥 Max voyageurs : ${trip.travelers}</p>
                    <p>👥 Max chambres : ${trip.rooms}</p>
                    <p>🏕️ Activité : ${trip.activity}</p>
                    <p>🌡️ Climat : ${trip.climate}</p>
                    <p>📫 Destination : ${trip.destination}</p>
                    <p>📈 Niveau : ${trip.level}</p>
                    <p>💰 Prix : ${trip.price}€ / personne</p>
                    <p>⭐ Note : ${trip.rating}/5</p>
                </div>
            </a>
        `;
        resultsContainer.appendChild(tripElement);
    });

    displayPagination(filteredTrips.length);
}

const sortSelect = document.getElementById('sort');


function sortTrips(trips, sort) {
    if (sort === 'price-asc') {
        return trips.sort((a, b) => a.price - b.price);
    } else if (sort === 'price-desc') {
        return trips.sort((a, b) => b.price - a.price);
    } else if (sort === 'traveler-rating') {
        return trips.sort((a, b) => b.rating - a.rating);
    }
    return trips; 
}


function filterTrips(resetPage = true) {
    if (resetPage) {
        currentPage = 1;
    }
    const travelers = parseInt(document.getElementById('travelers').value) || 0;
    const rooms = parseInt(document.getElementById('rooms').value) || 0;
    const level = document.getElementById('level').value;
    const activityElement = document.getElementById('activity');
    const activity = activityElement ? activityElement.value : '';
    const destination = document.getElementById('destination').value.toLowerCase();
    const climate = document.getElementById('climate').value;
    const departureDate = document.getElementById('departure-date').value;
    const returnDate = document.getElementById('return-date').value;
    const sort = sortSelect.value;

    console.log({ travelers, rooms, level, activity, destination, climate, departureDate, returnDate, sort });

    let filteredTrips = allTrips.filter(trip => {
        return (
            (travelers === 0 || trip.travelers >= travelers) &&
            (rooms === 0 || trip.rooms >= rooms) &&
            (!level || trip.level === level) &&
            (!activity || trip.activity === activity) &&
            (!destination || trip.destination.toLowerCase().includes(destination)) &&
            (!climate || trip.climate === climate) &&
            (!departureDate || trip.departure_date >= departureDate) &&
            (!returnDate || trip.return_date <= returnDate)
        );
    });

    filteredTrips = sortTrips(filteredTrips, sort);

    displayResults(filteredTrips);
}


const filterFields = [
    'travelers',
    'rooms',
    'level',
    'activity',
    'destination',
    'climate',
    'departure-date',
    'return-date'
];

filterFields.forEach(fieldId => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.addEventListener('change', filterTrips); 
    }
});


sortSelect.addEventListener('change', filterTrips);


displayResults(allTrips);
