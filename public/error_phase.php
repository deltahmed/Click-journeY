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
        <link rel="stylesheet" id="theme-style" type="text/css" href="../styles/style.css">
        <script src="scripts/themeSwitcher.js" defer></script>
    </head>

    <body>
        <div class="registration-content">
            <h1>Pour utiliser cette fonctionnalité <br> il faudra attendre la phase 3 ...</h1>
            <p><a class="small-link" href="../index.php">Si vous n'êtes pas redirigé automatiquement cliquez ici.</a></p>
            <?php header("Refresh:6; url=../index.php"); ?>
        </div>
        
        
        <?php include "../views/footer.php" ?>
    </body>
</html>