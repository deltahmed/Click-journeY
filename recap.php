<?php
require_once "includes/config.php";
require 'includes/getapikey.php'; 


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['trip_id'])) {
    header("Location: search.php");
    exit;
}


if (!isset($_SESSION['user_id'])) {
    header("Location: search.php");
    exit;
}



$id = $_SESSION['trip_id'];
$id = (int) $id;

$stmt_trips = $pdo->prepare("SELECT * FROM trips WHERE id = :id LIMIT 1");
$stmt_trips->bindParam(':id', $id, PDO::PARAM_INT);
$stmt_trips->execute();
$trip = $stmt_trips->fetch(PDO::FETCH_ASSOC);

if (!$trip) {
    header("Location: search.php");
    exit;
}

$stmt_stages = $pdo->prepare("SELECT * FROM stages WHERE trip_id = :id ORDER BY order_index ASC");
$stmt_stages->bindParam(':id', $id, PDO::PARAM_INT);
$stmt_stages->execute();
$stages = $stmt_stages->fetchAll(PDO::FETCH_ASSOC);


$transaction_id = uniqid();
$amount = number_format($trip['price'], 2, '.', '');
$seller = "MI-4_G"; 

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$base_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
$return_url = rtrim($base_url, '/') . '/public/return_payment.php';


$api_key = getAPIKey($seller);
if (!$api_key || $api_key === "zzzz") {
    $_SESSION['error'] = "Erreur API";
    header("Location: public/error.php");
}

$cost = 0;
foreach ($_SESSION as $key => $value) {
    if (strpos($key, $id . 'option_') === 0) {
        $option = $value;
        $cost += (float)$option['price'];
    }
}



$cost += 50 * ((int)$_SESSION['rooms' . $id] - 1);
$cost = ($cost + $amount) * (int)$_SESSION['travelers' . $id];
$amount = number_format($cost, 2, '.', '');


if ($amount <= 0 || $amount != $_SESSION['total_price']) {
    $_SESSION['error'] = "Erreur de prix";
    header("Location: public/error.php");
}


$control = md5($api_key . "#" . $transaction_id . "#" . $amount . "#" . $seller . "#" . $return_url . "#");

$stmt = $pdo->prepare("
    DELETE FROM user_trips
    WHERE payement_status = 'pending' AND user_id = :id
");
$stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
?>


<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        <title>Beyond Survival | Voyage</title>
        <meta charset="UTF-8">


        <link rel="icon" href="media/icons/info/info.png" type="image/icon type">
        <link rel="stylesheet" id="theme-style" type="text/css" href="styles/style.css">
        <script src="scripts/theme.js" defer></script>
    </head>
    <body class="trip-body">
        <header>
            <?php include "views/header.php" ?>
            
            <!-- Navigation bar -->
            <nav class="navbar">
                <a href="index.php">
                    <div class="home-button">
                        <img class="icon">
                        <h1>Accueil</h1>
                    </div>  
                </a>
                <a href="search.php">
                    <div class="search-button">
                        <img class="icon">
                        <h1>Rechercher</h1>
                    </div>
                </a>
            </nav>
        </header>

        <div class="trip-content">
            <div id="trip" class="trip-container">
                <div class="trip">
                    <h1>🌍 <?php echo $trip['title'];?></h1>
                    <h2>📝 <?php echo $trip['description'];?></h2>
                    <div class="trip-div">
                        <p>📅 <?php echo $trip['departure_date'];?> -  <?php echo $trip['return_date'];?></p>
                        <p>👥 Nombre de voyageurs : <?php echo $_SESSION['travelers' . $id];?></p>
                        <p>👥 Nombre de chambres : <?php echo $_SESSION['rooms' . $id];?></p>
                        <p>🏕️ Activité : <?php echo $trip['activity'];?></p>
                        <p>🌡️ Climat : <?php echo $trip['climate'];?></p>
                        <p>📫 Destination : <?php echo $trip['destination'];?></p>
                        <p>📈 Niveau : <?php echo $trip['level'];?></p>
                        <p>💰 prix : <?php echo $trip['price'];?>€ / personne</p>
                        <p>⭐ Note : <?php echo $trip['rating'];?>/5</p>
                        
                    </div>
                    <h2>Etapes du Voyage</h2>
                    <div class = "stages">
                        <form id="payment-form" action="https://www.plateforme-smc.fr/cybank/index.php" method="post">
                            <?php foreach ($stages as $stage) : ?>
                                <div class="stage">
                                    <div>
                                        <h3>Etape <?php echo $stage['order_index'];?> : <?php echo $stage['title'];?> </h3>
                                        <div>
                                            <p>📅 Durée : <?php echo $stage['duration'];?> Jours</p>
                                            <p>🏕️ Localisation : <?php echo $stage['location'];?></p>
                                            <p>🌍 GPS : <?php echo $stage['gps_position'];?></p>
                                        </div>
                                    </div>
                                    <div> 
                                        <h3> Options : </h3>
                                        <div>
                                            <div>
                                                <?php foreach ($_SESSION as $key => $value) : ?>
                                                    <?php if (strpos($key, $id . 'option_') === 0) : ?>
                                                        <?php $option = $value; ?>
                                                        <?php if ($option['stage_id'] == $stage['id']) : ?>
                                                            <div>
                                                                <p> <?php echo $option['title'];?> : <?php echo $option['price'];?>€</p>
                                                                <input type="hidden" name="<?php echo $id . 'option_' . $option['id'];?>" value="<?php echo $id . 'option_' . $option['id'];?>">
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div>
                                <h3>Total à payer : <?php echo $amount; ?>€</h3>
                            </div>
                            <div class = "submit-btn-div" >
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                <input type="hidden" name="un_id" value="<?php echo $_SESSION['un_id']; ?>">
                                <input type="hidden" name="trip_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="user_numbers" value="<?php echo $_SESSION['travelers' . $id]; ?>">
                                <input type="hidden" name="transaction" value="<?php echo $transaction_id; ?>">
                                <input type="hidden" name="montant" value="<?php echo $amount; ?>">
                                <input type="hidden" name="vendeur" value="<?php echo $seller; ?>">
                                <input type="hidden" name="retour" value="<?php echo $return_url; ?>">
                                <input type="hidden" name="control" value="<?php echo $control; ?>">
                                
                                <a class="submit-btn" href="trip.php?trip=<?php echo $trip['id'];?>">Modifier</a>
                                <br>
                                <button class="submit-btn" value="submit">Payer</button>
                                
                            </div>
                        </form>
                        
                    </div>
                </div> 
                
            </div>
        </div>
        
        <?php include "views/footer.php" ?>
    </body>
    <?php if(isset($_SESSION['user_id'])) : ?>
        <script src="scripts/payment.js"></script>
    <?php endif; ?>
</html>