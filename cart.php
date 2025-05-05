<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["user_id"]) !== true) {
    header("Location: index.php");
    exit;
}

require_once "includes/config.php";

$user_id = $_SESSION['user_id'];



?>
<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        <title>Beyond Survival | Profil</title>
        <meta charset="UTF-8">


        <link rel="icon" href="media/icons/account/account.png" type="image/icon type">
        <link rel="stylesheet" id="theme-style" type="text/css" href="styles/style.css">
        <script src="scripts/theme.js" defer></script>
        <script src="scripts/profil.js" defer></script>
    </head>

    <body>
        <header>
            <!-- The main banner with the logo -->
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
        <div class="profil-page-overlay">
            <div class="profil-page-content">
                <h1>Mon panier</h1>
                    
                    <?php foreach ($_SESSION as $key => $value) : ?>
                        <?php if (strpos($key, 'cart_') === 0) : ?>
                            <?php $trip = $value ?>
                            <?php $trip_id =  str_replace('cart_', '', $key); ?>
                            <div class="results-container-profile">
                                <a class="result-profile" href="trip.php?trip=<?php echo $trip_id; ?>">
                                    <h1>🌍 <?php echo htmlspecialchars($trip['title']); ?></h1>
                                    <div>
                                        <p>📅 <?php echo htmlspecialchars($trip['departure_date']); ?> - <?php echo htmlspecialchars($trip['return_date']); ?></p>
                                        <p>👥 Nombre de voyageurs : <?php echo $_SESSION['travelers' . $trip_id]; ?></p>
                                        <p>👥 Nombre de chambres : <?php echo $_SESSION['rooms' . $trip_id]; ?></p>
                                        <p>🏕️ Activité : <?php echo htmlspecialchars($trip['activity']); ?></p>
                                        <p>🌡️ Climat : <?php echo htmlspecialchars($trip['climate']); ?></p>
                                        <p>📫 Destination : <?php echo htmlspecialchars($trip['destination']); ?></p>
                                        <p>📈 Niveau : <?php echo htmlspecialchars($trip['level']); ?></p>
                                        <p>💰 Prix : <?php echo $_SESSION['price' . $trip_id]; ?>€</p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <br>
                    <a href="controllers/delete_cart.php" class="button_page">Supprimer mon panier</a>
            </div>
        </div>

        
        
        <?php include "views/footer.php" ?>
    </body>
</html>