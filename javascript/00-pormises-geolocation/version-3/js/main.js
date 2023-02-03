
/**
 * Callbacks : moyen de gérer l'enchaînement d'actions
 */

// FONCTIONS
function onClickBtn() 
{
    getCoords() // Je vais chercher les coordonnées de l'internaute... 
        .then(displayPosition) // ... quand je les ai je les affiche
        .catch(console.error);
}

/**
 * La fonction getCoords() retourne la promesse
 * @returns Promise
 */
function getCoords()
{
    return new Promise(function(resolve, reject) {

        // Si  l'API de géolocalisation est disponible dans le navigateur de l'internaute
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(resolve, reject);
        } 
        // L'API n'est pas disponible
        else {
            reject('Le navigateur ne prend pas en charge la géolocalisation');
        }
    });
}

// Callback appelé en cas de succès
function displayPosition(position) 
{
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;

    document.getElementById("text").classList.remove('hidden');
    document.getElementById("longitude").classList.remove('hidden');
    document.getElementById("lattitude").classList.remove('hidden');
    document.getElementById("longitude").textContent = lat;
    document.getElementById("lattitude").textContent = lng;
}

// CODE PRINCIPAL (en dehors de toute fonction)
document.getElementById("geolocate-btn").addEventListener("click", onClickBtn);



