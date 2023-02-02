
/**
 * Callbacks : moyen de gérer l'enchaînement d'actions
 */

// FONCTIONS
function onClickBtn() 
{
    const getCoords = new Promise(function(resolve, reject) {

        // Si  l'API de géolocalisation est disponible dans le navigateur de l'internaute
        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(

                // Callback de succès
                function(position) {
                    resolve(position);
                }, 

                // Callback d'échec
                function(error) {
                    reject(error.message);
                }
            );
        } 
        // L'API n'est pas disponible
        else {
            reject('Le navigateur ne prend pas en charge la géolocalisation');
        }
    });

    getCoords
        .then(function(position){
            displayPosition(position);
        })
        .catch(function(error) {
            console.error(error);
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



