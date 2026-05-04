let template;

const MovieForm = {};

template = await (await fetch("./component/MovieForm/template.html")).text();

MovieForm.format = function() {
  return template;
};

MovieForm.format = function(handlerString) {
    let html = template;
    html = html.replace('{{handler}}', handlerString);
    return html;
}

export { MovieForm };
