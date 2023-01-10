1. Créer la base de données en important le fichier db/framework.sql dans phpmyadmin (ou autre)
2. Renommer le fichier config-example.php en config.php et le remplir avec les informations de connexion à la base de données
3. Ouvrir le dossier du projet dans un terminal et lancer la commande `composer install`
4. Lancer le serveur interne de PHP avec la commande `php -S localhost:8000 -t public`
5. Ouvrir dans le navigateur l'URL localhost:8000

Pour créer une page : 
1. Ajouter la route dans le fichier app/routes.php
2. Créer le fichier de contrôleur correspondant dans le dossier `src/controllers`
3. Si besoin créer un fichier de template dans le dossier `templates`

-> Créer les classes de modèles dont vous avez besoin en fonction de votre base de données
-> Créer des classes d'entités si vous le souhaitez