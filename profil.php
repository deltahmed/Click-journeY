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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['user_role'] === 'admin') {
        $user_id = $_POST["user_id"];
    }

}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");

$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$user = $stmt->fetch();
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "User not found.";
    exit;
}


$stmt = $pdo->prepare("
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
        user_trips.id AS user_trip_id, 
        user_trips.user_numbers, 
        trips.rooms, 
        user_trips.payement_status 
    FROM user_trips
    INNER JOIN trips ON user_trips.trip_id = trips.id
    WHERE user_trips.user_id = :user_id
");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <?php if ($_SESSION['user_role'] === 'admin') : ?>
                    <h1> Profil de <?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?></h1>
                <?php else : ?>
                    <h1> Votre profil </h1>
                <?php endif; ?>
                <div id="profil-msg"></div>
                <?php if (isset($_SESSION['update_error'])) : ?>
                    <p class="p-error"> <?php 
                        echo $_SESSION['update_error'];
                        unset($_SESSION['update_error']);
                    ?></p>
                <?php endif; ?>
                <form class="change-profil" action="controllers/update_profil.php" method="post"  id="change-profil" name="change-profil">
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                    <table class="profil-page-table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Information</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Email -->
                            <tr>
                                <td>E-mail</td>
                                <td>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="email"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="email" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="email" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Nom -->
                            <tr>
                                <td>Nom</td>
                                <td>
                                    <input type="text" id="last-name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="last-name"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="last-name" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="last-name" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Prénom -->
                            <tr>
                                <td>Prénom</td>
                                <td>
                                    <input type="text" id="first-name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="first-name"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="first-name" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="first-name" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Sexe -->
                            <tr>
                                <td>Sexe</td>
                                <td>
                                    <select id="gender" name="gender" >
                                        <option value="F" <?php if($user['gender'] == 'F') echo 'selected'; ?>>Madame</option>
                                        <option value="M" <?php if($user['gender'] == 'M') echo 'selected'; ?>>Monsieur</option>
                                        <option value="A" <?php if($user['gender'] == 'A') echo 'selected'; ?>>Autres</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="gender"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="gender" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="gender" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Date de naissance -->
                            <tr>
                                <td>Date de naissance</td>
                                <td>
                                    <input type="date" id="birth-date" name="birth_date" value="<?php echo htmlspecialchars($user['birth_date']); ?>">
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="birth-date"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="birth-date" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="birth-date" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Téléphone -->
                            <tr>
                                <td>Numéro de téléphone</td>
                                <td>
                                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>" pattern="[0-9]{10}" maxlength="10" inputmode="numeric" >
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="phone"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="phone" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="phone" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Adresse -->
                            <tr>
                                <td>Adresse</td>
                                <td>
                                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" >
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="address"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="address" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="address" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Code postal -->
                            <tr>
                                <td>Code postal</td>
                                <td>
                                    <input type="number" id="postal-code" name="postal_code" value="<?php echo htmlspecialchars($user['postal_code']); ?>" maxlength="5" >
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="postal-code"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="postal-code" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="postal-code" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Ville -->
                            <tr>
                                <td>Ville</td>
                                <td>
                                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" >
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="city"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="city" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="city" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Commentaire -->
                            <tr>
                                <td>Commentaire</td>
                                <td>
                                    <textarea id="issues" name="issues" cols="30" rows="2" ><?php echo htmlspecialchars($user['comment']); ?></textarea>
                                </td>
                                <td>
                                    <button type="button" class="mod-b" data-target="issues"><img class="icon"> Modifier</button>
                                    <button type="submit" class="save-btn" data-target="issues" style="display: none;">Valider</button>
                                    <button type="button" class="cancel-btn" data-target="issues" style="display: none;">Annuler</button>
                                </td>
                            </tr>

                            <!-- Date d'inscription -->
                            <tr>
                                <td>Date d'inscription</td>
                                <td>
                                    <?php echo htmlspecialchars($user['registration_date']); ?>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
            
                    <!-- <div class="profil-reset-b">
                        <div>
                            <button class="reset-b">
                            <img class="icon">
                            Réinitialiser le mot de passe
                            </button> 
                        </div>
                        
                    </div> -->
                </form>
                
            </div>
            <div class="profil-page-content">
                <?php if ($_SESSION['user_role'] === 'admin') : ?>
                    <h1> Voyages de <?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?> :</h1>
                <?php else : ?>
                    <h1> Mes Voyages :</h1>
                <?php endif; ?>
                    <?php foreach ($trips as $trip) : ?>
                        <div class="results-container-profile">
                            <a class="result-profile" href="recap_user.php?trip=<?php echo $trip['user_trip_id']; ?>">
                                <h1>🌍 <?php echo htmlspecialchars($trip['title']); ?></h1>
                                <div>
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
                            </a>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>

        
        
        <?php include "views/footer.php" ?>
    </body>
</html>