let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

/**
 * Movie.format
 * 
 * Accepte un tableau de films ou un film unique et les formate en HTML.
 * @param {Array|Object} movies - Un tableau de films ou un film unique
 * @returns {string} - Le HTML formaté des films
 */
Movie.format = function (movies) {
  // Si movies n'est pas un tableau, on le convertit en tableau
  if (!Array.isArray(movies)) {
    movies = [movies];
  }

  let html = '<div class="movie-list">';
  
  // Si aucun film, afficher un message
  if (movies.length === 0) {
    html += '<p class="movie-list__empty">Aucun film disponible pour le moment.</p>';
  } else {
    // Pour chaque film, on remplace les variables dans le template
    movies.forEach((movie, index) => {
      let movieHtml = template;
      movieHtml = movieHtml.replaceAll("{{title}}", movie.name);
      movieHtml = movieHtml.replaceAll("{{image}}", movie.image);
      html += movieHtml;
    });
  }
  
  html += '</div>';
  return html;
};

export { Movie };
