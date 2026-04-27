let template;

const NavBar = {};

// Charge le template une seule fois au démarrage du module
async function initTemplate() {
      let templateFile = await fetch("./component/NavBar/template.html");
      template = await templateFile.text();
}

NavBar.format = function (hAbout) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  return html;
};

await initTemplate();

export { NavBar };
