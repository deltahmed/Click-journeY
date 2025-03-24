<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}
?>
<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        <title>Beyond Survival | Créer un Compte </title>
        <meta charset="UTF-8">


        <link rel="icon" href="media/icons/account/account.png" type="image/icon type">
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
                <a href="search.php">
                    <div class="search-button">
                        <img class="icon">
                        <h1>Rechercher</h1>
                    </div>
                </a>
            </nav>
        </header>
        <div class="registration-content">
            <h1>Inscription</h1>
            <?php if (isset($_SESSION['sign_in_up_error'])) : ?>
                <p class="p-error"> <?php 
                    echo $_SESSION['sign_in_up_error'];
                    unset($_SESSION['sign_in_up_error']);
                ?></p>
            <?php endif; ?>
            <form class="registration-form" action="controllers/control_signup.php" method="post"  id="registration-form" name="account-creation">
                <div>
                    <label class="form-label" for="gender">Genre :</label>
                    <label class="form-label" for="gender"><input type="radio" name="gender" value="M">Madame</label>
                    <label class="form-label" for="gender"><input type="radio" name="gender" value="F">Monsieur</label>
                    <label class="form-label" for="gender"><input type="radio" name="gender" value="A">Autres</label>
                </div>
                
            
                <label class="form-label" for="last-name">Nom :</label>
                <input type="text" id="last-name" name="last_name" required>
            
                <label class="form-label" for="first-name">Prénom :</label>
                <input type="text" id="first-name" name="first_name" required>

                <label class="form-label" for="birth-date">Date de naissance :</label>
                <input type="date" id="birth-date" name="birth_date" required>
            
                <label class="form-label" for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            
                <label class="form-label" for="issues">Problèmes particuliers :</label>
                <textarea id="issues" name="issues" cols="30" rows="2"></textarea>
            
                <label class="form-label" for="address">Adresse :</label>
                <input type="text" id="address" name="address" required>
            
                <label class="form-label" for="postal-code">Code postal :</label>
                <input type="number" id="postal-code" name="postal_code" maxlength="5" required>
            
                <label class="form-label" for="city">Ville :</label>
                <input type="text" id="city" name="city" required>
            
                <label class="form-label" for="phone">Numéro de téléphone :</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" inputmode="numeric" maxlength="10">
            
                <label class="form-label" for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" maxlength="15" required>
            
                <label class="form-label" for="confirm-password">Confirmer le mot de passe :</label>
                <input type="password" id="confirm-password" name="confirm_password" maxlength="15" required>
                <div>
                    <button class="submit-btn" type="submit" id="submit" name="submit" value="submit">Créer mon compte</button>
                </div>
                <div>
                    <a class="small-link" href="login.php">Vous avez déja un compte ? Cliquez ici pour se connecter</a>
                </div>
                
            </form>
        </div>
        
        
        <?php include "views/footer.php" ?>
    </body>
</html>