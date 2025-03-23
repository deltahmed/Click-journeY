<?php
require_once "includes/config.php";

$row_number = 0;


$stmt = $pdo->prepare("SELECT * FROM trips LIMIT WHERE 1=1");

$title = $_GET['title'] ?? null;
$price = $_GET['price'] ?? null;
$travelers = $_GET['travelers'] ?? null;
$rooms = $_GET['rooms'] ?? null;
$level = $_GET['level'] ?? null;
$activity = $_GET['activity'] ?? null;
$destination = $_GET['destination'] ?? null;
$climate = $_GET['climate'] ?? null;
$departure_date = $_GET['departure_date'] ?? null;
$return_date = $_GET['return_date'] ?? null;
$rating = $_GET['rating'] ?? 5;
$sort = $_GET['sort'] ?? 'recommended';
$q = $_GET['q'] ?? null;

$sql = "SELECT * FROM trips WHERE 1=1";

if (!empty($travelers)) {
    $sql .= " AND travelers >= :travelers";
}
if (!empty($rooms)) {
    $sql .= " AND rooms >= :rooms";
}
if (!empty($level)) {
    $sql .= " AND level = :level";
}
if (!empty($activity)) {
    $sql .= " AND activity = :activity";
}
if (!empty($destination)) {
    $sql .= " AND destination = :destination";
}
if (!empty($climate)) {
    $sql .= " AND climate = :climate";
}
if (!empty($departure_date)) {
    $sql .= " AND departure_date >= :departure_date";
}
if (!empty($return_date)) {
    $sql .= " AND return_date <= :return_date";
}

try {
    $stmt = $pdo->prepare($sql);

    
    if (!empty($travelers)) {
        $stmt->bindParam(':travelers', $travelers, PDO::PARAM_INT);
    }
    if (!empty($rooms)) {
        $stmt->bindParam(':rooms', $rooms, PDO::PARAM_INT);
    }
    if (!empty($level)) {
        $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    }
    if (!empty($activity)) {
        $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
    }
    if (!empty($destination)) {
        $stmt->bindParam(':destination', $destination, PDO::PARAM_STR);
    }
    if (!empty($climate)) {
        $stmt->bindParam(':climate', $climate, PDO::PARAM_STR);
    }
    if (!empty($departure_date)) {
        $stmt->bindParam(':departure_date', $departure_date, PDO::PARAM_STR);
    }
    if (!empty($return_date)) {
        $stmt->bindParam(':return_date', $return_date, PDO::PARAM_STR);
    }

    $stmt->execute();
    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la recherche : " . $e->getMessage());
}

function SearchWordInText($texte, $search_words) {
    // Convertir en minuscules
    $texte = strtolower($texte);
    $search_words = array_map('strtolower', explode(" ", $search_words));

    // Découper le texte en mots
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

?>


<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        <title>Beyond Survival | Rechercher</title>
        <meta charset="UTF-8">


        <link rel="icon" href="media/icons/compass/compass.png" type="image/icon type">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
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
                        <input type="text" name="q" placeholder="Rechercher une aventure..." required>
                        <button type="submit">Rechercher</button>
                    </form>
                </div>
                <script>
                    const card = document.getElementById("search-overlay");
                    
                    document.addEventListener("mousemove", (e) => {
                        const { clientX, clientY } = e;
                        const { innerWidth, innerHeight } = window;
                        const xRotation = ((clientY / innerHeight) - 0.5) * 30;
                        const yRotation = ((clientX / innerWidth) - 0.5) * -30;
                        
                        card.style.transform = `perspective(1000px) rotateX(${xRotation}deg) rotateY(${yRotation}deg)`;
                    });
                </script>
            </section>
            <!-- For the final web site search.php will be search.php -->
            <form action="search.php" method="get" class="travel-form">
                <h2>Recherche :</h2>
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
                            <option value="beginner">Débutant</option>
                            <option value="intermediate">Intermédiaire</option>
                            <option value="advanced">Confirmé</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="activity">Activité :</label>
                        <select id="activity" name="activity">
                            <option value="wilderness-survival">Survie en pleine nature</option>
                            <option value="survival-training">Stage de survie</option>
                            <option value="survival-escape-game">Escape-game de survie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination :</label>
                        <select id="destination" name="destination">
                            <option value="france">France</option>
                            <option value="canada">Canada</option>
                            <option value="australia">Australie</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="climate">Climat :</label>
                        <select id="climate" name="climate">
                            <option value="arid-desert">Déserts arides</option>
                            <option value="lush-jungle">Jungles luxuriantes</option>
                            <option value="dense-forest">Forêts denses</option>
                            <option value="polar-regions">Régions polaires</option>
                            <option value="rugged-mountains">Montagnes escarpées</option>
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
                            <option value="recommended">Recommandés</option>
                            <option value="price-asc">Prix (croissant)</option>
                            <option value="price-desc">Prix (décroissant)</option>
                            <option value="traveler-rating">Note des voyageurs</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="submit-btn">Rechercher</button>
                    </div>
                </div>
            </form>  
            <?php foreach ($trips as $trip) : ?>
                <?php 
                $concat = $trip['title'] . " " . $trip['activity'] . " " . $trip['destination'] . " " . $trip['climate'] . " " . $trip['level'] . " " . $trip['price'] . " " . $trip['rating'] . " " . $trip['departure_date'] . " " . $trip['return_date'] . " " . $trip['travelers'] . " " . $trip['rooms'];
                if (!empty($q) && !SearchWordInText($concat, $q)) {
                    continue;
                }
                $row_number++;
                ?>
                <div id="results" class="results-container">
                    <a class="result" href="#">
                        <h1>🌍 <?php echo $trip['title'];?></h1>
                        <div>
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
                        
                        
                    </a>
                </div> 
            <?php endforeach; ?>

            <?php if ($row_number === 0) : ?>
                <div class="login-content">
                    <h1>Aucun résultat trouvé</h1>
                    <p>Essayez une autre recherche.</p>
                </div>
            <?php endif; ?>
                    
        </div>

        
        
        <?php include "views/footer.php" ?>
    </body>
</html>