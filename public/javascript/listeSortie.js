/**
 * Création de la méthode qui permet d'afficher le tableau
 */
function afficherTableau(tableau) {
    //Création d'une variable qui récupère l'élément #myTbody dans le twig
    let tbody = document.querySelector("#myTbody");
    // Création d'une variable qui récupère l'lément #ligne dans le twig
    let template = document.querySelector("#ligne");
    // Création d'une variable pour chaque lien du tableau, qui sera complétée
    // dans le tableau avec l'id de la sortie
    let urlInscrire = "http://127.0.0.1:8000/sortie/inscription/";// lien s'inscrire
    let urlDetail = "http://127.0.0.1:8000/sortie/detail/"; // lien afficher
    let urlseDesinscrire = "http://127.0.0.1:8000/sortie/seDesinscrire/"; //lien Se désister
    let urlPublier = "http://127.0.0.1:8000/sortie/publier/"; // lien publier
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
        let date2 = new Date(s.dateLimiteInscription); // Je recupere la date dans mon tableau et la stocke dans une variable
        let date3 = new Date(s.dateHeureDebut);

        
    //    let urlAnnuler2 = urlAnnuler=s.id; // lien annuler

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

        //lien s'inscrire Condition SI user n'est pas inscrit et que la date de cloture est supperieur a la date du jour
        if( s.userInscrit === false || date2 > date1) {

            //j'affiche le lien "s'inscrire'
            tabTd[7].querySelector('#inscrire').setAttribute('href', urlInscrire2);
        }if (s.userInscrit === true || date2 < date1) {
            //je cache le lien "s'inscrire"
            tabTd[7].querySelector('#inscrire').setAttribute('hidden', '');//lien "s'inscrire" caché
        }

        //lien se désister
        if (s.userInscrit === true || date3 > date1) {

            // j'affiche le lien se Désister
            tabTd[7].querySelector('#seDesister').setAttribute('href', urlSeDesinscrire2);
        }if( s.userInscrit === false || date3 < date1) {
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
   /*     if (s.userOrganisateur == true) {
            // j'affiche le lien
            tabTd[7].querySelector('#annuler').setAttribute('href', urlAnnuler2);
        } if (s.userOrganisateur == false) {
            // je cache le lien
            tabTd[7].querySelector('#annuler').setAttribute('hidden', '');
        }
*/

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


