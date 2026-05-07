const Stats = {};

let template = await (await fetch('./component/Stats/template.html')).text();

Stats.format = function(data) {
    if (!data) return `<div class="empty-state">Données indisponibles.</div>`;
    
    return template
        .replaceAll('{{total_profiles}}', data.total_profiles)
        .replaceAll('{{avg_favorites}}', data.avg_favorites)
        .replaceAll('{{total_movies}}', data.total_movies)
        .replaceAll('{{top_movie}}', data.top_movie)
        .replaceAll('{{top_category}}', data.top_category);
};

export { Stats };