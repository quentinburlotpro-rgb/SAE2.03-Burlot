const HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";
const DataStats = {};

DataStats.requestStats = async function() {
    let answer = await fetch(HOST_URL + "/script.php?todo=readStats");
    return await answer.json();
};

export { DataStats };