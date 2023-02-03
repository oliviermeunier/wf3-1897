

// FONCTIONS
async function onInputCity(event)
{
    // Dans un gestionnaire d'événement, event.currentTarget représente l'élément déclencheur
    const city = event.currentTarget.value; // On récupère ce qu'a écrit l'internaute dans le champ

    // Si il y a au moins 3 caractères...
    if (city.length > 2) {

        // ... on lance la recherche
        const url = 'searchCity.php?city=' + encodeURIComponent(city);
        const response = await fetch(url);
        const data = await response.json();

        displayResults(data);
    }
}

function displayResults(cities) 
{
    const container = document.getElementById('search-results');

    // On efface les précédents résultats
    container.innerHTML = ''; // On vide la section

    // On parcours le tableau de résultats
    for (const city of cities) {

        const link = document.createElement('a');
        link.href="#";
        link.textContent = city.ville_nom_reel;

        const para = document.createElement('p');
        para.appendChild(link);

        container.appendChild(para);

        link.addEventListener('click', e => {
            document.getElementById('city').value = city.ville_nom_reel;
            container.innerHTML = ''; 
        });
    }
}

// CODE PRINCIPAL 
document.getElementById('city').addEventListener('input', onInputCity);
