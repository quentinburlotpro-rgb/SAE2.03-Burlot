const Movie = {};
let template = await (await fetch("./component/Movie/template.html")).text();

Movie.format = function(movie, favIds = []) {
    let isFav = favIds.includes(parseInt(movie.id));
    let html = template;
    html = html.replaceAll('{{id}}', movie.id);
    html = html.replaceAll('{{name}}', movie.name);
    html = html.replace('{{image}}', "../server/images/" + movie.image);
    html = html.replace('{{favClass}}', isFav ? 'active' : '');
    html = html.replace('{{fillColor}}', isFav ? 'currentColor' : 'none');
    return html;
};

Movie.formatMany = function(movies, favIds = []) {
    let html = '';
    for (const movie of movies) {
        html += Movie.format(movie, favIds);
    }
    return html;
};

export { Movie };