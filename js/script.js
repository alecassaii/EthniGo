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

        if (!response.ok) throw new Error(`Errore HTTP: ${response.status}`);

        const data = await response.json();
        console.log(JSON.stringify(data, null, 2))

        if (data.length === 0) outputElement.innerText = "Nessun risultato trovato.";
        else outputElement.innerText = outputCity(data);

    } catch (error) {
        outputElement.innerText = "Errore nella chiamata: " + error.message;
        console.error("Dettagli errore:", error);
    }
}

function outputCity(data) {
    let str = "Risultati:\n\n";
    for (let i = 0; i < data.length; i++) str +=
        `Nome: ${data[i].display_name}\n`;

    return str;
}