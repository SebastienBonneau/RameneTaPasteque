function afficherTableau(tableau) {
    let tbody = document.querySelector("#myTbody");
    let template = document.querySelector("#ligne");
    let urlInscrire = "http://127.0.0.1:8000/sortie/inscription/";
    let urlseDesinscrire = "http://127.0.0.1:8000/sortie/seDesinscrire/";


    for (let s of tableau){
        let urlInscrire2 = urlInscrire+s.id;
        let urlSeDesinscrire2 = urlseDesinscrire+s.id;
        // je clone le contenu du template dans une variable
        let clone = template.content.cloneNode(true);
        // je mets un sélecteur à l'interieur de la partie HTMl clonée
        let tabTd = clone.querySelectorAll("td"); // j'ai un tableau
        tabTd[0].innerHTML = s.nom;
        tabTd[1].innerHTML = s.dateHeureDebut;
        tabTd[2].innerHTML = s.dateLimiteInscription;
        tabTd[3].innerHTML = s.nbInscriptionsMax;
        tabTd[4].innerHTML = s.etat;
        if( s.userInscrit === false){
            tabTd[5].querySelector('i').setAttribute('hidden', '');
        }if (s.userInscrit === true){
            tabTd[5].querySelector('i').removeAttribute('hidden');
        }
            tabTd[6].innerHTML = s.organisateur;
        tabTd[7].querySelector('#inscrire').setAttribute('href',urlInscrire2);
        tabTd[7].querySelector('#seDesister').setAttribute('href',urlSeDesinscrire2);
        // j'ajoute la balise <tr> dans la balise tbody
        tbody.appendChild(clone);
    }
}
let url = 'http://127.0.0.1:8000/sortie/api/liste/'; // l'URL pour afficher le tableau doit être identique a l'url donner lors du lancement du serveur.
fetch(url)
    .then(response => response.json()) // renvoie au 2 eme then le body (contenu JSON)
    .then(tableau=>
    {
        console.log(tableau);
        afficherTableau(tableau);
    });