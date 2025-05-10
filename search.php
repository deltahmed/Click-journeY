<?php
require_once "includes/config.php";

$q = $_GET['q'] ?? null;

function SearchWordInText($texte, $search_words) {
    $texte = strtolower($texte);
    $search_words = array_map('strtolower', explode(" ", $search_words));

    $motsTexte = preg_split('/[\s\-]+/', $texte);

    foreach ($search_words as $search_word) {
        $find_word = false;

        foreach ($motsTexte as $motTexte) {
            if ($motTexte === $search_word) {
                $find_word = true;
                break;
            }

            similar_text($motTexte, $search_word, $percent);
            if ($percent > 80) {
                $find_word = true;
                break;
            }

            if (levenshtein($motTexte, $search_word) <= 2) {
                $find_word = true;
                break;
            }
            if (soundex($motTexte) === soundex($search_word)) {
                $find_word = true;
                break;
            }
        }
        if (!$find_word) {
            return false;
        }
    }

    return true;
}

try {

    $stmt = $pdo->prepare("SELECT * FROM trips");
    $stmt->execute();
    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($trips as $key => $trip) {
        $concat = $trip['description'] . " " . $trip['title'] . " " . $trip['activity'] . " " . $trip['destination'] . " " . $trip['climate'] . " " . $trip['level'] . " " . $trip['price'] . " " . $trip['rating'] . " " . $trip['departure_date'] . " " . $trip['return_date'] . " " . $trip['travelers'] . " " . $trip['rooms'];
        if (!empty($q) && !SearchWordInText($concat, $q)) {
            unset($trips[$key]);
            continue;
        }
    }

    $allTripsJson = json_encode(array_values($trips));
} catch (PDOException $e) {
    $_SESSION['error'] = "Erreur de recherche";
    header("Location: public/error.php");
    exit;
}
?>

<html lang="fr">
    <head>
        <meta name="name" content="Beyond Survival" />
        <meta name="description" content="A travel agency for Survival" />
        <meta name="keywords" content="Travel, Survival" />
        <meta name="tags" content="Travel, Survival" />
        <title>Beyond Survival | Rechercher</title>
        <meta charset="UTF-8">
        <link rel="icon" href="media/icons/compass/compass.png" type="image/icon type">
        <link rel="stylesheet" id="theme-style" type="text/css" href="styles/style.css">
        <script src="scripts/theme.js" defer></script>
    </head>

    <body>
        <header>
            <?php include "views/header.php"; ?>
            <nav class="navbar">
                <a href="index.php">
                    <div class="home-button">
                        <img class="icon">
                        <h1>Accueil</h1>
                    </div>
                </a>
                <a href="presentation.php">
                    <div class="pres-button">
                        <img class="icon">
                        <h1>Présentation</h1>
                    </div>
                </a>
            </nav>
        </header>

        <div class="search-content">
            <section class="search-section">
                <div class="search-overlay" id="search-overlay">
                    <h2>Bienvenue chez Beyond Survival</h2>
                    <p>Découvrez nos stages, immersions et escape games pour tester vos limites.</p>
                    <form class="search-form" action="search.php" method="get">
                        <input type="text" name="q" placeholder="Rechercher une aventure..." value="<?php echo $q; ?>">
                        <button type="submit">Rechercher</button>
                    </form>
                </div>
                <script src="scripts/card.js" defer></script>
            </section>
            <form class="travel-form">
                <h2>Recherche Avancée :</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="travelers">Voyageurs :</label>
                        <input type="number" id="travelers" name="travelers" min="1" max="10">
                    </div>
                    <div class="form-group">
                        <label for="rooms">Chambres :</label>
                        <input type="number" id="rooms" name="rooms" min="1" max="5">
                    </div>
                    <div class="form-group">
                        <label for="level">Niveau :</label>
                        <select id="level" name="level">
                            <option value=""></option>
                            <option value="beginner">Débutant</option>
                            <option value="intermediate">Intermédiaire</option>
                            <option value="advanced">Confirmé</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="activity">Activité :</label>
                        <select id="activity" name="activity">
                            <option value=""></option>
                            <option value="wilderness-survival">Survie en pleine nature</option>
                            <option value="survival-training">Stage de survie</option>
                            <option value="survival-escape-game">Escape-game de survie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination :</label>
                        <input type="text" id="destination" name="destination">
                    </div>
                    <div class="form-group">
                        <label for="climate">Climat :</label>
                        <select id="climate" name="climate">
                            <option value=""></option>
                            <option value="arid-desert">Déserts arides</option>
                            <option value="lush-jungle">Jungles luxuriantes</option>
                            <option value="dense-forest">Forêts denses</option>
                            <option value="polar-regions">Régions polaires</option>
                            <option value="rugged-mountains">Montagnes escarpées</option>
                            <option value="volcanic-terrain">Terrain volcanique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="departure-date">Départ :</label>
                        <input type="date" id="departure-date" name="departure_date">
                    </div>
                    <div class="form-group">
                        <label for="return-date">Retour :</label>
                        <input type="date" id="return-date" name="return_date">
                    </div>
                    <div class="form-group">
                        <label for="sort">Trier :</label>
                        <select id="sort" name="sort">
                            <option value="recommended">Recommandé</option>
                            <option value="price-asc">Prix (croissant)</option>
                            <option value="price-desc">Prix (décroissant)</option>
                            <option value="traveler-rating">Note des voyageurs</option>
                        </select>
                    </div>
                </div>
            </form>
            <div id="pagination" class="pagination-container"></div>
            <div id="search-results"></div>
        </div>

        <script>
            const allTrips = <?php echo $allTripsJson; ?>;
            
        </script>
        <script src="scripts/search.js" defer></script>
    </body>
</html>
