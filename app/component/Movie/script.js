let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movie) {
      let movieHtml = template;
      movieHtml = movieHtml.replaceAll("{{title}}", movie.name);
      movieHtml = movieHtml.replaceAll("{{image}}", movie.image);
      return movieHtml;
};

Movie.formatMany = function (movies) {
      if (!movies || movies.length === 0) {
            return '<div class="movie-list"><div class="movie-list__empty">Aucun film trouvé.</div></div>';
      }
      let allMoviesHtml = '<div class="movie-list">';
      for (let movie of movies) {
            allMoviesHtml += Movie.format(movie);
      }
      allMoviesHtml += '</div>';
      return allMoviesHtml;
};

export { Movie };
