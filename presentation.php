<html lang="fr">
    <head>
        <meta name = "name" content ="Beyond Survival" />
        <meta name = "description" content = "A travel agency for Survival"/>
        <meta name = "keywords" content = "Travel, Survival"/>
        <meta name = "tags" content = "Travel, Survival"/>
        <title>Beyond Survival | Présentation</title>
        <meta charset="UTF-8">


        <link rel="icon" href="media/icons/compass/compass.png" type="image/icon type">
        <link rel="stylesheet" id="theme-style" type="text/css" href="styles/style.css">
        <script src="scripts/theme.js" defer></script>
    </head>

    <body class="pres-body">
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

        <section class="search-section">
            <div class="search-overlay" id="search-overlay">
                <h2>Bienvenue chez Beyond Survival</h2>
                <p>Découvrez nos stages, immersions et escape games pour tester vos limites.</p>
                <form class="search-form" action="search.php" method="get">
                    <input type="text" name="q" placeholder="Rechercher une aventure...">
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
        <section class="pres-section">
            <div class="pres-card">
                <h1>L’Expérience Ultime de Survie et d’Aventure</h1>
                <h2>Qui sommes-nous ?</h2>
                <p>Beyond Survival est une agence spécialisée dans les stages de survie et les immersions en pleine nature. Nous proposons également des escape games grandeur nature permettant à nos clients de tester leurs capacités de réflexion et d'adaptation en situation réelle. Nos expériences sont conçues pour être à la fois éducatives et palpitantes, adaptées aux aventuriers débutants comme aux experts en quête de nouveaux défis.</p>
                
                <h2>Nos missions</h2>
                <p>Notre objectif principal est d’offrir des expériences uniques et enrichissantes, en préparant nos clients à affronter différentes situations extrêmes en pleine nature. Grâce à nos formations, ils acquièrent des compétences essentielles telles que l’orientation, la construction d’abris, la gestion de ressources limitées et la survie face aux éléments. Nous mettons également l’accent sur la résilience mentale et la capacité à gérer le stress, des compétences précieuses dans la vie quotidienne comme en situation de survie.</p>
                
                <h2>Nos destinations</h2>
                <p>Nous emmenons nos participants dans les environnements les plus extrêmes du globe :</p>
                <ul>
                    <li><strong>Forêts denses</strong> : Apprenez à survivre au milieu de la nature, où chaque ressource doit être utilisée à bon escient.</li>
                    <li><strong>Jungles luxuriantes</strong> : Testez vos limites face à l’humidité, aux insectes et aux conditions climatiques éprouvantes.</li>
                    <li><strong>Déserts arides</strong> : Expérimentez la survie en milieux extrêmes, où la gestion de l’eau et de la chaleur est cruciale.</li>
                    <li><strong>Régions polaires</strong> : Domptez le froid et apprenez à survivre dans des conditions glaciales et hostiles.</li>
                    <li><strong>Montagnes escarpées</strong> : Maîtrisez les techniques d’escalade et d’adaptation aux hautes altitudes.</li>
                </ul>
                
                <h2>Nos valeurs et engagements</h2>
                <p>Nous nous engageons à transmettre des valeurs fortes :</p>
                <ul>
                    <li><strong>Aventure</strong> : Chaque expérience est pensée pour procurer des sensations fortes et un sentiment d’accomplissement.</li>
                    <li><strong>Dépassement de soi</strong> : Nous encourageons nos participants à toujours aller plus loin, à affronter leurs peurs et à révéler leur véritable potentiel.</li>
                    <li><strong>Respect de la nature</strong> : Nous prônons une approche respectueuse de l’environnement, en enseignant des techniques de survie durables et en sensibilisant nos clients à la préservation des écosystèmes.</li>
                </ul>
                
                <h2>Pourquoi choisir Beyond Survival ?</h2>
                <p>Nos programmes sont encadrés par des experts en survie et des aventuriers chevronnés, garantissant une formation de qualité et en toute sécurité. Chaque stage est conçu pour être immersif et réaliste, avec des scénarios inspirés de situations réelles. Rejoignez-nous pour une aventure hors du commun, où chaque défi vous rapprochera de votre véritable potentiel.</p>
                
                <h2>Prêt à relever le défi ?</h2>
                <p>Rejoignez Beyond Survival et découvrez jusqu’où vous pouvez aller. Plus qu’une simple aventure, c’est une expérience qui transformera votre façon de voir le monde… et vous-même.</p>
            </div>
        
        </section>
        
        
        <?php include "views/footer.php" ?>
    </body>
</html>