<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../includes/config.php';
require '../includes/getapikey.php';

// Vérifier que les paramètres sont bien envoyés par CY Bank
if (!isset($_GET['transaction'], $_GET['montant'], $_GET['vendeur'], $_GET['status'], $_GET['control'])) {
    die("❌ Données de paiement invalides.");
}

$transaction = $_GET['transaction'];
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$status = $_GET['status'];
$control_received = $_GET['control'];

// Récupérer la clé API du vendeur
$api_key = getAPIKey($vendeur);
if (!$api_key || $api_key === "zzzz") {
    die("❌ Erreur API Key : Le vendeur n'est pas valide.");
}

// Recalculer la signature de contrôle
$control_calculated = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

// Vérifier si la signature est correcte
if ($control_received !== $control_calculated) {
    die("❌ Erreur retour : La valeur de contrôle est erronée.");
}

?>
<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        
        <title>Beyond Survival | Connexion</title>
        <meta charset="UTF-8">


        <link rel="icon" href="../media/icons/account/account.png" type="image/icon type">
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>

    <body>
        <div class="login-content">       
            <?php if ($status === "accepted") :?>
                <h1>✅ Paiement réussi !</h1>
                <p>Merci pour votre achat.</p>
                <p><a class="small-link" href="../search.php">Cliquez ici pour retourner a la boutique cliquez ici.</a></p>
            <?php else : ?>
                <h1>❌ Paiement refusé</h1>
                <p>Le paiement a été refusé. Veuillez réessayer.</p>
                <p><a class="small-link" href="../trip.php?trip=<?php echo $_SESSION['trip_id'] ?>">Cliquez ici pour retourner a la boutique cliquez ici.</a></p>
            <?php endif; ?>
            
        </div>
        



        
        <?php include "../views/footer.php" ?>
    </body>
</html>