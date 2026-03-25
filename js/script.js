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