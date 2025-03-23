<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$forward_url = "index.php";
if (isset($_SESSION['forward_url'])) {
    $forward_url = $_SESSION['forward_url'];
    unset($_SESSION['forward_url']);
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


        <link rel="icon" href="../media/icons/account/account.png" type="image/icon type">
        <link rel="stylesheet" type="text/css" href="../style.css">
    </head>

    <body>
        <div class="login-content">            
            <h1>Connexion réussie. Redirection...</h1>
            <p><a class="small-link" href="<?php echo $forward_url ?>">Si vous n'êtes pas redirigé automatiquement cliquez ici.</a></p>
             <?php header("Refresh:1; url=../$forward_url"); ?>
        </div>
        



        
        <?php include "../views/footer.php" ?>
    </body>
</html>