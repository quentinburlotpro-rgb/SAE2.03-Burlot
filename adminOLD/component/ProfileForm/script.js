const ProfileForm = {};

let template = "";
let response = await fetch('./component/ProfileForm/template.html');
template = await response.text();

ProfileForm.format = function(handlerString, profiles, currentProfile = null) {
    let html = template;
    html = html.replace('{{handler}}', handlerString);

    let formTitle = "Ajouter un profil";
    let btnText = "Créer le profil";
    
    let id = "";
    let name = "";
    let avatar = "";
    let minAge = 0;

    if (currentProfile) {
        formTitle = "Modifier : " + currentProfile.name;
        btnText = "Enregistrer les modifications";
        id = currentProfile.id;
        name = currentProfile.name;
        avatar = currentProfile.avatar;
        minAge = currentProfile.min_age;
    }

    html = html.replace('{{formTitle}}', formTitle);
    html = html.replace('{{buttonText}}', btnText);
    
    html = html.replace('{{id}}', id);
    html = html.replace('{{name}}', name);
    html = html.replace('{{avatar}}', avatar);
    html = html.replace(`value="${minAge}"`, `value="${minAge}" selected`);

    let profileOptions = '';
    if (profiles) {
        for (let p of profiles) {
            let selected = (currentProfile && currentProfile.id == p.id) ? "selected" : "";
            profileOptions += `<option value="${p.id}" ${selected}>${p.name}</option>`;
        }
    }
    html = html.replace('{{profileOptions}}', profileOptions);

    return html;
}

export { ProfileForm };