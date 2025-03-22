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

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");

$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$user = $stmt->fetch();
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "User not found.";
    exit;
}
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
        <link rel="stylesheet" type="text/css" href="style.css">
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
                <h1> Votre profil </h1>
                <form class="change-profil" action="change-profil.php" method="post"  id="change-profil" name="change-profil">
                    <table class="profil-page-table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Information</th>
                                <th>Remplacement</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>E-mail</td>
                                    <td>
                                        <?php echo $user['email']; ?>
                                    </td>
                                    <td>    
                                        <input type="email" id="email" name="email">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Nom</td>
                                    <td>
                                        <?php echo $user['last_name']; ?>
                                    </td>
                                    <td>    
                                        <input type="text" id="last-name" name="last_name">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Prénom</td>
                                    <td>
                                        <?php echo $user['first_name']; ?>
                                    </td>
                                    <td>    
                                        <input type="text" id="first-name" name="first_name">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Sexe</td>
                                    <td>
                                        <?php echo $user['gender']; ?>
                                    </td>
                                    <td>
                                        <label class="form-label" for="gender"><input type="radio" name="gender" value="Madame">Madame</label>
                                        <label class="form-label" for="gender"><input type="radio" name="gender" value="Monsieur">Monsieur</label>
                                        <label class="form-label" for="gender"><input type="radio" name="gender" value="Autres">Autres</label>
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Date de naissance</td>
                                    <td>
                                        <?php echo $user['birth_date']; ?>
                                    </td>
                                    <td>    
                                        <input type="date" id="birth-date" name="birth_date">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Numéro de téléphone</td>
                                    <td>
                                        <?php echo $user['phone_number']; ?>
                                    </td>
                                    <td>    
                                        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" inputmode="numeric" maxlength="10">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Adresse</td>
                                    <td>
                                        <?php echo $user['address']; ?>
                                    </td>
                                    <td>    
                                        <input type="text" id="address" name="address">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Code postal</td>
                                    <td>
                                        <?php echo $user['postal_code']; ?>
                                    </td>
                                    <td>    
                                        <input type="number" id="postal-code" name="postal_code" maxlength="5">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Ville</td>
                                    <td>
                                        <?php echo $user['city']; ?>
                                    </td>
                                    <td>    
                                        <input type="text" id="city" name="city">
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <form class="registration-form"  method="post"  id="registration-form" name="account-creation">
                                    <td>Commentaire</td>
                                    <td>
                                       <?php echo $user['comment']; ?>
                                    </td>
                                    <td>
                                        <textarea id="issues" name="issues" cols="30" rows="2"></textarea>
                                    </td>
                                    <td>
                                        <button type="submit" id="submit" name="submit" value="submit" class="mod-b">
                                            <img class="icon">
                                            Modifier
                                        </button>
                                    </td>
                                </form>
                            </tr>
                            <tr>
                                <td>Date d'Inscription</td>
                                <td>
                                    <?php echo $user['registration_date']; ?>
                                </td>
                                <td>    
                                </td>
                                <td>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            
                    <div class="profil-reset-b">
                        <div>
                            <button class="reset-b">
                            <img class="icon">
                            Réinitialiser le mot de passe
                            </button> 
                        </div>
                        
                    </div>
                    
            </div>
        </div>
        
        <?php include "views/footer.php" ?>
    </body>
</html>