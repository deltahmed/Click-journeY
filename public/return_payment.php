<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}
if (!isset($_SESSION["un_id"])) {
    header("Location: ../index.php");
    exit;
}
require '../includes/config.php';
require '../includes/getapikey.php';


if(!verifyUnId($pdo, $_SESSION['user_id'], $_SESSION['un_id'])){
    header("Location: ../controllers/control_logout.php");
    exit;
}
$montant = $_GET['montant'];
$vendeur = $_GET['vendeur'];
$status = $_GET['status'];
$control_received = $_GET['control'];
$transaction = $_GET['transaction'];


$stmt = $pdo->prepare("
    SELECT * FROM user_trips
    WHERE id_tr = :transaction AND user_id = :user_id
");
$stmt->bindParam(':transaction', $transaction, PDO::PARAM_STR);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

$tripData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tripData) {
    $_SESSION['error'] = "❌ Transaction introuvable.";
    header("Location: error.php");
    exit;
}


if ((float)$tripData['amount'] !== (float)$montant) {
    $_SESSION['error'] = "❌ Montant incorrect.";
    header("Location: error.php");
    exit;
}

if ($tripData['payement_status'] !== 'pending') {
    $_SESSION['error'] = "❌ Statut de paiement invalide.";
    header("Location: error.php");
    exit;
}

// Vérifier que les paramètres sont bien envoyés par CY Bank
if (!isset($_GET['transaction'], $_GET['montant'], $_GET['vendeur'], $_GET['status'], $_GET['control'])) {
    $_SESSION['error'] = "❌ Données de paiement invalides.";
    header("Location: error.php");
    exit;
}




// Récupérer la clé API du vendeur
$api_key = getAPIKey($vendeur);
if (!$api_key || $api_key === "zzzz") {
    $_SESSION['error'] = "Erreur API";
    header("Location: error.php");
}

// Recalculer la signature de contrôle
$control_calculated = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $status . "#");

// Vérifier si la signature est correcte
if ($control_received !== $control_calculated) {
    $_SESSION['error'] = "Erreur Control";
    header("Location: error.php");
}

if ($status === "accepted") {
    $stmt = $pdo->prepare("
        UPDATE user_trips
        SET payement_status = 'paid'
        WHERE id_tr = :transaction
    ");
    $stmt->bindParam(':transaction', $transaction, PDO::PARAM_STR);
    $stmt->execute();
}

$stmt = $pdo->prepare("
    DELETE FROM user_trips
    WHERE payement_status = 'pending' AND user_id = :user_id
");
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();




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
        <link rel="stylesheet" id="theme-style" type="text/css" href="../styles/style.css">
        <script src="scripts/themeSwitcher.js" defer></script>
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