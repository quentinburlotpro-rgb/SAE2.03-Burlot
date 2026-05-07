const HOST_URL = "https://burlot-sae203.mmi-limoges.fr/serverOLD";
const DataStats = {};

DataStats.requestStats = async function() {
    return await (await fetch(`${HOST_URL}/script.php?todo=readStats`)).json();
};

export { DataStats };