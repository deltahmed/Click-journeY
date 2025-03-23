<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>

    <body>
        <div class="registration-content">
            <h1>Votre compte a été créé avec succès ! Redirection...</h1>
            <p><a class="small-link" href="../login.php">Si vous n'êtes pas redirigé automatiquement cliquez ici.</a></p>
            <?php header("Refresh:1; url=../login.php"); ?>
        </div>
        
        
        <?php include "views/../footer.php" ?>
    </body>
</html>