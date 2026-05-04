const HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";

const DataMovie = {};

DataMovie.requestMovies = async function(age = 0) {
    let answer = await fetch(HOST_URL + "/script.php?todo=readMovies&age=" + age);
    return await answer.json();
};

DataMovie.requestMovieDetail = async function(id) {
    let answer = await fetch(HOST_URL + "/script.php?todo=readMovieDetail&id=" + id);
    
    return await answer.json();
};

DataMovie.requestFeatured = async function(ageLimit) {
    let answer = await fetch(HOST_URL + "/script.php?todo=readFeaturedMovies&age=" + ageLimit);
    return await answer.json();
};

DataMovie.search = async function(ageLimit, query) {
    return await (await fetch(`${HOST_URL}/script.php?todo=searchMovies&age=${ageLimit}&q=${encodeURIComponent(query)}`)).json();
};

export { DataMovie };