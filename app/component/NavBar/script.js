let template;

const NavBar = {};

template = await (await fetch("./component/NavBar/template.html")).text();

NavBar.format = function(hAbout, hHome, hFav, hStats) {
    let html = template;
    html = html.replaceAll('{{handlerAbout}}', hAbout);
    html = html.replaceAll('{{handlerHome}}', hHome);
    html = html.replaceAll('{{handlerFavorites}}', hFav);
    html = html.replaceAll('{{handlerStats}}', hStats);
    
    return html;
}

export { NavBar };