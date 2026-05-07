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

MovieCategory.init = function() {
    document.querySelectorAll('.category-row').forEach(function(row) {
        let carousel = row.querySelector('.carousel');
        if (!carousel) return;

        let prev = row.querySelector('.carousel-prev');
        let next = row.querySelector('.carousel-next');
        let scrollAmount = Math.round(carousel.clientWidth * 0.75);

        if (prev) {
            prev.onclick = function() {
                carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            };
        }
        if (next) {
            next.onclick = function() {
                carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            };
        }
    });
};

export { MovieCategory };