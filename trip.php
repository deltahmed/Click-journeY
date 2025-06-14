<?php
require_once "includes/config.php";


$id = $_GET['trip'] ?? null;
if ($id === null) {
    header("Location: search.php");
    exit;
}
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
                        <p>👥 Max voyageurs : <?php echo $trip['travelers'];?></p>
                        <p>👥 Max chambres : <?php echo $trip['rooms'];?></p>
                        <p>🏕️ Activité : <?php echo $trip['activity'];?></p>
                        <p>🌡️ Climat : <?php echo $trip['climate'];?></p>
                        <p>📫 Destination : <?php echo $trip['destination'];?></p>
                        <p>📈 Niveau : <?php echo $trip['level'];?></p>
                        <p>💰 prix : <?php echo $trip['price'];?>€ / personne</p>
                        <p>⭐ Note : <?php echo $trip['rating'];?>/5</p>
                        
                    </div>
                    <h2>Etapes du Voyage</h2>
                    <div class = "stages">
                        <script id="stages-data" type="application/json">
                            <?php echo json_encode($stages); ?>
                        </script>
                        <script id="selected-options-data" type="application/json">
                            <?php
                            $selectedOptions = [];
                            foreach ($_SESSION as $key => $value) {
                                if (strpos($key, $id . 'option_') === 0) {
                                    $selectedOptions[$key] = $value['id'] ?? $value;
                                }
                            }
                            echo json_encode($selectedOptions);
                            ?>
                        </script>
                        <script src="scripts/options.js"></script>
                        <form action="controllers/control_buy.php" method="post">
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
                                            <div id="options_home_<?php echo $stage['id'];?>"></div>
                                            <div id="options_transport_<?php echo $stage['id'];?>"></div>
                                            <div id="options_food_<?php echo $stage['id'];?>"></div>
                                            <div id="options_activity_<?php echo $stage['id'];?>"></div>
                                            <div id="options_other_<?php echo $stage['id'];?>"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class = "submit-btn-div" >
                                <input type="hidden" name="trip_id" id="trip_id" value="<?php echo $trip['id'];?>">

                                <label for="rooms">Chambres :</label>
                                <?php if (isset($_SESSION['rooms' . $id])) : ?>
                                    <input type="number" id="rooms" name="rooms" min="1" max="<?php echo $trip['rooms']; ?>" value=<?php echo $_SESSION['rooms' . $id]; ?>>
                                <?php else : ?>
                                    <input type="number" id="rooms" name="rooms" min="1" max="<?php echo $trip['rooms']; ?>" value="1">
                                <?php endif; ?>

                                <label for="travelers">Voyageurs :</label>
                                <?php if (isset($_SESSION['travelers' . $id])) : ?>
                                    <input type="number" id="travelers" name="travelers" min="1" max="<?php echo $trip['travelers']; ?>" value=<?php echo $_SESSION['travelers' . $id]; ?>>
                                <?php else : ?> 
                                    <input type="number" id="travelers" name="travelers" min="1" max="<?php echo $trip['travelers']; ?>" value="1">
                                <?php endif; ?>
                                <div>
                                    <!-- Ajouter un conteneur pour afficher le prix total -->
                                    <div id="total-price-container">
                                        <h3>Total à payer : <span id="total-price">0</span>€</h3>
                                    </div>

                                    <script>
                                        window.basePricePerPerson = <?php echo json_encode($trip['price']); ?>;
                                    </script>
                                    <input type="hidden" id="total_price" name="total_price" value="0">
                                    <?php if (isset($_SESSION['cart_' . $id])) : ?>
                                        <button class="submit-btn" type="submit" id="submit" name="submit" value="submit">Modifier mon panier / Acheter</button>
                                    <?php else : ?>
                                        <button class="submit-btn" type="submit" id="submit" name="submit" value="submit">Ajouter au panier / Acheter</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
                
            </div>
        </div>
        
        <?php include "views/footer.php" ?>
    </body>
</html>
