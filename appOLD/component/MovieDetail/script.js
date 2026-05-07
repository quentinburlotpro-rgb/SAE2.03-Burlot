let template = await (await fetch("./component/MovieDetail/template.html")).text();
const MovieDetail = {};

MovieDetail.format = function(movie) {
  let html = template;
  html = html.replaceAll("{{name}}", movie.name);
  html = html.replaceAll("{{image}}", movie.image);
  html = html.replaceAll("{{director}}", movie.director);
  html = html.replaceAll("{{year}}", movie.year);
  html = html.replaceAll("{{length}}", movie.length);
  html = html.replaceAll("{{category_name}}", movie.category_name);
  html = html.replaceAll("{{min_age}}", movie.min_age);
  html = html.replaceAll("{{description}}", movie.description);
  html = html.replaceAll("{{trailer}}", movie.trailer);
  return html;
};

export { MovieDetail };