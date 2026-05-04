let HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";

let DataMovie = {};

DataMovie.add = async function (fdata) {
    let config = {
        method: "POST",
        body: fdata
    };
    let answer = await fetch(HOST_URL + "/script.php?todo=addMovie", config);
    let data = await answer.json();
    
    return data;
}

export {DataMovie};