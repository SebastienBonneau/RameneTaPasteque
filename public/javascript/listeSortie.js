
// Création de la variable tableau utilisable dans plusieurs fonctions
let tableau = [];

/**
 * Création de la méthode qui permet d'afficher le tableau js en HTML
 */
function afficherTableau(tableau) {
    //Création d'une variable qui récupère l'élément #myTbody dans le twig
    let tbody = document.querySelector("#myTbody");
    tbody.innerHTML='';
    // Création d'une variable qui récupère l'lément #ligne dans le twig
    let template = document.querySelector("#ligne");
    // Création d'une variable pour chaque lien du tableau, qui sera complétée
    // dans le tableau avec l'id de la sortie
    let urlInscrire = "http://127.0.0.1:8000/sortie/inscription/";// lien s'inscrire
    let urlDetail = "http://127.0.0.1:8000/sortie/detail/"; // lien afficher
    let urlseDesinscrire = "http://127.0.0.1:8000/sortie/seDesinscrire/"; //lien Se désister
    let urlPublier = "http://127.0.0.1:8000/sortie/publier/"; // lien publier
    let urlAnnuler = "http://127.0.0.1:8000/sortie/annuler/"; // lien annuler
    let date1 = new Date(); // Je creer une variable avec la date du jour, pas besoin de la mettre dans la boucle


    // On fait une boucle pour récupérer chaque élément d'une sortie
    // pour toutes les sorties existantes
    for (let s of tableau){
        // création des liens à insérer dans le tableau (repris de ci-dessus
        // et concaténation avec l'id de la sortie (+s.id)
        let urlInscrire2 = urlInscrire+s.id;// lien s'inscrire
        let urlDetail2 = urlDetail+s.id;//lien afficher
        let urlSeDesinscrire2 = urlseDesinscrire+s.id;//lien se désister
        let urlPublier2 = urlPublier+s.id; // lien publier
        let urlAnnuler2 = urlAnnuler+s.id; // lien annuler
        let date2 = new Date(s.dateLimiteInscription2); // Je recupere la date dans mon tableau et la stocke dans une variable
        let date3 = new Date(s.dateHeureDebut3);


        // je clone le contenu du template dans une variable
        let clone = template.content.cloneNode(true);
        // je mets un sélecteur à l'interieur de la partie HTMl clonée
        let tabTd = clone.querySelectorAll("td"); // j'ai un tableau
        // J'affecte à chaque colonne du tableau la donnée de la sortie que je souhaite afficher
        tabTd[0].innerHTML = s.nom;
        tabTd[1].innerHTML = s.dateHeureDebut;
        tabTd[2].innerHTML = s.dateLimiteInscription;
        tabTd[3].innerHTML = s.nbInscription +" / " + s.nbInscriptionsMax;
        tabTd[4].innerHTML = s.etat;
        // Colonne 'inscrit' par défaut il y a une image V que je cache si s.userInsrit est false
        if( s.userInscrit === false){
            tabTd[5].querySelector('i').setAttribute('hidden', '');

        //Dans la même colonne 'inscit', si l'user connecté est inscrit, j'enlève l'attribut hidden
        // pour que l'image soit visible
        }if (s.userInscrit === true){
            tabTd[5].querySelector('i').removeAttribute('hidden');
        }
            tabTd[6].innerHTML = s.organisateur;
        // C'est la colonne où s'affichent tous les liens ==> je les cible avec le querySelector et leur #id
        // et je les active avec setAttribute('href', urlId)
        console.log(date2 > date1);
        console.log(date2);
        console.log(date1);
        console.log(date3);
        //lien s'inscrire Condition SI user n'est pas inscrit et que la date de cloture est supperieur a la date du jour
        if( s.userInscrit === false && s.nbInscription < s.nbInscriptionsMax && s.etat === 'Ouverte' && date2 >= date1)
             {
            //j'affiche le lien "s'inscrire'
            tabTd[7].querySelector('#inscrire').setAttribute('href', urlInscrire2);
        }if (s.userInscrit === true || s.nbInscription >= s.nbInscriptionsMax || s.etat !== 'Ouverte' || date2 <= date1 )
             {
            //je cache le lien "s'inscrire"
            tabTd[7].querySelector('#inscrire').setAttribute('hidden', '');//lien "s'inscrire" caché
        }

        //lien se désister
        if (s.userInscrit === true  && date3 > date1)
            {

            // j'affiche le lien se Désister
            tabTd[7].querySelector('#seDesister').setAttribute('href', urlSeDesinscrire2);
        }if( s.userInscrit === false || date3 < date1)
            {
            //je cache le lien "se désister"
            tabTd[7].querySelector('#seDesister').setAttribute('hidden', '');
        }
        // Lien afficher
        tabTd[7].querySelector('#detail').setAttribute('href',urlDetail2);

        //Lien publier
        if (s.etat === 'Créée') {
            // je l'affiche
           tabTd[7].querySelector('#publier').setAttribute('href', urlPublier2);
        } if (s.etat !== 'Créée'){
            // je le cache
            tabTd[7].querySelector('#publier').setAttribute('hidden', '');// lien "publier"caché
        }

        //Lien annuler
         if (s.userOrganisateur === true && s.annulationPossible ===true) {
            // j'affiche le lien
            tabTd[7].querySelector('#annuler').setAttribute('href', urlAnnuler2);
       } if (s.etat ==='Annulée' || s.userOrganisateur === false) {
            // je cache le lien
          tabTd[7].querySelector('#annuler').setAttribute('hidden', '');
        }


        // j'ajoute la balise <tr> dans la balise tbody
        tbody.appendChild(clone);
    }
}

