const Topbar = {};
let template = await (await fetch("./component/TopBar/template.html")).text();

Topbar.format = function(profiles, hProfile, hLogout) {
    let html = template;
    html = html.replace('{{handlerProfile}}', hProfile);
    html = html.replace('{{handlerLogout}}', hLogout);
    let optionsHtml = '';
    if (profiles) {
        for (const p of profiles) {
            optionsHtml += `<option value="${p.id}">${p.name}</option>`;
        }
    }
    html = html.replace('{{profileOptions}}', optionsHtml);
    return html;
};

export { Topbar };