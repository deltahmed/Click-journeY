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
        
        <title>Beyond Survival | Connexion</title>
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
        <div class="login-content">
            <h1>Connexion</h1>
            <form class="registration-form" action="controllers/control_login.php" method="post" id="login-form" name="login">
                <label class="form-label" for="email">Email :</label>
                <input type="email" id="email" name="email">
            
                <label class="form-label" for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" maxlength="15">
                
                <div>
                    <label class="stay-conected" for="stay-conected">
                        <input type="checkbox" id="stay-conected" name="stay-conected"> Rester connecté
                    </label> 
                </div>
                

                


                <div class="submit-btn-div">
                    <button class="submit-btn" type="submit" id="submit" name="submit" value="submit">Connexion</button>
                    
                </div>
                <div>
                    <a class="small-link" href="signup.php">Vous n'avez pas de compte ? Cliquez ici pour s'inscrire</a>
                </div>
                
            </form>
        </div>
        
        
        <?php include "views/footer.php" ?>
    </body>
</html>