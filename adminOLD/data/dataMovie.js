let HOST_URL = "https://burlot-sae203.mmi-limoges.fr/serverOLD";

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