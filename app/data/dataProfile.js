const HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";

const DataProfile = {
    profiles: [],
    activeProfileId: null,
    favoriteMovieIds: []
};

DataProfile.requestProfiles = async function() {
    let answer = await fetch(HOST_URL + "/script.php?todo=readProfiles");
    DataProfile.profiles = await answer.json(); 
    return DataProfile.profiles;
};

DataProfile.requestFavorites = async function(id_profile) {
    let answer = await fetch(HOST_URL + "/script.php?todo=readFavorites&profile=" + id_profile);
    return await answer.json();
};

DataProfile.addFavorite = async function(id_movie) {
    let fdata = new FormData();
    fdata.append('id_profile', DataProfile.activeProfileId);
    fdata.append('id_movie', id_movie);
    
    let config = { method: "POST", body: fdata };
    let answer = await fetch(HOST_URL + "/script.php?todo=addFavorite", config);
    let result = await answer.json();
    
    if (result) {
        DataProfile.favoriteMovieIds.push(parseInt(id_movie));
    }
    return result;
};

DataProfile.removeFavorite = async function(id_movie) {
    let fdata = new FormData();
    fdata.append('id_profile', DataProfile.activeProfileId);
    fdata.append('id_movie', id_movie);
    
    let config = { method: "POST", body: fdata };
    let answer = await fetch(`${HOST_URL}/script.php?todo=removeFavorite`, config);
    let result = await answer.json();
    
    if (result) {
        DataProfile.favoriteMovieIds = DataProfile.favoriteMovieIds.filter(id => id !== parseInt(id_movie));
    }
    return result;
};

DataProfile.getActiveProfile = function() {
    if (!DataProfile.activeProfileId) return null;
    return DataProfile.profiles.find(p => p.id == DataProfile.activeProfileId);
};

DataProfile.getActiveAgeLimit = function() {
    let profile = DataProfile.getActiveProfile();
    return profile ? profile.min_age : 18; 
};

DataProfile.setActiveProfile = async function(profileId) {
    if (!profileId || profileId === "") {
        DataProfile.activeProfileId = null;
        DataProfile.favoriteMovieIds = [];
        return null;
    }
    
    DataProfile.activeProfileId = profileId;
    DataProfile.favoriteMovieIds = [];
    
    let favs = await DataProfile.requestFavorites(profileId);
    if (favs && favs.length > 0 && favs[0].movies) {
        DataProfile.favoriteMovieIds = favs[0].movies.map(m => parseInt(m.id));
    }
    return DataProfile.getActiveProfile();
};


DataProfile.toggleFavoriteSafe = async function(movieId) {
    if (!DataProfile.activeProfileId) {
        return { error: "Veuillez d'abord sélectionner un profil !" };
    }
    
    let id = parseInt(movieId);
    
    if (DataProfile.favoriteMovieIds.includes(id)) {
        let success = await DataProfile.removeFavorite(id);
        return success 
            ? { success: true, action: "removed", message: "Le film a été retiré de vos favoris." } 
            : { error: "Erreur lors de la suppression." };
    } else {
        let success = await DataProfile.addFavorite(id);
        return success 
            ? { success: true, action: "added", message: "Le film a été ajouté à vos favoris." } 
            : { error: "Erreur lors de l'ajout." };
    }
};

DataProfile.getFavoritesForDisplay = async function() {
    if (!DataProfile.activeProfileId) {
        return { error: "Veuillez d'abord sélectionner un profil pour voir vos favoris !" };
    }
    
    let favs = await DataProfile.requestFavorites(DataProfile.activeProfileId);
    
    if (favs && favs.length > 0 && favs[0].movies && favs[0].movies.length > 0) {
        return { data: [{ category_name: "Mes Favoris", movies: favs[0].movies }] };
    }
    
    return { empty: true, message: "Votre liste de favoris est vide." };
};

export { DataProfile };