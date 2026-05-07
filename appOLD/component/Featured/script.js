const Featured = {};

let template = "";
let response = await fetch('./component/Featured/template.html');
template = await response.text();

Featured.format = function(movies) {
    if (!movies || movies.length === 0) {
        return `<div class="empty-state"><p>Aucun film mis en avant pour le moment.</p></div>`;
    }
    
    let m = movies[0];
    let html = template;
    
    html = html.replaceAll('{{id}}', m.id);
    html = html.replaceAll('{{name}}', m.name);
    html = html.replaceAll('{{image}}', m.image);
    
    html = html.replaceAll('{{description}}', m.description || "Aucune description disponible pour ce film.");
    
    return html;
}

export { Featured };