<?php 

// Documentation : php.net

// Variables : pas de déclaration, le nom commence par le signe $
$firstname = 'Alfred';

// Constantes : pas de $, nom en majuscules et _ (underscore)
const MA_CONSTANTE = 'value';

// ou bien avec la fonction define()
define('UNE_AUTRE_CONSTANTE', 10);

// Types de données

// string : chaînes de caractères
$hello = "Hello $firstname"; // avec les double "" je peux insérer directement une variable
$message = 'Hello ' . $firstname; // Opérateur de concaténation : . 

$length = strlen($message); // Récupérer la longueur d'une chaîne de caractères

// Nombres : entiers (int) et les flottants (float) 
// Opérateurs arithmétiques : +-/*%
// Opérateurs d'incrémentation : ++ --


// Booléen (bool) : true / false

// Debugger une variable en PHP
var_dump($length);

// Tableaux
$tab = [1,2,3];
$tab2 = array('titi', 'toto', 'tata');

var_dump('La première valeur du tableau $tab est : ' . $tab[0]);

// Ajouter des éléments dans un tableau
array_push($tab, 4, 5);
var_dump($tab);

// Autre syntaxe pour ajouter un élément à la fin d'un tableau
$tab[] = 6;

// Taille d'un tableau
var_dump(count($tab));

// Objets



// Conditions
if ($firstname == 'Alfred') {
    echo 'Bonjour Alfred';
}

if ($firstname == 'Alfred') {
    echo 'Bonjour Alfred';
} 
else {
    echo "Ce n'est pas Alfred";
}

switch($firstname) {
    case 'Alfred':
        // ...
        break;

    case 'Robert':
        //...
        break;

    default: 
        // ...   
}


// Boucles

// Boule for
for ($i = 1 ; $i <= 10 ; $i++) {
    echo '<p>Tour de boucle n°'.$i.'</p>';
}

// Boucle while
$j = 1;
while ($j <= 10) {
    echo '<p>Tour de boucle n°'.$j.'</p>';
    $j++;
}

// Boucle do...while
$k = 1;
do {
    echo '<p>Tour de boucle n°'.$k.'</p>';
    $k++;
} while ($k <= 10);


// Parcourir un tableau
$persons = ['Alfred', 'Sarah', 'Killian'];

// Avec la boucle for
for ($i = 0; $i < count($persons) ; $i++) {
    echo '<p>'.$persons[$i].'</p>';
}

// foreach (l'équivalent de la boucle for...of en JavaScript)
foreach ($persons as $index => $person) {
    echo '<p>Indice n°'.$index. ' : ' .$person.'</p>';
}


// Tableaux associatifs 
// -> les valeurs ne sont pas associés à un indice numérique mais à une chaîne de caractères (clé)
$recettes = [
    // CLE => VALEUR
    'couscous' => 'Ma recette de couscous',
    'tajine' => 'Ma super recette de tajine'
];

$recettes['taboulé'] = 'Ma super recette de taboulé';

$customer = [
    'firstname' => 'Alfred',
    'lastname' => 'Dupont',
    'email' => 'ad@gmail.com',
    'phone' => '0754218495'
];

echo $customer['email'] . '<br>';

foreach ($customer as $key => $value) {
    echo "<p>$key: $value</p>";
}

// Imbrication de tableaux
$customers = [
    [
        'firstname' => 'Alfred',
        'lastname' => 'Dupont',
        'email' => 'ad@gmail.com',
        'phone' => '0754218495'
    ],
    [
        'firstname' => 'Sylvie',
        'lastname' => 'Durant',
        'email' => 'sd@gmail.com',
        'phone' => '0695847432'
    ]
];

foreach ($customers as $c) {
    echo '<p>'.$c['firstname'].'</p>';
}

// Fonctions

// Définition de la fonction sayHello
function sayHello(string $name = 'world'): string // : string -> typage de la valeur de retour 
{
    $result = '<p>Hello '.$name.' ! :)</p>';
    return $result; // résultat de la fonction (l'exécution s'arrête)
}

// Exécution de la fonction sayHello
echo sayHello('Alfred'); // Hello Alfred !
$message = sayHello('Sarah'); // Hello Sarah !
echo sayHello(); // Hello world !

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <h1><?php echo "Bonjour PHP ! :)"; ?></h1>
    </header>
    <main>
        
    </main>
</body>
</html>