
/**
 * Callbacks : moyen de gérer l'enchaînement d'actions
 */

// FONCTIONS
function onClickBtn() 
{
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(onSuccess, onError);
    } 
    else {
        console.error('Le navigateur ne prend pas en charge la géolocalisation');
    }
}

// Callback appelé en cas de succès
function onSuccess(position) 
{
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;

    document.getElementById("text").classList.remove('hidden');
    document.getElementById("longitude").classList.remove('hidden');
    document.getElementById("lattitude").classList.remove('hidden');
    document.getElementById("longitude").textContent = lat;
    document.getElementById("lattitude").textContent = lng;
}

// Callback appelé en cas d'échec
function onError(error)
{
    console.error(error.message);
}

// CODE PRINCIPAL (en dehors de toute fonction)
document.getElementById("geolocate-btn").addEventListener("click", onClickBtn);



/**
 * Promesse : ça permet de gérer une action qui prend un certain temps et qui peut échouer
 */

// Exemple de création d'une promesse
const tirerUnNombrePair = new Promise(function(resolve, reject) {

    // Fonction qui fait une action qui peut prendre un certain temps et qui peut échouer
    
    // On simule une action qui prend 2 secondes pour se faire
    setTimeout(function(){

        // On tire un entier aléatoire entre 0 et 10
        const num = Math.floor(Math.random() * 10);

        // Si l'entier est pair, on a gagné
        if (num % 2 == 0) {

            // Le reste de la division par 2 est égal à 0 => le nombre est pair
            resolve(num);
        }
        // Si l'entier est impair, on a perdu
        else {
            // Sinon le nombre est impair
            reject(num);
        }
    }, 2000);
});

// Exploitation de la promesse
tirerUnNombrePair
    .then(function(num) {
        // Cette fonction est appelée en cas de résolution de la promesse (succès, appel de resolve()) 
        console.log(`GAGNE : le nombre ${num} est pair !`);
    })
    .catch(function(num) {
        // Cette fonction est appelée en cas de rejet de la promesse (échec, appel de reject()) 
        console.log(`PERDU : le nombre ${num} est impair !`)
    });
