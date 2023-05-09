/* lesLiens contient la liste des éléments <a> correspond au lien avec le*/
var lesLiens = document.getElementsByClassName('coeurfavoris')
console.log(lesLiens);
for (var i = 0; i < lesLiens.length; i++) {
    lesLiens[i].addEventListener('click', majLike);
}

function majLike(event) {
    console.log(event);
    event.preventDefault()
    //On instancie un objet XMLHttpRequest
    let xhr = new XMLHttpRequest();

    /* utiliser la propriété parentNode pour récupérer le parent de l'élément 
   sur lequel s'est produit l'événement c’est-à-dire la balise <a> */

    // On utilise la méthode closest pour récupérer la balise <a> parente la plus proche
    let baliseA = event.target.closest('a');

    // On récupère la valeur de l'attribut href
    let url = baliseA.getAttribute('href');
    //on dump l'url et la baliseA
    console.log(baliseA);
    console.log(url);
    //On initialise notre requête avec open()
    xhr.open("GET", url);
    //On indique le format de la réponse
    xhr.responseType = "json";
    //On envoie la requête
    xhr.send();

    //Dès que la réponse est reçue...
    xhr.onload = function () {
        //Si le statut HTTP n'est pas 200...
        if (xhr.status != 200) {
            //...On affiche le statut et le message correspondant
            alert("Erreur " + xhr.status + " : " + xhr.statusText);
            //Si le statut HTTP est 200
        } else {

            //On récupère la réponse
            let reponse = xhr.response;
            //On récupère la balise <span> qui contient le nombre de likes
            let span = baliseA.querySelector('span.js-nb-likes');
            //On met à jour le nombre de likes
            span.textContent = reponse[0];

        };
    };
    //Si la requête n'a pas pu aboutir...
    xhr.onerror = function () {
        alert("La requête a échoué");
    }
}