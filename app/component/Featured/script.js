const Featured = {};

let template = "";
let response = await fetch('./component/Featured/template.html');
template = await response.text();

Featured.format = function(movies, favIds = []) {
    if (!movies || movies.length === 0) {
        return `<div class="empty-state"><p>Aucun film mis en avant pour le moment.</p></div>`;
    }
    let isFav = favIds.includes(parseInt(movies[0].id));

    let m = movies[0];
    let html = template;
    
    html = html.replaceAll('{{id}}', m.id);
    html = html.replaceAll('{{name}}', m.name);
    html = html.replaceAll('{{image}}', m.image);
    html = html.replaceAll('{{description}}', m.description);
    html = html.replaceAll('{{min_age}}', m.min_age);
    html = html.replaceAll('{{year}}', m.year);
    html = html.replaceAll('{{length}}', m.length);
    html = html.replace('{{favClass}}', isFav ? "active" : "");
    html = html.replace('{{fillColor}}', isFav ? "rgb(0, 0, 0)" : "none");   

    
    return html;
}

export { Featured };