//------------------------------------

let url = 'http://127.0.0.1:8000/sortie/api/liste/'; // l'URL pour afficher le tableau doit être identique a l'url donner lors du lancement du serveur.
fetch(url)
    .then(response => response.json()) // renvoie au 2 eme then le body (contenu JSON)
    .then(tab=>
    {

        for (let s of tab)
        {
            s.dateHeureDebut2 = new Date(s.dateHeureDebut);
        }
        //let campusId = tab.campus[0].id;
        //sorties = tab.sorties;
        //afficherSortie(campusId)
        console.log(tab);
        tableau = tab;
        afficherTableau(tableau);
    });

//------------------------------------

function filtrerCampus(tab, campus)
{

    let tab2 = [];
    // si il n'y pas de nom je retourne le tableau
    if (campus != 0)
    {
        for (let s of tab){

            if (s.campus == campus)
            {
                tab2.push(s);
            }
        }
    }
    else
    {
        tab2 = tab;
    }
    return tab2;
}

//------------------------------------

function filtrerNom(tab,nom)
{
    let tab2 = [];
    // si il n'y pas de nom je retourne le tableau
    if (nom.length > 0){
        // parcourir le tableau de sortied
        for(let s of tab)
        {
            // si le nom contient des lettre de nom
            if (s.nom.indexOf(nom) != -1)
            {
                tab2.push(s);
            }
        }
    }else
    {
        tab2 = tab;
    }
    return tab2;

}

//------------------------------------
/*
function filtrerDate(tab, dateDebut, dateFin)
{
    let tab2 = [];

    if (dateFin != null)
    {
        for (let s of tab)
        {
            if (s.dateHeureDebut2 >= dateDebut && s.dateHeureDebut2 <= dateFin)
            {
                tab2.push(s);
            }
        }
        return tab2;
}
*/
//------------------------------------

function filtrerOrga(tab)
{
    let tab2 = [];
    for (let s of tab)
    {
        if (s.userOrganisateur === true)
        {
            tab2.push(s);
        }
    }
    return tab2;
}

//------------------------------------

function filtrerInscrit(tab)
{
    let tab2 = [];
    for (let s of tab)
    {
        if (s.userInscrit === true)
        {
            tab2.push(s);
        }
    }
    return tab2;
}

//------------------------------------

function filtrerNinscrit(tab)
{
    let tab2 = [];
    for (let s of tab)
    {
        if (s.userInscrit === false)
        {
            tab2.push(s);
        }
    }
    return tab2;
}

//------------------------------------

function filtrerPassees(tab)
{
    let tab2 = [];
    let date1 = new Date();
    for (let s of tab)
    {
        if (s.dateHeureDebut2 < date1)
        {
            tab2.push(s);
        }
    }
    return tab2;
}

//------------------------------------

function filtrer()
{
    //console.log('filtre !!!');
    let tableau2 = tableau;
    //---
    let campus = document.querySelector('#campus').value;
    tableau2 = filtrerCampus(tableau2, campus);
    //---
    let nom = document.querySelector('#filtreNom').value;
    tableau2 = filtrerNom(tableau2,nom);
    //---
    /*
    let dateDebut = document.querySelector('#dateDebut').value;
    let dateFin = document.querySelector('#dateFin').value;
    if (dateDebut && dateFin){
        tableau2 = filtrerDate(tableau2, dateDebut, dateFin);
    }
    */
    //---
    let critereOrga = document.querySelector('#critereOrga').checked;
    //console.log(critereOrga);
    if (critereOrga){
        tableau2 = filtrerOrga(tableau2);
    }
    //---
    let critereInscrit = document.querySelector('#critereInscrit').checked;
    //console.log(critereDate);
    if (critereInscrit){
        tableau2 = filtrerInscrit(tableau2);
    }
    //---
    let critereNinscrit = document.querySelector('#critereNinscrit').checked;
    //console.log(critereDate);
    if (critereNinscrit){
        tableau2 = filtrerNinscrit(tableau2);
    }
    //---
    let criterePassees = document.querySelector('#criterePassees').checked;
    //console.log(critereDate);
    if (criterePassees){
        tableau2 = filtrerPassees(tableau2);
    }

    afficherTableau(tableau2);

}


