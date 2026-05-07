let template = await (await fetch("./component/Search/template.html")).text();

const Search = {};

Search.format = function(categories = []) {
    let html = template;
    let categoriesHtml = "";
    
    for (let cat of categories) {
        categoriesHtml += `<button class="filter-btn empty" onclick="C.handlerFilterSearch('${cat.category_name}')">${cat.category_name}</button>`;
    }
    
    html = html.replace('{{categories_html}}', categoriesHtml);
    return html;
};

export { Search };