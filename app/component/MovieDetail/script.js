let template = await (await fetch("./component/MovieDetail/template.html")).text();
const MovieDetail = {};

MovieDetail.format = function(movie, favIds = []) {
  let isFav = favIds.includes(parseInt(movie.id));
  let html = template;
  html = html.replaceAll("{{id}}", movie.id);
  html = html.replaceAll("{{name}}", movie.name);
  html = html.replaceAll("{{image}}", movie.image);
  html = html.replaceAll("{{director}}", movie.director);
  html = html.replaceAll("{{year}}", movie.year);
  html = html.replaceAll("{{length}}", movie.length);
  html = html.replaceAll("{{category_name}}", movie.category_name);
  html = html.replaceAll("{{min_age}}", movie.min_age);
  html = html.replaceAll("{{description}}", movie.description);
  html = html.replaceAll("{{trailer}}", movie.trailer);
  html = html.replace('{{favClass}}', isFav ? "active" : "");
  html = html.replace('{{fillColor}}', isFav ? "rgb(0, 0, 0)" : "none");   

  return html;
};

export { MovieDetail };