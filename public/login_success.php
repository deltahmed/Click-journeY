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
        <div class="login-content">            
            <h1>Connexion réussie. Redirection...</h1>
            <p><a class="small-link" href="index.php">Si vous n'êtes pas redirigé automatiquement cliquez ici.</a></p>
            <?php header("Refresh:1; url=index.php"); ?>
        </div>
        



        
        <?php include "views/footer.php" ?>
    </body>
</html>