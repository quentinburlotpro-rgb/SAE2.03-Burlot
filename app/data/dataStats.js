const HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";
const DataStats = {};

DataStats.requestStats = async function() {
    return await (await fetch(`${HOST_URL}/script.php?todo=readStats`)).json();
};

export { DataStats };