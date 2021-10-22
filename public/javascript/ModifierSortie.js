
let lieux = [];
let villes = [];

//------------------------------------

/**
 * Méthode qui permet de mettre à jour le code postal en
 * fonction de la ville sélectionnée
 * Elle sera utilisée à l'affichage du formulaire et au moment de la sélection d'une ville
 * @param villeId
 */
function afficherCP(villeId){
    // je crée un objet ville
    let ville ={};
    // retrouver la ville à partir de l'id que j'ai dans le lieu
    for (let v of villes){
        if (villeId == v.id){
            ville = v;
        }
    }
    // je sélectionne l'élément dont l'id=code et je lui affecte le code postal de
    // l'objet ville recréé
    document.querySelector('#cp').value= ville.codePostal;
}

//------------------------------------

/**
 * Méthode qui permet de mettre à jour la rue en
 * fonction du lieu sélectionné
 * Elle sera utilisée à l'affichage du formulaire et au moment de la sélection d'un lieu
 * @param lieuId
 */
function afficherRue(lieuId){
    // je crée un objet lieu
    let lieu ={};
    // retrouver la rue à partir de l'id que j'ai dans le lieu
    for (let l of lieux){
        if (lieuId == l.id){
            lieu = l;
        }
    }
    // je sélectionne l'élément dont l'id=rue et je lui affecte la rue de
    // l'objet lieu recréé
    document.querySelector('#rue').value= lieu.rue;
}

//------------------------------------

/**
 * Méthode qui permet de mettre à jour la latitude en
 * fonction du lieu sélectionné
 * Elle sera utilisée à l'affichage du formulaire et au moment de la sélection d'un lieu
 * @param lieuId
 */
function afficherLatitude(lieuId){
    // je crée un objet lieu
    let lieu ={};
    // retrouver la latitude à partir de l'id que j'ai dans le lieu
    for (let l of lieux){
        if (lieuId == l.id){
            lieu = l;
        }
    }
    // je sélectionne l'élément dont l'id=latitude et je lui affecte la latitude de
    // l'objet lieu recréé
    document.querySelector('#latitude').value= lieu.latitude;
}

//------------------------------------

/**
 * Méthode qui permet de mettre à jour la longitude en
 * fonction du lieu sélectionné
 * Elle sera utilisée à l'affichage du formulaire et au moment de la sélection d'un lieu
 * @param lieuId
 */
function afficherLongitude(lieuId){
    // je crée un objet lieu
    let lieu ={};
    // retrouver la longitude à partir de l'id que j'ai dans le lieu
    for (let l of lieux){
        if (lieuId == l.id){
            lieu = l;
        }
    }
    // je sélectionne l'élément dont l'id=longitude et je lui affecte la longitude de
    // l'objet lieu recréé
    document.querySelector('#longitude').value= lieu.longitude;
}

//------------------------------------

/**
 * Méthode qui permet de sélectionner une ville et qui sera appelée
 * pour mettre à jour les lieux en fonction de la ville
 */
function changerVille()
{
    // je récupère l'id de la ville dans l'élément dont l'id=ville et
    // je l'affecte à la variable villeId
    let villeId = document.querySelector('#ville').value;

    afficherLieu(villeId);// affiche les lieux en fonction de la ville
    afficherCP(villeId);// met à jour le code postal en fonction de la ville
}

//------------------------------------

/**
 * Méthode qui affiche le menu déroulant des lieux relatifs à une ville sélectionnée dans le
 * menu déroulant précédent
 * @param villeId
 */
function afficherLieu(villeId)
{
    // on cible l'élément dont l'id=lieu
    let selectLieu = document.querySelector('#lieu');
    //on vide la variable selectLieu
    selectLieu.innerHTML ='';
    // je parcours les lieux pour trouver la bonne ville
    for (let l of lieux)
    {
        if(villeId == l.ville)
        {
            console.log('ok');
            let option = document.createElement('option'); //<option></option>
            option.setAttribute('value',l.id); //<option value="42"></option>
            option.textContent = l.nom; //<option value="42"> rouge</option>
            selectLieu.appendChild(option);
        }
    }
}

//------------------------------------

/**
 * Méthode qui permet d'afficher le menu déroulant des villes
 * @param tab
 */
function afficherVille(tab)
{
    for (v of tab)
    {
        let option = document.createElement('option'); //<option></option>
        option.setAttribute('value',v.id); //<option value="42"></option>
        option.textContent = v.nom; //<option value="42"> rouge</option>
        document.querySelector('#ville').appendChild(option);
    }
}

//------------------------------------

let url = 'http://127.0.0.1:8000/sortie/api/ville-lieu/';
fetch(url)
    .then( response => response.json())
    .then(
        objet => {
            villes = objet.villes;
            lieux = objet.lieux;

            let villeId = objet.villes[0].id;
            let lieuId = objet.lieux[0].id;

            afficherVille(objet.villes);
            afficherLieu(villeId);
            afficherRue(lieuId);
            afficherCP(villeId);
            afficherLatitude(lieuId);
            afficherLongitude(lieuId);
        });