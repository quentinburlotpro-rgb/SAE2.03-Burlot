let templateFile = await fetch("./component/MovieForm/template.html");
let template = await templateFile.text();

let MovieForm = {};

/**
 * MovieForm.format
 * 
 * Retourne le HTML du formulaire d'ajout de film
 * @returns {string} - HTML du formulaire
 */
MovieForm.format = function() {
  return template;
};

/**
 * MovieForm.getData
 * 
 * Récupère les données du formulaire
 * @param {string} formId - ID de l'élément form
 * @returns {Object} - Objet contenant les données du formulaire
 */
MovieForm.getData = function(formId) {
  const form = document.getElementById(formId);
  const formData = new FormData(form);
  
  // Convertit le FormData en objet JavaScript
  const data = {};
  for (let [key, value] of formData.entries()) {
    data[key] = value;
  }
  
  return data;
};

/**
 * MovieForm.reset
 * 
 * Réinitialise le formulaire
 * @param {string} formId - ID de l'élément form
 */
MovieForm.reset = function(formId) {
  const form = document.getElementById(formId);
  form.reset();
};

export { MovieForm };
