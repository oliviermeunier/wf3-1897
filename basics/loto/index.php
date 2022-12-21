<?php 

function randomTirage1()
{
    $tirage = [];

    for ($i = 0 ; $i < 6; $i++) {
        do  {
            $randomNumber = mt_rand(1,49);
        }
        while (in_array($randomNumber, $tirage));
        $tirage[] = $randomNumber;
    }

    return $tirage;
}

function randomTirage2()
{
    $tirage = [];

    while (count($tirage) < 6) {
        $randomNumber = mt_rand(1,49);
        if(in_array($randomNumber, $tirage)) {
            continue; // je passe au tour de boucle suivant directement
        }
        array_push($tirage, $randomNumber);
    }

    return $tirage;
}

$tirage = randomTirage1();

// AFFICHAGE
// echo '<ul>';

// foreach ($tirage as $number) {
//     echo '<li>'.$number.'</li>';
// }

// echo '</ul>';

// Inclusion du fichier de template
include 'index.phtml';