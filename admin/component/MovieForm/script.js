let templateFile = await fetch("./component/MovieForm/template.html");
let template = await templateFile.text();

let MovieForm = {};

MovieForm.format = function() {
  return template;
};


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

MovieForm.reset = function(formId) {
  const form = document.getElementById(formId);
  form.reset();
};

export { MovieForm };
