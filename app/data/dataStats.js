const HOST_URL = "https://burlot-sae203.mmi-limoges.fr/server";
const DataStats = {};

DataStats.requestStats = async function() {
    let answer = await fetch(HOST_URL + "/script.php?todo=readStats");
    return await answer.json();
};

export { DataStats };