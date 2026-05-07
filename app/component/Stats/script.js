const Stats = {};

let template = await (await fetch('./component/Stats/template.html')).text();

Stats.format = function(data) {    
    let html = template;
    html = html.replaceAll('{{total_profiles}}', data.total_profiles);
    html = html.replaceAll('{{avg_favorites}}', data.avg_favorites);
    html = html.replaceAll('{{total_movies}}', data.total_movies);
    html = html.replaceAll('{{top_movie}}', data.top_movie);
    html = html.replaceAll('{{top_category}}', data.top_category);
    return html;
};

export { Stats };