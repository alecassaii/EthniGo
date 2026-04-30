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
    const selectedCard = document.getElementById("selected-card");
    selectedCard.style.display = "none";

    if (!cityInput) {
        outputElement.innerHTML = '<p>Per favore, inserisci una città.</p>';
        return;
    }

    const url = `https://nominatim.openstreetmap.org/search?format=json&city=${encodeURIComponent(cityInput)}`;

    try {
        outputElement.innerHTML = '<p>Ricerca in corso...</p>';
        const response = await fetch(url, { headers: { 'User-Agent': 'EthniGoApp/1.0' } });
        if (!response.ok) throw new Error(`Errore HTTP: ${response.status}`);
        const data = await response.json();

        if (data.length === 0) {
            outputElement.innerHTML = '<p>Nessun risultato trovato.</p>';
        } else {
            outputCity(data, outputElement);
        }
    } catch (error) {
        outputElement.innerHTML = `<p>Errore: ${error.message}</p>`;
    }
}

function outputCity(data, container) {
    const label = document.createElement("p");
    label.style.cssText = "font-size: 12px; color: var(--color-text-secondary); margin: 0 0 8px; text-transform: uppercase; letter-spacing: 0.05em;";
    label.textContent = `${data.length} risultat${data.length === 1 ? 'o' : 'i'}`;

    const list = document.createElement("div");
    list.style.cssText = "display: flex; flex-direction: column; gap: 4px;";

    data.forEach((item, i) => {
        const row = document.createElement("div");
        row.style.cssText = "padding: 10px 12px; border-radius: var(--border-radius-md); border: 0.5px solid var(--color-border-tertiary); cursor: pointer; background: var(--color-background-primary); transition: background 0.15s;";

        const name = document.createElement("p");
        name.style.cssText = "margin: 0 0 2px; font-size: 14px; font-weight: 500; color: var(--color-text-primary);";
        name.textContent = item.name || item.display_name.split(",")[0];

        const detail = document.createElement("p");
        detail.style.cssText = "margin: 0; font-size: 12px; color: var(--color-text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;";
        detail.textContent = item.display_name;

        row.appendChild(name);
        row.appendChild(detail);

        row.addEventListener("mouseenter", () => row.style.background = "var(--color-background-secondary)");
        row.addEventListener("mouseleave", () => row.style.background = "var(--color-background-primary)");
        row.addEventListener("click", () => selectCity(item, row, list));

        list.appendChild(row);
    });

    container.innerHTML = "";
    container.appendChild(label);
    container.appendChild(list);
}

function selectCity(item, clickedRow, list) {
    list.querySelectorAll("div").forEach(r => {
        r.style.borderColor = "var(--color-border-tertiary)";
        r.style.background = "var(--color-background-primary)";
    });
    clickedRow.style.borderColor = "var(--color-border-info)";
    clickedRow.style.background = "var(--color-background-info)";

    const card = document.getElementById("selected-card");
    card.style.display = "block";

    const fields = [
        ["Nome", item.display_name],
        ["Tipo", item.type || item.class || "—"],
        ["Latitudine", item.lat],
        ["Longitudine", item.lon],
        ["Bounding box", item.boundingbox ? item.boundingbox.join(", ") : "—"],
        ["OSM ID", item.osm_id || "—"],
        ["OSM Type", item.osm_type || "—"],
    ];

    card.innerHTML = `
    <p style="font-size: 12px; color: var(--color-text-secondary); margin: 0 0 12px; text-transform: uppercase; letter-spacing: 0.05em;">Luogo selezionato</p>
    <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
      ${fields.map(([k, v]) => `
        <tr>
          <td style="color: var(--color-text-secondary); padding: 5px 0; width: 40%; vertical-align: top;">${k}</td>
          <td style="color: var(--color-text-primary); padding: 5px 0; word-break: break-all;">${v}</td>
        </tr>
      `).join("")}
    </table>
  `;
}

document.getElementById("city").addEventListener("keydown", e => {
    if (e.key === "Enter") cityAPI();
});