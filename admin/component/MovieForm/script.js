let template;

const MovieForm = {};

// Charge le template une seule fois au démarrage du module
async function initTemplate() {
      let templateFile = await fetch("./component/MovieForm/template.html");
      template = await templateFile.text();
}

// Récupère les données du formulaire
MovieForm.getData = function(formId) {
  const form = document.querySelector("#" + formId);
  const formData = new FormData(form);
  const data = {};
  
  for (let [key, value] of formData.entries()) {
    data[key] = value;
  }
  
  return data;
};

// Réinitialise le formulaire
MovieForm.reset = function(formId) {
  const form = document.querySelector("#" + formId);
  form.reset();
};

// Formate et retourne le template du formulaire
MovieForm.format = function() {
  return template;
};

await initTemplate();

export { MovieForm };
