<?php 

// Inclusion du fichier d'autoload de composer
require 'vendor/autoload.php';
require 'config.php';

// Import des classes PHP
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

// 1. Récupérer les données du formulaire
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$message = $_POST['message'];

// 2. Valider les données
$errors = [];
$output = [];

if (!$firstname) {
    $errors['firstname'] = 'Le champ "Prénom" est obligatoire';
}

if (!$lastname) {
    $errors['lastname'] = 'Le champ "Nom" est obligatoire';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Adresse email non valide';
}

if (strlen($message) < 15) {
    $errors['message'] = 'Le champ "Message" doit comporter au moins 15 caractères';
}

// 3. Envoyer le mail
if (empty($errors)) {
    
    try {
        $transport = Transport::fromDsn(SMTP_DSN);
        $mailer = new Mailer($transport);
        
        $objEmail = (new Email())
            ->from($email)
            ->to(EMAIL_CONTACT)
            ->subject('Nouveau message de ' . $firstname . ' ' . $lastname)
            ->html('<p>'.$message.'</p>');
        
        $mailer->send($objEmail);

        // Si tout fonctionne bien, on ajoute un message de succès en sortie
        $output['success'] = 'Votre message a bien été envoyé';
    }
    catch(Exception $e) {
        $output['errors'] = ['smtp' => $e->getMessage()];
    }

    // 4. Retourner la réponse au client (message de succès)
    echo json_encode($output);
    exit;
} 

// 4. Retourner la réponse au client (messages d'erreurs)
$output['errors'] = $errors;
echo json_encode($output);