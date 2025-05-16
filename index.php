<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        <title>Beyond Survival</title>
        <meta charset="UTF-8">


        <link rel="icon" href="media/logo.png" type="image/icon type">
        <link rel="stylesheet" id="theme-style" type="text/css" href="styles/style.css">
        <script src="scripts/theme.js" defer></script>
    </head>

    <body>
        <header>
            <?php include "views/header.php" ?>
            
            <!-- Navigation bar -->
            <nav class="navbar">
                <a href="presentation.php">
                    <div class="pres-button">
                        <img class="icon">
                        <h1>Présentation</h1>
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
        <!-- Section for navigating between the 3 services proposed by the web site -->
        <nav class="selector">
            <!-- For the final web site search.php will be search.php -->
            <a href="search.php?q=wilderness-survival">
                <img src="media/backgrounds/forest.jpg" alt="Survie en pleine nature">
                <div class="selector-text">
                    <h1>Survie en pleine nature</h1>
                    <p>Pour les passionné d'aventure immersion totale en pleine nature sur un terrain inconnu avec des objets de survie et une assistance en cas de danger </p>
                </div>
            </a>
            <!-- For the final web site search.php will be search.php -->
            <a href="search.php?q=survival-training">
                <img src="media/backgrounds/stage.jpg" alt="Survie en pleine nature">
                <div class="selector-text">
                    <h1>Stages de survie</h1>
                    <p>Apprenez les bases de la survie en pleine nature avec des professionnels de la survie</p>
                </div>
            </a>
            <!-- For the final web site search.php will be search.php -->
            <a href="search.php?q=survival-escape-game">
                <img src="media/backgrounds/island.jpg" alt="Survie en pleine nature">
                <div class="selector-text">
                    <h1>Escape games de survie</h1>
                    <p>Survivez dans un environnement hostile avec des énigmes à résoudre pour vous échapper dans un environnement grandeur nature</p>
                </div>
            </a>
        </nav>
        
        <?php include "views/footer.php" ?>
    </body>
</html>