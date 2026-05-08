function err() {
    const navEntries = performance.getEntriesByType("navigation");
    const isReload = navEntries.length && navEntries[0].type === "reload";

    if (isReload) document.getElementById("log").innerText = "";
}

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.filter = "blur(5px)";
}
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.filter = "none";
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
        html += `<button type="button" class='city-result' data-lat='${lat}' data-lon='${lon}' style="cursor: pointer">
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
            const name = this.textContent;
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