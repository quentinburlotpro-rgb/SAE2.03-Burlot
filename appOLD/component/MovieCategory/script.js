import { Movie } from '../Movie/script.js';
let template = await (await fetch("./component/MovieCategory/template.html")).text();

const MovieCategory = {};

MovieCategory.format = function(categoryData, favIds = []) {
    let html = template;
    html = html.replaceAll('{{category_name}}', categoryData.category_name);
    html = html.replace('{{movies_list}}', Movie.formatMany(categoryData.movies, favIds));
    return html;
};

MovieCategory.formatMany = function(categories, favIds = []) {
    let html = '';
    for (const category of categories) {
        html += MovieCategory.format(category, favIds);
    }
    return html;
};

export { MovieCategory };