const HOST_URL = "https://mmi.unilim.fr/~burlot4/SAE2.03-Burlot/server";

const DataProfile = {

    profiles: [],
    currentProfileEdit: null
};



DataProfile.requestProfiles = async function() {
    let answer = await fetch(HOST_URL + "/script.php?todo=readProfiles");
    DataProfile.profiles = await answer.json();
    return DataProfile.profiles;
};

DataProfile.save = async function (fdata) {
    let config = { method: "POST", body: fdata };
    let answer = await fetch(HOST_URL + "/script.php?todo=saveProfile", config);
    let result = await answer.json();
    

    if (result) {
        await DataProfile.requestProfiles();
    }
    return result;
};

DataProfile.getProfiles = function() {
    return DataProfile.profiles;
};

DataProfile.getCurrentEdit = function() {
    return DataProfile.currentProfileEdit;
};


DataProfile.setCurrentEdit = function(id) {
    return DataProfile.currentProfileEdit = DataProfile.profiles.find(p => p.id == id);
};

export { DataProfile };