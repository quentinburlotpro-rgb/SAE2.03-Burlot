const NavBar = {};
let template;
template = await (await fetch("./component/NavBar/template.html")).text();

NavBar.format = function(profiles) {
    let html = template;
    let optionsHtml = '';
    for (const p of profiles) {
        optionsHtml += `<option value="${p.id}">${p.name}</option>`;
    }
    html = html.replace('{{profileOptions}}', optionsHtml);

    return html;
}

export { NavBar };