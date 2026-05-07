const HOST_URL = "https://burlot-sae203.mmi-limoges.fr/server";

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
    let answer = await fetch(HOST_URL + "/script.php?todo=addFavorite&id_profile=" + DataProfile.activeProfileId + "&id_movie=" + id_movie);
    let result = await answer.json();
    
    if (result) {
        DataProfile.favoriteMovieIds.push(parseInt(id_movie));
    }
    return result;
};

DataProfile.removeFavorite = async function(id_movie) {
    let answer = await fetch(HOST_URL + "/script.php?todo=removeFavorite&id_profile=" + DataProfile.activeProfileId + "&id_movie=" + id_movie);
    let result = await answer.json();
    
    if (result) {
        let idNumber = parseInt(id_movie);
        DataProfile.favoriteMovieIds = DataProfile.favoriteMovieIds.filter(id => id !== idNumber);
    }
    return result;
};

DataProfile.getActiveProfile = function() {
    let profile = DataProfile.profiles.find(p => p.id == DataProfile.activeProfileId);
    return profile ? profile : null;
};

DataProfile.getActiveAgeLimit = function() {
    let profile = DataProfile.getActiveProfile();
    return profile ? profile.min_age : 18; 
};

DataProfile.setActiveProfile = async function(profileId) {
    DataProfile.activeProfileId = profileId ? profileId : null;
    DataProfile.favoriteMovieIds = [];
    
    if (!profileId) return null;
    
    let favs = await DataProfile.requestFavorites(profileId);
    
    if (favs && favs[0] && favs[0].movies) {
        for (let movie of favs[0].movies) {
            DataProfile.favoriteMovieIds.push(parseInt(movie.id));
        }
    }
    
    return DataProfile.getActiveProfile();
};

DataProfile.toggleFavorite = async function(movieId) {
    let id = parseInt(movieId);
    if (DataProfile.favoriteMovieIds.includes(id)) {
        return await DataProfile.removeFavorite(id);
    } else {
        return await DataProfile.addFavorite(id);
    }
};

DataProfile.getFullFavorites = async function() {
    if (!DataProfile.activeProfileId) return null;
    
    let favs = await DataProfile.requestFavorites(DataProfile.activeProfileId);
    
    if (favs && favs[0] && favs[0].movies) {
        return favs[0].movies;
    }
    return [];
};

export { DataProfile };