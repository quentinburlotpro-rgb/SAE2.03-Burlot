// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";//"http://mmi.unilim.fr/~????"; // CHANGE THIS TO MATCH YOUR CONFIG

let DataMovie = {};

DataMovie.add = async function(movieData){
    const formData = new FormData();
        Object.keys(movieData).forEach(key => {
        formData.append(key, movieData[key]);
    });
    
    const response = await fetch(HOST_URL + "/script.php?todo=addmovie", {
        method: 'POST',
        body: formData
    });
    
    const data = await response.json();
    console.log(data);
    
    return data;
}

export {DataMovie};
