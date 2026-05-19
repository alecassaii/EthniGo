function err() {
    const navEntries = performance.getEntriesByType("navigation");
    const isReload = navEntries.length && navEntries[0].type === "reload";

    if (isReload) document.getElementById("log").innerText = "";
}

async function cityAPI() {
    const cityInput = document.getElementById("city").value;
    const outputElement = document.getElementById("output");

    if (!cityInput) {
        outputElement.innerText = "Per favore, inserisci una città.";
        return;
    }

    const url = `https://nominatim.openstreetmap.org/search?format=json&city=${encodeURIComponent(cityInput)}`;

    try {
        outputElement.innerText = "Ricerca in corso...";
        const response = await fetch(url, {
            headers: {
                'User-Agent': 'EthniGoApp/1.0'
            }
        });

        if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);

        const data = await response.json();
        console.log(JSON.stringify(data, null, 2))

        if (data.length === 0) outputElement.innerText = "Nessun risultato trovato.";
        else {
            outputElement.innerHTML = outputCity(data);
            setupCityClickListeners();
        }

    } catch (error) {
        outputElement.innerText = "Errore nella chiamata: " + error.message;
        console.error("Error details:", error);
    }
}

function outputCity(data) {
    let html = "<div id='results-container' style='width: 95%'>";
    html += "<p>Risultati:</p>";

    for (let i = 0; i < data.length; i++) {
        const { display_name, lat, lon } = data[i];
        html += `<button type="button" class='city-result' data-lat='${lat}' data-lon='${lon}' data-name='${display_name}' style="cursor: pointer">
            ${display_name}
        </button>`;
    }
    html += "</div>";

    return html;
}

function setupCityClickListeners() {
    const buttons = document.querySelectorAll('.city-result');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const lat = this.getAttribute('data-lat');
            const lon = this.getAttribute('data-lon');
            const name = this.getAttribute('data-name');
            let selectedCity;
            selectedCity = { name, lat, lon };
            console.log('Selected cities:', selectedCity);
            sendCity(selectedCity);

            buttons.forEach(b => b.style.backgroundColor = '#f9f9f9');      // reset highlight
            this.style.backgroundColor = '#e0e0e0';     // highlight clicked button
        });
    });
}

function sendCity(selectedCity) {
    document.getElementById('hidden-city').value = JSON.stringify(selectedCity);
}

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('save-btn')) {
        const restaurantRaw = e.target.getAttribute('data-info');

        try {
            const restaurant = JSON.parse(restaurantRaw);
            saveRestaurant(restaurant);
            e.target.classList.add('saved');
            e.target.textContent = 'Salvato';
        } catch (error) {
            console.error("Error parsing restaurant data:", error);
        }
    }
});

function saveRestaurant(restaurant) {
    console.log('Saving restaurant:', restaurant.poi.name, "|",restaurant.address.freeformAddress, "|", restaurant.poi.phone, "|", restaurant.poi.url, "|", restaurant.id);

    fetch('../src/salvaRistorante.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(restaurant)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Restaurant saved successfully:', data);
    })
    .catch(error => {
        console.error('Error saving restaurant:', error);
    });
}

async function markSavedRestaurants() {
    try {
        const response = await fetch('../src/getPreferiti.php');
        const savedIds = await response.json();

        document.querySelectorAll('.save-btn').forEach(btn => {
            const info = JSON.parse(btn.getAttribute('data-info'));
            if (savedIds.includes(info.id)) {
                btn.classList.add('saved');
                btn.textContent = 'Salvato';
            }
        });
    } catch (err) {
        console.error('Errore nel recupero preferiti:', err);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.save-btn')) markSavedRestaurants();
});

// ── Rimozione dai preferiti (preferiti.php) ───────────────
document.addEventListener('click', function (e) {
    if (!e.target.closest('.delete-btn')) return;

    const btn  = e.target.closest('.delete-btn');
    const card = btn.closest('.restaurant-card');
    const id   = btn.getAttribute('data-id');

    // Animazione di uscita
    card.classList.add('removing');

    fetch('../src/rimuoviPreferito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                // Aspetta la fine dell'animazione poi rimuove il DOM
                card.addEventListener('transitionend', () => {
                    card.remove();

                    // Aggiorna contatore
                    const remaining = document.querySelectorAll('.restaurant-card').length;
                    const counter = document.querySelector('.result-count strong');
                    if (counter) counter.textContent = remaining;

                    // Se non ci sono più preferiti mostra stato vuoto
                    if (remaining === 0) {
                        document.querySelector('.results-grid').innerHTML = `
                        <div class="no-results" style="grid-column: 1/-1">
                            <p>Non hai ancora salvato nessun ristorante.</p>
                            <a href="utente.php" class="btn-cerca-link">Inizia a esplorare</a>
                        </div>`;
                    }
                }, { once: true });
            } else {
                // In caso di errore torna visibile
                card.classList.remove('removing');
                console.error('Errore rimozione:', data.message);
            }
        })
        .catch(err => {
            card.classList.remove('removing');
            console.error('Errore fetch:', err);
        });
});