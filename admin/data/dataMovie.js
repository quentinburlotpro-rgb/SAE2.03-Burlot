// URL où se trouve le répertoire "server" sur mmi.unilim.fr
let HOST_URL = "..";//"http://mmi.unilim.fr/~????"; // CHANGE THIS TO MATCH YOUR CONFIG

let DataMovie = {};

/**
 * DataMovie.add
 * 
 * Envoie les données du formulaire de film au serveur en POST
 * @param {Object} movieData - Objet contenant les données du film
 * @returns {Promise} - Réponse du serveur
 */
DataMovie.add = async function(movieData){
    // Crée un objet FormData pour envoyer les données en POST
    const formData = new FormData();
    
    // Ajoute chaque propriété du film au FormData
    Object.keys(movieData).forEach(key => {
        formData.append(key, movieData[key]);
    });
    
    // Envoie les données au serveur avec le paramètre todo=addmovie
    const response = await fetch(HOST_URL + "/server/script.php?todo=addmovie", {
        method: 'POST',
        body: formData
    });
    
    // Récupère la réponse en JSON
    const data = await response.json();
    
    return data;
}

export {DataMovie};
