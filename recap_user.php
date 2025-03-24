<?php
require_once "includes/config.php";
require 'includes/getapikey.php'; 


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'];
$un_id = $_SESSION['un_id'];

if(!verifyUnId($pdo, $_SESSION['user_id'], $un_id)){
    header("Location: controllers/control_logout.php");
    exit;
}

$user_trips_id = $_GET['trip'] ?? null;
if ($user_trips_id === null) {
    header("Location: profil.php");
    exit;
}


$stmt_trips = $pdo->prepare("
    SELECT 
        trips.id, 
        trips.title, 
        trips.departure_date, 
        trips.return_date, 
        trips.activity, 
        trips.climate, 
        trips.destination, 
        trips.level, 
        trips.price,
        trips.description,
        user_trips.id AS user_trip_id, 
        user_trips.user_numbers, 
        trips.rooms, 
        user_trips.payement_status 
    FROM user_trips
    INNER JOIN trips ON user_trips.trip_id = trips.id
    WHERE user_trips.id = :user_trip_id
");

$stmt_trips->bindParam(':user_trip_id', $user_trips_id, PDO::PARAM_INT);
$stmt_trips->execute();
$trip = $stmt_trips->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    SELECT 
        stages.id AS stage_id,
        stages.title AS stage_title,
        stages.gps_position AS stage_gps_position,
        stages.location AS stage_location,
        stages.duration AS stage_duration,
        stages.order_index AS stage_order_index,
        options.id AS option_id,
        options.title AS option_title,
        options.price AS option_price
    FROM stages
    LEFT JOIN options ON options.stage_id = stages.id
    LEFT JOIN options_user_trips ON options.id = options_user_trips.option_id
    WHERE options_user_trips.user_trip_id = :user_trip_id
    ORDER BY stages.order_index ASC, options.id ASC
");
$stmt->bindParam(':user_trip_id', $user_trips_id, PDO::PARAM_INT);
$stmt->execute();
$options_by_stage = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->bindParam(':user_trip_id', $user_trips_id, PDO::PARAM_INT);
$stmt->execute();
$options_by_stage = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stages_with_options = [];
foreach ($options_by_stage as $row) {
    $stage_id = $row['stage_id'] ?? null; 
    if ($stage_id === null) {
        continue; 
    }
    if (!isset($stages_with_options[$stage_id])) {
        $stages_with_options[$stage_id] = [
            'stage_title' => $row['stage_title'] ?? 'N/A',
            'stage_order_index' => $row['stage_order_index'] ?? 0,
            'stage_duration' => $row['stage_duration'] ?? 'N/A',
            'stage_location' => $row['stage_location'] ?? 'N/A',
            'stage_gps_position' => $row['stage_gps_position'] ?? 'N/A',
            'options' => []
        ];
    }

    // Ajout de l'option à l'étape
    if (!empty($row['option_id'])) {
        $stages_with_options[$stage_id]['options'][] = [
            'option_id' => $row['option_id'],
            'option_title' => $row['option_title'] ?? 'N/A',
            'option_price' => $row['option_price'] ?? 0
        ];
    }
}


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
        <link rel="stylesheet" type="text/css" href="style.css">
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
                    <p>📅 <?php echo htmlspecialchars($trip['departure_date']); ?> - <?php echo htmlspecialchars($trip['return_date']); ?></p>
                                    <p>👥 Nombre de voyageurs : <?php echo htmlspecialchars($trip['user_numbers']); ?></p>
                                    <p>👥 Nombre de chambres : <?php echo htmlspecialchars($trip['rooms']); ?></p>
                                    <p>🏕️ Activité : <?php echo htmlspecialchars($trip['activity']); ?></p>
                                    <p>🌡️ Climat : <?php echo htmlspecialchars($trip['climate']); ?></p>
                                    <p>📫 Destination : <?php echo htmlspecialchars($trip['destination']); ?></p>
                                    <p>📈 Niveau : <?php echo htmlspecialchars($trip['level']); ?></p>
                                    <p>💰 Paiement de : <?php echo htmlspecialchars($trip['price']); ?>€</p>
                                    <p>💰 Statut du paiement : <?php echo htmlspecialchars($trip['payement_status']); ?></p>
                        
                    </div>
                    <h2>Etapes du Voyage</h2>
                    <div class = "stages">
                        <?php foreach ($stages_with_options as $stage) : ?>
                            <div class="stage">
                                <div>
                                    <h3>Etape <?php echo $stage['stage_order_index'];?> : <?php echo $stage['stage_title'];?> </h3>
                                    <div>
                                        <p>📅 Durée : <?php echo $stage['stage_duration'];?> Jours</p>
                                        <p>🏕️ Localisation : <?php echo $stage['stage_location'];?></p>
                                        <p>🌍 GPS : <?php echo $stage['stage_gps_position'];?></p>
                                    </div>
                                </div>
                                <div> 
                                    <h3> Options : </h3>
                                    <div>
                                        <div>
                                            <?php foreach ($stage['options'] as $option) : ?>
                                                    <div>
                                                        <p> <?php echo $option['option_title'];?> : <?php echo $option['option_price'];?>€</p>
                                                    </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        <?php endforeach; ?>

                    
                    </div>
                    <a class="submit-btn" href="profil.php">Retour</a>
                </div> 
                
            </div>
        </div>
        
        <?php include "views/footer.php" ?>
    </body>
</html>