const HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";

const DataMovie = {};

DataMovie.requestMovies = async function() {
    let answer = await fetch(HOST_URL + "/script.php?todo=readmovies");
    let data = await answer.json();
    return data;
};

export { DataMovie };